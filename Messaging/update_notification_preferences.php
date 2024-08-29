<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
    $sms_notifications = isset($_POST['sms_notifications']) ? 1 : 0;

    $sql_update_notifications = "UPDATE users SET email_notifications = ?, sms_notifications = ? WHERE id = ?";
    $stmt_update_notifications = $conn->prepare($sql_update_notifications);
    $stmt_update_notifications->bind_param("iii", $email_notifications, $sms_notifications, $user_id);

    if ($stmt_update_notifications->execute()) {
        $_SESSION['message'] = "Notification preferences updated.";
    } else {
        $_SESSION['error'] = "Failed to update notification preferences.";
    }

    $stmt_update_notifications->close();
}

$conn->close();
header("Location: notification_preferences.php");
exit();
?>
