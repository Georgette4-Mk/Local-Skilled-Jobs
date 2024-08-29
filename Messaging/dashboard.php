<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once('config.php');

$user_id = $_SESSION['user_id'];

// Fetch notifications, messages, etc. if needed

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        /* Add your CSS styling here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        nav {
            width: 200px;
            background-color: #333;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            margin: 20px 0;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <h2>Dashboard</h2>
        <ul>
            <li><a href="send_message.php">Send Message</a></li>
            <li><a href="add_friend.php">Add Friend</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="messages.php">Messages</a></li>
        </ul>
    </nav>
    <div class="content">
        <h1>Welcome to your Dashboard</h1>
        <p>Use the navigation links on the left to access different sections.</p>
    </div>
</body>
</html>
