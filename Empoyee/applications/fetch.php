<?php
include 'db.php';

$sql = "SELECT id, company_name, role, date_applied, status FROM applications";
$result = $conn->query($sql);
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
    <!-- Sidebar and Header Code as shown above -->

    <div class="applications-section">
        <!-- Info Box as shown above -->
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
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['company_name']}</td>
                                    <td>{$row['role']}</td>
                                    <td>{$row['date_applied']}</td>
                                    <td>{$row['status']}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No applications found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
