<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current notification preferences
$sql = "SELECT email_notifications, sms_notifications FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $email_notifications = $user['email_notifications'];
    $sms_notifications = $user['sms_notifications'];
} else {
    die('User not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
    $sms_notifications = isset($_POST['sms_notifications']) ? 1 : 0;

    $sql_update = "UPDATE users SET email_notifications = ?, sms_notifications = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);

    if ($stmt_update === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt_update->bind_param("iii", $email_notifications, $sms_notifications, $user_id);
    $stmt_update->execute();

    header("Location: settings.php");
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Preferences</title>
</head>
<body>
    <h1>Notification Preferences</h1>
    <form method="post">
        <label>
            <input type="checkbox" name="email_notifications" <?php echo $email_notifications ? 'checked' : ''; ?>>
            Email Notifications
        </label>
        <br>
        <label>
            <input type="checkbox" name="sms_notifications" <?php echo $sms_notifications ? 'checked' : ''; ?>>
            SMS Notifications
        </label>
        <br>
        <input type="submit" value="Save Changes">
    </form>
    <a href="settings.php">Back to Settings</a>
</body>
</html>
