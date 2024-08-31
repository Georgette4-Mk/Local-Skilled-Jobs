<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Form</title>
</head>
<body>
    <h1>Job Application Form</h1>
    <?php
    // Get the job ID from the POST request
    if (isset($_POST['job_id'])) {
        $job_id = $_POST['job_id'];
    } else {
        echo "No job ID provided.";
        exit;
    }

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "job_applications";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch job details
    $sql = "SELECT title FROM job_posting WHERE job_id = $job_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $job_title = $row['title'];
    } else {
        echo "Job not found.";
        exit;
    }

    $conn->close();
    ?>
    <h2>Applying for: <?php echo $job_title; ?></h2>
    <form action="applyingforjob.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
        <div class="container">
            <h2>Job Application <span></span></h2>
            <div class="row">
                <div class="col-50">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="firstname" placeholder="Enter First Name">
                </div>
                <div class="col-50">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lastname" placeholder="Enter Last Name">
                </div>
            </div>
            <div class="row">
                <div class="col-50">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email">
                </div>
                <div class="col-50">
                    <label for="jobrole">Job Role</label>
                    <select id="jobrole" name="jobrole">
                        <option value="" disabled selected>Select Job Role</option>
                        <option value="developer">Full-time</option>
                        <option value="designer">Part-time</option>
                    </select>
                </div>
            </div>
            <label for="address">Address</label>
            <textarea id="address" name="address" placeholder="Enter Address"></textarea>

            <div class="row">
                <div class="col-50">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" placeholder="Enter City">
                </div>
            </div>

            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="2022-10-24">

            <label for="cv">Upload Your CV</label>
            <input type="file" id="cv" name="cv">

            <button type="submit">Apply Now</button>
        </div>
    </form>
</body>
</html>
