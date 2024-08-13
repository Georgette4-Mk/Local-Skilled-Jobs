<?php
session_start();

// Unset session variables
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_username']);

// Destroy session
session_destroy();

// Redirect to login page
header("Location: admin_login.php");
exit;
?>