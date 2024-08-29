<?php
session_start();

include 'db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare query
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if query returns a result
    if ($result->num_rows > 0) {
        // Set session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;

        // Redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Display error message
        $error = "Invalid username or password";
    }
}

// Close database connection
$conn->close();
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

</head>
<body>
    <h1>Admin Login </h1>
<form style="margin: 0 auto; width: 25%; text-align: center;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">password:</label>
    <input type="password" id="password" name="password" required><br><br>
    
    <input type="submit" value="Login">
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</form>
<p>Don't have an account? <a href="admin_signup.php">Sign Up here</a></p>

</body>
</html>
