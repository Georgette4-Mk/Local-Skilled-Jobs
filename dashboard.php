<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = $conn->prepare("SELECT username FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Fetch users to use as contacts
$contactsQuery = $conn->prepare("SELECT id, username FROM users WHERE id != ?");
$contactsQuery->bind_param("i", $user_id);
$contactsQuery->execute();
$contactsResult = $contactsQuery->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        nav {
            background-color: #343a40;
            padding: 10px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: #495057;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .contacts {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .contacts ul {
            list-style-type: none;
            padding: 0;
        }
        .contacts ul li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .contacts ul li:last-child {
            border-bottom: none;
        }
        .contacts ul li a {
            text-decoration: none;
            color: #007bff;
        }
        .contacts ul li a:hover {
            text-decoration: underline;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .feature-box {
            flex: 1 1 calc(33.333% - 20px);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .feature-box h3 {
            margin-bottom: 10px;
            color: #007bff;
        }
        .feature-box p {
            color: #333;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            margin-top: 20px;
        }
        footer p {
            margin: 0;
            font-size: 14px;
        }
        footer a {
            color: #007bff;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
        /* Responsive design */
        @media (max-width: 768px) {
            .feature-box {
                flex: 1 1 100%;
            }
            nav {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
</header>

<nav>
    <a href="dashboard.php">Home</a>
    <a href="messaging.php">Messages</a>
    <a href="profile.php">Profile</a>
    <a href="settings.php">Settings</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">
    <div class="contacts">
        <h2>Contacts</h2>
        <ul>
            <?php while ($contact = $contactsResult->fetch_assoc()) : ?>
                <li><a href="messaging.php?contact_id=<?php echo $contact['id']; ?>"><?php echo htmlspecialchars($contact['username']); ?></a></li>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="features">
        <div class="feature-box">
            <h3>Real-Time Messaging</h3>
            <p>Send and receive messages without reloading the page.</p>
        </div>
        <div class="feature-box">
            <h3>Typing Indicator</h3>
            <p>See when a user is typing a message.</p>
        </div>
        <div class="feature-box">
            <h3>Read Receipts</h3>
            <p>Know when your message has been read.</p>
        </div>
        <div class="feature-box">
            <h3>Emojis & Attachments</h3>
            <p>Express yourself with emojis and send attachments.</p>
        </div>
        <div class="feature-box">
            <h3>Search Messages</h3>
            <p>Find specific contacts or messages quickly.</p>
        </div>
        <div class="feature-box">
            <h3>Message Notifications</h3>
            <p>Get notified of new messages while browsing other sections.</p>
        </div>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Messaging Platform. All Rights Reserved.</p>
    <p><a href="privacy.php">Privacy Policy</a> | <a href="terms.php">Terms of Service</a></p>
</footer>

</body>
</html>
