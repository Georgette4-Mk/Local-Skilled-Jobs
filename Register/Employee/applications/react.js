document.querySelector('.search-input').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.applications-table tbody tr');

    rows.forEach(row => {
        const companyName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        row.style.display = companyName.includes(searchTerm) ? '' : 'none';
    });
});
