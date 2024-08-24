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

// Get the contact ID and message text from the POST request
$contact_id = $_POST['contact_id'];
$message_text = $_POST['message_text'];

// Insert the message into the database
$query = "INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('iii', $current_user_id, $contact_id, $message_text);
$stmt->execute();

// Send the message to the contact via WebSocket
$socket = fsockopen('localhost', 8080);
fputs($socket, json_encode(array('message_text' => $message_text, 'receiver_id' => $contact_id)));
fclose($socket);

echo 'Message sent successfully!';
?>