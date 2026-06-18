<?php
session_start();
include "php/db.php";

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'consumer') {
   header("Location: login.php");
   exit();
}

$user_id = $_SESSION['user_id'];

// Fetch purchased products
$sql = "SELECT p.*, pur.purchase_amount, pur.payment_method, pur.transaction_id, pur.purchase_date, pur.status
        FROM purchases pur
        JOIN products p ON pur.product_id = p.id
        WHERE pur.user_id = '$user_id'
        ORDER BY pur.purchase_date DESC";

$result = mysqli_query($conn, $sql);
$total_purchases = mysqli_num_rows($result);
$total_spent = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Purchases | Harvest Hub</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

   <style>
      :root {
         --primary: #2e7d32;
         --dark: #1b5e20;
         --bg: #f4f7f6;
         --accent: #fbc02d;
      }

      /* Prevent horizontal scrolling and white gaps */
      html,
      body {
         overflow-x: hidden;
         max-width: 100vw;
         font-family: 'Poppins', sans-serif;
         background: var(--bg);
         color: #333;
         margin: 0;
         padding: 0;
      }

      /* Header */
      .header {
         background: linear-gradient(135deg, var(--primary), var(--dark));
         color: white;
         padding: 40px 0;
         margin-top: 80px;
         /* Fixed: Only apply margin to the top */
         margin-bottom: 30px;
         border-radius: 0 0 20px 20px;
      }

      .header h1 {
         margin: 0;
         font-size: 2.5rem;
         font-weight: 700;
      }

      .header p {
         opacity: 0.9;
         margin: 10px 0 0;
         font-weight: 300;
      }

      /* Stats Cards */
      .stat-card {
         background: white;
         padding: 25px;
         border-radius: 15px;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
         text-align: center;
         border-left: 5px solid var(--primary);
         height: 100%;
         transition: transform 0.3s;
      }

      .stat-card:hover {
         transform: translateY(-5px);
         box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      }

      .stat-card h3 {
         color: var(--dark);
         margin: 0 0 10px;
         font-size: 1.1rem;
         font-weight: 600;
      }

      .stat-card .number {
         font-size: 2.5rem;
         font-weight: 700;
         color: var(--primary);
         margin: 10px 0;
      }

      /* Purchase Cards */
      .purchase-card {
         background: white;
         border-radius: 15px;
         overflow: hidden;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
         transition: transform 0.3s;
         height: 100%;
         border: none;
      }

      .purchase-card:hover {
         transform: translateY(-5px);
         box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
      }

      .card-header-custom {
         background: var(--primary);
         color: white;
         padding: 15px;
         position: relative;
         border-bottom: none;
      }

      .card-header-custom h3 {
         margin: 0;
         font-size: 1.2rem;
         font-weight: 600;
      }

      .card-body {
         padding: 20px;
      }

      .status-badge {
         position: absolute;
         top: 15px;
         right: 15px;
         background: var(--accent);
         color: #000;
         padding: 4px 12px;
         border-radius: 20px;
         font-size: 0.75rem;
         font-weight: 600;
      }

      .product-image {
         width: 100%;
         height: 180px;
         object-fit: cover;
         border-radius: 10px;
         margin-bottom: 15px;
      }

      .info-row {
         display: flex;
         justify-content: space-between;
         margin-bottom: 8px;
         padding-bottom: 8px;
         border-bottom: 1px solid #eee;
      }

      .info-row:last-child {
         border-bottom: none;
      }

      .info-label {
         color: #666;
         font-weight: 500;
         font-size: 0.9rem;
      }

      .info-value {
         font-weight: 600;
         color: var(--dark);
         font-size: 0.95rem;
      }

      .total-row {
         background: #f8f9fa;
         padding: 15px;
         border-radius: 10px;
         margin-top: 15px;
         font-size: 1.2rem;
         font-weight: 700;
         color: var(--primary);
         text-align: center;
      }

      /* Empty State */
      .empty-state {
         text-align: center;
         padding: 60px 20px;
         color: #666;
      }

      .empty-state i {
         font-size: 4rem;
         color: #ddd;
         margin-bottom: 20px;
      }

      .btn-back {
         display: inline-block;
         background: var(--primary);
         color: white;
         padding: 12px 30px;
         border-radius: 10px;
         text-decoration: none;
         font-weight: 600;
         margin-top: 20px;
         transition: 0.3s;
         border: none;
      }

      .btn-back:hover {
         background: var(--dark);
         color: white;
      }

      /* Section Title */
      .section-title {
         color: var(--dark);
         margin-bottom: 20px;
         font-weight: 700;
         font-size: 1.8rem;
         position: relative;
         padding-bottom: 10px;
      }

      .section-title::after {
         content: '';
         position: absolute;
         left: 0;
         bottom: 0;
         width: 60px;
         height: 4px;
         background: var(--accent);
         border-radius: 2px;
      }

      /* Responsive */
      @media (max-width: 768px) {
         .header {
            padding: 30px 0;
            border-radius: 0 0 15px 15px;
         }

         .header h1 {
            font-size: 2rem;
         }

         .stat-card {
            padding: 20px;
         }

         .stat-card .number {
            font-size: 2rem;
         }

         .product-image {
            height: 150px;
         }

         .section-title {
            font-size: 1.5rem;
         }
      }

      @media (max-width: 576px) {
         .header h1 {
            font-size: 1.7rem;
         }

         .header p {
            font-size: 0.95rem;
         }

         .stat-card {
            padding: 15px;
         }

         .stat-card .number {
            font-size: 1.8rem;
         }

         .status-badge {
            position: static;
            display: inline-block;
            margin-top: 5px;
         }

         .empty-state i {
            font-size: 3rem;
         }
      }
   </style>
</head>

<body>
   <?php include "navbar.php"; ?>

   <div class="header">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <h1><i class="fas fa-shopping-bag me-3"></i>My Purchases</h1>
               <p class="mb-0">View all your purchased products and transactions</p>
            </div>
         </div>
      </div>
   </div>

   <div class="container">
      <div class="row g-4 mb-5">
         <div class="col-md-4">
            <div class="stat-card">
               <h3>Total Purchases</h3>
               <div class="number">
                  <?php echo $total_purchases; ?>
               </div>
               <p class="mb-0 text-muted">Items bought</p>
            </div>
         </div>
         <div class="col-md-4">
            <div class="stat-card">
               <h3>Total Spent</h3>
               <div class="number">₹
                  <?php
                  $total_amount = 0;
                  if ($total_purchases > 0) {
                     mysqli_data_seek($result, 0); // Reset pointer
                     while ($row = mysqli_fetch_assoc($result)) {
                        $total_amount += $row['purchase_amount'];
                     }
                     mysqli_data_seek($result, 0); // Reset again for display
                  }
                  echo number_format($total_amount, 2);
                  ?>
               </div>
               <p class="mb-0 text-muted">Overall expenditure</p>
            </div>
         </div>
         <div class="col-md-4">
            <div class="stat-card">
               <h3>Last Purchase</h3>
               <div class="number">
                  <?php
                  if ($total_purchases > 0) {
                     $row = mysqli_fetch_assoc($result);
                     echo date('d M', strtotime($row['purchase_date']));
                     mysqli_data_seek($result, 0); // Reset pointer
                  } else {
                     echo "N/A";
                  }
                  ?>
               </div>
               <p class="mb-0 text-muted">Most recent order</p>
            </div>
         </div>
      </div>

      <h2 class="section-title">Purchased Products</h2>

      <?php if ($total_purchases > 0): ?>
         <div class="row g-4 mb-5">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
               <div class="col-12 col-md-6 col-lg-4">
                  <div class="purchase-card">
                     <div class="card-header-custom">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <span class="status-badge">
                           <?php echo strtoupper($row['status']); ?>
                        </span>
                     </div>

                     <div class="card-body">
                        <img src="images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>"
                           class="product-image" onerror="this.src='https://via.placeholder.com/300x180?text=No+Image'">

                        <div class="info-row">
                           <span class="info-label">Purchase Date:</span>
                           <span class="info-value">
                              <?php echo date('d M Y', strtotime($row['purchase_date'])); ?>
                           </span>
                        </div>

                        <div class="info-row">
                           <span class="info-label">Transaction ID:</span>
                           <span class="info-value">
                              <?php echo $row['transaction_id']; ?>
                           </span>
                        </div>

                        <div class="info-row">
                           <span class="info-label">Payment Method:</span>
                           <span class="info-value">
                              <?php echo ucfirst($row['payment_method']); ?>
                           </span>
                        </div>

                        <div class="info-row">
                           <span class="info-label">Original Price:</span>
                           <span class="info-value">₹
                              <?php echo number_format($row['base_price'], 2); ?>
                           </span>
                        </div>

                        <div class="total-row">
                           Paid: ₹<?php echo number_format($row['purchase_amount'], 2); ?>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endwhile; ?>
         </div>
      <?php else: ?>
         <div class="row">
            <div class="col-12">
               <div class="empty-state">
                  <i class="fas fa-shopping-bag"></i>
                  <h3 class="mb-3">No Purchases Yet</h3>
                  <p class="mb-4">You haven't purchased any products yet. Start bidding on auctions!</p>
                  <a href="index.php" class="btn-back">Browse Auctions</a>
               </div>
            </div>
         </div>
      <?php endif; ?>
   </div>

   <?php include "footer.php"; ?>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

   <script>
      document.addEventListener('DOMContentLoaded', function () {
         // Add tooltips to status badges
         const statusBadges = document.querySelectorAll('.status-badge');
         statusBadges.forEach(badge => {
            badge.setAttribute('title', 'Purchase Status');
            badge.setAttribute('data-bs-toggle', 'tooltip');
         });

         // Initialize Bootstrap tooltips
         const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
         const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
         });
      });
   </script>
</body>

</html>