// JavaScript function to load different pages dynamically into the main content area
function loadPage(pageUrl, button) {
    const contentDiv = document.getElementById('content');

    // Remove 'active' class from all buttons
    const buttons = document.querySelectorAll('.sidebar-btn');
    buttons.forEach(btn => btn.classList.remove('active'));

    // Add 'active' class to the clicked button
    button.classList.add('active');

    // Fetch the content of the clicked page
    fetch(pageUrl)
        .then(response => response.text())
        .then(html => {
            // Replace the content inside the main content area
            contentDiv.innerHTML = html;
        })
        .catch(error => {
            contentDiv.innerHTML = '<p>Error loading the page.</p>';
            console.error('Error:', error);
        });
}
