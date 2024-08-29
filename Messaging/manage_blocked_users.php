<?php
include 'db_connect.php'; // Make sure this file includes the correct database connection setup
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch blocked users
$sql_blocked_users = "SELECT u.id, u.username FROM blocked_users b JOIN users u ON b.blocked_user_id = u.id WHERE b.user_id = ?";
$stmt_blocked_users = $conn->prepare($sql_blocked_users);

// Check if the statement preparation was successful
if (!$stmt_blocked_users) {
    die("Error preparing statement: " . $conn->error);
}

$stmt_blocked_users->bind_param("i", $user_id);
$stmt_blocked_users->execute();
$blocked_users = $stmt_blocked_users->get_result();

// Check if fetching the result was successful
if (!$blocked_users) {
    die("Error executing query: " . $stmt_blocked_users->error);
}

$stmt_blocked_users->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blocked Users</title>
</head>
<body>
    <h1>Manage Blocked Users</h1>
    <?php if ($blocked_users->num_rows > 0) { ?>
        <ul>
            <?php while ($user = $blocked_users->fetch_assoc()) { ?>
                <li>
                    <?php echo htmlspecialchars($user['username']); ?> 
                    - <a href="unblock_user.php?blocked_user_id=<?php echo $user['id']; ?>">Unblock</a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>You have no blocked users.</p>
    <?php } ?>
    <a href="settings.php">Back to Settings</a>
</body>
</html>
