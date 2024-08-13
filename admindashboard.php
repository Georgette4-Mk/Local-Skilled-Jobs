<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit;
}

// Display admin dashboard content
echo "Welcome, " . $_SESSION['admin_username'] . "!";
?>