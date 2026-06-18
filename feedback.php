<?php
include "php/db.php";

// 1. Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = "";
$msg_type = "";

// --- AUTO-FILL & DISABLE LOGIC ---
$name_val = "";
$role_val = "";
$is_readonly = "";
$disable_farmer = "";
$disable_consumer = "";
$farmer_class = "";
$consumer_class = "";

// If user is logged in, fetch their details
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_query = "SELECT * FROM users WHERE id = '$user_id'";
    $user_result = mysqli_query($conn, $user_query);
    
    if ($row = mysqli_fetch_assoc($user_result)) {
        $name_val = $row['name'];
        $role_val = $row['role']; 
        $is_readonly = "readonly"; 

        if ($role_val == 'farmer') {
            $disable_consumer = "disabled";
            $consumer_class = "disabled-label"; 
        } elseif ($role_val == 'consumer') {
            $disable_farmer = "disabled";
            $farmer_class = "disabled-label";
        }
    }
}

// 2. Handle Form Submission (RESTRICTED TO LOGGED IN)
if (isset($_POST['submit_review'])) {

    // Extra Check: Prevent submission if not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    
    // Logic: Use Session role if logged in
    if (!empty($role_val)) {
        $role = $role_val;
    } else {
        $role = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : '';
    }

    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $rating = (int) $_POST['rating'];
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    if ($role) {
        $sql = "INSERT INTO feedbacks (name, role, location, rating, review) 
                VALUES ('$name', '$role', '$location', '$rating', '$review')";

        if (mysqli_query($conn, $sql)) {
            $message = "Thank you! Your story has been published. 🌾";
            $msg_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $msg_type = "danger";
        }
    } else {
        $message = "Please select a role.";
        $msg_type = "warning";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Your Story | Harvest Hub</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2e7d32; 
            --dark: #1b5e20; 
            --accent: #fbc02d; 
            --light-bg: #f4f7f6; 
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0,0,0,0.08); 
            --text-dark: #333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            margin: 0;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex; 
            flex-direction: column;
        }

        .main-container {
            flex: 1; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 30px 15px;
        }

        .form-card {
            background: var(--white); 
            width: 100%; 
            max-width: 600px; 
            padding: 35px;
            border-radius: 20px; 
            box-shadow: var(--shadow); 
            border: 1px solid rgba(0,0,0,0.02);
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 25px 20px;
                margin: 10px 0;
            }
            
            .form-header h1 {
                font-size: 1.5rem !important;
            }
        }

        .form-header { 
            text-align: center; 
            margin-bottom: 25px; 
        }
        .form-header h1 { 
            font-size: 2rem; 
            color: var(--primary); 
            margin: 0 0 8px; 
            font-weight: 700; 
        }
        .form-header p { 
            color: #666; 
            font-size: 0.95rem; 
        }

        /* Custom Input Styling */
        .input-group-custom { 
            position: relative; 
            margin-bottom: 20px; 
        }
        .input-group-custom i { 
            position: absolute; 
            left: 15px; 
            top: 50%;
            transform: translateY(-50%); 
            color: #999; 
            z-index: 4;
        }

        .input-group-custom input[type="text"], 
        .input-group-custom textarea {
            width: 100%; 
            padding: 12px 15px 12px 45px; 
            border: 2px solid #eee;
            border-radius: 12px; 
            font-family: inherit; 
            font-size: 1rem; 
            box-sizing: border-box; 
            transition: 0.3s;
        }
        
        .input-group-custom input[type="text"]:focus, 
        .input-group-custom textarea:focus { 
            border-color: var(--primary); 
            outline: none; 
            background: #f9fcf9; 
            box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
        }
        
        .input-group-custom input[readonly] { 
            background-color: #f5f5f5; 
            color: #777; 
            cursor: not-allowed; 
        }
        
        .input-group-custom textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Role Selector */
        .role-selector { 
            display: flex; 
            gap: 15px; 
            margin-bottom: 25px; 
        }
        
        @media (max-width: 576px) {
            .role-selector {
                flex-direction: column;
                gap: 10px;
            }
        }
        
        .role-selector label { 
            flex: 1; 
            cursor: pointer; 
            border: 2px solid #eee; 
            border-radius: 12px; 
            padding: 20px 15px; 
            text-align: center; 
            transition: 0.3s; 
            color: #777;
            margin-bottom: 0;
        }
        
        .role-selector label.disabled-label { 
            opacity: 0.5; 
            background-color: #f5f5f5; 
            cursor: not-allowed; 
            border-color: #ddd; 
        }
        
        .role-selector input { 
            display: none; 
        }
        
        .role-selector label:has(input:checked) { 
            border-color: var(--primary); 
            background: #e8f5e9; 
            color: var(--primary);
            font-weight: bold;
        }
        
        .role-icon { 
            font-size: 1.8rem; 
            margin-bottom: 8px; 
            display: block; 
        }

        /* Star Rating */
        .rating-container {
            margin-bottom: 25px;
        }
        
        .rate { 
            display: inline-block;
            height: 46px; 
            padding: 0 10px; 
        }
        
        .rate:not(:checked) > input { 
            position: absolute; 
            top: -9999px; 
        }
        
        .rate:not(:checked) > label { 
            float: right; 
            width: 1em; 
            overflow: hidden; 
            white-space: nowrap; 
            cursor: pointer; 
            font-size: 30px; 
            color: #ccc; 
        }
        
        .rate:not(:checked) > label:before { 
            content: '★ '; 
        }
        
        .rate > input:checked ~ label { 
            color: #fbc02d; 
        }
        
        .rate:not(:checked) > label:hover, 
        .rate:not(:checked) > label:hover ~ label { 
            color: #deb217; 
        }
        
        .rate > input:checked + label:hover, 
        .rate > input:checked + label:hover ~ label, 
        .rate > input:checked ~ label:hover, 
        .rate > input:checked ~ label:hover ~ label, 
        .rate > label:hover ~ input:checked ~ label { 
            color: #c59b08; 
        }

        /* Buttons */
        .btn-main {
            width: 100%; 
            background: linear-gradient(135deg, var(--primary), var(--dark)); 
            color: white; 
            border: none; 
            padding: 15px;
            border-radius: 50px; 
            font-size: 1rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.3s;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            gap: 10px; 
            text-decoration: none;
        }
        
        .btn-main:hover { 
            background: var(--dark); 
            transform: translateY(-2px); 
            color: white;
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
        }

        .btn-login-req { 
            background: #e0e0e0; 
            color: #555; 
            cursor: pointer; 
        }
        
        .btn-login-req:hover { 
            background: #d6d6d6; 
            color: #333; 
        }

        .back-link { 
            display: block; 
            text-align: center; 
            margin-top: 20px; 
            color: #777; 
            text-decoration: none; 
            font-size: 0.9rem; 
        }
        
        .back-link:hover { 
            color: var(--primary); 
        }
        
        /* Mobile adjustments */
        @media (max-width: 576px) {
            .form-header h1 {
                font-size: 1.4rem !important;
            }
            
            .form-header p {
                font-size: 0.9rem;
            }
            
            .role-selector label {
                padding: 15px 10px;
            }
            
            .role-icon {
                font-size: 1.5rem;
            }
            
            .rate:not(:checked) > label {
                font-size: 25px;
            }
            
            .input-group-custom input[type="text"], 
            .input-group-custom textarea {
                padding: 10px 12px 10px 40px;
                font-size: 0.95rem;
            }
            
            .input-group-custom i {
                left: 12px;
            }
            
            .btn-main {
                padding: 12px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="main-container">
        <div class="form-card">
            
            <div class="form-header">
                <h1 class="mb-2">Share Your Experience ✍️</h1>
                <p class="text-muted mb-0">Your stories inspire our community.</p>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                    <?php if ($msg_type == 'success'): ?>
                        <i class="fas fa-check-circle me-2"></i>
                    <?php elseif ($msg_type == 'danger'): ?>
                        <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php elseif ($msg_type == 'warning'): ?>
                        <i class="fas fa-exclamation-circle me-2"></i>
                    <?php endif; ?>
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST">
                
                <div class="mb-4">
                    <label class="form-label fw-semibold">I am a...</label>
                    <div class="role-selector">
                        <label class="form-check-label w-100 <?php echo $farmer_class; ?>">
                            <input class="form-check-input" type="radio" name="role" value="farmer" 
                                <?php echo ($role_val == 'farmer' || $role_val == '') ? 'checked' : ''; ?>
                                <?php echo $disable_farmer; ?>>
                            <div>
                                <i class="fas fa-tractor role-icon"></i> 
                                <span>Farmer</span>
                            </div>
                        </label>
                        <label class="form-check-label w-100 <?php echo $consumer_class; ?>">
                            <input class="form-check-input" type="radio" name="role" value="consumer" 
                                <?php echo ($role_val == 'consumer') ? 'checked' : ''; ?>
                                <?php echo $disable_consumer; ?>>
                            <div>
                                <i class="fas fa-shopping-basket role-icon"></i> 
                                <span>Consumer</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full Name</label>
                        <div class="input-group-custom">
                            <i class="far fa-user"></i>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Rajesh Kumar" 
                                value="<?php echo htmlspecialchars($name_val); ?>" <?php echo $is_readonly; ?>>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Location / Title</label>
                        <div class="input-group-custom">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" name="location" class="form-control" required placeholder="e.g. Punjab">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold mb-3">Rate your experience</label>
                    <div class="rating-container">
                        <div class="rate">
                            <input type="radio" id="star5" name="rating" value="5" required />
                            <label for="star5" title="5 stars">5 stars</label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="4 stars">4 stars</label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="3 stars">3 stars</label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="2 stars">2 stars</label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="1 star">1 star</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Your Story</label>
                    <div class="input-group-custom">
                        <i class="fas fa-comment-alt" style="top: 20px; transform: none;"></i>
                        <textarea name="review" class="form-control" rows="4" required placeholder="How has Harvest Hub helped you?"></textarea>
                    </div>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <button type="submit" name="submit_review" class="btn btn-main mb-3">
                        <i class="fas fa-paper-plane me-2"></i>Submit Feedback
                    </button>
                <?php else: ?>
                    <a href="login.php" class="btn btn-main btn-login-req mb-3">
                        <i class="fas fa-lock me-2"></i>Login to Share Story
                    </a>
                <?php endif; ?>

            </form>
            
            <a href="about.php" class="back-link">
                <i class="fas fa-arrow-left me-1"></i> Back to About Us
            </a>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>