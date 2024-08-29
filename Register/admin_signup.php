<?php
session_start();
require_once 'db.php';


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; 
     
    // Check if passwords match
    if ($password != $confirm_password) {
        $error = "Passwords do not match";
    } 
    
    else {
        // Prepare query
        $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        // Check if query was successful
        if ($stmt->affected_rows > 0) {
            // Set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;

            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
            exit;
        } else {
            // Display error message
            $error = "Failed to create account";
        }
    }
}

// Close database connection
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
    <h1>Admin Signup </h1>
<!-- HTML form -->
<form style="margin: 0 auto; width: 25%; text-align: center;"method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="confirm password"> Confirm Password:</label>
    <input type="confirm password" id="confirm password" name="confirm password" required><br><br>

    
    
    <input type="submit" value="Sign Up">
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <p>Aready have an account? <a href="admin_login.php">Login here</a></p>
</form>
</body>
</html>

