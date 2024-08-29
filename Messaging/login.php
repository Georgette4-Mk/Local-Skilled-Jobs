<?php
session_start();
require_once 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the email and password fields are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Ensure all fields are filled
        if (!empty($email) && !empty($password)) {
            // Prepare the SQL query
            $stmt = $mysqli->prepare("SELECT user_id, username, password FROM users WHERE email = ?");
            if ($stmt) {
                // Bind parameters
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                // Check if the user exists
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($user_id, $username, $hashed_password);
                    $stmt->fetch();

                    // Verify the password
                    if (password_verify($password, $hashed_password)) {
                        // Set session variables
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['username'] = $username;

                        // Redirect to the dashboard
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        echo "Invalid email or password.";
                    }
                } else {
                    echo "No user found with this email.";
                }
                $stmt->close();
            } else {
                // Output the error message if the query fails
                echo "Error preparing statement: " . $mysqli->error;
            }
        } else {
            echo "Email and password are required.";
        }
    } else {
        echo "Email and password are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
