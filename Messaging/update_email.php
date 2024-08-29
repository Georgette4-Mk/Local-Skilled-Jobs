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
    <title>Update Email</title>
</head>
<body>
    <h2>Update Email</h2>
    <form method="post" action="">
        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email" required>
        <br><br>
        <input type="submit" value="Update Email">
    </form>
</body>
</html>
