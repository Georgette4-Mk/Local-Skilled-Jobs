<?php
session_start();
require_once 'db.php';

// Get the search query from the form
if (isset($_GET['search_query'])) {
    $search_query = $_GET['search_query'];
} else {
    echo "No search query provided.";
    exit;
}


// Validate and sanitize the search query
$search_query = trim($search_query);
$search_query = filter_var($search_query, FILTER_SANITIZE_STRING);

// Prepare the SQL query
$stmt = $conn->prepare("SELECT job_title, job_description, job_location, job_type, date_posted, due_date FROM job_listings WHERE job_title LIKE ? OR job_description LIKE ? OR job_location LIKE ? OR job_type LIKE? OR date_posted LIKE? OR due_date LIKE?");
$stmt->bind_param("ssssss", $search_query, $search_query, $search_query, $search_query, $search_query, $search_query);
$stmt->execute();
$result = $stmt->get_result();

// Display the search results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='job-card'>";
        echo "<h3>" . htmlspecialchars($row['job_title']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['job_description']) . "</p>";
        echo "<p>Location: " . htmlspecialchars($row['job_location']) . "</p>";
        echo "<p>Location: " . htmlspecialchars($row['job_type']) . "</p>";
        echo "<p>Location: " . htmlspecialchars($row['date_posted']) . "</p>";
        echo "<p>Location: " . htmlspecialchars($row['due_date']) . "</p>";
        echo "</div>";
    }
} else {
    echo "No jobs found matching your search query.";
}

// Free the result set and close the database connection
$result->free();
$conn->close();
?>