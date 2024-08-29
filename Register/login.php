<?php
session_start(); 
require_once 'signupdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

}
    $stmt = $conn->prepare("SELECT * FROM form WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, log in the user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['login'] = true;
            header("Location: MainDashboard.php");
            exit();
        } else {
            echo "Invalid email or password!";
            $stmt->close();
            $conn->close();
        }
    }

?>

<!-- HTML form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login and Register</title>
    <link rel="stylesheet" href="style.css">
    


<!--<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">-->

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="display: block; margin: 0 auto; width: 300px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

  <h2>Login</h2>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required><br><br>
  
  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required><br><br>
  <input type="submit" value="Login">
</form>

<p>Don't have an account? <a href="signup.php">Signup here</a></p>

</body>
</html>

