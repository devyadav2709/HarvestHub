<?php
// 1. Start session FIRST
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure this path is correct based on your file structure
include "php/db.php";

$success = "";
$error = "";

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    csrf_verify();

    // Collect and sanitize input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate role
    $allowed_roles = ['farmer', 'consumer'];
    if (!in_array($role, $allowed_roles)) {
        $error = "Invalid role selected.";
    } elseif (strlen($name) < 2 || strlen($name) > 100) {
        $error = "Name must be between 2 and 100 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    }

    if (!$error) {
        // 1. Check if email already exists using a Prepared Statement
        $check_stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            // 2. Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 3. Insert user into database using a Prepared Statement
            $insert_stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

            if ($insert_stmt->execute()) {
                $success = "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $error = "Something went wrong. Please try again later.";
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
} // <-- This is the closing brace that was missing
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Harvest Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Wrapper */
        .wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 150px 37px;
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
            margin-bottom: 25px;
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
            margin-bottom: 15px;
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
            padding: 12px 12px 12px 45px;
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

        /* Role Selector */
        .role-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .role-selector input {
            display: none;
        }

        .role-label {
            flex: 1;
            cursor: pointer;
            text-align: center;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 0.9rem;
            text-transform: none;
            margin: 0;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .role-label i {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        /* Checked State */
        .role-selector input:checked+.role-label {
            background-color: #e8f5e9;
            border-color: var(--primary);
            color: var(--primary);
            font-weight: 700;
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
            margin-top: 20px;
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

        /* Messages */
        .msg-box {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .msg-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        .msg-success {
            background: #e8f5e9;
            color: var(--primary);
            border: 1px solid #c8e6c9;
        }

        .msg-success a {
            text-decoration: underline;
            font-weight: bold;
            color: var(--dark);
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

            .role-selector {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <?php include "navbar.php"; ?>

    <div class="wrapper">
        <div class="card-container">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="left-panel">
                        <div class="left-content">
                            <div class="left-icon"><i class="fas fa-seedling"></i></div>
                            <h1>Join Us.</h1>
                            <p>Start your journey towards transparent and fair agricultural trading today.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="right-panel">
                        <div class="auth-form">
                            <h2><b>Create Account</b></h2>
                            <p class="sub-text">Fill in your details to get started.</p>

                            <?php if ($error): ?>
                                <div class="msg-box msg-error">
                                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($success): ?>
                                <div class="msg-box msg-success">
                                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                                </div>
                            <?php endif; ?>

                            <form action="register.php" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <div class="input-group-custom">
                                        <i class="far fa-user"></i>
                                        <input type="text" name="name" id="name" class="form-control-custom" required
                                            placeholder="John Doe">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
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

                                <div class="mb-4">
                                    <label class="form-label">I am a...</label>
                                    <div class="role-selector">
                                        <input type="radio" name="role" value="consumer" id="role-consumer" checked>
                                        <label for="role-consumer" class="role-label">
                                            <i class="fas fa-shopping-basket"></i> Consumer
                                        </label>

                                        <input type="radio" name="role" value="farmer" id="role-farmer">
                                        <label for="role-farmer" class="role-label">
                                            <i class="fas fa-tractor"></i> Farmer
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn-main">
                                    Sign Up <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </form>

                            <div class="footer-link">
                                Already have an account? <a href="login.php">Sign In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>