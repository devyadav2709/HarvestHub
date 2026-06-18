<?php
include "php/db.php";

// 1. Make all products available again (Un-sell them)
mysqli_query($conn, "UPDATE products SET is_sold = 0");

// 2. Delete all past bids (Start fresh from Base Price)
mysqli_query($conn, "TRUNCATE TABLE bids");

// 3. Delete all old notifications
mysqli_query($conn, "TRUNCATE TABLE notifications");

echo "<h1>System Reset Successfully! ♻️</h1>";
echo "<p>All products are available again.</p>";
echo "<p>All previous bids and notifications have been deleted.</p>";
echo "<br><a href='index.php'>Go to Homepage</a>";
?>