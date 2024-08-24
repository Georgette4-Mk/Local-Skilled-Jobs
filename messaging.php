<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the current user's ID
$current_user_id = $_SESSION['user_id'];

// Get the contact ID from the GET request
// Get the contact ID from the GET request
if (isset($_GET['contact_id'])) {
    $contact_id = $_GET['contact_id'];
} else {
    // If contact_id is not set, redirect to the contact list or an error page
    header('Location: conversations.php');
    exit();
}

// Fetch contact information from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $contact_id);
$stmt->execute();
$result = $stmt->get_result();
$contact = $result->fetch_assoc();

if (!$contact) {
    echo "Contact not found.";
    exit();
}

// Fetch messages between the current user and the contact
$query = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param('iiii', $current_user_id, $contact_id, $contact_id, $current_user_id);
$stmt->execute();
$messages = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
        }
        .messaging-container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            margin: 0 0 20px;
            text-align: center;
        }
        .messages {
            height: 400px;
            overflow-y: scroll;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .message {
            padding: 8px;
            margin: 5px 0;
            border-radius: 4px;
        }
        .message.sent {
            background-color: #d1e7dd;
            text-align: right;
        }
        .message.received {
            background-color: #f8d7da;
            text-align: left;
        }
        .message-form {
            display: flex;
            gap: 10px;
        }
        .message-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .message-form button {
            padding: 10px 20px;
            border: none;
            background-color: #0d6efd;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .message-form button:hover {
            background-color: #0a58ca;
        }
        #typingIndicator {
            display: none;
            font-style: italic;
            color: #007bff;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="messaging-container">
        <h2>Chat with <?php echo htmlspecialchars($contact['username']); ?></h2>
        
        <div class="messages" id="messageBox">
            <?php while ($message = $messages->fetch_assoc()): ?>
                <div class="message <?php echo $message['sender_id'] == $current_user_id ? 'sent' : 'received'; ?>">
                    <?php echo htmlspecialchars($message['message_text']); ?>
                </div>
            <?php endwhile; ?>
        </div>

        <div id="typingIndicator">Typing...</div>

        <form class="message-form" id="messageForm">
            <input type="text" id="messageInput" placeholder="Type your message..." autocomplete="off">
            <input type="hidden" id="contactId" value="<?php echo $contact_id; ?>">
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        // Handle message sending via AJAX
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const messageInput = document.getElementById('messageInput');
            const messageText = messageInput.value.trim();
            const contactId = document.getElementById('contactId').value;

            if (messageText === '') return;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_message.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(`message_text=${messageText}&contact_id=${contactId}`);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    messageInput.value = '';
                    const messageBox = document.getElementById('messageBox');
                    const newMessage = document.createElement('div');
                    newMessage.classList.add('message', 'sent');
                    newMessage.textContent = messageText;
                    messageBox.appendChild(newMessage);
                    messageBox.scrollTop = messageBox.scrollHeight;
                } else {
                    console.error('Error sending message:', xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error('Error sending message:', xhr.statusText);
            };
        });

        // Handle typing indicator
        const typingIndicator = document.getElementById('typingIndicator');
        const messageInput = document.getElementById('messageInput');

        messageInput.addEventListener('input', function() {
            if (messageInput.value.trim() !== '') {
                typingIndicator.style.display = 'block';
            } else {
                typingIndicator.style.display = 'none';
            }
        });

        // Handle incoming messages via WebSockets
        const socket = new WebSocket('ws://localhost:8080');

        socket.onmessage = function(event) {
            const message = JSON.parse(event.data);
            const messageBox = document.getElementById('messageBox');
            const newMessage = document.createElement('div');
            newMessage.classList.add('message', 'received');
            newMessage.textContent = message.message_text;
            messageBox.appendChild(newMessage);
            messageBox.scrollTop = messageBox.scrollHeight;
        };

        socket.onopen = function() {
            console.log('Connected to WebSocket server');
        };

        socket.onerror = function() {
            console.error('Error connecting to WebSocket server');
        };

        socket.onclose = function() {
            console.log('Disconnected from WebSocket server');
        };
    </script>
</body>
</html>