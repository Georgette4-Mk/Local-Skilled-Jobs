<?php
// Create a new mysqli object
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'admin';

//$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
$conn = new mysqli("localhost", "root", "", "admin");

// Check connection
if ($conn->connect_error) {
    
    // Log the error
    error_log("Error connecting to database: " . $conn->connect_error);

    // Display a user-friendly error message
    die("Error connecting to database. Please try again later.");
}
?>