document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search_employee');
    const employeeDropdown = document.getElementById('employee_dropdown');
    const employeeNameInput = document.getElementById('employee_name');
    const positionDropdown = document.getElementById('position_dropdown');
    const positionIdInput = document.getElementById('position_id');
    const positionNameInput = document.getElementById('position_name');

    // Event listener for the search input
    searchInput.addEventListener('input', function () {
        // Fetch employee suggestions from the server
        fetch(`contestant_registration.php?q=${encodeURIComponent(searchInput.value)}`)
            .then(response => response.json())
            .then(data => {
                // Populate the employee drop-down list
                employeeDropdown.innerHTML = '';
                data.forEach(employee => {
                    const option = document.createElement('option');
                    option.value = employee.employee_id;
                    option.text = `${employee.emp_name} (${employee.username})`;
                    employeeDropdown.add(option);
                });
            })
            .catch(error => console.error('Error fetching employee suggestions:', error));
    });

    // Event listener for employee drop-down selection
    employeeDropdown.addEventListener('change', function () {
        const selectedEmployeeId = employeeDropdown.value;
        if (selectedEmployeeId) {
            // Fetch and display employee details
            fetch(`contestant_registration.php?id=${selectedEmployeeId}`)
                .then(response => response.json())
                .then(employee => {
                    employeeNameInput.value = employee.emp_name;
                })
                .catch(error => console.error('Error fetching employee details:', error));
        } else {
            employeeNameInput.value = '';
        }
    });

    // Event listener for position drop-down selection
    positionDropdown.addEventListener('change', function () {
        const selectedPositionId = positionDropdown.value;
        if (selectedPositionId) {
            // Fetch and display position details
            fetch(`contestant_registration.php?position_id=${selectedPositionId}`)
                .then(response => response.json())
                .then(position => {
                    positionIdInput.value = position.position_id;
                    positionNameInput.value = position.position_name;
                })
                .catch(error => console.error('Error fetching position details:', error));
        } else {
            positionIdInput.value = '';
            positionNameInput.value = '';
        }
    });
});
