<?php
// admin_panel.php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

include "php/db.php";

// --- ADMIN LOGIN LOGIC ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
   if (isset($_POST['admin_login'])) {
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = $_POST['password'];

      $sql = "SELECT * FROM admin WHERE email = '$email'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
         $admin = mysqli_fetch_assoc($result);
         if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $admin['email'];
            header("Location: admin_panel.php");
            exit();
         } else {
            $login_error = "Invalid password. Please try again.";
         }
      } else {
         $login_error = "Admin account not found.";
      }
   }
   ?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin Login | Harvest Hub</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
         rel="stylesheet">
      <style>
         body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?q=80&w=2070&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin: 0;
         }

         body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(5, 150, 105, 0.75) 100%);
            z-index: 1;
         }

         .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1000px;
            padding: 2rem;
            animation: fadeIn 0.6s ease-out;
         }

         @keyframes fadeIn {
            from {
               opacity: 0;
               transform: translateY(20px);
            }

            to {
               opacity: 1;
               transform: translateY(0);
            }
         }

         .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.4);
         }

         .login-left {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 5rem 4rem;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
         }

         .login-left::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.1;
            pointer-events: none;
         }

         .brand-icon {
            width: 80px;
            height: 80px;
            background: #ffffff;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #059669;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
         }

         .brand-text {
            font-weight: 800;
            font-size: 2.75rem;
            letter-spacing: -1px;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
         }

         .login-right {
            padding: 5rem 4rem;
            background: #ffffff;
         }

         .form-floating>.form-control {
            border: 2px solid #f1f5f9;
            border-radius: 16px;
            font-weight: 500;
            color: #1e293b;
            padding: 1rem 1.25rem;
            height: auto;
            transition: all 0.3s ease;
            background: #f8fafc;
         }

         .form-floating>.form-control:focus {
            border-color: #10b981;
            background: #ffffff;
            box-shadow: 0 0 0 5px rgba(16, 185, 129, 0.1);
         }

         .form-floating>label {
            color: #64748b;
            padding: 1rem 1.25rem;
            font-weight: 500;
         }

         .btn-login {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 1.2rem;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
            letter-spacing: 0.5px;
         }

         .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
            color: white;
         }
      </style>
   </head>

   <body>
      <div class="login-wrapper">
         <div class="card login-card border-0">
            <div class="row g-0">
               <div class="col-md-5 login-left d-none d-md-flex">
                  <div class="brand-icon">
                     <i class="fas fa-leaf"></i>
                  </div>
                  <div class="brand-text">Harvest Hub</div>
                  <p class="mb-0 text-white-50 fw-medium" style="z-index: 2;">Secure Admin Control Panel</p>
               </div>
               <div class="col-md-7 login-right d-flex flex-column justify-content-center">
                  <div class="d-md-none text-center mb-4">
                     <div class="brand-icon mx-auto" style="background: #10b981; color: white;">
                        <i class="fas fa-leaf"></i>
                     </div>
                     <h2 class="fw-bold mt-3 text-dark">Harvest Hub</h2>
                  </div>
                  <h2 class="fw-bold text-dark mb-2" style="font-size: 2.2rem;">Welcome Back 👋</h2>
                  <p class="text-muted mb-5 fs-5">Sign in to manage the platform.</p>

                  <?php if (isset($login_error)): ?>
                     <div
                        class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-4 d-flex align-items-center mb-4 p-3"
                        role="alert">
                        <i class="fas fa-exclamation-circle me-3 fs-5"></i>
                        <div class="fw-medium"><?php echo $login_error; ?></div>
                     </div>
                  <?php endif; ?>

                  <form method="post">
                     <div class="form-floating mb-4">
                        <input type="email" name="email" class="form-control" id="floatingEmail"
                           placeholder="name@example.com" required>
                        <label for="floatingEmail">Email address</label>
                     </div>
                     <div class="form-floating mb-5">
                        <input type="password" name="password" class="form-control" id="floatingPassword"
                           placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                     </div>
                     <button type="submit" name="admin_login" class="btn btn-login w-100 mt-2">
                        Sign In <i class="fas fa-arrow-right ms-2"></i>
                     </button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </body>

   </html>
   <?php
   exit();
}

// --- INITIALIZE VARIABLES ---
$message = '';
$table = isset($_GET['table']) ? $_GET['table'] : 'users';
$view_user_id = isset($_GET['view_user']) ? $_GET['view_user'] : null;
$view_consumer_id = isset($_GET['view_consumer']) ? $_GET['view_consumer'] : null;

// --- HANDLE POST REQUESTS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   // 1. DELETE
   if (isset($_POST['delete'])) {
      $id = $_POST['id'];
      $tbl = $_POST['table'];

      if ($tbl === 'purchases') {
         $purchase_query = mysqli_query($conn, "SELECT product_id FROM purchases WHERE id = $id");
         if ($purchase = mysqli_fetch_assoc($purchase_query)) {
            mysqli_query($conn, "UPDATE products SET is_sold = 0, status = 'active' WHERE id = {$purchase['product_id']}");
         }
      }

      mysqli_query($conn, "DELETE FROM $tbl WHERE id = $id");
      header("Location: " . $_SERVER['REQUEST_URI']);
      exit();
   }

   // 2. ADD RECORD
   if (isset($_POST['add'])) {
      $tbl = $_POST['table'];

      if ($tbl === 'users') {
         $name = mysqli_real_escape_string($conn, $_POST['name']);
         $email = mysqli_real_escape_string($conn, $_POST['email']);
         $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
         $role = $_POST['role'];
         mysqli_query($conn, "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");

      } elseif ($tbl === 'products') {
         $name = mysqli_real_escape_string($conn, $_POST['name']);
         $desc = mysqli_real_escape_string($conn, $_POST['description']);
         $price = $_POST['base_price'];
         $user_id = $_POST['user_id'];
         $status = 'active';
         $bid_end = $_POST['bid_end'];

         $image = 'default.jpg';
         if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
            $target_dir = "images/";
            if (!file_exists($target_dir))
               mkdir($target_dir, 0777, true);
            $image_name = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $image_name;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
               $image = $image_name;
            }
         }

         $sql = "INSERT INTO products (name, description, base_price, price, image, status, user_id, farmer_id, bid_end, is_sold) 
                 VALUES ('$name', '$desc', '$price', '$price', '$image', '$status', '$user_id', '$user_id', '$bid_end', 0)";
         mysqli_query($conn, $sql);

      } elseif ($tbl === 'purchases') {
         $product_id = $_POST['product_id'];
         $user_id = $_POST['user_id'];
         $purchase_amount = $_POST['purchase_amount'];
         $payment_method = $_POST['payment_method'];
         $transaction_id = 'ADMIN_' . time() . rand(100, 999);

         $product_check = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
         if (mysqli_num_rows($product_check) > 0) {
            mysqli_query($conn, "UPDATE products SET is_sold = 1, status = 'sold' WHERE id = '$product_id'");
            $sql = "INSERT INTO purchases (product_id, user_id, purchase_amount, payment_method, transaction_id, status) 
                    VALUES ('$product_id', '$user_id', '$purchase_amount', '$payment_method', '$transaction_id', 'completed')";
            mysqli_query($conn, $sql);
         }
      }

      header("Location: " . $_SERVER['REQUEST_URI']);
      exit();
   }

   // 3. UPDATE RECORD
   if (isset($_POST['update'])) {
      $id = $_POST['id'];
      $tbl = $_POST['table'];

      if ($tbl === 'users') {
         $name = mysqli_real_escape_string($conn, $_POST['name']);
         $email = mysqli_real_escape_string($conn, $_POST['email']);
         $role = $_POST['role'];
         mysqli_query($conn, "UPDATE users SET name='$name', email='$email', role='$role' WHERE id = $id");

      } elseif ($tbl === 'products') {
         $name = mysqli_real_escape_string($conn, $_POST['name']);
         $price = $_POST['base_price'];
         $status = $_POST['status'];
         $desc = mysqli_real_escape_string($conn, $_POST['description']);

         $img_sql_part = "";
         if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
            $target_dir = "images/";
            if (!file_exists($target_dir))
               mkdir($target_dir, 0777, true);
            $image_name = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $image_name;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
               $img_sql_part = ", image='$image_name'";
            }
         }

         $sql = "UPDATE products SET name='$name', base_price='$price', price='$price', status='$status', description='$desc' $img_sql_part WHERE id = $id";
         mysqli_query($conn, $sql);
      } elseif ($tbl === 'purchases') {
         $status = $_POST['status'];
         $sql = "UPDATE purchases SET status='$status' WHERE id = $id";
         mysqli_query($conn, $sql);
      }

      header("Location: " . $_SERVER['REQUEST_URI']);
      exit();
   }

   if (isset($_POST['logout'])) {
      session_destroy();
      header("Location: admin_panel.php");
      exit();
   }
}

// --- DATA FETCHING ---
function getData($conn, $table)
{
   if ($table == 'products')
      return mysqli_query($conn, "SELECT p.*, u.name as farmer_name FROM products p LEFT JOIN users u ON p.user_id = u.id ORDER BY p.id DESC");
   if ($table == 'bids')
      return mysqli_query($conn, "SELECT b.*, u.name as bidder_name, p.name as product_name FROM bids b LEFT JOIN users u ON b.user_id = u.id LEFT JOIN products p ON b.product_id = p.id ORDER BY b.id DESC");
   if ($table == 'purchases') {
      // Get all consumers with their purchase stats
      $consumers_query = mysqli_query($conn, "SELECT u.id, u.name, u.email, u.role, 
                                              COUNT(pur.id) as total_orders, 
                                              COALESCE(SUM(pur.purchase_amount), 0) as total_spent,
                                              MAX(pur.purchase_date) as last_purchase
                                              FROM users u 
                                              LEFT JOIN purchases pur ON u.id = pur.user_id 
                                              WHERE u.role = 'consumer' 
                                              GROUP BY u.id 
                                              ORDER BY total_spent DESC");
      return $consumers_query;
   }
   if ($table == 'consumer_purchases' && isset($_GET['consumer_id'])) {
      $consumer_id = mysqli_real_escape_string($conn, $_GET['consumer_id']);
      return mysqli_query($conn, "SELECT pur.*, p.name as product_name, p.image as product_image, p.description as product_description 
                                   FROM purchases pur 
                                   LEFT JOIN products p ON pur.product_id = p.id 
                                   WHERE pur.user_id = '$consumer_id' 
                                   ORDER BY pur.purchase_date DESC");
   }
   if ($table == 'sales_report') {
      $report = [];
      $report['total_sales'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count, SUM(purchase_amount) as total FROM purchases"))['count'];
      $report['monthly_sales'] = mysqli_query($conn, "SELECT MONTH(purchase_date) as month, YEAR(purchase_date) as year, COUNT(*) as count, SUM(purchase_amount) as total FROM purchases GROUP BY YEAR(purchase_date), MONTH(purchase_date) ORDER BY year DESC, month DESC");
      $report['top_products'] = mysqli_query($conn, "SELECT p.name, COUNT(pur.id) as sales_count, SUM(pur.purchase_amount) as revenue FROM purchases pur LEFT JOIN products p ON pur.product_id = p.id GROUP BY pur.product_id ORDER BY revenue DESC LIMIT 10");
      $report['top_customers'] = mysqli_query($conn, "SELECT u.name, COUNT(pur.id) as purchases, SUM(pur.purchase_amount) as spent FROM purchases pur LEFT JOIN users u ON pur.user_id = u.id GROUP BY pur.user_id ORDER BY spent DESC LIMIT 10");
      return $report;
   }
   return mysqli_query($conn, "SELECT * FROM $table ORDER BY id DESC");
}

// Get consumer purchases if requested
if ($table == 'consumer_purchases' && isset($_GET['consumer_id'])) {
   $consumer_id = mysqli_real_escape_string($conn, $_GET['consumer_id']);
   $consumer_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$consumer_id' AND role = 'consumer'"));
   $purchases_data = getData($conn, 'consumer_purchases');
} else {
   $data = getData($conn, $table);
}

// --- FETCH SPECIFIC USER DETAILS ---
if ($view_user_id) {
   $u_res = mysqli_query($conn, "SELECT * FROM users WHERE id = '$view_user_id'");
   $user_details = mysqli_fetch_assoc($u_res);
   $user_products = mysqli_query($conn, "SELECT * FROM products WHERE farmer_id = '$view_user_id' ORDER BY id DESC");
   $total_products = mysqli_num_rows($user_products);
   $user_purchases = mysqli_query($conn, "SELECT pur.*, p.name as product_name, p.image as product_image FROM purchases pur LEFT JOIN products p ON pur.product_id = p.id WHERE pur.user_id = '$view_user_id' ORDER BY pur.purchase_date DESC");
   $total_purchases = mysqli_num_rows($user_purchases);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Dashboard | Harvest Hub</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
      rel="stylesheet">
   <style>
      :root {
         --primary: #2e7d32;
         --primary-hover: #047857;
         --primary-light: #d1fae5;
         --bg-body: #f4f7fe;
         --bg-surface: #ffffff;
         --sidebar-bg: #0f172a;
         --sidebar-text: #94a3b8;
         --sidebar-hover: #1e293b;
         --sidebar-active: #10b981;
         --text-dark: #1e293b;
         --text-muted: #64748b;
         --border-color: #e2e8f0;
         --sidebar-width: 280px;
         --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
         --shadow-md: 0 10px 30px 0 rgba(82, 63, 105, 0.05);
         --shadow-lg: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
      }

      body {
         font-family: 'Plus Jakarta Sans', sans-serif;
         background: var(--bg-body);
         color: var(--text-dark);
         overflow-x: hidden;
      }

      /* Scrollbar */
      ::-webkit-scrollbar {
         width: 6px;
         height: 6px;
      }

      ::-webkit-scrollbar-track {
         background: transparent;
      }

      ::-webkit-scrollbar-thumb {
         background: #cbd5e1;
         border-radius: 10px;
      }

      ::-webkit-scrollbar-thumb:hover {
         background: #94a3b8;
      }

      /* Typography */
      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
         font-weight: 700;
         letter-spacing: -0.02em;
      }

      /* Sidebar */
      .sidebar {
         width: var(--sidebar-width);
         background: var(--sidebar-bg);
         height: 100vh;
         position: fixed;
         left: 0;
         top: 0;
         z-index: 1000;
         transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
         display: flex;
         flex-direction: column;
         box-shadow: 4px 0 24px rgba(0, 0, 0, 0.05);
      }

      .sidebar-header {
         padding: 2.5rem 1.5rem 1.5rem;
         display: flex;
         align-items: center;
         gap: 15px;
         text-decoration: none;
      }

      .brand-icon {
         width: 44px;
         height: 44px;
         background: linear-gradient(135deg, var(--primary) 0%, #10b981 100%);
         border-radius: 14px;
         display: flex;
         align-items: center;
         justify-content: center;
         color: white;
         font-size: 1.25rem;
         box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
      }

      .brand-text {
         font-weight: 800;
         font-size: 1.5rem;
         color: white;
         letter-spacing: -0.5px;
      }

      .sidebar-nav {
         padding: 1rem 1.25rem;
         flex-grow: 1;
         overflow-y: auto;
      }

      .nav-link {
         display: flex;
         align-items: center;
         padding: 0.875rem 1.25rem;
         color: var(--sidebar-text);
         font-weight: 600;
         border-radius: 14px;
         margin-bottom: 0.5rem;
         transition: all 0.3s ease;
         gap: 15px;
         text-decoration: none;
      }

      .nav-link i {
         font-size: 1.2rem;
         width: 24px;
         text-align: center;
         transition: transform 0.3s;
      }

      .nav-link:hover {
         background: var(--sidebar-hover);
         color: #f8fafc;
      }

      .nav-link:hover i {
         transform: scale(1.1);
         color: var(--sidebar-active);
      }

      .nav-link.active {
         background: linear-gradient(90deg, var(--primary) 0%, #10b981 100%);
         color: white;
         box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
      }

      .nav-link.active i {
         color: white !important;
      }

      .sidebar-footer {
         padding: 1.5rem;
      }

      /* Main Content */
      .main-content {
         margin-left: var(--sidebar-width);
         padding: 2rem 2.5rem;
         min-height: 100vh;
         transition: margin 0.3s ease;
      }

      /* Top Header */
      .top-header {
         background: rgba(255, 255, 255, 0.9);
         backdrop-filter: blur(12px);
         border-radius: 20px;
         padding: 1.25rem 1.75rem;
         margin-bottom: 2.5rem;
         display: flex;
         justify-content: space-between;
         align-items: center;
         box-shadow: var(--shadow-sm);
         border: 1px solid rgba(255, 255, 255, 0.5);
      }

      .page-title {
         font-size: 1.5rem;
         color: var(--text-dark);
         margin: 0;
         display: flex;
         align-items: center;
         gap: 12px;
      }

      .page-title i {
         color: var(--primary);
         background: var(--primary-light);
         padding: 10px;
         border-radius: 12px;
         font-size: 1.25rem;
      }

      /* Cards & Containers */
      .content-card {
         background: var(--bg-surface);
         border-radius: 20px;
         border: none;
         box-shadow: var(--shadow-md);
         overflow: hidden;
         margin-bottom: 2rem;
         transition: transform 0.3s, box-shadow 0.3s;
      }

      .card-header-custom {
         padding: 1.5rem 2rem;
         border-bottom: 1px solid var(--border-color);
         display: flex;
         justify-content: space-between;
         align-items: center;
         background: #ffffff;
      }

      .card-header-custom h5 {
         margin: 0;
         color: var(--text-dark);
         display: flex;
         align-items: center;
         gap: 10px;
      }

      .card-body-custom {
         padding: 2rem;
      }

      /* Custom Accordion overrides for Bids & Purchases Grouping */
      .custom-accordion .accordion-button::after {
         filter: invert(0.5);
      }

      .custom-accordion .accordion-button:not(.collapsed) {
         background-color: #f8fafc !important;
         color: var(--text-dark);
         box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .05);
      }

      .custom-accordion .accordion-button:focus {
         box-shadow: none;
         border-color: rgba(0, 0, 0, .125);
      }

      /* Stat Cards */
      .stat-card {
         background: var(--bg-surface);
         border-radius: 20px;
         padding: 2rem;
         border: none;
         box-shadow: var(--shadow-md);
         position: relative;
         overflow: hidden;
         transition: transform 0.3s ease;
         display: flex;
         flex-direction: column;
         justify-content: center;
      }

      .stat-card:hover {
         transform: translateY(-5px);
      }

      .stat-card-icon {
         position: absolute;
         right: -20px;
         bottom: -20px;
         font-size: 7rem;
         opacity: 0.04;
         color: var(--text-dark);
         z-index: 0;
      }

      .stat-card h3 {
         color: var(--text-muted);
         font-size: 0.9rem;
         font-weight: 700;
         text-transform: uppercase;
         letter-spacing: 0.05em;
         margin-bottom: 0.5rem;
         position: relative;
         z-index: 1;
      }

      .stat-card .number {
         font-size: 2.25rem;
         font-weight: 800;
         color: var(--text-dark);
         margin: 0;
         position: relative;
         z-index: 1;
      }

      /* Tables */
      .table-responsive {
         border-radius: 16px;
         overflow-x: auto;
      }

      .table {
         margin-bottom: 0;
         color: var(--text-dark);
         border-collapse: separate;
         border-spacing: 0;
      }

      .table th {
         background: #f8fafc;
         color: #64748b;
         font-weight: 700;
         text-transform: uppercase;
         font-size: 0.75rem;
         letter-spacing: 0.05em;
         padding: 1.25rem 1.5rem;
         border-bottom: 1px solid var(--border-color);
         border-top: none;
      }

      .table td {
         padding: 1.25rem 1.5rem;
         vertical-align: middle;
         border-bottom: 1px solid var(--border-color);
         font-size: 0.95rem;
         font-weight: 500;
      }

      .table tbody tr {
         transition: background-color 0.2s;
      }

      .table tbody tr:hover {
         background-color: #f8fafc;
      }

      .table tbody tr:last-child td {
         border-bottom: none;
      }

      .table-img {
         width: 48px;
         height: 48px;
         border-radius: 12px;
         object-fit: cover;
         box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      }

      /* Badges */
      .status-badge {
         padding: 0.4rem 0.85rem;
         border-radius: 50rem;
         font-size: 0.75rem;
         font-weight: 700;
         letter-spacing: 0.03em;
         display: inline-flex;
         align-items: center;
         text-transform: uppercase;
      }

      .status-active,
      .status-completed {
         background: #dcfce7;
         color: #166534;
      }

      .status-pending {
         background: #fef9c3;
         color: #854d0e;
      }

      .status-sold,
      .status-delivered {
         background: #dbeafe;
         color: #1e40af;
      }

      .status-cancelled {
         background: #fee2e2;
         color: #991b1b;
      }

      .status-farmer {
         background: #e0e7ff;
         color: #3730a3;
      }

      .status-consumer {
         background: #ffedd5;
         color: #9a3412;
      }

      .status-admin {
         background: #f3e8ff;
         color: #6b21a8;
      }

      /* Buttons */
      .btn {
         font-weight: 600;
         padding: 0.6rem 1.25rem;
         border-radius: 12px;
         transition: all 0.3s ease;
         font-size: 0.9rem;
         display: inline-flex;
         align-items: center;
         justify-content: center;
      }

      .btn-primary {
         background: linear-gradient(135deg, var(--primary) 0%, #10b981 100%);
         border: none;
         color: white;
         box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
      }

      .btn-primary:hover {
         background: linear-gradient(135deg, #047857 0%, #059669 100%);
         transform: translateY(-2px);
         box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3);
      }

      .btn-outline-danger {
         color: #ef4444;
         border-color: #fecaca;
         background: #fef2f2;
      }

      .btn-outline-danger:hover {
         background: #ef4444;
         color: white;
         border-color: #ef4444;
      }

      .action-buttons .btn-sm {
         padding: 0.4rem 0.6rem;
         border-radius: 10px;
         margin-left: 0.4rem;
      }

      /* Forms */
      .form-container {
         background: #f8fafc;
         border-radius: 20px;
         padding: 2.5rem;
         margin-bottom: 2rem;
         border: 1px dashed #cbd5e1;
      }

      .form-label {
         font-weight: 600;
         color: #475569;
         font-size: 0.875rem;
         margin-bottom: 0.5rem;
      }

      .form-control,
      .form-select {
         border: 1px solid #cbd5e1;
         border-radius: 12px;
         padding: 0.75rem 1rem;
         font-size: 0.95rem;
         transition: all 0.3s;
         background-color: #ffffff;
      }

      .form-control:focus,
      .form-select:focus {
         border-color: var(--primary);
         box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
      }

      /* Consumer Cards */
      .consumer-card {
         background: var(--bg-surface);
         border-radius: 16px;
         padding: 1.5rem;
         margin-bottom: 1rem;
         border: 1px solid var(--border-color);
         transition: all 0.3s ease;
         cursor: pointer;
      }

      .consumer-card:hover {
         transform: translateY(-2px);
         box-shadow: var(--shadow-md);
         border-color: var(--primary);
      }

      .consumer-avatar {
         width: 60px;
         height: 60px;
         background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         color: var(--primary);
         font-size: 1.5rem;
         font-weight: 700;
         border: 2px solid var(--primary);
      }

      .consumer-stats {
         display: flex;
         gap: 2rem;
         margin-top: 1rem;
         padding-top: 1rem;
         border-top: 1px solid var(--border-color);
      }

      .stat-item {
         text-align: center;
      }

      .stat-label {
         font-size: 0.75rem;
         color: var(--text-muted);
         text-transform: uppercase;
         font-weight: 600;
      }

      .stat-value {
         font-size: 1.1rem;
         font-weight: 700;
         color: var(--text-dark);
      }

      /* Mobile Adjustments */
      .mobile-header {
         display: none;
         background: rgba(255, 255, 255, 0.95);
         backdrop-filter: blur(10px);
         padding: 1rem 1.5rem;
         position: sticky;
         top: 0;
         z-index: 999;
         box-shadow: var(--shadow-sm);
         border-bottom: 1px solid var(--border-color);
      }

      .menu-toggle {
         background: none;
         border: none;
         font-size: 1.5rem;
         color: var(--text-dark);
         cursor: pointer;
      }

      .sidebar-overlay {
         display: none;
         position: fixed;
         inset: 0;
         background: rgba(15, 23, 42, 0.6);
         z-index: 998;
         backdrop-filter: blur(4px);
      }

      .mobile-table-cards {
         display: none;
      }

      @media (max-width: 992px) {
         .sidebar {
            transform: translateX(-100%);
         }

         .sidebar.active {
            transform: translateX(0);
         }

         .main-content {
            margin-left: 0;
            padding: 1.5rem;
         }

         .mobile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
         }

         .sidebar-overlay.active {
            display: block;
         }

         .top-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
            border-radius: 16px;
         }

         .desktop-table {
            display: none;
         }

         .mobile-table-cards {
            display: block;
         }

         .data-card {
            background: var(--bg-surface);
            border: none;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.25rem;
            box-shadow: var(--shadow-md);
         }

         .data-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
         }

         .data-card-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            font-size: 0.9rem;
         }

         .data-card-label {
            color: var(--text-muted);
            font-weight: 600;
         }

         .data-card-value {
            font-weight: 600;
            color: var(--text-dark);
            text-align: right;
         }

         .data-card-actions {
            margin-top: 1.25rem;
            display: flex;
            gap: 0.75rem;
         }

         .data-card-actions .btn {
            flex: 1;
            justify-content: center;
         }
      }
   </style>
</head>

<body>
   <div class="mobile-header">
      <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
      <a href="?table=users" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
         <div class="brand-icon" style="width: 35px; height: 35px; font-size: 1rem;"><i class="fas fa-leaf"></i></div>
         <span class="fw-bold fs-5">Harvest Hub</span>
      </a>
      <div style="width: 35px;"></div>
   </div>

   <div class="sidebar-overlay" id="sidebarOverlay"></div>

   <div class="sidebar" id="sidebar">
      <a href="?table=users" class="sidebar-header">
         <div class="brand-icon"><i class="fas fa-leaf"></i></div>
         <span class="brand-text">Harvest Hub</span>
      </a>

      <div class="sidebar-nav">
         <a href="?table=users" class="nav-link <?php echo ($table == 'users' && !$view_user_id) ? 'active' : ''; ?>">
            <i class="fas fa-users"></i><span>Users</span>
         </a>
         <a href="?table=products" class="nav-link <?php echo $table == 'products' ? 'active' : ''; ?>">
            <i class="fas fa-seedling"></i><span>Products</span>
         </a>
         <a href="?table=bids" class="nav-link <?php echo $table == 'bids' ? 'active' : ''; ?>">
            <i class="fas fa-gavel"></i><span>Bids</span>
         </a>
         <a href="?table=purchases" class="nav-link <?php echo $table == 'purchases' ? 'active' : ''; ?>">
            <i class="fas fa-shopping-cart"></i><span>Purchases</span>
         </a>
         <a href="?table=sales_report" class="nav-link <?php echo $table == 'sales_report' ? 'active' : ''; ?>">
            <i class="fas fa-chart-pie"></i><span>Analytics</span>
         </a>
         <a href="?table=contact_messages" class="nav-link <?php echo $table == 'contact_messages' ? 'active' : ''; ?>">
            <i class="fas fa-envelope"></i><span>Messages</span>
         </a>
      </div>

      <div class="sidebar-footer">
         <a href="index.php" target="_blank" class="nav-link mb-0" style="background: rgba(255,255,255,0.08);">
            <i class="fas fa-external-link-alt"></i><span>View Website</span>
         </a>
      </div>
   </div>

   <div class="main-content" id="mainContent">
      <div class="top-header">
         <h1 class="page-title">
            <i class="fas fa-<?php
            if ($view_user_id)
               echo 'user-circle';
            elseif ($table == 'users')
               echo 'users';
            elseif ($table == 'products')
               echo 'seedling';
            elseif ($table == 'bids')
               echo 'gavel';
            elseif ($table == 'purchases')
               echo 'shopping-cart';
            elseif ($table == 'sales_report')
               echo 'chart-pie';
            elseif ($table == 'contact_messages')
               echo 'envelope';
            else
               echo 'border-all';
            ?>"></i>
            <?php
            if ($view_user_id)
               echo "User Profile";
            elseif ($table == 'users')
               echo "User Management";
            elseif ($table == 'products')
               echo "Product Inventory";
            elseif ($table == 'purchases') {
               if (isset($consumer_info)) {
                  echo "Purchase History - " . htmlspecialchars($consumer_info['name']);
               } else {
                  echo "Consumers";
               }
            } elseif ($table == 'sales_report')
               echo "Analytics Dashboard";
            else
               echo ucfirst(str_replace('_', ' ', $table));
            ?>
         </h1>
         <form method="POST" class="m-0">
            <button type="submit" name="logout" class="btn btn-outline-danger shadow-sm">
               <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
         </form>
      </div>

      <?php if ($view_user_id && $user_details): ?>
         <div class="content-card">
            <div class="card-header-custom">
               <div>
                  <h4 class="mb-1 text-dark d-flex align-items-center gap-3">
                     <?php echo htmlspecialchars($user_details['name'] ?? 'Unknown User'); ?>
                     <?php if (!empty($user_details['role'])): ?>
                        <span class="status-badge status-<?php echo $user_details['role']; ?>">
                           <?php echo ucfirst($user_details['role']); ?>
                        </span>
                     <?php endif; ?>
                  </h4>
                  <p class="text-muted mb-0"><i
                        class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($user_details['email'] ?? 'N/A'); ?>
                  </p>
               </div>
               <a href="?table=users" class="btn btn-outline-secondary bg-light border-0">
                  <i class="fas fa-arrow-left me-2"></i>Back
               </a>
            </div>
            <div class="card-body-custom">
               <?php if (($user_details['role'] ?? '') === 'farmer'): ?>
                  <div class="d-flex justify-content-between align-items-center mb-4">
                     <h5 class="mb-0 text-dark"><i class="fas fa-box me-2 text-primary"></i>Inventory
                        (<?php echo $total_products; ?>)</h5>
                     <button class="btn btn-primary" onclick="toggleForm('addProdForm')">
                        <i class="fas fa-plus me-2"></i>New Product
                     </button>
                  </div>

                  <div id="addProdForm" class="form-container" style="display:none;">
                     <h6 class="mb-4 text-dark fw-bold border-bottom pb-3">Add Product for
                        <?php echo htmlspecialchars($user_details['name'] ?? 'Farmer'); ?>
                     </h6>
                     <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="table" value="products">
                        <input type="hidden" name="farmer_id" value="<?php echo $view_user_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $view_user_id; ?>">
                        <div class="row g-4">
                           <div class="col-md-6">
                              <label class="form-label">Product Name</label>
                              <input type="text" name="name" class="form-control" required>
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Price (₹)</label>
                              <input type="number" name="base_price" class="form-control" required>
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Bid End Date</label>
                              <input type="datetime-local" name="bid_end" class="form-control" required>
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Image Upload</label>
                              <input type="file" name="image" class="form-control" required>
                           </div>
                           <div class="col-12">
                              <label class="form-label">Description</label>
                              <textarea name="description" class="form-control" rows="4" required></textarea>
                           </div>
                           <div class="col-12 pt-3">
                              <button type="submit" name="add" class="btn btn-primary me-2 px-4">Upload Product</button>
                              <button type="button" class="btn btn-outline-secondary bg-white px-4"
                                 onclick="toggleForm('addProdForm')">Cancel</button>
                           </div>
                        </div>
                     </form>
                  </div>

                  <div class="desktop-table">
                     <div class="table-responsive border border-light">
                        <table class="table align-middle">
                           <thead>
                              <tr>
                                 <th class="ps-4">Product Details</th>
                                 <th>Base Price</th>
                                 <th>Status</th>
                                 <th>Bid Ends</th>
                                 <th class="text-end pe-4">Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if ($total_products > 0):
                                 while ($p = mysqli_fetch_assoc($user_products)): ?>
                                    <tr>
                                       <td class="ps-4">
                                          <div class="d-flex align-items-center gap-3">
                                             <img src="images/<?php echo htmlspecialchars($p['image'] ?? 'default.jpg'); ?>"
                                                class="table-img">
                                             <div>
                                                <strong
                                                   class="d-block text-dark"><?php echo htmlspecialchars($p['name'] ?? 'Unknown'); ?></strong>
                                                <span class="text-muted small">ID: #<?php echo $p['id']; ?></span>
                                             </div>
                                          </div>
                                       </td>
                                       <td class="fw-bold text-success fs-6">
                                          ₹<?php echo number_format((float) ($p['base_price'] ?? 0), 2); ?></td>
                                       <td><span
                                             class="status-badge status-<?php echo $p['status'] ?? 'unknown'; ?>"><?php echo ucfirst($p['status'] ?? 'Unknown'); ?></span>
                                       </td>
                                       <td class="text-muted fw-medium">
                                          <?php
                                          $bDate = strtotime($p['bid_end'] ?? '');
                                          echo $bDate ? date("d M Y, H:i", $bDate) : 'N/A';
                                          ?>
                                       </td>
                                       <td class="text-end pe-4">
                                          <form method="POST" class="d-inline"
                                             onsubmit="return confirm('Are you sure you want to delete this product?');">
                                             <input type="hidden" name="table" value="products"><input type="hidden" name="id"
                                                value="<?php echo $p['id']; ?>">
                                             <button type="submit" name="delete"
                                                class="btn btn-sm btn-outline-danger border-0 bg-transparent"><i
                                                   class="fas fa-trash fs-5"></i></button>
                                          </form>
                                       </td>
                                    </tr>
                                 <?php endwhile; else: ?>
                                 <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No products listed yet.</td>
                                 </tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               <?php elseif (($user_details['role'] ?? '') === 'consumer'): ?>
                  <h5 class="mb-4 text-dark"><i class="fas fa-shopping-bag me-2 text-primary"></i>Purchase History
                     (<?php echo $total_purchases; ?>)</h5>
                  <div class="desktop-table">
                     <div class="table-responsive border border-light">
                        <table class="table align-middle">
                           <thead>
                              <tr>
                                 <th class="ps-4">Product Details</th>
                                 <th>Amount Paid</th>
                                 <th>Payment Mode</th>
                                 <th>Date</th>
                                 <th class="pe-4">Status</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if ($total_purchases > 0):
                                 while ($pur = mysqli_fetch_assoc($user_purchases)): ?>
                                    <tr>
                                       <td class="ps-4">
                                          <div class="d-flex align-items-center gap-3">
                                             <img
                                                src="images/<?php echo htmlspecialchars($pur['product_image'] ?? 'default.jpg'); ?>"
                                                class="table-img">
                                             <div>
                                                <strong
                                                   class="d-block text-dark"><?php echo htmlspecialchars($pur['product_name'] ?? 'Unknown Product'); ?></strong>
                                                <span class="text-muted small">Order #<?php echo $pur['id']; ?></span>
                                             </div>
                                          </div>
                                       </td>
                                       <td class="fw-bold text-success fs-6">
                                          ₹<?php echo number_format((float) ($pur['purchase_amount'] ?? 0), 2); ?></td>
                                       <td><span class="badge bg-light text-dark border px-3 py-2 rounded-3"><i
                                                class="fas fa-credit-card me-2 text-muted"></i><?php echo strtoupper($pur['payment_method'] ?? 'N/A'); ?></span>
                                       </td>
                                       <td class="text-muted fw-medium">
                                          <?php
                                          $puDate = strtotime($pur['purchase_date'] ?? '');
                                          echo $puDate ? date("d M Y", $puDate) : 'N/A';
                                          ?>
                                       </td>
                                       <td class="pe-4"><span
                                             class="status-badge status-<?php echo $pur['status'] ?? 'unknown'; ?>"><?php echo ucfirst($pur['status'] ?? 'Unknown'); ?></span>
                                       </td>
                                    </tr>
                                 <?php endwhile; else: ?>
                                 <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No purchases found.</td>
                                 </tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               <?php else: ?>
                  <div class="text-center py-5">
                     <i class="fas fa-user-shield fs-1 text-muted mb-3 opacity-50"></i>
                     <h5 class="text-muted">No specific role details to display for this user.</h5>
                  </div>
               <?php endif; ?>
            </div>
         </div>

      <?php elseif ($table == 'purchases' && isset($consumer_info) && isset($purchases_data)): ?>
         <!-- Consumer Purchase Details View -->
         <div class="content-card">
            <div class="card-header-custom">
               <div>
                  <h4 class="mb-1 text-dark d-flex align-items-center gap-3">
                     <i class="fas fa-user-circle text-primary"></i>
                     <?php echo htmlspecialchars($consumer_info['name']); ?>
                     <span class="status-badge status-consumer">Consumer</span>
                  </h4>
                  <p class="text-muted mb-0"><i
                        class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($consumer_info['email']); ?></p>
               </div>
               <a href="?table=purchases" class="btn btn-outline-secondary bg-light border-0">
                  <i class="fas fa-arrow-left me-2"></i>Back to Consumers
               </a>
            </div>
            <div class="card-body-custom">
               <h5 class="mb-4 text-dark"><i class="fas fa-shopping-bag me-2 text-primary"></i>Purchase History</h5>

               <?php if ($purchases_data && mysqli_num_rows($purchases_data) > 0): ?>
                  <div class="desktop-table">
                     <div class="table-responsive border border-light">
                        <table class="table align-middle">
                           <thead>
                              <tr>
                                 <th class="ps-4">Product Details</th>
                                 <th>Amount Paid</th>
                                 <th>Payment Mode</th>
                                 <th>Date</th>
                                 <th>Status</th>
                                 <th class="text-end pe-4">Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php while ($purchase = mysqli_fetch_assoc($purchases_data)): ?>
                                 <tr>
                                    <td class="ps-4">
                                       <div class="d-flex align-items-center gap-3">
                                          <img
                                             src="images/<?php echo htmlspecialchars($purchase['product_image'] ?? 'default.jpg'); ?>"
                                             class="table-img">
                                          <div>
                                             <strong
                                                class="d-block text-dark"><?php echo htmlspecialchars($purchase['product_name'] ?? 'Unknown Product'); ?></strong>
                                             <span class="text-muted small">Order #<?php echo $purchase['id']; ?></span>
                                          </div>
                                       </div>
                                    </td>
                                    <td class="fw-bold text-success fs-6">
                                       ₹<?php echo number_format((float) ($purchase['purchase_amount'] ?? 0), 2); ?>
                                    </td>
                                    <td>
                                       <span class="badge bg-light text-dark border px-3 py-2 rounded-3">
                                          <i class="fas fa-credit-card me-2 text-muted"></i>
                                          <?php echo strtoupper($purchase['payment_method'] ?? 'N/A'); ?>
                                       </span>
                                    </td>
                                    <td class="text-muted fw-medium">
                                       <?php
                                       $pDate = strtotime($purchase['purchase_date'] ?? '');
                                       echo $pDate ? date("d M Y, H:i", $pDate) : 'N/A';
                                       ?>
                                    </td>
                                    <td>
                                       <span class="status-badge status-<?php echo $purchase['status'] ?? 'unknown'; ?>">
                                          <?php echo ucfirst($purchase['status'] ?? 'Unknown'); ?>
                                       </span>
                                    </td>
                                    <td class="text-end pe-4">
                                       <div class="action-buttons justify-content-end">
                                          <button class="btn btn-sm btn-light border"
                                             onclick="showUpdateForm(<?php echo $purchase['id']; ?>, '<?php echo $purchase['status'] ?? 'completed'; ?>')"
                                             title="Update Status">
                                             <i class="fas fa-pen text-primary"></i>
                                          </button>
                                          <form method="POST" class="d-inline" onsubmit="return confirm('Delete this record?');">
                                             <input type="hidden" name="table" value="purchases">
                                             <input type="hidden" name="id" value="<?php echo $purchase['id']; ?>">
                                             <button type="submit" name="delete" class="btn btn-sm btn-light border text-danger"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                             </button>
                                          </form>
                                       </div>
                                    </td>
                                 </tr>
                              <?php endwhile; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>

                  <!-- Mobile View -->
                  <div class="mobile-table-cards">
                     <?php
                     mysqli_data_seek($purchases_data, 0);
                     while ($purchase = mysqli_fetch_assoc($purchases_data)):
                        ?>
                        <div class="data-card">
                           <div class="data-card-header">
                              <div class="d-flex align-items-center gap-2">
                                 <img src="images/<?php echo htmlspecialchars($purchase['product_image'] ?? 'default.jpg'); ?>"
                                    style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                 <strong
                                    class="text-dark"><?php echo htmlspecialchars($purchase['product_name'] ?? 'Unknown'); ?></strong>
                              </div>
                              <span class="status-badge status-<?php echo $purchase['status'] ?? 'unknown'; ?>">
                                 <?php echo ucfirst($purchase['status'] ?? 'Unknown'); ?>
                              </span>
                           </div>
                           <div class="data-card-row">
                              <span class="data-card-label">Amount</span>
                              <span
                                 class="data-card-value text-success">₹<?php echo number_format((float) ($purchase['purchase_amount'] ?? 0), 2); ?></span>
                           </div>
                           <div class="data-card-row">
                              <span class="data-card-label">Payment</span>
                              <span
                                 class="data-card-value"><?php echo strtoupper($purchase['payment_method'] ?? 'N/A'); ?></span>
                           </div>
                           <div class="data-card-row">
                              <span class="data-card-label">Date</span>
                              <span class="data-card-value">
                                 <?php
                                 $pDate = strtotime($purchase['purchase_date'] ?? '');
                                 echo $pDate ? date("d M Y", $pDate) : 'N/A';
                                 ?>
                              </span>
                           </div>
                           <div class="data-card-row">
                              <span class="data-card-label">Order #</span>
                              <span class="data-card-value"><?php echo $purchase['id']; ?></span>
                           </div>
                           <div class="data-card-actions">
                              <button class="btn btn-light border text-primary btn-sm"
                                 onclick="showUpdateForm(<?php echo $purchase['id']; ?>, '<?php echo $purchase['status'] ?? 'completed'; ?>')">
                                 <i class="fas fa-pen me-1"></i> Update
                              </button>
                              <form method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('Delete this record?');">
                                 <input type="hidden" name="table" value="purchases">
                                 <input type="hidden" name="id" value="<?php echo $purchase['id']; ?>">
                                 <button type="submit" name="delete" class="btn btn-light border text-danger btn-sm w-100">
                                    <i class="fas fa-trash me-1"></i> Delete
                                 </button>
                              </form>
                           </div>
                        </div>
                     <?php endwhile; ?>
                  </div>
               <?php else: ?>
                  <div class="text-center py-5">
                     <i class="fas fa-shopping-bag fs-1 text-muted mb-3 opacity-50"></i>
                     <h5 class="text-muted">No purchases found for this consumer.</h5>
                  </div>
               <?php endif; ?>
            </div>
         </div>

      <?php elseif ($table == 'sales_report'): ?>
         <div class="row g-4 mb-4">
            <?php
            $total_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count, SUM(purchase_amount) as total FROM purchases"));
            $total_revenue = $total_data['total'] ?? 0;
            $total_sales = $total_data['count'] ?? 0;
            $avg_sale = $total_sales > 0 ? $total_revenue / $total_sales : 0;
            ?>
            <div class="col-md-4">
               <div class="stat-card" style="border-bottom: 4px solid var(--primary)">
                  <i class="fas fa-wallet stat-card-icon"></i>
                  <h3>Total Revenue</h3>
                  <p class="number text-dark">₹<?php echo number_format((float) $total_revenue, 2); ?></p>
               </div>
            </div>
            <div class="col-md-4">
               <div class="stat-card" style="border-bottom: 4px solid #3b82f6">
                  <i class="fas fa-shopping-cart stat-card-icon"></i>
                  <h3>Total Sales</h3>
                  <p class="number text-dark"><?php echo $total_sales; ?></p>
               </div>
            </div>
            <div class="col-md-4">
               <div class="stat-card" style="border-bottom: 4px solid #f59e0b">
                  <i class="fas fa-chart-line stat-card-icon"></i>
                  <h3>Avg Sale Value</h3>
                  <p class="number text-dark">₹<?php echo number_format((float) $avg_sale, 2); ?></p>
               </div>
            </div>
         </div>

         <div class="row g-4 mb-4">
            <div class="col-md-6">
               <div class="content-card h-100 mb-0">
                  <div class="card-header-custom border-0 pb-0">
                     <h5 class="fw-bold"><i class="fas fa-crown text-warning me-2"></i>Top Products</h5>
                  </div>
                  <div class="card-body-custom pt-3">
                     <?php if (isset($data['top_products']) && mysqli_num_rows($data['top_products']) > 0):
                        while ($product = mysqli_fetch_assoc($data['top_products'])): ?>
                           <div class="d-flex justify-content-between align-items-center py-3 border-bottom border-light">
                              <span
                                 class="fw-semibold text-dark"><?php echo htmlspecialchars($product['name'] ?? 'Unknown Product'); ?></span>
                              <span
                                 class="fw-bold text-success bg-success bg-opacity-10 px-3 py-1 rounded-pill">₹<?php echo number_format((float) ($product['revenue'] ?? 0), 2); ?></span>
                           </div>
                        <?php endwhile; else: ?>
                        <p class="text-muted py-3">No data available.</p>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="content-card h-100 mb-0">
                  <div class="card-header-custom border-0 pb-0">
                     <h5 class="fw-bold"><i class="fas fa-star text-primary me-2"></i>Top Customers</h5>
                  </div>
                  <div class="card-body-custom pt-3">
                     <?php if (isset($data['top_customers']) && mysqli_num_rows($data['top_customers']) > 0):
                        while ($customer = mysqli_fetch_assoc($data['top_customers'])): ?>
                           <div class="d-flex justify-content-between align-items-center py-3 border-bottom border-light">
                              <span class="text-dark fw-semibold d-flex align-items-center"><i
                                    class="fas fa-user-circle me-3 text-muted fs-4"></i><?php echo htmlspecialchars($customer['name'] ?? 'Unknown Customer'); ?></span>
                              <span
                                 class="fw-bold text-success bg-success bg-opacity-10 px-3 py-1 rounded-pill">₹<?php echo number_format((float) ($customer['spent'] ?? 0), 2); ?></span>
                           </div>
                        <?php endwhile; else: ?>
                        <p class="text-muted py-3">No data available.</p>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>

         <div class="content-card">
            <div class="card-header-custom">
               <h5 class="fw-bold"><i class="fas fa-calendar-alt text-info me-2"></i>Monthly Revenue</h5>
            </div>
            <div class="card-body-custom p-0">
               <div class="table-responsive">
                  <table class="table align-middle mb-0">
                     <thead>
                        <tr>
                           <th class="ps-4">Month</th>
                           <th>Transactions</th>
                           <th class="pe-4">Revenue</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (isset($data['monthly_sales']) && mysqli_num_rows($data['monthly_sales']) > 0):
                           while ($month = mysqli_fetch_assoc($data['monthly_sales'])): ?>
                              <tr>
                                 <td class="fw-bold text-dark ps-4">
                                    <?php echo date('F Y', mktime(0, 0, 0, $month['month'], 1, $month['year'])); ?>
                                 </td>
                                 <td><span class="badge bg-light text-dark border px-3 py-2 rounded-3"><i
                                          class="fas fa-receipt me-2 text-muted"></i><?php echo $month['count']; ?> orders</span>
                                 </td>
                                 <td class="fw-bold text-success pe-4 fs-5">
                                    ₹<?php echo number_format((float) ($month['total'] ?? 0), 2); ?></td>
                              </tr>
                           <?php endwhile; else: ?>
                           <tr>
                              <td colspan="3" class="text-center py-5 text-muted">No data available.</td>
                           </tr>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>

      <?php elseif ($table == 'purchases'): ?>
         <!-- Consumer List View -->
         <div class="content-card">
            <div class="card-header-custom">
               <h5 class="fw-bold"><i class="fas fa-users me-2 text-primary"></i>All Consumers</h5>
            </div>
            <div class="card-body-custom">
               <?php if ($data && mysqli_num_rows($data) > 0): ?>
                  <div class="row g-4">
                     <?php while ($consumer = mysqli_fetch_assoc($data)): ?>
                        <div class="col-md-6 col-lg-4">
                           <div class="consumer-card"
                              onclick="window.location.href='?table=purchases&consumer_id=<?php echo $consumer['id']; ?>'">
                              <div class="d-flex align-items-center gap-3">
                                 <div class="consumer-avatar">
                                    <?php echo strtoupper(substr($consumer['name'] ?? 'U', 0, 1)); ?>
                                 </div>
                                 <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1">
                                       <?php echo htmlspecialchars($consumer['name'] ?? 'Unknown'); ?>
                                    </h6>
                                    <p class="text-muted small mb-0"><i
                                          class="fas fa-envelope me-1"></i><?php echo htmlspecialchars($consumer['email'] ?? 'N/A'); ?>
                                    </p>
                                 </div>
                                 <i class="fas fa-chevron-right text-primary opacity-50"></i>
                              </div>

                              <div class="consumer-stats">
                                 <div class="stat-item flex-grow-1">
                                    <div class="stat-label">Orders</div>
                                    <div class="stat-value"><?php echo $consumer['total_orders'] ?? 0; ?></div>
                                 </div>
                                 <div class="stat-item flex-grow-1">
                                    <div class="stat-label">Total Spent</div>
                                    <div class="stat-value text-success">
                                       ₹<?php echo number_format((float) ($consumer['total_spent'] ?? 0), 0); ?></div>
                                 </div>
                              </div>

                              <?php if (!empty($consumer['last_purchase'])): ?>
                                 <div class="mt-2 small text-muted">
                                    <i class="fas fa-clock me-1"></i>Last:
                                    <?php echo date('d M Y', strtotime($consumer['last_purchase'])); ?>
                                 </div>
                              <?php endif; ?>
                           </div>
                        </div>
                     <?php endwhile; ?>
                  </div>
               <?php else: ?>
                  <div class="text-center py-5">
                     <i class="fas fa-users fs-1 text-muted mb-3 opacity-50"></i>
                     <h5 class="text-muted">No consumers found.</h5>
                  </div>
               <?php endif; ?>
            </div>
         </div>

      <?php else: ?>
         <div class="content-card">
            <div class="card-header-custom">
               <h5 class="fw-bold">Manage Records</h5>
               <?php if ($table != 'sales_report' && $table != 'bids' && $table != 'purchases'): ?>
                  <button class="btn btn-primary" onclick="toggleForm('addForm')">
                     <i class="fas fa-plus me-2"></i>Create New
                  </button>
               <?php endif; ?>
            </div>

            <div class="card-body-custom p-0">
               <?php if ($table != 'sales_report' && $table != 'bids'): ?>
                  <div id="addForm" class="form-container m-4" style="display:none;">
                     <h6 class="mb-4 fw-bold border-bottom border-light pb-3">Create New
                        <?php echo ucfirst(substr($table, 0, -1)); ?>
                     </h6>
                     <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="table" value="<?php echo $table; ?>">
                        <?php if ($table == 'users'): ?>
                           <div class="row g-4">
                              <div class="col-md-6"><label class="form-label">Full Name</label><input type="text" name="name"
                                    class="form-control" placeholder="John Doe" required></div>
                              <div class="col-md-6"><label class="form-label">Email Address</label><input type="email"
                                    name="email" class="form-control" placeholder="name@example.com" required></div>
                              <div class="col-md-6"><label class="form-label">Password</label><input type="password"
                                    name="password" class="form-control" placeholder="••••••••" required></div>
                              <div class="col-md-6"><label class="form-label">Role</label>
                                 <select name="role" class="form-select">
                                    <option value="consumer">Consumer</option>
                                    <option value="farmer">Farmer</option>
                                    <option value="admin">Admin</option>
                                 </select>
                              </div>
                           </div>
                        <?php elseif ($table == 'products'): ?>
                           <div class="row g-4">
                              <div class="col-md-6"><label class="form-label">Product Name</label><input type="text" name="name"
                                    class="form-control" required></div>
                              <div class="col-md-6"><label class="form-label">Base Price (₹)</label><input type="number"
                                    name="base_price" class="form-control" required></div>
                              <div class="col-md-6"><label class="form-label">Farmer ID</label><input type="number"
                                    name="user_id" class="form-control" required></div>
                              <div class="col-md-6"><label class="form-label">Bid End Date</label><input type="datetime-local"
                                    name="bid_end" class="form-control" required></div>
                              <div class="col-md-12"><label class="form-label">Product Image</label><input type="file"
                                    name="image" class="form-control" required></div>
                              <div class="col-12"><label class="form-label">Description</label><textarea name="description"
                                    class="form-control" rows="4" required></textarea></div>
                           </div>
                        <?php elseif ($table == 'purchases'): ?>
                           <div class="row g-4">
                              <div class="col-md-6"><label class="form-label">Product ID</label><input type="number"
                                    name="product_id" class="form-control" required></div>
                              <div class="col-md-6"><label class="form-label">Customer ID</label><input type="number"
                                    name="user_id" class="form-control" required></div>
                              <div class="col-md-6"><label class="form-label">Amount (₹)</label><input type="number"
                                    name="purchase_amount" step="0.01" class="form-control" required></div>
                              <div class="col-md-6"><label class="form-label">Payment Method</label>
                                 <select name="payment_method" class="form-select" required>
                                    <option value="card">Credit/Debit Card</option>
                                    <option value="upi">UPI</option>
                                    <option value="cod">Cash on Delivery</option>
                                    <option value="cash">Cash</option>
                                 </select>
                              </div>
                           </div>
                        <?php endif; ?>
                        <div class="mt-4 gap-3 d-flex pt-2">
                           <button type="submit" name="add" class="btn btn-primary px-4">Save Record</button>
                           <button type="button" class="btn btn-outline-secondary bg-white px-4"
                              onclick="toggleForm('addForm')">Cancel</button>
                        </div>
                     </form>
                  </div>
               <?php endif; ?>


               <?php if ($table == 'bids'): ?>
                  <div class="p-4 bg-light">
                     <?php
                     $grouped_bids = [];
                     if ($data && $data instanceof mysqli_result && mysqli_num_rows($data) > 0) {
                        mysqli_data_seek($data, 0);
                        while ($row = mysqli_fetch_assoc($data)) {
                           $uid = $row['user_id'] ?? 'unknown';
                           if (!isset($grouped_bids[$uid])) {
                              $grouped_bids[$uid] = [
                                 'name' => $row['bidder_name'] ?? 'Unknown User',
                                 'bids' => []
                              ];
                           }
                           $grouped_bids[$uid]['bids'][] = $row;
                        }
                     }
                     ?>
                     <div class="accordion custom-accordion shadow-sm" id="bidsAccordion"
                        style="border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">
                        <?php if (!empty($grouped_bids)): ?>
                           <?php $i = 0;
                           foreach ($grouped_bids as $uid => $group):
                              $i++; ?>
                              <div class="accordion-item border-0 border-bottom border-light">
                                 <h2 class="accordion-header" id="heading-<?php echo $uid; ?>">
                                    <button class="accordion-button <?php echo $i > 1 ? 'collapsed' : ''; ?> py-4 px-4 bg-white"
                                       type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $uid; ?>">
                                       <div class="d-flex align-items-center w-100 pe-3">
                                          <div class="brand-icon me-4 shadow-none"
                                             style="width: 45px; height: 45px; font-size: 1.2rem; background: #f8fafc; color: var(--primary); border: 1px solid #e2e8f0;">
                                             <i class="fas fa-user-tag"></i>
                                          </div>
                                          <span
                                             class="fs-5 fw-bold text-dark"><?php echo htmlspecialchars($group['name']); ?></span>
                                          <span
                                             class="badge bg-primary bg-opacity-10 text-primary ms-auto rounded-pill px-3 py-2 border border-primary border-opacity-25 fs-6">
                                             <?php echo count($group['bids']); ?> Bids
                                          </span>
                                       </div>
                                    </button>
                                 </h2>
                                 <div id="collapse-<?php echo $uid; ?>"
                                    class="accordion-collapse collapse <?php echo $i === 1 ? 'show' : ''; ?>"
                                    data-bs-parent="#bidsAccordion">
                                    <div class="accordion-body p-0">
                                       <div class="table-responsive border-top">
                                          <table class="table align-middle mb-0">
                                             <thead class="bg-light">
                                                <tr>
                                                   <th class="ps-5">Product Details</th>
                                                   <th>Bid Amount</th>
                                                   <th class="text-end pe-5">Action</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php foreach ($group['bids'] as $bid): ?>
                                                   <tr>
                                                      <td class="ps-5">
                                                         <strong
                                                            class="text-dark d-block fw-bold"><?php echo htmlspecialchars($bid['product_name'] ?? 'Unknown Product'); ?></strong>
                                                         <span class="text-muted small">Bid #<?php echo $bid['id']; ?></span>
                                                      </td>
                                                      <td class="fw-bold text-success fs-6">
                                                         ₹<?php echo number_format((float) ($bid['bid_amount'] ?? 0), 2); ?></td>
                                                      <td class="text-end pe-5">
                                                         <form method="POST" class="d-inline"
                                                            onsubmit="return confirm('Delete this bid?');">
                                                            <input type="hidden" name="table" value="bids">
                                                            <input type="hidden" name="id" value="<?php echo $bid['id']; ?>">
                                                            <button type="submit" name="delete"
                                                               class="btn btn-sm bg-white border text-danger shadow-sm"><i
                                                                  class="fas fa-trash"></i></button>
                                                         </form>
                                                      </td>
                                                   </tr>
                                                <?php endforeach; ?>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           <?php endforeach; ?>
                        <?php else: ?>
                           <div class="text-center py-5 text-muted">No bids recorded yet.</div>
                        <?php endif; ?>
                     </div>
                  </div>

               <?php else: ?>
                  <div class="desktop-table">
                     <div class="table-responsive">
                        <table class="table align-middle mb-0">
                           <thead>
                              <tr>
                                 <?php
                                 if ($table == 'users')
                                    echo "<th class='ps-4'>User</th><th>Contact</th><th>Role</th><th class='text-end pe-4'>Actions</th>";
                                 if ($table == 'products')
                                    echo "<th class='ps-4'>Product</th><th>Price</th><th>Farmer</th><th>End Time</th><th class='text-end pe-4'>Actions</th>";
                                 if ($table == 'contact_messages')
                                    echo "<th class='ps-4'>Sender</th><th>Message</th><th class='text-end pe-4'>Actions</th>";
                                 ?>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if ($data && $data instanceof mysqli_result && mysqli_num_rows($data) > 0): ?>
                                 <?php while ($row = mysqli_fetch_assoc($data)): ?>
                                    <tr>
                                       <?php if ($table == 'users'): ?>
                                          <td class="ps-4">
                                             <strong
                                                class="text-dark d-block fw-bold"><?php echo htmlspecialchars($row['name'] ?? 'Unknown'); ?></strong>
                                             <span class="text-muted small">ID: #<?php echo $row['id']; ?></span>
                                          </td>
                                          <td class="text-muted"><i
                                                class="fas fa-envelope me-2 small text-primary"></i><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?>
                                          </td>
                                          <td>
                                             <?php if (!empty($row['role'])): ?>
                                                <span
                                                   class="status-badge status-<?php echo $row['role']; ?>"><?php echo ucfirst($row['role']); ?></span>
                                             <?php endif; ?>
                                          </td>
                                          <td class="text-end pe-4">
                                             <div class="action-buttons justify-content-end">
                                                <a href="?view_user=<?php echo $row['id']; ?>" class="btn btn-sm btn-light border"
                                                   title="View Profile"><i class="fas fa-eye text-info"></i></a>
                                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this user?');">
                                                   <input type="hidden" name="table" value="users"><input type="hidden" name="id"
                                                      value="<?php echo $row['id']; ?>">
                                                   <button type="submit" name="delete" class="btn btn-sm btn-light border text-danger"
                                                      title="Delete"><i class="fas fa-trash"></i></button>
                                                </form>
                                             </div>
                                          </td>
                                       <?php elseif ($table == 'products'): ?>
                                          <td class="ps-4">
                                             <div class="d-flex align-items-center gap-3">
                                                <img src="images/<?php echo htmlspecialchars($row['image'] ?? 'default.jpg'); ?>"
                                                   class="table-img">
                                                <span
                                                   class="fw-bold text-dark"><?php echo htmlspecialchars($row['name'] ?? 'Unknown'); ?></span>
                                             </div>
                                          </td>
                                          <td class="fw-bold text-success fs-6">
                                             ₹<?php echo number_format((float) ($row['base_price'] ?? 0), 2); ?></td>
                                          <td class="text-dark fw-medium">
                                             <?php echo htmlspecialchars($row['farmer_name'] ?? 'ID: ' . ($row['user_id'] ?? 'Unknown')); ?>
                                          </td>
                                          <td class="text-muted"><i class="far fa-clock me-2 text-warning"></i>
                                             <?php
                                             $bd = strtotime($row['bid_end'] ?? '');
                                             echo $bd ? date("M d, H:i", $bd) : 'N/A';
                                             ?>
                                          </td>
                                          <td class="text-end pe-4">
                                             <form method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                                <input type="hidden" name="table" value="products"><input type="hidden" name="id"
                                                   value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="delete" class="btn btn-sm btn-light border text-danger"><i
                                                      class="fas fa-trash"></i></button>
                                             </form>
                                          </td>
                                       <?php elseif ($table == 'contact_messages'): ?>
                                          <td class="ps-4">
                                             <strong
                                                class="text-dark d-block fw-bold"><?php echo htmlspecialchars($row['name'] ?? 'Unknown'); ?></strong>
                                             <span class="text-muted small">#<?php echo $row['id']; ?></span>
                                          </td>
                                          <td class="text-muted fst-italic">
                                             "<?php echo htmlspecialchars(substr($row['message'] ?? '', 0, 70)); ?>..."</td>
                                          <td class="text-end pe-4">
                                             <form method="POST" class="d-inline" onsubmit="return confirm('Delete message?');">
                                                <input type="hidden" name="table" value="contact_messages"><input type="hidden"
                                                   name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="delete" class="btn btn-sm btn-light border text-danger"><i
                                                      class="fas fa-trash"></i></button>
                                             </form>
                                          </td>
                                       <?php endif; ?>
                                    </tr>
                                 <?php endwhile; ?>
                              <?php else: ?>
                                 <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No records found.</td>
                                 </tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>

                  <div class="mobile-table-cards px-3 pb-3">
                     <?php
                     if ($data && $data instanceof mysqli_result && mysqli_num_rows($data) > 0) {
                        mysqli_data_seek($data, 0);
                        while ($row = mysqli_fetch_assoc($data)):
                           ?>
                           <div class="data-card">
                              <?php if ($table == 'users'): ?>
                                 <div class="data-card-header">
                                    <div>
                                       <strong
                                          class="d-block text-dark fw-bold"><?php echo htmlspecialchars($row['name'] ?? 'Unknown'); ?></strong>
                                       <span class="text-muted small">ID: #<?php echo $row['id']; ?></span>
                                    </div>
                                    <?php if (!empty($row['role'])): ?>
                                       <span
                                          class="status-badge status-<?php echo $row['role']; ?>"><?php echo ucfirst($row['role']); ?></span>
                                    <?php endif; ?>
                                 </div>
                                 <div class="data-card-row">
                                    <span class="data-card-label">Email</span><span
                                       class="data-card-value"><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></span>
                                 </div>
                                 <div class="data-card-actions">
                                    <a href="?view_user=<?php echo $row['id']; ?>"
                                       class="btn btn-light border text-info fw-bold btn-sm"><i class="fas fa-eye me-1"></i> View</a>
                                    <form method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('Delete?');">
                                       <input type="hidden" name="table" value="users"><input type="hidden" name="id"
                                          value="<?php echo $row['id']; ?>">
                                       <button type="submit" name="delete"
                                          class="btn btn-light border text-danger fw-bold btn-sm w-100"><i
                                             class="fas fa-trash me-1"></i> Delete</button>
                                    </form>
                                 </div>
                              <?php else: ?>
                                 <div class="data-card-header border-0 pb-0 mb-0">
                                    <div><strong class="d-block text-dark fw-bold">Record #<?php echo $row['id']; ?></strong></div>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                       <input type="hidden" name="table" value="<?php echo $table; ?>"><input type="hidden" name="id"
                                          value="<?php echo $row['id']; ?>">
                                       <button type="submit" name="delete" class="btn btn-light border text-danger btn-sm px-3"><i
                                             class="fas fa-trash"></i></button>
                                    </form>
                                 </div>
                              <?php endif; ?>
                           </div>
                           <?php
                        endwhile;
                     }
                     ?>
                  </div>
               <?php endif; ?>

            </div>
         </div>
      <?php endif; ?>
   </div>

   <div class="modal fade" id="updateModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-header border-bottom border-light p-4"
               style="background: #f8fafc; border-radius: 24px 24px 0 0;">
               <h5 class="modal-title fw-bold text-dark"><i class="fas fa-sync-alt me-2 text-primary"></i>Update Order
                  Status</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="updateForm">
               <div class="modal-body p-4">
                  <input type="hidden" name="table" value="purchases">
                  <input type="hidden" name="id" id="updateId">
                  <input type="hidden" name="update" value="1">
                  <div class="mb-2">
                     <label class="form-label text-muted fw-bold">Select New Status</label>
                     <select name="status" class="form-select form-select-lg fs-6" style="border-radius: 12px;"
                        required>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                     </select>
                  </div>
               </div>
               <div class="modal-footer border-top-0 p-4 pt-0">
                  <button type="button" class="btn btn-outline-secondary px-4 bg-white"
                     data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Changes</button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script>
      function toggleForm(formId) {
         const form = document.getElementById(formId);
         form.style.display = form.style.display === 'none' ? 'block' : 'none';
      }

      function showUpdateForm(id, currentStatus) {
         document.getElementById('updateId').value = id;
         document.getElementById('updateForm').querySelector('select[name="status"]').value = currentStatus;
         const modal = new bootstrap.Modal(document.getElementById('updateModal'));
         modal.show();
      }

      // Sidebar Toggle Logic
      document.addEventListener('DOMContentLoaded', () => {
         const menuToggle = document.getElementById('menuToggle');
         const sidebar = document.getElementById('sidebar');
         const overlay = document.getElementById('sidebarOverlay');

         const toggleSidebar = () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
         };

         menuToggle.addEventListener('click', toggleSidebar);
         overlay.addEventListener('click', toggleSidebar);

         window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
               sidebar.classList.remove('active');
               overlay.classList.remove('active');
            }
         });
      });
   </script>
</body>

</html>