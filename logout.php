<?php
session_start();

/* remove all session data */
$_SESSION = [];

/* destroy session */
session_destroy();

/* redirect to home */
header("Location: index.php");
exit;
