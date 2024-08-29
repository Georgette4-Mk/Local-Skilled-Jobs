<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission here...

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
</head>
<body>
    <h2>Delete Account</h2>
    <form method="post" action="">
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
        <input type="submit" value="Delete Account">
    </form>
</body>
</html>
