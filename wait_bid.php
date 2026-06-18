<?php
include "php/db.php";

if (isset($_POST['notification_id'])) {

    $notification_id = $_POST['notification_id'];

    // mark notification as read (wait chosen)
    mysqli_query($conn, "
        UPDATE notifications 
        SET is_read = 1 
        WHERE id = '$notification_id'
    ");

    // go back to farmer dashboard
    header("Location: farmer_dashboard.php");
    exit;
}
?>
