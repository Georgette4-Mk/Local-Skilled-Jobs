<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$selected_friend_id = isset($_GET['friend_id']) ? $_GET['friend_id'] : null;

// Fetch messages between user and selected friend
$sql = "SELECT m.id, u.username, m.content, m.created_at
        FROM messages m
        JOIN users u ON (m.sender_id = u.id OR m.receiver_id = u.id)
        WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?)
        ORDER BY m.created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $user_id, $selected_friend_id, $selected_friend_id, $user_id);
$stmt->execute();
$messages = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .navbar { background-color: #333; padding: 10px; color: #fff; text-align: center; }
        .navbar a { color: #fff; margin: 0 15px; text-decoration: none; }
        .container { width: 80%; margin: auto; overflow: hidden; }
        .message { background: #fff; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .success { color: green; }
        .error { color: red; }
        .form-group { margin: 20px 0; }
        label { font-size: 18px; color: #333; }
        textarea, input[type="submit"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="send_message.php">Send Message</a>
        <a href="add_friend.php">Add Friend</a>
        <a href="profile.php">Profile</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <h2>Messages with <?php echo htmlspecialchars($selected_friend_id); ?></h2>
        <?php if ($messages->num_rows > 0) { ?>
            <?php while ($row = $messages->fetch_assoc()) { ?>
                <div class="message">
                    <p><strong><?php echo htmlspecialchars($row['username']); ?>:</strong> <?php echo htmlspecialchars($row['content']); ?></p>
                    <p><small><?php echo htmlspecialchars($row['created_at']); ?></small></p>
                    <?php if ($row['sender_id'] == $user_id) { ?>
                        <a href="edit_message_form.php?message_id=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="delete_message.php?message_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No messages yet.</p>
        <?php } ?>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
