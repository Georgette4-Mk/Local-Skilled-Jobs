<?php
require 'config.php';

$sender_id = $_GET['sender_id'];
$receiver_id = $_GET['receiver_id'];
$last_retrieved = $_GET['last_retrieved'];

$stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) AND timestamp > ?");
$stmt->bind_param("iiiii", $sender_id, $receiver_id, $receiver_id, $sender_id, $last_retrieved);
$stmt->execute();
$result = $stmt->get_result();

$messages = array();
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);