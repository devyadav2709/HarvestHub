<?php
// 1. Include Database Connection
include "php/db.php";

// 2. Admin Credentials
$email = "nevu03@gmail.com";
$password_plain = "dev@123";
$role = "admin";

// 3. Encrypt the Password (Crucial Step!)
$hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

// 4. Check if user exists
$check_sql = "SELECT * FROM users WHERE email = '$email'";
$check_result = mysqli_query($conn, $check_sql);

echo "<div style='font-family: sans-serif; padding: 40px; text-align: center; background: #f4f4f4; border: 1px solid #ddd; margin: 20px;'>";

if (mysqli_num_rows($check_result) > 0) {
   // User Exists -> UPDATE Password & Role
   $update_sql = "UPDATE users 
                   SET password = '$hashed_password', role = '$role' 
                   WHERE email = '$email'";

   if (mysqli_query($conn, $update_sql)) {
      echo "<h1 style='color:green'>✅ ADMIN UPDATED</h1>";
      echo "<p>The password for <strong>$email</strong> has been fixed.</p>";
   } else {
      echo "<h1 style='color:red'>❌ UPDATE FAILED</h1>";
      echo "<p>" . mysqli_error($conn) . "</p>";
   }

} else {
   // User Does Not Exist -> INSERT New Admin
   $insert_sql = "INSERT INTO users (name, email, password, role) 
                   VALUES ('Super Admin', '$email', '$hashed_password', '$role')";

   if (mysqli_query($conn, $insert_sql)) {
      echo "<h1 style='color:green'>✅ ADMIN CREATED</h1>";
      echo "<p>New account for <strong>$email</strong> has been created.</p>";
   } else {
      echo "<h1 style='color:red'>❌ INSERT FAILED</h1>";
      echo "<p>" . mysqli_error($conn) . "</p>";
   }
}

echo "<hr style='margin: 20px 0;'>";
echo "<p>You can now log in with:</p>";
echo "<p>Email: <b>$email</b></p>";
echo "<p>Password: <b>$password_plain</b></p>";
echo "<br>";
echo "<a href='login.php' style='background: #2e7d32; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;'>Go to Login Page</a>";
echo "</div>";
?>