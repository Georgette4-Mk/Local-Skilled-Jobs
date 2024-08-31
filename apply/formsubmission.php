<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_id = $_POST['job_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $jobrole = $_POST['jobrole'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $date = $_POST['date'];
    $cv = $_FILES['cv'];

    // Process the application (e.g., save to database, send email, etc.)
    // For now, we'll just display a confirmation message
    echo "Thank you, $firstname $lastname! Your application for job ID $job_id has been submitted.";
}
?>
