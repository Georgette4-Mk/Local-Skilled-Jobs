<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$blocked_user_id = isset($_GET['blocked_user_id']) ? $_GET['blocked_user_id'] : null;

if ($blocked_user_id) {
    $sql_unblock = "DELETE FROM blocked_users WHERE user_id = ? AND blocked_user_id = ?";
    $stmt_unblock = $conn->prepare($sql_unblock);
    $stmt_unblock->bind_param("ii", $user_id, $blocked_user_id);

    if ($stmt_unblock->execute()) {
        $_SESSION['message'] = "User unblocked successfully.";
    } else {
        $_SESSION['error'] = "Failed to unblock user.";
    }

    $stmt_unblock->close();
}

$conn->close();
header("Location: manage_blocked_users.php");
exit();
?>
