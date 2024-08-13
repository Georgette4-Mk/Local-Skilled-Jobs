<?php
session_start();

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = filter_var($_POST['mail']);
    $password = $_POST['pass'];

    $sql = "SELECT * FROM form WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
 
                echo "<script type='text/javascript'> alert ('Signin Succesfull')</script>";
            }
        } else {
            echo "<script type='text/javascript'> alert ('wrong username')</script>";
        }

     $conn->close();   
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
    <div class="login">
        <h1>Login</h1>
        <form method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="mail" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="pass" required>

            <input type="submit" value="Submit">
        </form>

        <p>Don't have an account? <a href="signup.php">Sign Up here</a></p>
    </div>
</body>
</html>