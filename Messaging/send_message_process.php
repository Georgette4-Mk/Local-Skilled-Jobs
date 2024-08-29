<?php
// Include your database connection file
include('database_connection.php'); 
session_start();

// Check if the user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// Fetch all registered users
$query = "SELECT id, username, profile_picture FROM users";
$users = mysqli_query($conn, $query);

// Function to send a message (if the form is submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message']) && isset($_POST['recipient_id'])) {
    $sender_id = $_SESSION['user_id'];
    $recipient_id = $_POST['recipient_id'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert the message into the database
    $insertQuery = "INSERT INTO messages (sender_id, recipient_id, message) VALUES ('$sender_id', '$recipient_id', '$message')";
    mysqli_query($conn, $insertQuery);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file here -->
    <script src="script.js"></script> <!-- Add your JavaScript file here -->
</head>
<body>
    <div class="main-container">
        <!-- Left Section: Chat Window -->
        <div class="chat-window" id="chat-window">
            <div id="conversation">
                <!-- Conversation will be loaded here via AJAX -->
            </div>
            
            <!-- Message Input -->
            <form id="sendMessageForm" method="post">
                <input type="hidden" id="recipient_id" name="recipient_id">
                <textarea name="message" id="message" placeholder="Type your message here..." required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>

        <!-- Right Sidebar: Contacts List -->
        <div class="contacts-sidebar">
            <h3>Contacts</h3>
            <ul id="contacts-list">
                <?php while ($row = mysqli_fetch_assoc($users)) { ?>
                    <li class="contact-item" onclick="loadConversation(<?php echo $row['id']; ?>)">
                        <img src="<?php echo $row['profile_picture']; ?>" alt="Profile Picture">
                        <span><?php echo $row['username']; ?></span>
                        <input type="hidden" value="<?php echo $row['id']; ?>" class="contact-id">
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <script>
        // JavaScript function to load conversation
        function loadConversation(userId) {
            // Set recipient_id in the form
            document.getElementById('recipient_id').value = userId;

            // Fetch conversation via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_conversation.php?user_id=' + userId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('conversation').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Handle form submission to send a message
        document.getElementById('sendMessageForm').onsubmit = function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_message.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Reload conversation after sending the message
                    loadConversation(formData.get('recipient_id'));
                    document.getElementById('message').value = ''; // Clear the input
                }
            };
            xhr.send(formData);
        };
    </script>
</body>
</html>
