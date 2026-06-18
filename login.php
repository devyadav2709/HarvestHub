<?php
// 1. Start session FIRST
session_start();

include "php/db.php";

// 2. Backend Logic
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Search for user
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    // Check password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'farmer') {
            header("Location: farmer_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Harvest Hub</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #2e7d32;
            --dark: #1b5e20;
            --light-bg: #f4f7f6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: #333;
            margin-top: 50px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Wrapper for centering */
        .wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 15px;
        }

        /* Card Container */
        .card-container {
            width: 100%;
            max-width: 1000px;
            background-color: #ffffff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }

        /* Left Panel */
        .left-panel {
            background-color: var(--primary);
            color: white;
            padding: 50px 40px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-icon {
            width: 60px;
            height: 60px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 25px;
        }

        .left-content h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: 700;
            line-height: 1.2;
        }

        .left-content p {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Right Panel */
        .right-panel {
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-form {
            width: 100%;
            max-width: 380px;
        }

        .auth-form h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: var(--primary);
        }

        .sub-text {
            color: #666;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        /* Form Inputs */
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.75rem;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

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
            z-index: 10;
        }

        .form-control-custom {
            width: 100%;
            padding: 14px 14px 14px 45px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            color: #333;
            font-family: inherit;
            font-size: 0.95rem;
            transition: 0.3s;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            outline: none;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
        }

        /* Button */
        .btn-main {
            width: 100%;
            padding: 14px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-main:hover {
            background-color: var(--dark);
            transform: translateY(-2px);
            color: white;
        }

        /* Footer Links */
        .footer-link {
            margin-top: 25px;
            text-align: center;
            font-size: 0.85rem;
            color: #666;
        }

        .footer-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }

        /* Error Message */
        .error-msg {
            background: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ffcdd2;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-container {
                border-radius: 20px;
                max-width: 500px;
            }

            .left-panel,
            .right-panel {
                padding: 30px 25px;
            }

            .left-content h1 {
                font-size: 2rem;
            }

            .auth-form h2 {
                font-size: 1.5rem;
            }

            .left-icon {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .wrapper {
                padding: 20px 15px;
            }

            .card-container {
                border-radius: 15px;
            }

            .left-panel,
            .right-panel {
                padding: 25px 20px;
            }

            .left-content h1 {
                font-size: 1.7rem;
            }

            .auth-form h2 {
                font-size: 1.3rem;
            }

            .form-control-custom {
                padding: 12px 12px 12px 40px;
            }

            .btn-main {
                padding: 12px;
            }
        }
    </style>
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="wrapper">
        <div class="card-container">
            <div class="row g-0">
                <!-- Left Panel -->
                <div class="col-lg-6">
                    <div class="left-panel">
                        <div class="left-content">
                            <div class="left-icon"><i class="fas fa-tractor"></i></div>
                            <h1>Welcome Back.</h1>
                            <p>Join thousands of local growers connecting directly with their community.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="col-lg-6">
                    <div class="right-panel">
                        <div class="auth-form">
                            <h2><b>Sign In</b></h2>
                            <p class="sub-text">Enter your details to access your account.</p>

                            <?php if (isset($error)): ?>
                                <div class="error-msg">
                                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                                </div>
                            <?php endif; ?>

                            <form method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group-custom">
                                        <i class="far fa-envelope"></i>
                                        <input type="email" name="email" id="email" class="form-control-custom" required
                                            placeholder="name@example.com">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group-custom">
                                        <i class="fas fa-lock"></i>
                                        <input type="password" name="password" id="password" class="form-control-custom"
                                            required placeholder="••••••••">
                                    </div>
                                </div>

                                <button type="submit" name="login" class="btn-main">
                                    Sign In <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </form>

                            <div class="footer-link">
                                New to Harvest Hub? <a href="register.php">Create Account</a>
                            </div>

                            <div class="text-center mt-3">
                                <a href="index.php" class="text-decoration-none" style="color:#999; font-size:0.8rem;">
                                    Return to Home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: Add form validation feedback -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add Bootstrap validation classes on form submit
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            form.addEventListener('submit', function (e) {
                // Remove previous validation classes
                emailInput.classList.remove('is-invalid');
                passwordInput.classList.remove('is-invalid');

                // Simple validation
                let isValid = true;

                if (!emailInput.value) {
                    emailInput.classList.add('is-invalid');
                    isValid = false;
                }

                if (!passwordInput.value) {
                    passwordInput.classList.add('is-invalid');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Remove validation classes on input
            emailInput.addEventListener('input', function () {
                this.classList.remove('is-invalid');
            });

            passwordInput.addEventListener('input', function () {
                this.classList.remove('is-invalid');
            });
        });
    </script>
</body>

</html>