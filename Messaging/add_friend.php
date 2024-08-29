<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['friend_id'])) {
    $friend_id = $_POST['friend_id'];

    // Add friend to database
    $sql = "INSERT INTO friendships (user_id, friend_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $friend_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?section=messages"); // Redirect to the messaging section
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Friend</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 50%; margin: auto; overflow: hidden; }
        .form-group { margin: 20px 0; }
        label { font-size: 18px; color: #333; }
        select, input[type="submit"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Friend</h2>
        <form method="post" action="add_friend.php">
            <div class="form-group">
                <label for="friend_id">Select Friend:</label>
                <select name="friend_id" id="friend_id" required>
                    <option value="" disabled selected>Select a friend</option>
                    <?php
                    // Fetch users except the current user
                    $sql = "SELECT id, username FROM users WHERE id != ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo "<option value=\"" . $row['id'] . "\">" . htmlspecialchars($row['username']) . "</option>";
                    }

                    $stmt->close();
                    ?>
                </select>
            </div>
            <input type="submit" value="Add Friend">
        </form>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
