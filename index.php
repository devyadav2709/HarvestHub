<?php
include "php/db.php";

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- 1. LOGIC: Fetch "Winning Bids" (If User is Consumer) ---
$winnings = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'consumer') {
    $my_id = $_SESSION['user_id'];

    $win_sql = "SELECT p.*, b.bid_amount 
                FROM products p 
                JOIN bids b ON p.id = b.product_id 
                WHERE b.user_id = '$my_id' 
                AND p.is_sold = 1 
                AND b.is_highest = 1
                AND NOT EXISTS (
                    SELECT 1 FROM purchases pur 
                    WHERE pur.product_id = p.id 
                    AND pur.user_id = '$my_id'
                )
                ORDER BY p.id DESC";

    $winnings = mysqli_query($conn, $win_sql);
}

// --- 2. LOGIC: Search Functionality ---
$search_term = "";
$search_sql = "";
$is_searching = false;

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $search_sql = " AND (p.name LIKE '%$search_term%' OR p.description LIKE '%$search_term%') ";
    $is_searching = true;
}

// --- 3. LOGIC: Standard Product Limit ---
$limit_query = "LIMIT 6";
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'consumer') {
    $limit_query = "";
}

// --- 4. DATA: Fetch Active AND Sold Market Products ---
// UPDATED: Removed "AND p.is_sold = 0" so we can see sold items too
$query_sql = "
    SELECT p.*,
           (SELECT MAX(bid_amount) 
            FROM bids 
            WHERE product_id = p.id) AS highest_bid
    FROM products p
    WHERE p.status = 'active'
    $search_sql
    ORDER BY p.is_sold ASC, p.id DESC
    $limit_query
";

$products = mysqli_query($conn, $query_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvest Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #2e7d32;
            --accent: #fbc02d;
            --dark: #1b5e20;
            --light-bg: #f4f7f6;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        body,
        button,
        input,
        select,
        textarea,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        a {
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            background-color: var(--light-bg);
            margin: 0;
            color: #333;
            line-height: 1.6;
            /* Prevents horizontal scrolling/white gaps on mobile */
            overflow-x: hidden;
            max-width: 100vw;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 20px;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            box-shadow: var(--shadow);
            margin-bottom: 50px;
            width: 100%;
            box-sizing: border-box;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 10px;
            font-weight: 800;
            letter-spacing: -1px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        }

        .search-container {
            width: 100%;
            max-width: 600px;
            position: relative;
        }

        .search-form {
            display: flex;
            background: white;
            border-radius: 50px;
            padding: 5px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            border: 4px solid rgba(255, 255, 255, 0.2);
        }

        .search-input {
            flex: 1;
            min-width: 0;
            /* Crucial: Allows input to shrink below placeholder width on small screens */
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 1rem;
            outline: none;
            text-overflow: ellipsis;
        }

        .search-btn {
            background: var(--primary);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
            /* Prevents the button from squishing on mobile */
        }

        .search-btn:hover {
            background: var(--dark);
            transform: scale(1.05);
        }

        .section-title {
            text-align: center;
            margin: 60px 0 40px;
            font-weight: 700;
            font-size: 2.2rem;
            color: var(--dark);
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: var(--accent);
            margin: 10px auto;
            border-radius: 2px;
        }

        /* Product Grid */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            /* Adjusted to 280px for better mobile fit */
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto 50px;
            padding: 0 20px;
        }

        .product-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: var(--transition);
        }

        .card-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-content h3 {
            margin: 0 0 10px;
            font-size: 1.4rem;
            color: var(--dark);
            font-weight: 600;
        }

        .bid-info {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Buttons */
        .btn-main {
            display: block;
            text-align: center;
            background: var(--primary);
            color: white;
            padding: 12px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: var(--transition);
        }

        .btn-main:hover {
            background: var(--dark);
        }

        /* Disabled Button for Closed Bids */
        .btn-disabled {
            background: #e0e0e0 !important;
            cursor: not-allowed;
            color: #999 !important;
            box-shadow: none;
        }

        /* New Style for Sold Button */
        .btn-sold {
            background: #d32f2f !important;
            cursor: not-allowed;
            color: white !important;
            box-shadow: none;
            opacity: 0.8;
        }

        .register-cta {
            background: linear-gradient(135deg, #1b5e20 0%, #033008 100%);
            padding: 100px 20px;
            color: white;
            text-align: center;
            border-top-left-radius: 60px;
            border-top-right-radius: 60px;
            margin-top: 80px;
        }

        .cta-btn {
            background: #fbc02d;
            color: #0d3311;
            padding: 18px 45px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        /* --- MOBILE RESPONSIVENESS FIXES --- */
        @media (max-width: 768px) {
            .hero {
                height: 400px;
                border-bottom-left-radius: 30px;
                border-bottom-right-radius: 30px;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 0.9rem;
                padding: 0 10px;
            }

            .search-form {
                padding: 4px;
            }

            .search-input {
                padding: 12px 15px;
                font-size: 0.85rem;
            }

            .search-btn {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }

            .products {
                grid-template-columns: 1fr;
            }

            .register-cta {
                padding: 60px 20px;
                border-top-left-radius: 40px;
                border-top-right-radius: 40px;
            }

            .register-cta h3 {
                font-size: 1.8rem !important;
                /* Forces the text to fit without stretching screen */
            }

            .cta-btn {
                padding: 15px 30px;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="hero">
        <h1>Harvest Hub</h1>
        <p>Direct Farm Sourcing • Transparent Bidding • Fresh Quality</p>
        <div class="search-container">
            <form action="index.php" method="GET" class="search-form">
                <input type="text" name="search" class="search-input"
                    placeholder="Search for onions, wheat, tomatoes..."
                    value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <?php if ($winnings && mysqli_num_rows($winnings) > 0): ?>
        <h2 class="section-title">🏆 Your Successful Bids</h2>
        <div class="products">
            <?php while ($row = mysqli_fetch_assoc($winnings)) { ?>
                <div class="product-card" style="border: 2px solid var(--accent); background: #fffdf2;">
                    <div
                        style="position:absolute; top:15px; right:15px; background:var(--accent); color:#000; padding:6px 15px; border-radius:50px; font-weight:700; font-size:0.75rem; z-index:10;">
                        WON</div>
                    <img src="images/<?php echo $row['image']; ?>" alt="Product">
                    <div class="card-content">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><?php echo substr($row['description'], 0, 100); ?>...</p>
                        <div class="bid-info" style="border-left: 4px solid var(--accent);">
                            <small style="color: #888;">Final Price</small>
                            <div style="font-size: 1.5rem; font-weight: 800;">₹<?php echo $row['bid_amount']; ?></div>
                        </div>
                        <a href="payment.php?product_id=<?php echo $row['id']; ?>" class="btn-main"
                            style="background: var(--accent); color: #000;">Pay Now</a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr style="margin: 60px auto; width: 60%; opacity: 0.1;">
    <?php endif; ?>

    <h2 class="section-title">
        <?php echo $is_searching ? 'Search Results' : 'Active Auctions'; ?>
    </h2>

    <div class="products">
        <?php
        if (mysqli_num_rows($products) > 0) {
            while ($row = mysqli_fetch_assoc($products)) {

                // 1. Calculate Total Value
                $calculated_total_value = $row['base_price'] * $row['quantity'];

                // 2. Check Sold Status
                $is_sold = ($row['is_sold'] == 1);

                // 3. Check Bid Time / Expiration Logic
                $is_expired = false;
                $time_display = "Ongoing";
                $time_color = "#2e7d32"; // Green
        
                if ($is_sold) {
                    $time_display = "Sold Out";
                    $time_color = "#d32f2f"; // Red
                } elseif (!empty($row['bid_end'])) {
                    $end_time = new DateTime($row['bid_end']);
                    $now = new DateTime();

                    if ($now > $end_time) {
                        $is_expired = true;
                        $time_display = "Bidding Closed";
                        $time_color = "#d32f2f"; // Red
                    } else {
                        // Format: "Ends: 12 Oct, 05:30 PM"
                        $time_display = "Ends: " . $end_time->format('d M, h:i A');
                    }
                }

                // Determine Status Badge color and text
                $status_text = $is_sold ? "SOLD" : "ACTIVE";
                $status_bg = $is_sold ? "#d32f2f" : "#2e7d32";
                ?>

                <div class="product-card">
                    <div style="position: relative; overflow: hidden;">
                        <img src="images/<?php echo $row['image']; ?>" alt="Product Image">

                        <span
                            style="position: absolute; top: 10px; right: 10px; background: #fbc02d; color: #000; padding: 5px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                            <?php echo $row['category']; ?>
                        </span>

                        <span
                            style="position: absolute; top: 10px; left: 10px; background: <?php echo $status_bg; ?>; color: #fff; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                            <?php echo $status_text; ?>
                        </span>
                    </div>

                    <div class="card-content">
                        <h3><?php echo $row['name']; ?></h3>

                        <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 15px;">
                            <?php echo substr($row['description'], 0, 120); ?>...
                        </p>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9rem; color: #555;">
                            <span><i class="fas fa-weight-hanging"></i> <strong>Qty:</strong> <?php echo $row['quantity']; ?>
                                kg</span>
                            <span><i class="fas fa-tag"></i> <strong>Price:</strong>
                                ₹<?php echo $row['base_price']; ?>/kg</span>
                        </div>

                        <div
                            style="background: #e8f5e9; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
                            <span
                                style="display: block; font-size: 0.8rem; color: #2e7d32; text-transform: uppercase; font-weight: 600;">Total
                                Value</span>
                            <span style="font-size: 1.4rem; font-weight: 800; color: #1b5e20;">
                                ₹<?php echo number_format($calculated_total_value, 2); ?>
                            </span>
                        </div>

                        <div class="bid-info">
                            <div class="price-row">
                                <span style="font-size: 0.85rem; color: #666; font-weight: 500;">
                                    <i class="fas fa-gavel"></i> Highest Bid
                                </span>
                                <?php if ($row['highest_bid'] !== null) { ?>
                                    <span style="color:#d84315; font-weight:800; font-size: 1.2rem;">
                                        ₹<?php echo number_format($row['highest_bid'], 2); ?>
                                    </span>
                                <?php } else { ?>
                                    <span style="color:gray; font-size: 0.9rem;">No bids yet</span>
                                <?php } ?>
                            </div>
                        </div>

                        <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                            <i class="far fa-clock" style="color: <?php echo $time_color; ?>;"></i>
                            <span style="color: <?php echo $time_color; ?>; font-size:0.85rem; font-weight: 600;">
                                <?php echo $time_display; ?>
                            </span>
                        </div>

                        <?php
                        // UPDATED: Button Logic for Sold Items
                        if ($is_sold) { ?>
                            <button class="btn-main btn-sold" disabled>Sold Out</button>
                        <?php } elseif ($is_expired) { ?>
                            <button class="btn-main btn-disabled" disabled>Bidding Closed</button>
                        <?php } elseif (!isset($_SESSION['role'])) { ?>
                            <a href="login.php" class="btn-main btn-disabled">Login to Bid</a>
                        <?php } elseif ($_SESSION['role'] === 'consumer') { ?>
                            <a href="place_bid.php?product_id=<?php echo $row['id']; ?>" class="btn-main">Place Bid Now</a>
                        <?php } else { ?>
                            <div style="background: #f1f8e9; padding: 10px; border-radius: 8px; text-align: center;">
                                <span style="color:var(--primary); font-size: 0.85rem; font-weight: 600;">Farmer Preview Mode</span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div style='grid-column: 1/-1; text-align:center; padding: 50px;'>
                    <i class='fas fa-search' style='font-size: 3rem; color: #e0e0e0; margin-bottom: 15px;'></i>
                    <p style='color: #777; font-size: 1.1rem;'>No crops found.</p>
                  </div>";
        }
        ?>
    </div>

    <?php if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'consumer'): ?>
        <div class="register-cta">
            <div style="max-width: 700px; margin: 0 auto; position: relative; z-index: 2;">
                <i class="fas fa-hand-holding-seedling" style="font-size: 3.5rem; color: #fbc02d; margin-bottom: 25px;"></i>
                <h3 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 20px;">Ready to Support Local Farmers?</h3>
                <p style="font-size: 1.1rem; margin-bottom: 40px;">Join our community and get fresh produce directly from
                    the source.</p>
                <a href="register.php" class="cta-btn">Create Your Account <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    <?php endif; ?>

    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>