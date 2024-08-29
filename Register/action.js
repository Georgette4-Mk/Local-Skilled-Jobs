document.addEventListener("DOMContentLoaded", function() {
    const jobChart = document.getElementById('job-chart');
    
    // Example data for the job chart
    const jobData = {
        jobView: [122, 34, 56, 78, 90, 12, 34],
        jobApplied: [10, 20, 30, 40, 50, 60, 70]
    };
    
    // Render job chart (you can use a chart library like Chart.js for better visuals)
    jobChart.innerHTML = <pre>${JSON.stringify(jobData, null, 2)}</pre>;
});