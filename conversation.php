<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the current user's ID
$current_user_id = $_SESSION['user_id'];

// Fetch all registered users
$query = "SELECT * FROM users WHERE id != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $current_user_id);
$stmt->execute();
$users = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversations</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
        }
        .conversations {
            list-style-type: none;
            padding: 0;
        }
        .conversations li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .conversations li a {
            text-decoration: none;
            color: #007bff;
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <h1>Conversations</h1>
    <ul class="conversations">
        <?php while ($user = $users->fetch_assoc()): ?>
            <li>
                <div class="user-profile">
                    <?php if ($user['profile_picture']): ?>
                        <img src="<?php echo $user['profile_picture']; ?>" alt="<?php echo $user['username']; ?>">
                    <?php else: ?>
                        <img src="default_profile_picture.jpg" alt="<?php echo $user['username']; ?>">
                    <?php endif; ?>
                    <a href="messaging.php?contact_id=<?php echo $user['id']; ?>">
                        <?php echo htmlspecialchars($user['username']); ?>
                    </a>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>