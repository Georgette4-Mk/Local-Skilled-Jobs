<?php
include('db.php');
if(!isset($_SESSION['user_logged_in']))
{
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login and Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body> 
<h1> WELCOME USER</h1>
<a href= "login.php">Logout</a>
</body>
</html>