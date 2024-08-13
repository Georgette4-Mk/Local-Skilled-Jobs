<?php
session_start();

// Connect to database
$conn = mysqli_connect("localhost", "username", "password", "database");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Define variables
$username = $_POST['username'];
$password = $_POST['password'];

// Query to check if username and password match
$query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $query);

// Check if query returns a result
if (mysqli_num_rows($result) > 0) {
  // Set session variables
  $_SESSION['admin_logged_in'] = true;
  $_SESSION['admin_username'] = $username;

  // Redirect to admin dashboard
  header("Location: admin_dashboard.php");
  exit;
} else {
  // Display error message
  echo "Invalid username or password";
}

// Close database connection
mysqli_close($conn);
?>