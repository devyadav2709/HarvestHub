<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "harwest_hub";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Auto-expire products whose bidding window has closed
$cleanup_sql = "UPDATE products
                SET status = 'expired'
                WHERE bid_end < NOW() AND status = 'active'";
mysqli_query($conn, $cleanup_sql);

// ─── Session ──────────────────────────────────────────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ─── CSRF Helpers ─────────────────────────────────────────────────────────────

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}

function csrf_verify(): void
{
    $submitted = $_POST['_csrf_token'] ?? '';
    if (!hash_equals(csrf_token(), $submitted)) {
        http_response_code(403);
        die('CSRF token mismatch. Please go back and try again.');
    }
}
