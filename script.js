document.addEventListener('DOMContentLoaded', function () {
    // Simulate fetching positions and resolutions from the server
    const positions = ['Position 1', 'Position 2', 'Position 3', 'Position 4'];
    const resolutions = ['Resolution 1: Lorem ipsum dolor sit amet.', 'Resolution 2: Consectetur adipiscing elit.'];

    // Populate positions in the form
    const form = document.getElementById('votingForm');
    positions.forEach((position, index) => {
        const label = document.createElement('label');
        label.innerHTML = `<input type="radio" name="position" value="${index}"> ${position}`;
        form.appendChild(label);
    });

    // Populate resolutions in the list
    const resolutionList = document.getElementById('resolutionList');
    resolutions.forEach((resolution) => {
        const li = document.createElement('li');
        li.textContent = resolution;
        resolutionList.appendChild(li);
    });
});
