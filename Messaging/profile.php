<?php
session_start();
require_once 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile data
$stmt = $mysqli->prepare("SELECT username, email, profile_picture FROM users WHERE user_id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $email, $profile_picture);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $mysqli->error;
}

// Handle profile picture update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $profile_picture = $_FILES['profile_picture']['name'];
    $target = "uploads/" . basename($profile_picture);

    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
        $stmt = $mysqli->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $profile_picture, $user_id);
            $stmt->execute();
            $stmt->close();
            echo "Profile picture updated successfully.";
            // Refresh the page to show updated profile picture
            header("Refresh:0");
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}

// Handle contact profile picture update
if (isset($_POST['update_contact'])) {
    $contact_id = $_POST['contact_id'];
    if (isset($_FILES['contact_profile_picture'])) {
        $contact_profile_picture = $_FILES['contact_profile_picture']['name'];
        $target = "uploads/" . basename($contact_profile_picture);

        if (move_uploaded_file($_FILES['contact_profile_picture']['tmp_name'], $target)) {
            $stmt = $mysqli->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
            if ($stmt) {
                $stmt->bind_param("si", $contact_profile_picture, $contact_id);
                $stmt->execute();
                $stmt->close();
                echo "Contact's profile picture updated successfully.";
            } else {
                echo "Error preparing statement: " . $mysqli->error;
            }
        } else {
            echo "Failed to upload contact image.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        img {
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Profile</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="profile_picture">Update Your Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
            <br>
            <input type="submit" value="Update Picture">
        </form>
        <h2><?php echo htmlspecialchars($username); ?></h2>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" width="150" height="150">
        <br>
        <h2>Update Contact Profile Pictures</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="contact_id">Select Contact:</label>
            <select name="contact_id" id="contact_id">
                <?php
                $stmt = $mysqli->prepare("SELECT user_id, username FROM users WHERE user_id != ?");
                if ($stmt) {
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $stmt->bind_result($contact_id, $contact_username);
                    while ($stmt->fetch()) {
                        echo "<option value=\"$contact_id\">$contact_username</option>";
                    }
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $mysqli->error;
                }
                ?>
            </select>
            <br>
            <label for="contact_profile_picture">Update Contact Profile Picture:</label>
            <input type="file" name="contact_profile_picture" id="contact_profile_picture" accept="image/*">
            <br>
            <input type="submit" name="update_contact" value="Update Contact Picture">
        </form>
        <br>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
