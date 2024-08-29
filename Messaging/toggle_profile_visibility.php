<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current visibility status
$sql = "SELECT profile_visibility FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $current_visibility = $user['profile_visibility'];
} else {
    die('User not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_visibility = isset($_POST['profile_visibility']) ? 1 : 0;

    $sql_update = "UPDATE users SET profile_visibility = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    if ($stmt_update === false) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt_update->bind_param("ii", $new_visibility, $user_id);
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
    <title>Toggle Profile Visibility</title>
</head>
<body>
    <h1>Toggle Profile Visibility</h1>
    <form method="post">
        <label>
            <input type="checkbox" name="profile_visibility" <?php echo $current_visibility ? 'checked' : ''; ?>>
            Make Profile Visible
        </label>
        <input type="submit" value="Save Changes">
    </form>
    <a href="settings.php">Back to Settings</a>
</body>
</html>
