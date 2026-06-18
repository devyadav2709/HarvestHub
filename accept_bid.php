<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "php/db.php";

// Redirect if not a farmer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'farmer') {
    header("Location: login.php");
    exit();
}

// Check if the product_id was sent by the form
if (isset($_POST['product_id'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Get farmer ID for verification
    $farmer_id = $_SESSION['user_id'];

    // Verify that the product belongs to the logged-in farmer
    $verify_sql = "SELECT * FROM products WHERE id = '$product_id' AND farmer_id = '$farmer_id'";
    $verify_result = mysqli_query($conn, $verify_sql);

    if (mysqli_num_rows($verify_result) == 0) {
        $error = "You don't have permission to accept bids for this product.";
    } else {
        // 1. Mark the product as SOLD in the database
        mysqli_query($conn, "
            UPDATE products 
            SET is_sold = 1 
            WHERE id = '$product_id'
        ");

        // 2. Mark the highest bid as the winner
        mysqli_query($conn, "
            UPDATE bids 
            SET is_winner = 1 
            WHERE product_id = '$product_id' 
            AND is_highest = 1
        ");

        // 3. Delete the notifications so the farmer doesn't see them anymore
        mysqli_query($conn, "
            DELETE FROM notifications 
            WHERE product_id = '$product_id'
        ");

        // Get winner information for display
        $winner_sql = "SELECT b.*, u.name as bidder_name, u.email as bidder_email 
                      FROM bids b 
                      JOIN users u ON b.user_id = u.id 
                      WHERE b.product_id = '$product_id' AND b.is_highest = 1";
        $winner_result = mysqli_query($conn, $winner_sql);
        $winner_data = mysqli_fetch_assoc($winner_result);

        // Get product name
        $product_sql = "SELECT name FROM products WHERE id = '$product_id'";
        $product_result = mysqli_query($conn, $product_sql);
        $product_data = mysqli_fetch_assoc($product_result);
        $product_name = $product_data['name'];

        $success = true;
    }
} else {
    $error = "No product specified.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accept Bid | Harvest Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #2e7d32;
            --dark: #1b5e20;
            --light-bg: #f4f7f6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .result-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: none;
            max-width: 600px;
            width: 100%;
            overflow: hidden;
        }

        .result-header {
            background: var(--primary);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .result-header h2 {
            font-weight: 700;
            margin-bottom: 0;
        }

        .result-body {
            padding: 40px;
        }

        @media (max-width: 768px) {
            .result-header {
                padding: 20px 15px;
            }

            .result-body {
                padding: 30px 20px;
            }

            .result-header h2 {
                font-size: 1.5rem;
            }
        }

        .success-icon {
            color: #28a745;
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .error-icon {
            color: #dc3545;
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .winner-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .winner-info h5 {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .info-item i {
            width: 30px;
            color: var(--primary);
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
            color: white;
        }
    </style>
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="main-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card result-card">

                        <div class="result-header">
                            <h2><i class="fas fa-gavel me-2"></i>Bid Acceptance</h2>
                        </div>

                        <div class="result-body text-center">
                            <?php if (isset($error)): ?>
                                <div class="error-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <h3 class="text-danger mb-3">Operation Failed</h3>
                                <div class="alert alert-danger">
                                    <?php echo htmlspecialchars($error); ?>
                                </div>
                                <a href="farmer_dashboard.php" class="btn-custom mt-3">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                </a>
                            <?php elseif (isset($success) && $success): ?>
                                <div class="success-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h3 class="text-success mb-3">Bid Accepted Successfully! ✅</h3>
                                <p class="lead mb-4">Product
                                    <strong>"<?php echo htmlspecialchars($product_name); ?>"</strong> has been marked as
                                    SOLD.</p>

                                <?php if ($winner_data): ?>
                                    <div class="winner-info text-start">
                                        <h5>Winning Bid Details:</h5>
                                        <div class="info-item">
                                            <i class="fas fa-user"></i>
                                            <span><strong>Winner:</strong>
                                                <?php echo htmlspecialchars($winner_data['bidder_name']); ?></span>
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-envelope"></i>
                                            <span><strong>Email:</strong>
                                                <?php echo htmlspecialchars($winner_data['bidder_email']); ?></span>
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span><strong>Winning Amount:</strong>
                                                ₹<?php echo number_format($winner_data['bid_amount'], 2); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <p class="text-muted mb-4">
                                    All notifications for this product have been cleared from your dashboard.
                                </p>

                                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mt-4">
                                    <a href="farmer_dashboard.php" class="btn-custom">
                                        <i class="fas fa-tachometer-alt me-2"></i>Back to Dashboard
                                    </a>
                                    <a href="my_products.php" class="btn btn-outline-success"
                                        style="border-radius: 50px; padding: 12px 30px;">
                                        <i class="fas fa-boxes me-2"></i>View My Products
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    Invalid request. Please try again.
                                </div>
                                <a href="farmer_dashboard.php" class="btn-custom mt-3">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php include "footer.php"; ?>

</body>

</html>