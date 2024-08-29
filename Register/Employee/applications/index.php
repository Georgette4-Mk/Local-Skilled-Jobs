<?php
session_start(); // Initialize the session

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "admin");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve application data from the database
$query = "SELECT company_name, job_title as role, a.status, a.applied_date  
          FROM applications a 
          JOIN job_listings j ON a.job_id = j.id 
          WHERE a.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Display the application data in the table
    $count = 1; // Initialize a counter for the application number

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $count . "</td>"; // Display the application number
        echo "<td>" . $row["company_name"] . "</td>";
        echo "<td>" . $row["role"] . "</td>";
        echo "<td>" . $row["applied_date"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "</tr>";
        $count++; // Increment the counter
    }
} else {
    echo "<tr><td colspan='5'>No applications found</td></tr>"; // or some other message
}
// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobHuntly Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Sidebar -->
     <div class="container">
    <aside class="sidebar">
        <div class="profile-section">
            <img src="profile.jpg" alt="Jake Gyll" class="profile-img">
            <h3 class="profile-name">Jake Gyll</h3>4
            <p class="profile-email">jakegyll@email.com</p>
        </div>
        <nav class="menu">
            <ul>
                <li><a href="../dash2/index.html">Dashboard</a></li>
                    <li><a href="../messages/messaging.html">Messages</a></li>
                    <li><a href="../applications/Application.html" class = "active">My Applications</a></li>
                    <li><a href="../listing/Jobs.html">Find Jobs</a></li>
                    <li><a href="../applications/employee_profile.html">View Public Profile</a></li>
                    
            </ul>
        </nav>
        <div class="settings">
           <li> <a href="../register/settings.html">Settings</a></li> 
            <a href="#">Help Center</a>
        </div>
    </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header class="main-header">
            <h2>My Applications</h2>
            <button class="btn-primary">Back to homepage</button>
        </header>

        <section class="applications-section">
            <div class="info-box">
                <h3>Keep it up, Jake</h3>
                <p>Here is the job applications status from July 19 - July 25.</p>
                <div class="new-feature">
                    <p><strong>New Feature:</strong> You can request a follow-up 7 days after applying for a job if the application status is in review.</p>
                </div>
            </div>

            <div class="applications-history">
                <h3>Applications History</h3>
                <div class="search-filter">
                    <input type="text" placeholder="Search..." class="search-input">
                    <button class="btn-filter">Filter</button>
                </div>
                <table class="applications-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Company Name</th>
                            <th>Role</th>
                            <th>Date Applied</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic Rows Inserted Here via PHP -->
                       
                    </tbody>
                </table>
                <div class="pagination">
                    <button class="btn-pagination">1</button>
                    <button class="btn-pagination">2</button>
                    <button class="btn-pagination">3</button>
                    <!-- More pages... -->
                </div>
            </div>
        </section>
    </div>
   
</body>
</html>
<script>
    const searchInput = document.querySelector('.search-input');
const filterButton = document.querySelector('.btn-filter');
const tableRows = document.querySelectorAll('.applications-table tbody tr');

filterButton.addEventListener('click', () => {
  const searchTerm = searchInput.value.toLowerCase();
  tableRows.forEach((row) => {
    const rowText = row.textContent.toLowerCase();
    if (rowText.includes(searchTerm)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});
</script>
