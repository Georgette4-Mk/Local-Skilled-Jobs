<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle data sharing preferences here...

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sharing Settings</title>
</head>
<body>
    <h2>Data Sharing Settings</h2>
    <!-- Form to manage data sharing preferences -->
</body>
</html>
