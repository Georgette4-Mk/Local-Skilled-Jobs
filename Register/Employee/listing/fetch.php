<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_dashbord";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$jobTitle = $_POST['jobTitle'];
$location = $_POST['location'];

$sql = "SELECT * FROM jobs WHERE title LIKE '%$jobTitle%' AND location LIKE '%$location%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='job-card'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . $row['company'] . " - " . $row['location'] . "</p>";
        echo "<p>" . $row['type'] . " | " . $row['category'] . "</p>";
        echo "<div class='job-meta'>5 applied of 10 capacity</div>";
        echo "</div>";
    }
} else {
    echo "No jobs found.";
}

$conn->close();
?>
