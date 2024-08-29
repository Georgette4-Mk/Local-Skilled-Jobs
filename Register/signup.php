<?php
session_start();

require_once 'signupdb.php';

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $Gender = $_POST['gender'];
    $num = $_POST['number'];
    $address = $_POST['add'];
    $gmail = $_POST['mail'];
    $password = $_POST['pass'];

    if(!empty($gmail) && !empty($password) && !is_numeric($gmail))
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO form (fname, lname, gender, cnum, address, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstname, $lastname, $Gender, $num, $address, $gmail, $hashed_password);
        $stmt->execute();

        echo "<script type='text/javascript'> alert('Successfully Register')</script>";

        header('Location:login.php');

        exit;
    }
    else{
        echo "<script type='text/javascript'> alert('Please Enter some Valid Information')</script>";
    }
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
    
    <div class="signup">
        <h1>Sign Up</h1>
        <h4>It's free and only takes a minute</h4>

        <form method="POST">

            <label>First Name</label>
            <input type="text" name="fname" required>

            <label>Last Name</label>
            <input type="text" name="lname" required>

            <label> Gender</label>
            <input type="text" name="gender" required>

            <label> Contact Address</label>
            <input type="tel" name="number" required>

            <label>Address</label>
            <input type="text" name="add" required>

            <label>Email</label>
            <input type="email" name="mail" required>

            <label>Password</label>
            <input type="password" name="pass" required>

            <input type="submit" name="submit">
        </form>

        <p>By clicking the sign up button, you agree to our <br>
        <a href="">Terms and Condition</a> and <a href="#"> Policy Privacy</a></p>

        <p>Aready have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>