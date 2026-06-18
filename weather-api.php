<?php
// weather-api.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Free demo API key (limited usage) - Replace with your own key for production
$API_KEY = 'b6907d289e10d714a6e88b30761fae22'; // OpenWeatherMap demo key

// Get parameters
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
$lon = isset($_GET['lon']) ? floatval($_GET['lon']) : null;

// Default to Rajkot if nothing provided
if (empty($location) && $lat === null && $lon === null) {
    $location = 'Rajkot';
}

// Function to make API calls
function callAPI($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        return ['error' => "HTTP Error: $httpCode"];
    }

    return json_decode($response, true);
}

// Get coordinates if location name is provided
if ($location) {
    $geoUrl = "http://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($location) . "&limit=1&appid={$API_KEY}";
    $geoData = callAPI($geoUrl);

    if (isset($geoData['error']) || empty($geoData)) {
        // Try with just the city name if full location fails
        $cityOnly = explode(',', $location)[0];
        $geoUrl = "http://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($cityOnly) . "&limit=1&appid={$API_KEY}";
        $geoData = callAPI($geoUrl);

        if (isset($geoData['error']) || empty($geoData)) {
            echo json_encode(['error' => 'Location not found. Showing default location.']);
            // Default to Rajkot
            $lat = 22.3039;
            $lon = 70.8022;
            $displayName = 'Rajkot, Gujarat, IN';
        } else {
            $lat = $geoData[0]['lat'];
            $lon = $geoData[0]['lon'];
            $displayName = $geoData[0]['name'];
            if (isset($geoData[0]['state'])) {
                $displayName .= ', ' . $geoData[0]['state'];
            }
            $displayName .= ', ' . $geoData[0]['country'];
        }
    } else {
        $lat = $geoData[0]['lat'];
        $lon = $geoData[0]['lon'];
        $displayName = $geoData[0]['name'];
        if (isset($geoData[0]['state'])) {
            $displayName .= ', ' . $geoData[0]['state'];
        }
        $displayName .= ', ' . $geoData[0]['country'];
    }
} else {
    // Use provided coordinates
    $displayName = "Location ($lat, $lon)";
}

// Get current weather
$weatherUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units=metric&appid={$API_KEY}";
$weatherData = callAPI($weatherUrl);

if (isset($weatherData['error'])) {
    echo json_encode(['error' => 'Unable to fetch weather data']);
    exit;
}

// Get forecast
$forecastUrl = "https://api.openweathermap.org/data/2.5/forecast?lat={$lat}&lon={$lon}&units=metric&appid={$API_KEY}";
$forecastData = callAPI($forecastUrl);

if (isset($forecastData['error'])) {
    echo json_encode(['error' => 'Unable to fetch forecast data']);
    exit;
}

// Process current weather
$current = [
    'location' => $displayName,
    'temp' => round($weatherData['main']['temp']),
    'feels_like' => round($weatherData['main']['feels_like']),
    'condition' => $weatherData['weather'][0]['main'],
    'description' => $weatherData['weather'][0]['description'],
    'icon' => $weatherData['weather'][0]['icon'],
    'humidity' => $weatherData['main']['humidity'],
    'wind_speed' => round($weatherData['wind']['speed'] * 3.6, 1),
    'sunrise' => date('h:i A', $weatherData['sys']['sunrise']),
    'sunset' => date('h:i A', $weatherData['sys']['sunset']),
];

// Process forecast (next 5 days)
$forecast = [];
$dates = [];

foreach ($forecastData['list'] as $item) {
    $date = date('Y-m-d', $item['dt']);
    $dayName = date('D', $item['dt']);

    if (!in_array($date, $dates)) {
        $dates[] = $date;

        $forecast[] = [
            'day' => $dayName,
            'date' => date('M j', $item['dt']),
            'temp_max' => round($item['main']['temp_max']),
            'temp_min' => round($item['main']['temp_min']),
            'description' => $item['weather'][0]['description'],
            'icon' => $item['weather'][0]['icon'],
            'rain_chance' => isset($item['pop']) ? round($item['pop'] * 100) : 0,
            'humidity' => $item['main']['humidity'],
        ];
    }

    if (count($forecast) >= 5) {
        break;
    }
}

// Calculate soil moisture
$soilMoisture = calculateSoilMoisture($weatherData);

// Generate farming advisory
$advisory = generateAdvisory($weatherData, $forecastData);

echo json_encode([
    'success' => true,
    'current' => $current,
    'forecast' => $forecast,
    'soil_moisture' => $soilMoisture,
    'advisory' => $advisory
]);

function calculateSoilMoisture($weather)
{
    $humidity = $weather['main']['humidity'];
    $rain = isset($weather['rain']) ? ($weather['rain']['1h'] ?? 0) : 0;

    if ($rain > 5)
        return 'High (Saturated)';
    if ($rain > 2)
        return 'Moderate to High';
    if ($rain > 0.5)
        return 'Moderate';
    if ($humidity > 70)
        return 'Moderate';
    if ($humidity > 50)
        return 'Low to Moderate';
    if ($humidity > 30)
        return 'Low';
    return 'Very Low (Dry)';
}

function generateAdvisory($weather, $forecast)
{
    $windSpeed = $weather['wind']['speed'] * 3.6;
    $condition = $weather['weather'][0]['main'];
    $rainToday = isset($weather['rain']);

    // Check forecast for rain
    $rainChance = 0;
    if (isset($forecast['list'][0]['pop'])) {
        $rainChance = $forecast['list'][0]['pop'] * 100;
    }

    if ($rainToday) {
        return [
            'title' => '🌧️ Rain Detected',
            'message' => 'Postpone spraying and harvesting. Ensure proper drainage in fields.',
            'type' => 'warning'
        ];
    } elseif ($rainChance > 70) {
        return [
            'title' => '☔ Heavy Rain Expected',
            'message' => 'Consider harvesting ripe crops today. Prepare for irrigation adjustment.',
            'type' => 'warning'
        ];
    } elseif ($rainChance > 40) {
        return [
            'title' => '☔ Rain Expected (' . $rainChance . '% chance)',
            'message' => 'Light rain expected. Good for recently planted crops.',
            'type' => 'info'
        ];
    } elseif ($windSpeed > 30) {
        return [
            'title' => '💨 High Winds',
            'message' => 'Avoid spraying pesticides. Check for crop lodging in tall crops.',
            'type' => 'warning'
        ];
    } elseif ($condition === 'Clear' && $windSpeed < 20) {
        return [
            'title' => '☀️ Excellent Conditions',
            'message' => 'Perfect for spraying, harvesting, and field preparation.',
            'type' => 'success'
        ];
    } else {
        return [
            'title' => '🌱 Normal Conditions',
            'message' => 'Continue regular farm operations. Stay updated with forecast.',
            'type' => 'info'
        ];
    }
}
?>