<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch conversations
$sql_conversations = "SELECT DISTINCT 
                            CASE
                                WHEN sender_id = ? THEN receiver_id
                                ELSE sender_id
                            END AS contact_id
                       FROM messages
                       WHERE sender_id = ? OR receiver_id = ?";
$stmt_conversations = $conn->prepare($sql_conversations);
if (!$stmt_conversations) {
    die("Error preparing statement: " . $conn->error);
}
$stmt_conversations->bind_param("iii", $user_id, $user_id, $user_id);
$stmt_conversations->execute();
$conversations = $stmt_conversations->get_result();

$stmt_conversations->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 80%; margin: auto; overflow: hidden; }
        .sidebar { float: left; width: 20%; background-color: #fff; border-right: 1px solid #ddd; padding: 20px; }
        .content { float: right; width: 75%; padding: 20px; background-color: #fff; }
        .nav-link { display: block; padding: 10px; margin-bottom: 10px; text-decoration: none; color: #333; border-radius: 5px; background-color: #e4e4e4; }
        .nav-link:hover { background-color: #ddd; }
        .message-box { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Dashboard</h2>
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="send_message.php" class="nav-link">Send Message</a>
            <a href="add_friend.php" class="nav-link">Add Friend</a>
            <a href="profile.php" class="nav-link">Profile</a>
            <a href="settings.php" class="nav-link">Settings</a>
            <a href="notifications.php" class="nav-link">Notifications</a>
            <a href="logout.php" class="nav-link">Logout</a>
        </div>
        <div class="content">
            <h2>Messages</h2>
            <?php if ($conversations->num_rows > 0) { ?>
                <?php while ($conversation = $conversations->fetch_assoc()) { ?>
                    <div class="message-box">
                        <a href="view_conversation.php?contact_id=<?php echo htmlspecialchars($conversation['contact_id']); ?>">View Conversation</a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No conversations found.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
