<?php
include "php/db.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. FETCH FARMER REVIEWS
$farm_sql = "SELECT * FROM feedbacks WHERE role='farmer' ORDER BY id DESC LIMIT 4";
$farm_result = mysqli_query($conn, $farm_sql);

// 2. FETCH CONSUMER REVIEWS
$cons_sql = "SELECT * FROM feedbacks WHERE role='consumer' ORDER BY id DESC LIMIT 4";
$cons_result = mysqli_query($conn, $cons_sql);

function renderStars($rating)
{
    $stars = "";
    for ($i = 0; $i < $rating; $i++) {
        $stars .= '<i class="fas fa-star text-warning"></i>';
    }
    for ($i = $rating; $i < 5; $i++) {
        $stars .= '<i class="far fa-star text-muted" style="opacity:0.3"></i>';
    }
    return $stars;
}

// Helper to format date
function formatDate($date_string)
{
    return date("d M Y", strtotime($date_string));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Harvest Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #2e7d32;
            --dark: #1b5e20;
            --accent: #fbc02d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.6)), url('https://napratica.org.br/wp-content/uploads/2015/10/engenheiro-agronomo.jpg');
            background-size: cover;
            background-position: center;
            height: 400px;
            margin-top: 70px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        @media (max-width: 767.98px) {
            .hero-section {
                height: 300px;
                padding: 20px;
            }

            .hero-title {
                font-size: 2.5rem !important;
            }

            .hero-section .lead {
                font-size: 1rem;
            }
        }

        @media (min-width: 768px) {
            .hero-section {
                border-bottom-left-radius: 60px;
                border-bottom-right-radius: 60px;
            }

            .hero-title {
                font-size: 3.5rem;
            }
        }

        .hero-title {
            font-weight: 800;
            letter-spacing: -1px;
        }

        /* Section Headers */
        .section-separator {
            width: 50px;
            height: 4px;
            background: var(--accent);
            margin: 0 auto;
            border-radius: 2px;
        }

        /* Info Cards */
        .info-card {
            transition: 0.3s;
            border: none;
            border-top: 5px solid var(--primary);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            line-height: 80px;
            border-radius: 50%;
            background: #e8f5e9;
            color: var(--primary);
            font-size: 2.5rem;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mobile adjustments */
        @media (max-width: 767.98px) {
            .icon-circle {
                width: 60px;
                height: 60px;
                line-height: 60px;
                font-size: 1.8rem;
                margin-bottom: 15px;
            }

            .info-card {
                margin-bottom: 20px;
            }
        }

        /* Feedback Section */
        .feedback-wrapper {
            background: var(--dark);
            border-radius: 40px;
            color: white;
            padding: 60px 20px 80px;
            margin-bottom: 80px;
        }

        @media (max-width: 767.98px) {
            .feedback-wrapper {
                border-radius: 20px;
                padding: 30px 15px 40px;
                margin-bottom: 40px;
            }
        }

        .toggle-btn {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: transparent;
            transition: 0.3s;
            cursor: pointer;
        }

        .toggle-btn.active {
            background: var(--accent);
            color: #000;
            border-color: var(--accent);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Mobile toggle buttons */
        @media (max-width: 575.98px) {
            .toggle-btn {
                padding: 8px 16px;
                font-size: 0.9rem;
                width: 48%;
            }

            .d-flex.justify-content-center.gap-3 {
                flex-wrap: wrap;
                gap: 10px !important;
            }
        }

        /* Review Cards */
        .review-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: 0.3s;
        }

        .review-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            color: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .role-badge {
            font-size: 0.65rem;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-farmer {
            background: var(--accent);
            color: #000;
        }

        .badge-consumer {
            background: #bbdefb;
            color: #0d47a1;
        }

        /* Review card mobile adjustments */
        @media (max-width: 767.98px) {
            .col-md-6.col-lg-3 {
                margin-bottom: 20px;
            }

            .review-card {
                margin-bottom: 15px;
            }
        }

        .cta-box {
            background: white;
            border-radius: 25px;
            border: 2px dashed #ddd;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        @media (max-width: 767.98px) {
            .cta-box {
                padding: 30px 20px !important;
                margin: 0 15px;
            }

            .cta-box h2 {
                font-size: 1.5rem;
            }
        }

        .btn-custom-cta {
            background: var(--primary);
            color: white;
            border-radius: 50px;
            padding: 12px 40px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        @media (max-width: 575.98px) {
            .btn-custom-cta {
                padding: 10px 30px;
                font-size: 0.9rem;
                width: 100%;
                text-align: center;
            }
        }

        .btn-custom-cta:hover {
            background: var(--dark);
            color: white;
            transform: translateY(-2px);
        }

        /* View More Card */
        .view-more-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 200px;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }

        .view-more-card:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--accent);
            border-color: var(--accent);
        }

        /* Grid adjustments for mobile */
        @media (max-width: 767.98px) {
            .row.g-4 {
                margin-left: -8px;
                margin-right: -8px;
            }

            .row.g-4>[class*="col-"] {
                padding-left: 8px;
                padding-right: 8px;
            }
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>

    <div class="hero-section mb-5">
        <div class="container">
            <h1 class="hero-title display-4 mb-3">Empowering Agriculture</h1>
            <p class="lead fw-light mx-auto" style="max-width: 600px;">
                Building a transparent, sustainable future where farmers and consumers thrive together.
            </p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-success">What Drives Us</h2>
            <div class="section-separator"></div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="card info-card h-100 p-4 text-center">
                    <div class="card-body">
                        <div class="icon-circle">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Our Mission</h3>
                        <p class="text-muted">To eliminate unnecessary middlemen and ensure 100% of the value goes to
                            the hands that feed us.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card info-card h-100 p-4 text-center">
                    <div class="card-body">
                        <div class="icon-circle">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Our Promise</h3>
                        <p class="text-muted">Freshness guaranteed. We verify every listing to ensure you get
                            farm-to-table quality.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card info-card h-100 p-4 text-center">
                    <div class="card-body">
                        <div class="icon-circle">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Community</h3>
                        <p class="text-muted">We are a growing community of 5,000+ growers and conscious consumers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="feedback-wrapper">
            <div class="text-center mb-4">
                <h2 class="text-white fw-bold">Stories from the Field</h2>
                <div class="section-separator mb-3" style="background: var(--accent);"></div>
                <p class="text-white-50">Real experiences from our community.</p>
            </div>

            <div class="d-flex justify-content-center gap-3 mb-5 flex-wrap">
                <button class="toggle-btn active" id="btn-farmers" onclick="toggleCategory('farmers')">
                    <i class="fas fa-tractor me-2"></i> Farmers' Voice
                </button>
                <button class="toggle-btn" id="btn-consumers" onclick="toggleCategory('consumers')">
                    <i class="fas fa-shopping-basket me-2"></i> Buyers' Love
                </button>
            </div>

            <div id="farmers-container" class="row g-4">
                <?php if (mysqli_num_rows($farm_result) > 0) {
                    while ($row = mysqli_fetch_assoc($farm_result)) { ?>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card review-card h-100 p-3">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-circle">
                                                <?php echo strtoupper(substr($row['name'], 0, 1)); ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold small"><?php echo htmlspecialchars($row['name']); ?></div>
                                                <span
                                                    class="role-badge badge-farmer"><?php echo htmlspecialchars($row['location']); ?></span>
                                                <div class="small mt-1"><?php echo renderStars($row['rating']); ?></div>
                                            </div>
                                        </div>
                                        <small class="text-white-50"
                                            style="font-size: 0.75rem;"><?php echo formatDate($row['created_at']); ?></small>
                                    </div>
                                    <p class="fst-italic opacity-75 small mb-0 flex-grow-1">
                                        "<?php echo htmlspecialchars($row['review']); ?>"</p>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo "<div class='col-12 text-center text-white'><p>No farmer stories yet.</p></div>";
                } ?>

                <div class="col-12 col-sm-6 col-lg-3">
                    <a href="all_feedback.php?tab=farmers" class="card view-more-card h-100">
                        <i class="fas fa-arrow-right fa-2x mb-2"></i>
                        <span class="fw-bold text-center">View All<br>Farmer Stories</span>
                    </a>
                </div>
            </div>

            <div id="consumers-container" class="row g-4 d-none">
                <?php if (mysqli_num_rows($cons_result) > 0) {
                    while ($row = mysqli_fetch_assoc($cons_result)) { ?>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card review-card h-100 p-3">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-circle" style="color: #0d47a1;">
                                                <?php echo strtoupper(substr($row['name'], 0, 1)); ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold small"><?php echo htmlspecialchars($row['name']); ?></div>
                                                <span
                                                    class="role-badge badge-consumer"><?php echo htmlspecialchars($row['location']); ?></span>
                                                <div class="small mt-1"><?php echo renderStars($row['rating']); ?></div>
                                            </div>
                                        </div>
                                        <small class="text-white-50"
                                            style="font-size: 0.75rem;"><?php echo formatDate($row['created_at']); ?></small>
                                    </div>
                                    <p class="fst-italic opacity-75 small mb-0 flex-grow-1">
                                        "<?php echo htmlspecialchars($row['review']); ?>"</p>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo "<div class='col-12 text-center text-white'><p>No buyer stories yet.</p></div>";
                } ?>

                <div class="col-12 col-sm-6 col-lg-3">
                    <a href="all_feedback.php?tab=consumers" class="card view-more-card h-100">
                        <i class="fas fa-arrow-right fa-2x mb-2"></i>
                        <span class="fw-bold text-center">View All<br>Buyer Stories</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="cta-box p-5 text-center mx-auto" style="max-width: 800px;">
            <i class="fas fa-comment-dots text-success fa-3x mb-3"></i>
            <h2 class="fw-bold mb-3">Have a story or suggestion?</h2>
            <p class="text-muted mb-4">We are constantly improving. We want to hear from you!</p>
            <a href="feedback.php" class="btn-custom-cta">
                Share Your Feedback <i class="fas fa-paper-plane ms-2"></i>
            </a>
        </div>
    </div>

    <script>
        function toggleCategory(category) {
            const farmCont = document.getElementById('farmers-container');
            const consCont = document.getElementById('consumers-container');
            const btnFarm = document.getElementById('btn-farmers');
            const btnCons = document.getElementById('btn-consumers');

            if (category === 'farmers') {
                farmCont.classList.remove('d-none');
                consCont.classList.add('d-none');
                btnFarm.classList.add('active');
                btnCons.classList.remove('active');
            } else {
                farmCont.classList.add('d-none');
                consCont.classList.remove('d-none');
                btnFarm.classList.remove('active');
                btnCons.classList.add('active');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php include "footer.php"; ?>

</body>

</html>