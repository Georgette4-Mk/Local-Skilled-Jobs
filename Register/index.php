

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

<?php
session_start();



if(isset($_SESSION['login']) && $_SESSION['login'] == true)
{
    echo "<h1> WELCOME USER</h1>";
    
} else {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

?>
</body>
</html>