<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message_id']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $message_id = $_POST['message_id'];

    $stmt = $conn->prepare("SELECT sender_id FROM messages WHERE id = ?");
    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sender_id);
    $stmt->fetch();

    if ($sender_id == $user_id) {
        $del_stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
        $del_stmt->bind_param("i", $message_id);
        $del_stmt->execute();
    }

    header("Location: messaging.php?user_id={$_POST['contact_id']}");
} else {
    echo "Invalid request.";
}
?>
