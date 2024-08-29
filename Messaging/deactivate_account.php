<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission for deactivating the account
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE users SET status = 'deactivated' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo "Your account has been deactivated.";
            // Optionally, you can log the user out or redirect them
            session_destroy();
            header("Location: login.php");
            exit();
        } else {
            echo "Error deactivating account.";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deactivate Account</title>
</head>
<body>
    <h2>Deactivate Account</h2>
    <form method="post" action="">
        <p>Are you sure you want to deactivate your account? This action cannot be undone.</p>
        <input type="submit" value="Deactivate Account">
    </form>
</body>
</html>
