<?php
session_start();
require_once 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ensure contact_id is provided
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo "Contact not found.";
    exit();
}

$contact_id = $_GET['user_id'];

// Handle profile picture update for contact
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $profile_picture = $_FILES['profile_picture']['name'];
    $target = "uploads/" . basename($profile_picture);

    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
        $stmt = $mysqli->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $profile_picture, $contact_id);
            $stmt->execute();
            $stmt->close();
            echo "Profile picture updated successfully.";
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}

// Fetch contact details
$stmt = $mysqli->prepare("SELECT username, profile_picture FROM users WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $contact_id);
    $stmt->execute();
    $stmt->bind_result($username, $profile_picture);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $mysqli->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Update Profile Picture for <?php echo htmlspecialchars($username); ?></h1>
    <form method="post" enctype="multipart/form-data">
        <label for="profile_picture">Update Profile Picture:</label>
        <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
        <br>
        <input type="submit" value="Update Picture">
    </form>
    <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" width="150" height="150">
    <br>
    <a href="profile.php">Back to Profile</a>
</body>
</html>
