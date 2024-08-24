<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo 'User not logged in.';
    exit();
}

$current_user_id = $_SESSION['user_id'];
$typing = $_POST['typing'] ?? 0;
$contact_id = $_POST['contact_id'] ?? '';

if (isset($contact_id)) {
    $query = "REPLACE INTO typing_status (user_id, contact_id, typing) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iii', $current_user_id, $contact_id, $typing);
    $stmt->execute();
    echo 'Typing status updated.';
} else {
    echo 'Invalid request.';
}
?>
