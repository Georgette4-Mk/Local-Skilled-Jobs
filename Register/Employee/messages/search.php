<?php
// Example: Fetch messages from a database

// Connect to the database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "employee_dasbhord";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch messages
$sql = "SELECT sender, message, timestamp FROM messages WHERE conversation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $conversation_id);
$conversation_id = 1; // Example conversation ID
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

$stmt->close();
$conn->close();

// Display messages
foreach ($messages as $message) {
    echo "<div class='message-bubble'>";
    echo "<p>{$message['message']}</p>";
    echo "</div>";
}
?>