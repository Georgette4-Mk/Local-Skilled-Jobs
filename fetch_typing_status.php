<?php
session_start();
include 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo 'User not logged in.';
    exit();
}

$current_user_id = $_SESSION['user_id'];
$contact_id = $_POST['contact_id'] ?? '';

$query = "SELECT typing FROM typing_status WHERE user_id = ? AND contact_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $current_user_id, $contact_id);
$stmt->execute();
$result = $stmt->get_result();
$status = $result->fetch_assoc();

echo $status['typing'] ?? 0;
?>
