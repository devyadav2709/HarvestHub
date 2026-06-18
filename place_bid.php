<?php
session_start();
include "php/db.php";

// 1. Security Check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'consumer') {
    header("Location: login.php");
    exit;
}

// 2. Validate Product ID
if (!isset($_GET['product_id'])) {
    echo "Product ID missing.";
    exit;
}

$product_id = $_GET['product_id'];

// --- FETCH PRODUCT DETAILS ---
$sql_product = "SELECT * FROM products WHERE id = '$product_id'";
$result_product = mysqli_query($conn, $sql_product);
$product = mysqli_fetch_assoc($result_product);

if (!$product) {
    echo "Product not found.";
    exit;
}

$quantity = $product['quantity'];
$base_price_per_kg = $product['base_price'];

// --- FETCH CURRENT HIGHEST BID (TOTAL VALUE) ---
$sql_bid = "SELECT MAX(bid_amount) AS max_total_bid FROM bids WHERE product_id = '$product_id'";
$result_bid = mysqli_query($conn, $sql_bid);
$row_bid = mysqli_fetch_assoc($result_bid);

$current_highest_total_bid = $row_bid['max_total_bid']; // This is the Total Value

// LOGIC: Calculate Minimum Bid PER KG
if ($current_highest_total_bid) {
    // Convert Total back to Per Kg to show the user
    $current_highest_per_kg = $current_highest_total_bid / $quantity;

    // Minimum bid must be higher than current per kg rate
    $min_bid_per_kg = $current_highest_per_kg + 0.2;

    $status_text = "Current Highest: ₹" . number_format($current_highest_per_kg, 2) . "/kg";
    $status_class = "status-high";
} else {
    // If no bids, start at Base Price
    $min_bid_per_kg = $base_price_per_kg;
    $status_text = "No bids yet. Start the auction!";
    $status_class = "status-new";
}

// --- HANDLE FORM SUBMISSION ---
if (isset($_POST['submit_bid'])) {
    $user_id = $_SESSION['user_id'];
    $bidder_name = $_SESSION['name'];

    // User enters price PER KG
    $bid_rate_per_kg = $_POST['bid_amount'];

    // Calculate TOTAL Amount to store in DB
    $total_bid_amount = $bid_rate_per_kg * $quantity;

    // VALIDATION: Compare Totals
    $min_total_required = ($current_highest_total_bid) ? $current_highest_total_bid : ($base_price_per_kg * $quantity);

    if ($total_bid_amount > $min_total_required) {

        // Reset old highest flag
        mysqli_query($conn, "UPDATE bids SET is_highest = 0 WHERE product_id = '$product_id'");

        // Insert new highest bid (TOTAL AMOUNT)
        $insert_query = "INSERT INTO bids (product_id, user_id, bid_amount, is_highest)
                          VALUES ('$product_id', '$user_id', '$total_bid_amount', 1)";

        if (mysqli_query($conn, $insert_query)) {
            // Notify Farmer
            $message = "New highest bid ₹$total_bid_amount (Rate: ₹$bid_rate_per_kg/kg) by $bidder_name";

            // Clean up old notifications
            mysqli_query($conn, "DELETE FROM notifications WHERE product_id = '$product_id'");

            // Add new notification
            mysqli_query($conn, "INSERT INTO notifications (product_id, message) VALUES ('$product_id', '$message')");

            echo "<script>alert('Bid Placed Successfully!'); window.location.href='index.php';</script>";
        } else {
            $error = "Database Error: " . mysqli_error($conn);
        }
    } else {
        $error = "Bid too low! Your total bid must exceed ₹" . number_format($min_total_required, 2);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Bid | Harvest Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2e7d32;
            --accent: #fbc02d;
            --dark: #1b5e20;
            --light-bg: #f4f7f6;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin-top: 100px;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 15px;
        }

        .bid-container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .product-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .stat-box {
            padding: 12px;
            border-radius: 10px;
            font-size: 0.9rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100%;
        }

        .base-box {
            background-color: #e8f5e9;
            color: var(--dark);
            border: 1px solid #c8e6c9;
        }

        .status-new {
            background-color: #e3f2fd;
            color: #1565c0;
            border: 1px solid #bbdefb;
        }

        .status-high {
            background-color: #fff3e0;
            color: #e65100;
            border: 1px solid #ffe0b2;
            font-weight: bold;
        }

        .input-group-custom {
            position: relative;
        }

        .currency-symbol {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #555;
            font-weight: 600;
            z-index: 10;
        }

        .bid-input {
            width: 100%;
            padding: 15px 15px 15px 40px;
            font-size: 1.2rem;
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--dark);
            transition: 0.3s;
        }

        .bid-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
        }

        .total-display-box {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            margin-top: 15px;
        }

        .total-label {
            font-size: 0.85rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
            transition: transform 0.2s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.4);
            color: white;
        }

        .btn-cancel {
            display: inline-block;
            color: #777;
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .btn-cancel:hover {
            color: var(--dark);
            text-decoration: underline;
        }

        .error-msg {
            background: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 0.9rem;
            border: 1px solid #ffcdd2;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 576px) {
            .bid-container {
                border-radius: 15px;
            }

            .product-img {
                height: 180px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="main-wrapper">
        <div class="bid-container">
            <div class="p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-2" style="color: var(--dark);">Place Your Bid</h2>
                    <p class="text-muted mb-0">Total Quantity: <strong><?php echo $quantity; ?> kg</strong></p>
                </div>

                <div class="mb-4">
                    <img src="images/<?php echo $product['image']; ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img img-fluid">
                </div>

                <div class="text-center mb-4">
                    <h3 class="fw-semibold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                </div>

                <div class="stats-grid mb-4">
                    <div class="stat-box base-box">
                        <small>Min Bid Rate</small>
                        <span class="fw-bold fs-5">₹<?php echo number_format($min_bid_per_kg, 2); ?>/kg</span>
                    </div>
                    <div class="stat-box <?php echo $status_class; ?>">
                        <small>Market Status</small>
                        <span class="fw-semibold"><?php echo $status_text; ?></span>
                    </div>
                </div>

                <?php if (isset($error)): ?>
                    <div class="error-msg mb-3">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="bidAmount" class="form-label text-muted fw-bold">
                            Enter Price Per Kg (₹)
                        </label>
                        <div class="input-group-custom">
                            <span class="currency-symbol">₹</span>
                            <input type="number" name="bid_amount" id="bidAmount" class="form-control bid-input"
                                required min="<?php echo $min_bid_per_kg; ?>" step="0.01"
                                placeholder="Up to <?php echo $min_bid_per_kg; ?>">
                        </div>

                        <div class="total-display-box">
                            <span class="total-label">Total Bid Value (Rate × <?php echo $quantity; ?>kg)</span>
                            <span class="total-amount" id="totalDisplay">₹0.00</span>
                        </div>
                    </div>

                    <button type="submit" name="submit_bid" class="btn-submit mb-3">
                        Confirm Total Bid <i class="fas fa-gavel ms-2"></i>
                    </button>

                    <div class="text-center">
                        <a href="index.php" class="btn-cancel">Cancel & Return</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bidInput = document.getElementById('bidAmount');
            const totalDisplay = document.getElementById('totalDisplay');

            // Get PHP values
            const quantity = <?php echo $quantity; ?>;
            const minBidRate = <?php echo $min_bid_per_kg; ?>;

            // Function to calculate and update total
            function updateTotal() {
                const rate = parseFloat(bidInput.value) || 0;
                const total = rate * quantity;

                // Format currency
                totalDisplay.textContent = '₹' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

                // Visual validation
                // Only show invalid if user has typed something and it's too low
                if (bidInput.value && rate < minBidRate) {
                    bidInput.classList.add('is-invalid');
                } else {
                    bidInput.classList.remove('is-invalid');
                }
            }

            // Listen for input changes
            bidInput.addEventListener('input', updateTotal);

            // Initial calculation (will show 0.00 since input is empty)
            updateTotal();

            // Form Submit Validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function (e) {
                const rate = parseFloat(bidInput.value);
                if (isNaN(rate) || rate < minBidRate) {
                    e.preventDefault();
                    bidInput.classList.add('is-invalid');
                    alert('Bid rate too low! Minimum required is ₹' + minBidRate.toFixed(2) + '/kg');
                }
            });
        });
    </script>
</body>

</html>