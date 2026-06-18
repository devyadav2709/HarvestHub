<?php
// payment.php
session_start();
include "php/db.php";

// --- 1. HANDLE AJAX PAYMENT (Background Process) ---
if (isset($_POST['ajax_payment'])) {
   if (!isset($_SESSION['user_id'])) {
      echo "error";
      exit();
   }

   $pid = mysqli_real_escape_string($conn, $_POST['product_id']);
   $uid = $_SESSION['user_id'];
   $payment_method = isset($_POST['payment_method']) ? mysqli_real_escape_string($conn, $_POST['payment_method']) : 'card';

   // Get product price
   $price_sql = "SELECT base_price FROM products WHERE id = '$pid'";
   $price_result = mysqli_query($conn, $price_sql);
   $product_price = mysqli_fetch_assoc($price_result);
   $price = $product_price['base_price'];

   // Check if user has a bid for this product
   $bid_sql = "SELECT bid_amount FROM bids WHERE product_id = '$pid' AND user_id = '$uid' ORDER BY bid_amount DESC LIMIT 1";
   $bid_res = mysqli_query($conn, $bid_sql);

   if (mysqli_num_rows($bid_res) > 0) {
      $bid = mysqli_fetch_assoc($bid_res);
      $price = $bid['bid_amount'];
   }

   $tax = $price * 0.05;
   $total = $price + $tax;
   $transaction_id = 'TXN' . rand(100000, 999999) . time();

   // Start transaction
   mysqli_begin_transaction($conn);

   try {
      // A. Mark Product as SOLD
      $sql_prod = "UPDATE products SET is_sold = 1, status = 'sold' WHERE id = '$pid'";
      $update1 = mysqli_query($conn, $sql_prod);

      // B. Mark Bid as Winner
      $sql_bid = "UPDATE bids SET is_winner = 1 WHERE product_id = '$pid' AND user_id = '$uid'";
      $update2 = mysqli_query($conn, $sql_bid);

      // C. Record Purchase
      $sql_purchase = "INSERT INTO purchases (product_id, user_id, purchase_amount, payment_method, transaction_id, status) 
                        VALUES ('$pid', '$uid', '$total', '$payment_method', '$transaction_id', 'completed')";
      $update3 = mysqli_query($conn, $sql_purchase);

      if ($update1 && $update3) {
         mysqli_commit($conn);
         echo "success";
      } else {
         mysqli_rollback($conn);
         echo "error";
      }
   } catch (Exception $e) {
      mysqli_rollback($conn);
      echo "error";
   }
   exit();
}

// --- 2. STANDARD PAGE LOAD ---

// Security Check
if (!isset($_SESSION['user_id'])) {
   header("Location: login.php");
   exit();
}
if (!isset($_GET['product_id'])) {
   header("Location: index.php");
   exit();
}

$product_id = $_GET['product_id'];
$user_id = $_SESSION['user_id'];

// Fetch Product Details
$sql = "SELECT * FROM products WHERE id = '$product_id'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
   echo "Product not found or sold.";
   exit();
}

// Calculate Price (Winning Bid vs Base Price)
$bid_sql = "SELECT bid_amount FROM bids WHERE product_id = '$product_id' AND user_id = '$user_id' ORDER BY bid_amount DESC LIMIT 1";
$bid_res = mysqli_query($conn, $bid_sql);

if (mysqli_num_rows($bid_res) > 0) {
   $bid = mysqli_fetch_assoc($bid_res);
   $price = $bid['bid_amount'];
} else {
   $price = $product['base_price'];
}

$tax = $price * 0.05;
$total = $price + $tax;
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>Secure Payment | Harvest Hub</title>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
      :root {
         --primary: #2e7d32;
         --dark: #1b5e20;
         --bg: #f4f7f6;
      }

      body {
         font-family: 'Poppins', sans-serif;
         background: var(--bg);
         margin: 0;
         padding: 20px;
         display: flex;
         justify-content: center;
         min-height: 100vh;
      }

      .checkout-wrapper {
         display: flex;
         max-width: 1000px;
         width: 100%;
         background: white;
         border-radius: 20px;
         box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
         overflow: hidden;
         margin-top: 20px;
         height: fit-content;
      }

      /* LEFT SECTION */
      .payment-section {
         flex: 1.5;
         padding: 40px;
      }

      .payment-section h2 {
         color: var(--primary);
         margin-top: 0;
      }

      .methods-grid {
         display: grid;
         grid-template-columns: 1fr 1fr 1fr;
         gap: 10px;
         margin-bottom: 20px;
      }

      .method-btn {
         border: 2px solid #eee;
         border-radius: 12px;
         padding: 15px;
         text-align: center;
         cursor: pointer;
         transition: 0.3s;
         font-size: 0.9rem;
         color: #555;
      }

      .method-btn:hover {
         background: #f9f9f9;
      }

      .method-btn.active {
         border-color: var(--primary);
         background: #e8f5e9;
         color: var(--primary);
         font-weight: 700;
      }

      .method-btn i {
         display: block;
         font-size: 1.5rem;
         margin-bottom: 5px;
      }

      .payment-form {
         display: none;
         padding-top: 20px;
         border-top: 1px solid #eee;
         animation: fadeIn 0.3s;
      }

      .active-form {
         display: block;
      }

      /* Card Visual */
      .card-visual {
         background: linear-gradient(135deg, #1b5e20, #2e7d32);
         color: white;
         padding: 20px;
         border-radius: 15px;
         margin-bottom: 20px;
         height: 160px;
         display: flex;
         flex-direction: column;
         justify-content: space-between;
         box-shadow: 0 10px 20px rgba(46, 125, 50, 0.3);
      }

      .card-number {
         font-size: 1.2rem;
         letter-spacing: 2px;
         font-family: monospace;
      }

      .input-group {
         margin-bottom: 15px;
      }

      .input-group label {
         display: block;
         font-size: 0.8rem;
         font-weight: 600;
         color: #555;
         margin-bottom: 5px;
      }

      .input-group input {
         width: 100%;
         padding: 12px;
         border: 1px solid #ddd;
         border-radius: 8px;
         box-sizing: border-box;
      }

      .row {
         display: flex;
         gap: 15px;
      }

      .btn-pay {
         width: 100%;
         padding: 15px;
         background: var(--primary);
         color: white;
         border: none;
         border-radius: 10px;
         font-size: 1.1rem;
         font-weight: 700;
         cursor: pointer;
         margin-top: 20px;
         transition: 0.3s;
      }

      .btn-pay:hover {
         background: var(--dark);
         transform: translateY(-2px);
      }

      /* RIGHT SECTION */
      .summary-section {
         flex: 1;
         background: #fafafa;
         padding: 40px;
         border-left: 1px solid #eee;
      }

      .product-mini {
         display: flex;
         gap: 15px;
         margin-bottom: 20px;
         padding-bottom: 20px;
         border-bottom: 1px solid #ddd;
      }

      .product-mini img {
         width: 80px;
         height: 80px;
         border-radius: 10px;
         object-fit: cover;
      }

      .price-row {
         display: flex;
         justify-content: space-between;
         margin-bottom: 10px;
         color: #555;
      }

      .total-row {
         display: flex;
         justify-content: space-between;
         font-weight: 700;
         font-size: 1.3rem;
         margin-top: 20px;
         padding-top: 20px;
         border-top: 2px dashed #ddd;
      }

      /* OVERLAYS */
      .overlay {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(255, 255, 255, 0.95);
         z-index: 1000;
         display: none;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         text-align: center;
      }

      .spinner {
         border: 5px solid #f3f3f3;
         border-top: 5px solid var(--primary);
         border-radius: 50%;
         width: 50px;
         height: 50px;
         animation: spin 1s linear infinite;
         margin-bottom: 20px;
      }

      .receipt {
         background: white;
         padding: 40px;
         border-radius: 20px;
         box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
         width: 350px;
         text-align: center;
         border: 1px solid #eee;
      }

      @keyframes spin {
         0% {
            transform: rotate(0deg);
         }

         100% {
            transform: rotate(360deg);
         }
      }

      @keyframes fadeIn {
         from {
            opacity: 0;
            transform: translateY(10px);
         }

         to {
            opacity: 1;
            transform: translateY(0);
         }
      }

      @media(max-width: 800px) {
         .checkout-wrapper {
            flex-direction: column;
         }

         .summary-section {
            border-left: none;
            border-top: 1px solid #eee;
            order: -1;
         }
      }
   </style>
</head>

<body>

   <div class="checkout-wrapper">
      <div class="payment-section">
         <h2>Payment Details</h2>

         <div class="methods-grid">
            <div class="method-btn active" onclick="switchMethod('card', this)"><i class="far fa-credit-card"></i> Card
            </div>
            <div class="method-btn" onclick="switchMethod('upi', this)"><i class="fas fa-qrcode"></i> UPI</div>
            <div class="method-btn" onclick="switchMethod('cod', this)"><i class="fas fa-truck"></i> COD</div>
         </div>

         <div id="card-form" class="payment-form active-form">
            <div class="card-visual">
               <div style="width:40px; height:30px; background:#ffd700; border-radius:5px; opacity:0.8;"></div>
               <div class="card-number">•••• •••• •••• 4242</div>
               <div style="display:flex; justify-content:space-between; margin-top:auto;">
                  <span><?php echo $_SESSION['name']; ?></span><span>MM/YY</span>
               </div>
            </div>
            <div class="input-group"><label>Card Number</label><input type="text" placeholder="0000 0000 0000 0000">
            </div>
            <div class="row">
               <div class="input-group"><label>Expiry</label><input type="text" placeholder="MM/YY"></div>
               <div class="input-group"><label>CVV</label><input type="password" placeholder="123"></div>
            </div>
         </div>

         <div id="upi-form" class="payment-form">
            <div style="text-align:center; padding:20px; border:2px dashed #ddd; border-radius:10px;">
               <img
                  src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=harvest@upi&am=<?php echo $total; ?>"
                  style="width:150px;">
               <p>Scan with Any UPI App</p>
            </div>
         </div>

         <div id="cod-form" class="payment-form">
            <div style="text-align:center; padding:30px; background:#fafafa; border-radius:10px;">
               <i class="fas fa-money-bill-wave" style="font-size:3rem; color:var(--primary);"></i>
               <p>Pay <b>₹<?php echo number_format($total, 2); ?></b> on delivery.</p>
            </div>
         </div>

         <button class="btn-pay" type="button" onclick="startPayment()">Pay
            ₹<?php echo number_format($total, 2); ?></button>
      </div>

      <div class="summary-section">
         <h3>Order Summary</h3>
         <div class="product-mini">
            <img src="images/<?php echo $product['image']; ?>" onerror="this.src='https://via.placeholder.com/80'">
            <div>
               <h4 style="margin:0;"><?php echo $product['name']; ?></h4>
               <small>Product ID: #<?php echo $product['id']; ?></small>
            </div>
         </div>
         <div class="price-row"><span>Base Price</span><span>₹<?php echo number_format($price, 2); ?></span></div>
         <div class="price-row"><span>Fees (5%)</span><span>₹<?php echo number_format($tax, 2); ?></span></div>
         <div class="total-row"><span>Total</span><span>₹<?php echo number_format($total, 2); ?></span></div>
      </div>
   </div>

   <div id="processing" class="overlay">
      <div class="spinner"></div>
      <h2>Processing Payment...</h2>
      <p>Do not close this window</p>
   </div>

   <div id="success" class="overlay">
      <div class="receipt">
         <div
            style="width:60px; height:60px; background:#e8f5e9; color:#2e7d32; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2rem; margin:0 auto 20px;">
            <i class="fas fa-check"></i>
         </div>
         <h2 style="color:var(--primary); margin:0;">Success!</h2>
         <p>Your order has been placed.</p>
         <div style="background:#f9f9f9; padding:10px; border-radius:8px; margin:20px 0;">
            <div class="price-row"><span>Amount</span><strong>₹<?php echo number_format($total, 2); ?></strong></div>
            <div class="price-row"><span>Trans ID</span><span>#<?php echo rand(100000, 999999); ?></span></div>
         </div>
         <button class="btn-pay" onclick="window.location.href='my_purchases.php'" style="margin-top:0;">View My
            Purchases</button>
         <button class="btn-pay" onclick="window.location.href='index.php'"
            style="margin-top:10px; background:#f0f0f0; color:#333;">Continue Shopping</button>
      </div>
   </div>

   <script>
      function switchMethod(method, btn) {
         document.querySelectorAll('.method-btn').forEach(b => b.classList.remove('active'));
         btn.classList.add('active');
         document.querySelectorAll('.payment-form').forEach(f => f.style.display = 'none');
         document.getElementById(method + '-form').style.display = 'block';
      }

      function startPayment() {
         // Get selected payment method
         let selectedMethod = '';
         document.querySelectorAll('.method-btn').forEach(btn => {
            if (btn.classList.contains('active')) {
               let methodText = btn.querySelector('i').nextSibling.textContent.trim();
               selectedMethod = methodText.toLowerCase();
            }
         });

         // 1. Show Processing Screen
         document.getElementById('processing').style.display = 'flex';

         // 2. Prepare Data
         let formData = new FormData();
         formData.append('ajax_payment', '1');
         formData.append('product_id', '<?php echo $product_id; ?>');
         formData.append('payment_method', selectedMethod);

         // 3. Send Data to Server (AJAX)
         fetch('payment.php', {
            method: 'POST',
            body: formData
         })
            .then(response => response.text())
            .then(data => {
               // 4. Wait 2 seconds for visual effect, then show success
               setTimeout(() => {
                  document.getElementById('processing').style.display = 'none';
                  if (data.trim() === 'success') {
                     document.getElementById('success').style.display = 'flex';
                  } else {
                     alert('Payment Error: ' + data);
                  }
               }, 2000);
            })
            .catch(error => {
               alert('Connection Error');
               document.getElementById('processing').style.display = 'none';
            });
      }
   </script>
</body>

</html>