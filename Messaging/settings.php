<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user settings
$sql_settings = "SELECT * FROM user_settings WHERE user_id = ?";
$stmt_settings = $conn->prepare($sql_settings);
$stmt_settings->bind_param("i", $user_id);
$stmt_settings->execute();
$result_settings = $stmt_settings->get_result();
$user_settings = $result_settings->fetch_assoc();

$stmt_settings->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 80%; margin: auto; overflow: hidden; }
        .sidebar { width: 20%; float: left; background: #333; color: #fff; height: 100vh; }
        .sidebar h2 { padding: 10px; text-align: center; background: #444; margin: 0; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li { padding: 15px; border-bottom: 1px solid #444; }
        .sidebar ul li a { color: #fff; text-decoration: none; }
        .sidebar ul li:hover { background: #555; }
        .main-content { width: 75%; float: right; padding: 20px; }
        .section { margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Settings</h2>
            <ul>
                <li><a href="#account-management">Account Management</a></li>
                <li><a href="#privacy-settings">Privacy Settings</a></li>
                <li><a href="dashboard.php">Return to Dashboard</a></li>
            </ul>
        </div>
        <div class="main-content">
            <!-- Account Management Section -->
            <div id="account-management" class="section">
                <h2>Account Management</h2>
                <ul>
                    <li><a href="change_password.php">Change Password</a></li>
                    <li><a href="update_email.php">Update Email</a></li>
                    <li><a href="deactivate_account.php">Deactivate Account</a></li>
                </ul>
            </div>

            <!-- Privacy Settings Section -->
            <div id="privacy-settings" class="section">
                <h2>Privacy Settings</h2>
                <ul>
                    <li><a href="manage_blocked_users.php">Manage Blocked Users</a></li>
                    <li><a href="toggle_visibility.php">Toggle Profile Visibility</a></li>
                    <li><a href="notification_preferences.php">Notification Preferences</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
