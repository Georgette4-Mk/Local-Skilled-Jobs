<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Display admin dashboard content
echo "Welcome, " . $_SESSION['admin_username'] . "!<br>";
echo "You are now logged in as an administrator.";
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
    table {
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f0f0f0;
    }
    td:nth-child(2) { /* make the email column wider */
        width: 250px;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Dashboard</h1>
        </div>

        <div class="nav">
            <a href="#view-users">View Users</a> 
            <a href="#create-account">Create Account</a> 
            <a href="#delete-account">Delete Account</a> 
            <a href="#edit-account">Edit Account</a> 
            <a href="#verify-account">Verify Account</a>
        </div>

        <div class="content">
            <!-- View Users section -->
            
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

                <?php

            // Query to retrieve all users
            $conn = new mysqli('localhost', 'root', '', 'admin');
            $stmt = $conn->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->get_result();
            
            echo "<h2>View Users</h2>";
echo "<table>";
echo "<tr> <th>Username</th> <th>Email</th> <th>Role</th> <th>Status</th> <th>Actions</th> </tr>";
if (isset($_POST["verify-account"])) {
    $id = $_POST["id"];
    verifyUser($id);
    echo "Account verified successfully!";
}


while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>";
    if ($row['user_type'] == 'user') {
        echo "User";
    } elseif ($row['user_type'] == 'employer') {
        echo "Employer";
    } else {
        echo "Unknown";
    }
    echo "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>";
    echo "<a href='?suspend-user=" . $row['id'] . "'>Suspend</a> | ";
    echo "<a href='?delete-user=" . $row['id'] . "'>Delete</a> |";
    echo "<a href='?verify-user=" . $row['id'] . "'>Verify</a> ";

    if ($row['status'] == 'verified') {
        echo "<span style='color: green;'>Verified</span>";
    } else {
        echo "<span style='color: red;'>Not Verified</span>";
    }

    echo "</td>";
    echo "</tr>";

}
echo "</table>"; // add this closing tag

// Create User function
function createUser($username, $email, $password, $role, $user_type) {
    $conn = new mysqli('localhost', 'root', '', 'admin');
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, user_type ) VALUES (?, ?, ?, ?, ?)");
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $role, $user_type);
    
    $stmt->execute();
    $conn->close();
}

//just added


if (isset($_POST["create-account"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $user_type = $_POST["user_type"]; // Get the user type from the form
    createUser($username, $email, $password, $role, $user_type);
     return;
}


// Delete User function
if (isset($_GET["delete-user"])) {
    $id = $_GET["delete-user"];
    deleteUser($id);
    echo "Account deleted successfully!";
}
function deleteUser($id) {
    $conn = new mysqli('localhost', 'root', '', 'admin');
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $conn->close();
}

// Edit User function
function editUser($id, $username, $email, $role) {
    $conn = new mysqli('localhost', 'root', '', 'admin');
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $role, $id);
    $stmt->execute();
    $conn->close();
}

// Verify Account


function verifyUser($id) {
    $conn = new mysqli('localhost', 'root', '', 'admin');
    $stmt = $conn->prepare("UPDATE users SET status = 'verified' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $conn->close();
    
}

// Suspend User function
function suspendUser($id) {
    $conn = new mysqli('localhost', 'root', '', 'admin');
    $stmt = $conn->prepare("UPDATE users SET status = 'suspended' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $conn->close();
    if (isset($_GET["suspend-user"])) {
        $id = $_GET["suspend-user"];
        suspendUser($id);
        echo "Account suspended successfully!";
    }
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create-account"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = $_POST["role"];
        $user_type = $_POST ["user_type"];
        createUser($username, $email, $password, $role, $user_type);


    } elseif (isset($_POST["delete-account"])) {
        $id = $_POST["id"];
        deleteUser($id);

        
    } elseif (isset($_POST["edit-account"])) {
        $id = $_POST["id"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $role = $_POST["role"];
        $user_type = $_POST["user_type"];
        editUser($id, $username, $email, $role, $user_type);
    }
}

     
    if (isset($_GET["verify-user"])) {
        $id = $_GET["verify-user"];
        verifyUser($id);
        echo "Account verified successfully!";
    }
    else {
        echo "No rows updated. Check that the ID exists in the table.";
    }
    ?>
            </table>

            

            <!-- Create Account section -->
            <h2 id="create-account">Create Account</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"><br><br>
                <input type="hidden"  name="create-account" value="true"><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email"><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password"><br><br>

                <label for="role">Role:</label>
                <select id="role" name="role">

                    <option value="user">User</option>
                    <option value="user">Employer</option>
                    <option value="admin">Admin</option>
                </select><br><br>

                <label for="user_type">User Type:</label>
    <select id="user_type" name="user_type">
        <option value="user">User</option>
        <option value="employer">Employer</option>
    </select><br><br>

                <input type="submit" value="Create Account">
            </form>

            <!-- Delete Account section -->
            <h2 id="delete-account">Delete Account</h2>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <label for="username">Username:</label>
                <input type="text" id="username" name="username"><br><br>

                <input type="submit" value="Delete Account">
            </form>

            <!-- Edit Account section -->
            <h2 id="edit-account">Edit Account</h2>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                <label for="username">Username:</label>
                <input type="text" id="username" name="username"><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email"><br><br>

                <input type="submit" value="Edit Account">


                </form>
              
<!-- Verify Account section -->
<h2 id="verify-account">Verify Account</h2>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

    <label for="id">User ID:</label>
    <input type="text" id="id" name="id"><br><br>

    <input type="submit" value="Verify Account">
    <input type="hidden" name="verify-account" value="true">
</form>



            </body>
            </html>