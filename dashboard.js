document.addEventListener('DOMContentLoaded', function () {
    // Listen for key presses
    document.addEventListener('keydown', function (event) {
        logActivity({
            activity: `Key Pressed: ${event.key}`,
            keyStrokes: event.key
        });
    });

    // Listen for mouse movements
    document.addEventListener('mousemove', function (event) {
        logActivity({
            activity: `Mouse Moved: (${event.clientX}, ${event.clientY})`,
            cursorMovement: `(${event.clientX}, ${event.clientY})`
        });
    });
});

function logActivity(data) {
    // Send the activity to the server using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'log_activity.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    // Convert the data object to a query string
    const queryString = Object.entries(data).map(([key, value]) => `${key}=${encodeURIComponent(value)}`).join('&');

    xhr.send(queryString);
}
