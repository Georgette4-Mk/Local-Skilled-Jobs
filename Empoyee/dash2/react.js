fetch('fetch_applications.php')
    .then(response => response.json())
    .then(data => {
        // Use data to populate the applications history section dynamically
        console.log(data);
    });
    function goToHomepage() {
        window.location.href = "../LJ/landing/index.html"; // Replace with your desired URL
    }

