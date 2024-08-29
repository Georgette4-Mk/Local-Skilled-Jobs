<?php
include('database_connection.php');
session_start();

if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    $logged_in_user_id = $_SESSION['user_id'];

    // Fetch messages between logged-in user and the selected contact
    $query = "SELECT * FROM messages 
              WHERE (sender_id = '$logged_in_user_id' AND recipient_id = '$user_id') 
              OR (sender_id = '$user_id' AND recipient_id = '$logged_in_user_id') 
              ORDER BY created_at ASC";
    $messages = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($messages)){
        echo "<p><strong>".($row['sender_id'] == $logged_in_user_id ? 'You' : 'Contact').":</strong> ".$row['message']."</p>";
    }
}
?>
