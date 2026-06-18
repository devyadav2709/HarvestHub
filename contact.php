<?php
// 1. Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "php/db.php";

$msg = "";
$msg_type = "";

// Check for success signal
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $msg = "Message sent successfully! ✅";
    $msg_type = "success";
}

// 2. Handle Form Submission (ONLY IF LOGGED IN)
if (isset($_POST['send'])) {

    if (!isset($_SESSION['user_id'])) {
        // Security fallback if someone tries to bypass UI
        header("Location: login.php");
        exit;
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, message) 
            VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>window.location.href='contact.php?status=success';</script>";
        exit;
    } else {
        $msg = "Error: " . mysqli_error($conn);
        $msg_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Harvest Hub</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #2e7d32;
            --dark: #1b5e20;
            --accent: #fbc02d;
            --light-bg: #f4f7f6;
            --text: #333;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            margin: 0;
            color: var(--text);
        }

        .page-header {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.squarespace-cdn.com/content/v1/5e449c8c3ef68d752f3e70dc/1600090865798-PEM6RJ1XKYIEDM4U3QP5/farmers-iStock-484897193.jpg');
            background-size: cover;
            background-position: center;
            height: 300px;
            margin-top: 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            margin-bottom: -50px;
            padding: 0 20px;
        }

        @media (max-width: 768px) {
            .page-header {
                height: 250px;
                margin-bottom: 0;
                padding: 0 15px;
            }

            .page-header h1 {
                font-size: 2rem !important;
            }

            .page-header p {
                font-size: 1rem !important;
            }
        }

        .page-header h1 {
            font-size: 3rem;
            margin: 0;
            font-weight: 800;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 10px;
        }

        .info-card {
            background: var(--primary);
            color: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            height: 100%;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .info-text h3 {
            margin: 0 0 5px;
            font-size: 1.1rem;
        }

        .info-text p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .form-card {
            background: var(--white);
            padding: 30px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            height: 100%;
        }

        .form-card h2 {
            color: var(--dark);
            margin-top: 0;
        }

        .form-card p {
            color: #666;
            margin-bottom: 25px;
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
            color: #aaa;
            z-index: 4;
        }

        .input-group-custom input,
        .input-group-custom textarea {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1rem;
            transition: 0.3s;
            box-sizing: border-box;
        }

        .input-group-custom input:focus,
        .input-group-custom textarea:focus {
            border-color: var(--primary);
            outline: none;
            background-color: #f9fcf9;
            box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
        }

        .input-group-custom textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Buttons */
        .btn-main {
            background: var(--primary);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
            text-decoration: none;
            width: 100%;
        }

        .btn-main:hover {
            background: var(--dark);
            transform: translateY(-2px);
            color: white;
        }

        /* Login Button Style */
        .btn-login-req {
            background: #e0e0e0;
            color: #555;
        }

        .btn-login-req:hover {
            background: #d6d6d6;
            color: #333;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .row.g-4 {
                margin-left: -10px;
                margin-right: -10px;
            }

            .row.g-4>[class*="col-"] {
                padding-left: 10px;
                padding-right: 10px;
            }

            .info-card,
            .form-card {
                padding: 25px 20px;
            }

            .icon-circle {
                width: 45px;
                height: 45px;
                font-size: 1rem;
                margin-right: 15px;
            }

            .btn-main {
                padding: 12px 25px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                height: 200px;
            }

            .page-header h1 {
                font-size: 1.8rem !important;
            }

            .info-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .icon-circle {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .input-group-custom input,
            .input-group-custom textarea {
                padding: 10px 12px 10px 40px;
                font-size: 0.95rem;
            }

            .input-group-custom i {
                left: 12px;
            }
        }
    </style>
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold">Get in Touch</h1>
            <p class="lead opacity-75">Have questions about crops, bidding, or selling? We're here to help.</p>
        </div>
    </div>

    <div class="container">
        <div class="row g-4 mt-4 mb-5">
            <div class="col-lg-5">
                <div class="info-card">
                    <div class="info-item">
                        <div class="icon-circle"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-text">
                            <h3><b>Our Office</b></h3>
                            <p>123 Greenway Lane,<br>Farmville, CA 90210</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="icon-circle"><i class="fas fa-phone-alt"></i></div>
                        <div class="info-text">
                            <h3><b>Call Us</b></h3>
                            <p>+1 (555) 123-4567<br>Mon-Fri, 9am-6pm</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="icon-circle"><i class="fas fa-envelope"></i></div>
                        <div class="info-text">
                            <h3><b>Email Us</b></h3>
                            <p>support@harvesthub.com<br>info@harvesthub.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="form-card">
                    <h2 class="mb-3"><b>Send a Message</b></h2>
                    <p class="text-muted mb-4">Fill out the form below and our team will get back to you shortly.</p>

                    <?php if ($msg): ?>
                        <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                            <?php if ($msg_type == 'success'): ?>
                                <i class="fas fa-check-circle me-2"></i>
                            <?php elseif ($msg_type == 'danger'): ?>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php endif; ?>
                            <?php echo $msg; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Your Name</label>
                            <div class="input-group-custom">
                                <i class="far fa-user"></i>
                                <input type="text" name="name" class="form-control" required
                                    placeholder="e.g. Alex Smith">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <div class="input-group-custom">
                                <i class="far fa-envelope"></i>
                                <input type="email" name="email" class="form-control" required
                                    placeholder="name@example.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Message</label>
                            <div class="input-group-custom">
                                <i class="far fa-comment-alt"></i>
                                <textarea name="message" class="form-control" required
                                    placeholder="How can we help you today?"></textarea>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button type="submit" name="send" class="btn btn-main">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-main btn-login-req">
                                <i class="fas fa-lock me-2"></i>Login to Send Message
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php include "footer.php"; ?>

</body>

</html>