<?php
include "php/db.php";

/* ---------- KPI DATA ---------- */

$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];

$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];

$total_bids = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM bids"))['total'];

$total_sales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM purchases"))['total'];

$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(purchase_amount) as total FROM purchases"))['total'] ?? 0;


/* ---------- MONTHLY REVENUE ---------- */

$month_query = mysqli_query($conn, "
SELECT MONTH(purchase_date) as month,
SUM(purchase_amount) as revenue
FROM purchases
GROUP BY MONTH(purchase_date)
");

$months = [];
$revenues = [];

while ($row = mysqli_fetch_assoc($month_query)) {
   $months[] = $row['month'];
   $revenues[] = $row['revenue'];
}


/* ---------- USER ROLE CHART ---------- */

$role_query = mysqli_query($conn, "SELECT role, COUNT(*) as total FROM users GROUP BY role");

$roles = [];
$role_data = [];

while ($r = mysqli_fetch_assoc($role_query)) {
   $roles[] = $r['role'];
   $role_data[] = $r['total'];
}


/* ---------- TOP PRODUCTS ---------- */

$product_query = mysqli_query($conn, "
SELECT p.name,SUM(pur.purchase_amount) as revenue
FROM purchases pur
LEFT JOIN products p ON pur.product_id=p.id
GROUP BY pur.product_id
ORDER BY revenue DESC
LIMIT 5
");

$product_names = [];
$product_revenue = [];

while ($p = mysqli_fetch_assoc($product_query)) {
   $product_names[] = $p['name'];
   $product_revenue[] = $p['revenue'];
}

?>

<!DOCTYPE html>
<html>

<head>

   <title>Analytics Dashboard</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <style>
      body {
         background: #f5f7fb;
         font-family: Arial;
      }

      .card {
         border-radius: 15px;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
         border: none;
      }

      .kpi {
         font-size: 28px;
         font-weight: bold;
      }

      .chart-box {
         background: white;
         padding: 20px;
         border-radius: 15px;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      }
   </style>

</head>

<body>

   <div class="container py-4">

      <h2 class="mb-4">Admin Analytics Dashboard</h2>

      <div class="row g-4">

         <div class="col-md-3">
            <div class="card p-3">
               Total Users
               <div class="kpi"><?php echo $total_users ?></div>
            </div>
         </div>

         <div class="col-md-3">
            <div class="card p-3">
               Total Products
               <div class="kpi"><?php echo $total_products ?></div>
            </div>
         </div>

         <div class="col-md-3">
            <div class="card p-3">
               Total Bids
               <div class="kpi"><?php echo $total_bids ?></div>
            </div>
         </div>

         <div class="col-md-3">
            <div class="card p-3">
               Revenue
               <div class="kpi">₹<?php echo number_format($total_revenue, 2) ?></div>
            </div>
         </div>

      </div>


      <div class="row mt-5 g-4">

         <div class="col-md-6">

            <div class="chart-box">

               <h5>Monthly Revenue</h5>

               <canvas id="revenueChart"></canvas>

            </div>

         </div>


         <div class="col-md-6">

            <div class="chart-box">

               <h5>User Roles</h5>

               <canvas id="roleChart"></canvas>

            </div>

         </div>


         <div class="col-md-12">

            <div class="chart-box">

               <h5>Top Products</h5>

               <canvas id="productChart"></canvas>

            </div>

         </div>

      </div>

   </div>


   <script>

      /* Revenue Chart */

      new Chart(document.getElementById("revenueChart"), {

         type: 'line',

         data: {
            labels: <?php echo json_encode($months) ?>,
            datasets: [{
               label: 'Revenue',
               data: <?php echo json_encode($revenues) ?>,
               tension: 0.3
            }]
         }

      });


      /* Role Chart */

      new Chart(document.getElementById("roleChart"), {

         type: 'doughnut',

         data: {
            labels: <?php echo json_encode($roles) ?>,
            datasets: [{
               data: <?php echo json_encode($role_data) ?>
            }]
         }

      });


      /* Product Chart */

      new Chart(document.getElementById("productChart"), {

         type: 'bar',

         data: {
            labels: <?php echo json_encode($product_names) ?>,
            datasets: [{
               label: 'Revenue',
               data: <?php echo json_encode($product_revenue) ?>
            }]
         }

      });

   </script>

</body>

</html>