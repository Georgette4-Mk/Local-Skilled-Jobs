<?php
require_once 'config.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle profile picture update
if (isset($_POST['update_profile_pic'])) {
    $contact_id = $_POST['contact_id'];
    $profile_picture = $_FILES['profile_picture']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_picture);

    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
        // Update the profile picture in the database
        $stmt = $mysqli->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
        $stmt->bind_param("si", $profile_picture, $contact_id);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

// Handle message sending
$recipient_id = $_POST['recipient_id'] ?? null;
$message = $_POST['message'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($recipient_id) && isset($message)) {
    // Check if chat exists
    $stmt = $mysqli->prepare("SELECT chat_id FROM chats WHERE (user1_id = ? AND user2_id = ?) OR (user1_id = ? AND user2_id = ?)");
    $stmt->bind_param("iiii", $user_id, $recipient_id, $recipient_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $chat = $result->fetch_assoc();

    if ($chat) {
        $chat_id = $chat['chat_id'];
    } else {
        // Create a new chat
        $stmt = $mysqli->prepare("INSERT INTO chats (user1_id, user2_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $recipient_id);
        $stmt->execute();
        $chat_id = $stmt->insert_id;
    }

    // Insert message into chat_messages table
    $stmt = $mysqli->prepare("INSERT INTO chat_messages (chat_id, sender_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $chat_id, $user_id, $message);
    $stmt->execute();
    $stmt->close();
}

// Fetch contacts
$contacts = [];
$stmt = $mysqli->prepare("SELECT user_id, username, profile_picture FROM users WHERE user_id != ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}

// Fetch conversations
$selected_contact = $_GET['contact_id'] ?? null;
$messages = [];
if ($selected_contact) {
    $stmt = $mysqli->prepare("SELECT m.message, u.username, u.profile_picture FROM chat_messages m
        JOIN users u ON m.sender_id = u.user_id
        WHERE m.chat_id IN (SELECT chat_id FROM chats WHERE (user1_id = ? AND user2_id = ?) OR (user1_id = ? AND user2_id = ?))");
    $stmt->bind_param("iiii", $user_id, $selected_contact, $selected_contact, $user_id);
    $stmt->execute();
    $messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Message</title>
    <style>
        /* Contact Profile Picture */
        .contact img.profile-picture {
            width: 40px; /* Adjust size as needed */
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Message Profile Picture */
        .message img.profile-picture {
            width: 30px; /* Adjust size as needed */
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        /* Additional styles for layout */
        .dashboard {
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #f4f4f4;
            padding: 15px;
        }
        .main-content {
            flex-grow: 1;
            padding: 15px;
        }
        .contact {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .message-section {
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .messages {
            margin-bottom: 10px;
        }
        .message {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <a href="dashboard.php">Dashboard</a>
            <a href="send_message.php">Send Message</a>
            <a href="add_friend.php">Add Friend</a>
            <a href="profile.php">Profile</a>
            <a href="settings.php">Settings</a>
            <a href="logout.php">Logout</a>
        </nav>

        <main class="main-content">
            <div class="sidebar">
                <h2>Contacts</h2>
                <?php foreach ($contacts as $contact): ?>
                    <div class="contact">
                        <a href="send_message.php?contact_id=<?php echo $contact['user_id']; ?>">
                            <img src="uploads/<?php echo htmlspecialchars($contact['profile_picture']); ?>" alt="Profile Picture" class="profile-picture">
                            <?php echo htmlspecialchars($contact['username']); ?>
                        </a>
                        <!-- Profile Picture Update Form -->
                        <form action="send_message.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="contact_id" value="<?php echo $contact['user_id']; ?>">
                            <input type="file" name="profile_picture">
                            <button type="submit" name="update_profile_pic">Update Profile Picture</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="message-section">
                <?php if ($selected_contact): ?>
                    <h2>Conversation with <?php echo htmlspecialchars($selected_contact); ?></h2>
                    <div class="messages">
                        <?php foreach ($messages as $msg): ?>
                            <div class="message">
                                <img src="uploads/<?php echo htmlspecialchars($msg['profile_picture']); ?>" alt="Profile Picture" class="profile-picture">
                                <p><strong><?php echo htmlspecialchars($msg['username']); ?>:</strong> <?php echo htmlspecialchars($msg['message']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <form action="send_message.php" method="post">
                        <input type="hidden" name="recipient_id" value="<?php echo htmlspecialchars($selected_contact); ?>">
                        <textarea name="message" placeholder="Type your message here..."></textarea>
                        <button type="submit">Send</button>
                    </form>
                <?php else: ?>
                    <p>Select a contact to start a conversation.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
