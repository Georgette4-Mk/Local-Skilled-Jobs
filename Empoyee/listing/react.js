document.querySelector('.search-btn').addEventListener('click', function() {
    const jobTitle = document.querySelector('.search-input').value;
    const location = document.querySelector('.location-input').value;

    // Use AJAX to send the search query to the server
    fetch('search.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `jobTitle=${jobTitle}&location=${location}`
    })
    .then(response => response.text())
    .then(data => {
        document.querySelector('.job-listings').innerHTML = data;
    });
});
