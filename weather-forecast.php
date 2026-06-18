<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Agricultural Weather Forecast | Harvest Hub</title>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      :root {
         --primary-dark: #0d3311;
         --primary-light: #1b5e20;
         --accent-gold: #fbbf24;
         --text-main: #334155;
         --bg-light: #f8fafc;
         --card-bg: #ffffff;
      }

      body {
         font-family: 'Poppins', sans-serif;
         background-color: var(--bg-light);
         color: var(--text-main);
         min-height: 100vh;
      }

      .page-header {
         background: linear-gradient(135deg, var(--primary-dark) 0%, #0f3f16 100%);
         color: #fff;
         padding: 60px 20px 100px;
         text-align: center;
         position: relative;
         overflow: hidden;
      }

      .page-header h1 {
         font-size: 2.5rem;
         font-weight: 700;
         margin-bottom: 15px;
      }

      .page-header p {
         font-size: 1.1rem;
         color: #cbd5e1;
         max-width: 600px;
         margin: 0 auto;
      }

      .location-search {
         position: relative;
         max-width: 500px;
         margin: 30px auto 0;
         display: flex;
         background: rgba(255, 255, 255, 0.1);
         border: 1px solid rgba(255, 255, 255, 0.2);
         border-radius: 50px;
         padding: 5px;
         backdrop-filter: blur(10px);
      }

      .location-search input {
         flex: 1;
         background: transparent;
         border: none;
         color: #fff;
         padding: 12px 20px;
         font-size: 1rem;
         outline: none;
      }

      .location-search input::placeholder {
         color: rgba(255, 255, 255, 0.6);
      }

      .location-search button {
         background: var(--accent-gold);
         color: var(--primary-dark);
         border: none;
         padding: 10px 25px;
         border-radius: 50px;
         font-weight: 600;
         cursor: pointer;
         transition: all 0.3s;
      }

      .location-search button:hover {
         background: #fff;
      }

      .gps-button {
         background: rgba(255, 255, 255, 0.2);
         border: 1px solid rgba(255, 255, 255, 0.3);
         border-radius: 50px;
         padding: 8px 15px;
         margin-left: 10px;
         color: white;
         cursor: pointer;
         transition: all 0.3s;
      }

      .gps-button:hover {
         background: rgba(255, 255, 255, 0.3);
      }

      .container {
         max-width: 1200px;
         margin: -60px auto 50px;
         padding: 0 20px;
         position: relative;
         z-index: 10;
      }

      .loading-overlay {
         position: absolute;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background: rgba(255, 255, 255, 0.8);
         border-radius: 24px;
         display: none;
         justify-content: center;
         align-items: center;
         z-index: 20;
         backdrop-filter: blur(5px);
      }

      .loading-spinner {
         width: 50px;
         height: 50px;
         border: 3px solid #f3f3f3;
         border-top: 3px solid var(--primary-dark);
         border-radius: 50%;
         animation: spin 1s linear infinite;
      }

      @keyframes spin {
         0% {
            transform: rotate(0deg);
         }

         100% {
            transform: rotate(360deg);
         }
      }

      .error-message {
         background: #fee2e2;
         border-left: 4px solid #ef4444;
         color: #991b1b;
         padding: 15px 20px;
         border-radius: 12px;
         margin-bottom: 20px;
         display: none;
         align-items: center;
         gap: 12px;
      }

      .weather-main-card {
         background: var(--card-bg);
         border-radius: 24px;
         box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
         padding: 40px;
         display: grid;
         grid-template-columns: 1fr 1.5fr;
         gap: 40px;
         margin-bottom: 30px;
         position: relative;
      }

      .current-temp {
         text-align: center;
         border-right: 1px solid #e2e8f0;
         padding-right: 40px;
      }

      .current-temp h2 {
         font-size: 1.5rem;
         color: #64748b;
         margin: 0 0 5px 0;
      }

      .location-name {
         font-size: 1rem;
         color: #94a3b8;
         margin-bottom: 15px;
      }

      .temp-display {
         font-size: 5rem;
         font-weight: 700;
         color: var(--primary-dark);
         line-height: 1;
         margin-bottom: 10px;
         display: flex;
         align-items: center;
         justify-content: center;
         gap: 15px;
      }

      .temp-icon {
         font-size: 4rem;
         color: #f59e0b;
      }

      .weather-condition {
         font-size: 1.2rem;
         color: #475569;
         font-weight: 500;
         text-transform: capitalize;
      }

      .feels-like {
         font-size: 0.95rem;
         color: #64748b;
         margin-top: 5px;
      }

      .sun-times {
         display: flex;
         justify-content: center;
         gap: 20px;
         margin-top: 15px;
         font-size: 0.9rem;
         color: #64748b;
      }

      .agri-stats {
         display: grid;
         grid-template-columns: repeat(2, 1fr);
         gap: 20px;
      }

      .stat-box {
         background: #f8fafc;
         padding: 20px;
         border-radius: 16px;
         display: flex;
         align-items: center;
         gap: 15px;
         transition: all 0.3s;
      }

      .stat-box:hover {
         border-color: var(--accent-gold);
         transform: translateY(-3px);
         box-shadow: 0 10px 20px rgba(251, 191, 36, 0.1);
      }

      .stat-icon {
         width: 50px;
         height: 50px;
         border-radius: 12px;
         background: rgba(13, 51, 17, 0.05);
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 1.5rem;
      }

      .stat-info h4 {
         margin: 0;
         font-size: 0.9rem;
         color: #64748b;
         font-weight: 500;
      }

      .stat-info p {
         margin: 5px 0 0 0;
         font-size: 1.2rem;
         font-weight: 700;
         color: var(--primary-dark);
      }

      .stat-info small {
         font-size: 0.75rem;
         color: #94a3b8;
      }

      .advisory-banner {
         padding: 20px 25px;
         border-radius: 12px;
         margin-bottom: 40px;
         display: flex;
         align-items: flex-start;
         gap: 15px;
      }

      .advisory-success {
         background: linear-gradient(to right, rgba(34, 197, 94, 0.1), rgba(16, 185, 129, 0.05));
         border-left: 4px solid #22c55e;
      }

      .advisory-warning {
         background: linear-gradient(to right, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));
         border-left: 4px solid #f59e0b;
      }

      .advisory-info {
         background: linear-gradient(to right, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05));
         border-left: 4px solid #3b82f6;
      }

      .section-title {
         font-size: 1.4rem;
         color: var(--primary-dark);
         margin-bottom: 20px;
         font-weight: 600;
      }

      .forecast-grid {
         display: grid;
         grid-template-columns: repeat(5, 1fr);
         gap: 15px;
      }

      .forecast-card {
         background: var(--card-bg);
         padding: 25px 15px;
         border-radius: 16px;
         text-align: center;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
         border: 1px solid #f1f5f9;
         transition: all 0.3s;
      }

      .forecast-card:hover {
         transform: translateY(-5px);
         box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
         border-color: var(--accent-gold);
      }

      .forecast-day {
         font-weight: 600;
         color: #475569;
         margin-bottom: 5px;
      }

      .forecast-date {
         font-size: 0.8rem;
         color: #94a3b8;
         margin-bottom: 10px;
      }

      .forecast-icon {
         font-size: 2.5rem;
         margin: 15px 0;
         color: #f59e0b;
      }

      .forecast-temp {
         font-weight: 700;
         font-size: 1.2rem;
         color: var(--primary-dark);
      }

      .forecast-desc {
         font-size: 0.8rem;
         color: #64748b;
         margin: 5px 0;
         text-transform: capitalize;
      }

      .forecast-rain {
         font-size: 0.8rem;
         color: #3b82f6;
         margin-top: 10px;
         display: flex;
         align-items: center;
         justify-content: center;
         gap: 5px;
      }

      @media (max-width: 992px) {
         .weather-main-card {
            grid-template-columns: 1fr;
         }

         .current-temp {
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
            padding-right: 0;
            padding-bottom: 30px;
         }

         .forecast-grid {
            grid-template-columns: repeat(3, 1fr);
         }
      }

      @media (max-width: 768px) {
         .page-header h1 {
            font-size: 2rem;
         }

         .temp-display {
            font-size: 4rem;
         }

         .temp-icon {
            font-size: 3rem;
         }

         .agri-stats {
            grid-template-columns: 1fr;
         }

         .forecast-grid {
            grid-template-columns: repeat(2, 1fr);
         }

         .location-search {
            flex-direction: column;
            background: transparent;
            border: none;
            gap: 10px;
         }

         .location-search input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
         }

         .gps-button {
            margin-left: 0;
         }
      }
   </style>
</head>

<body>

   <section class="page-header">
      <h1>Local Farm Weather</h1>
      <p>Real-time weather updates for your farm. No sign-in required.</p>

      <div class="location-search">
         <input type="text" id="locationInput" placeholder="Enter city name (e.g., Rajkot, Ahmedabad)..."
            value="Rajkot">
         <button type="button" id="searchBtn">
            <i class="fas fa-search"></i> Update
         </button>
         <button type="button" id="gpsBtn" class="gps-button" title="Use my current location">
            <i class="fas fa-location-dot"></i> Use My Location
         </button>
      </div>
   </section>

   <div class="container">
      <div id="errorMessage" class="error-message">
         <i class="fas fa-exclamation-circle"></i>
         <span id="errorText"></span>
      </div>

      <div class="weather-main-card" id="weatherCard">
         <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
         </div>

         <div class="current-temp">
            <h2>Today, <span id="currentDate"></span></h2>
            <div class="location-name" id="locationDisplay">Loading location...</div>
            <div class="temp-display">
               <i class="fas fa-sun temp-icon" id="weatherIcon"></i>
               <span id="temperature">--</span>°C
            </div>
            <div class="weather-condition" id="weatherCondition">Loading...</div>
            <div class="feels-like" id="feelsLike">Feels like --°C</div>
            <div class="sun-times">
               <span><i class="fas fa-sunrise"></i> <span id="sunrise">--:--</span></span>
               <span><i class="fas fa-sunset"></i> <span id="sunset">--:--</span></span>
            </div>
         </div>

         <div class="agri-stats">
            <div class="stat-box">
               <div class="stat-icon" style="color: #3b82f6;"><i class="fas fa-droplet"></i></div>
               <div class="stat-info">
                  <h4>Humidity</h4>
                  <p id="humidity">--%</p>
               </div>
            </div>
            <div class="stat-box">
               <div class="stat-icon" style="color: #8b5cf6;"><i class="fas fa-wind"></i></div>
               <div class="stat-info">
                  <h4>Wind Speed</h4>
                  <p id="windSpeed">-- <small>km/h</small></p>
               </div>
            </div>
            <div class="stat-box">
               <div class="stat-icon" style="color: #d97706;"><i class="fas fa-seedling"></i></div>
               <div class="stat-info">
                  <h4>Soil Moisture</h4>
                  <p id="soilMoisture">--</p>
               </div>
            </div>
            <div class="stat-box">
               <div class="stat-icon" style="color: #ef4444;"><i class="fas fa-cloud-showers-heavy"></i></div>
               <div class="stat-info">
                  <h4>Rain Chance</h4>
                  <p id="rainChance">--%</p>
               </div>
            </div>
         </div>
      </div>

      <div id="advisoryBanner" class="advisory-banner advisory-info">
         <i class="fas fa-info-circle advisory-icon"></i>
         <div class="advisory-text">
            <h3 id="advisoryTitle">Loading Advisory...</h3>
            <p id="advisoryMessage">Please wait while we fetch weather data.</p>
         </div>
      </div>

      <h3 class="section-title">5-Day Weather Forecast</h3>
      <div class="forecast-grid" id="forecastGrid">
         <!-- Forecast will be populated by JavaScript -->
      </div>
   </div>

   <?php include 'footer.php'; ?>

   <script>
      // Configuration
      const API_URL = 'weather-api.php';

      // DOM Elements
      const locationInput = document.getElementById('locationInput');
      const searchBtn = document.getElementById('searchBtn');
      const gpsBtn = document.getElementById('gpsBtn');
      const loadingOverlay = document.getElementById('loadingOverlay');
      const errorMessage = document.getElementById('errorMessage');
      const errorText = document.getElementById('errorText');

      // Display elements
      const locationDisplay = document.getElementById('locationDisplay');
      const currentDate = document.getElementById('currentDate');
      const temperature = document.getElementById('temperature');
      const weatherIcon = document.getElementById('weatherIcon');
      const weatherCondition = document.getElementById('weatherCondition');
      const feelsLike = document.getElementById('feelsLike');
      const sunrise = document.getElementById('sunrise');
      const sunset = document.getElementById('sunset');
      const humidity = document.getElementById('humidity');
      const windSpeed = document.getElementById('windSpeed');
      const soilMoisture = document.getElementById('soilMoisture');
      const rainChance = document.getElementById('rainChance');
      const advisoryBanner = document.getElementById('advisoryBanner');
      const advisoryTitle = document.getElementById('advisoryTitle');
      const advisoryMessage = document.getElementById('advisoryMessage');
      const forecastGrid = document.getElementById('forecastGrid');

      // Weather icon mapping
      const weatherIcons = {
         '01d': 'fa-sun', '01n': 'fa-moon',
         '02d': 'fa-cloud-sun', '02n': 'fa-cloud-moon',
         '03d': 'fa-cloud', '03n': 'fa-cloud',
         '04d': 'fa-cloud', '04n': 'fa-cloud',
         '09d': 'fa-cloud-rain', '09n': 'fa-cloud-rain',
         '10d': 'fa-cloud-sun-rain', '10n': 'fa-cloud-moon-rain',
         '11d': 'fa-cloud-bolt', '11n': 'fa-cloud-bolt',
         '13d': 'fa-snowflake', '13n': 'fa-snowflake',
         '50d': 'fa-smog', '50n': 'fa-smog'
      };

      // Auto-load weather when page loads
      document.addEventListener('DOMContentLoaded', () => {
         // Set current date
         const now = new Date();
         const options = { month: 'short', day: 'numeric' };
         currentDate.textContent = now.toLocaleDateString('en-US', options);

         // Try to get user's location, otherwise use default (Rajkot)
         if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
               (position) => {
                  // User allowed GPS - use their location
                  fetchWeatherByCoords(position.coords.latitude, position.coords.longitude);
               },
               (error) => {
                  // User denied or error - use default location
                  console.log('Using default location (Rajkot)');
                  fetchWeather('Rajkot');
               }
            );
         } else {
            // Browser doesn't support geolocation - use default
            fetchWeather('Rajkot');
         }

         // Event listeners
         searchBtn.addEventListener('click', () => {
            if (locationInput.value.trim()) {
               fetchWeather(locationInput.value);
            } else {
               showError('Please enter a city name');
            }
         });

         locationInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && locationInput.value.trim()) {
               fetchWeather(locationInput.value);
            }
         });

         gpsBtn.addEventListener('click', getCurrentLocation);
      });

      function getCurrentLocation() {
         if (!navigator.geolocation) {
            showError('Geolocation is not supported by your browser');
            return;
         }

         showLoading(true);

         navigator.geolocation.getCurrentPosition(
            (position) => {
               fetchWeatherByCoords(position.coords.latitude, position.coords.longitude);
            },
            (error) => {
               showLoading(false);
               showError('Unable to get your location. Please enter city name manually.');
            }
         );
      }

      function fetchWeatherByCoords(lat, lon) {
         showLoading(true);
         hideError();

         fetch(`${API_URL}?lat=${lat}&lon=${lon}`)
            .then(response => response.json())
            .then(data => {
               if (data.error) {
                  showError(data.error);
                  // Fallback to default
                  fetchWeather('Rajkot');
               } else if (data.success) {
                  updateUI(data);
               }
            })
            .catch(error => {
               console.error('Error:', error);
               showError('Network error. Using default location.');
               fetchWeather('Rajkot');
            });
      }

      async function fetchWeather(location) {
         showLoading(true);
         hideError();

         try {
            const response = await fetch(`${API_URL}?location=${encodeURIComponent(location)}`);
            const data = await response.json();

            if (data.error) {
               showError(data.error + ' Showing default location.');
               // If error, try default location
               if (location !== 'Rajkot') {
                  fetchWeather('Rajkot');
               } else {
                  showLoading(false);
               }
            } else if (data.success) {
               updateUI(data);
            }
         } catch (error) {
            console.error('Error:', error);
            showError('Network error. Please try again.');
            showLoading(false);
         }
      }

      function updateUI(data) {
         const current = data.current;
         const forecast = data.forecast;

         // Update location
         locationDisplay.textContent = current.location;

         // Update temperature
         temperature.textContent = current.temp;

         // Update weather icon
         const iconClass = weatherIcons[current.icon] || 'fa-sun';
         weatherIcon.className = `fas ${iconClass} temp-icon`;

         // Update weather condition
         weatherCondition.textContent = current.description;
         feelsLike.textContent = `Feels like ${current.feels_like}°C`;

         // Update sun times
         sunrise.textContent = current.sunrise;
         sunset.textContent = current.sunset;

         // Update stats
         humidity.textContent = `${current.humidity}%`;
         windSpeed.innerHTML = `${current.wind_speed} <small>km/h</small>`;
         soilMoisture.textContent = data.soil_moisture;

         // Update rain chance
         if (forecast && forecast.length > 0) {
            rainChance.textContent = `${forecast[0].rain_chance}%`;
         }

         // Update advisory
         advisoryTitle.textContent = data.advisory.title;
         advisoryMessage.textContent = data.advisory.message;

         // Update advisory banner class
         advisoryBanner.className = 'advisory-banner';
         advisoryBanner.classList.add(`advisory-${data.advisory.type}`);

         // Update forecast
         updateForecast(forecast);

         showLoading(false);
      }

      function updateForecast(forecast) {
         if (!forecast || forecast.length === 0) {
            forecastGrid.innerHTML = '<p style="grid-column: 1/-1; text-align: center;">No forecast data available</p>';
            return;
         }

         let html = '';
         forecast.forEach(day => {
            const iconClass = weatherIcons[day.icon] || 'fa-sun';

            html += `
                    <div class="forecast-card">
                        <div class="forecast-day">${day.day}</div>
                        <div class="forecast-date">${day.date}</div>
                        <div class="forecast-icon">
                            <i class="fas ${iconClass}"></i>
                        </div>
                        <div class="forecast-temp">${day.temp_max}° / ${day.temp_min}°</div>
                        <div class="forecast-desc">${day.description}</div>
                        <div class="forecast-rain">
                            <i class="fas fa-tint"></i> ${day.rain_chance}%
                        </div>
                    </div>
                `;
         });

         forecastGrid.innerHTML = html;
      }

      function showLoading(show) {
         loadingOverlay.style.display = show ? 'flex' : 'none';
         searchBtn.disabled = show;
         gpsBtn.disabled = show;
      }

      function showError(message) {
         errorText.textContent = message;
         errorMessage.style.display = 'flex';

         setTimeout(() => {
            errorMessage.style.display = 'none';
         }, 5000);

         showLoading(false);
      }

      function hideError() {
         errorMessage.style.display = 'none';
      }
   </script>

</body>

</html>