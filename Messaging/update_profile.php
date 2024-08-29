<?php
session_start();
require_once 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$update_user_id = $_GET['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $update_user_id) {
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['profile_picture']['name'];
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validate file extension (optional)
        $allowed_exts = array('jpg', 'jpeg', 'png');
        if (in_array($file_ext, $allowed_exts)) {
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_dir = 'uploads/';
            $upload_file = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_file)) {
                // Update profile picture in the database
                $stmt = $mysqli->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
                if ($stmt) {
                    $stmt->bind_param("si", $new_file_name, $update_user_id);
                    if ($stmt->execute()) {
                        echo "Profile picture updated successfully.";
                    } else {
                        echo "Error updating profile picture.";
                    }
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $mysqli->error;
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
        }
    }
}

// Retrieve current profile picture of the user to be updated
$stmt = $mysqli->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $update_user_id);
    $stmt->execute();
    $stmt->bind_result($profile_picture);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $mysqli->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
</head>
<body>
    <h1>Update Profile</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="profile_picture">Profile Picture:</label>
        <?php if ($profile_picture): ?>
            <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" width="100">
        <?php endif; ?>
        <input type="file" name="profile_picture">
        <button type="submit">Update Profile Picture</button>
    </form>

    <a href="profile.php">Back to Profile</a>
</body>
</html>
