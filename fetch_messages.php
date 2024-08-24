<?php
require 'config.php';

$contact_id = $_GET['contact_id'];

$messages_stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY sent_at");
$messages_stmt->bind_param("iiii", $_SESSION['user_id'], $contact_id, $contact_id, $_SESSION['user_id']);
$messages_stmt->execute();
$messages_result = $messages_stmt->get_result();

while ($message = $messages_result->fetch_assoc()) {
    echo '<div class="message ' . ($message['sender_id'] == $_SESSION['user_id'] ? 'sent' : 'received') . '">';
    echo $message['message_text'];
    if ($message['attachment']) {
        echo '<a href="' . $message['attachment'] . '" target="_blank">Attachment</a>';
    }
    echo '</div>';
}