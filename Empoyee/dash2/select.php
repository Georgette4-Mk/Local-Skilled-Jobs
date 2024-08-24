<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_dashbord";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM applications";
$result = $conn->query($sql);

$applications = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
}

$conn->close();

echo json_encode($applications);
?>
