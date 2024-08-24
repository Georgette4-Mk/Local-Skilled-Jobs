<?php
session_start();
require 'config.php';

$user_id = $_SESSION['user_id'];
$contact_id = $_POST['contact_id'];

// Update typing status
$typing_stmt = $conn->prepare("UPDATE users SET typing_status = 1 WHERE id = ?");
$typing_stmt->bind_param("i", $contact_id);
$typing_stmt->execute();

// Check if the contact is typing
$check_typing_stmt = $conn->prepare("SELECT typing_status FROM users WHERE id = ?");
$check_typing_stmt->bind_param("i", $contact_id);
$check_typing_stmt->execute();
$typing_result = $check_typing_stmt->get_result();
$typing_status = $typing_result->fetch_assoc()['typing_status'];

if ($typing_status) {
    echo 'Typing...';
} else {
    echo '';
}

$typing_stmt->close();
$check_typing_stmt->close();
?>