<?php
include 'db_connect.php';
session_start();

// Check if user is logged in and user_id is set
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$contact_id = isset($_GET['contact_id']) ? $_GET['contact_id'] : null;

if (!$contact_id) {
    die("No contact specified.");
}

// Fetch messages
$sql_messages = "SELECT m.content, m.created_at, u.username, u.profile_picture, m.sender_id
                 FROM messages m
                 JOIN users u ON m.sender_id = u.id
                 WHERE (m.sender_id = ? AND m.receiver_id = ?) 
                    OR (m.sender_id = ? AND m.receiver_id = ?)
                 ORDER BY m.created_at ASC";
$stmt_messages = $conn->prepare($sql_messages);

if (!$stmt_messages) {
    die("Error preparing statement: " . $conn->error);
}

$stmt_messages->bind_param("iiii", $user_id, $contact_id, $contact_id, $user_id);
$stmt_messages->execute();
$messages = $stmt_messages->get_result();

$stmt_messages->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Conversation</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 80%; margin: auto; overflow: hidden; }
        .message { margin-bottom: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; border-radius: 5px; }
        .message img { width: 30px; height: 30px; border-radius: 50%; }
        .message p { margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Conversation with <?php echo htmlspecialchars($contact_id); ?></h2>
        <?php if ($messages->num_rows > 0) { ?>
            <?php while ($message = $messages->fetch_assoc()) { ?>
                <div class="message">
                    <img src="uploads/<?php echo htmlspecialchars($message['profile_picture']); ?>" alt="<?php echo htmlspecialchars($message['username']); ?>">
                    <p><strong><?php echo htmlspecialchars($message['sender_id'] == $user_id ? 'You' : htmlspecialchars($message['username'])); ?>:</strong> <?php echo htmlspecialchars($message['content']); ?></p>
                    <p><?php echo htmlspecialchars($message['created_at']); ?></p>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No messages found.</p>
        <?php } ?>
    </div>
</body>
</html>
