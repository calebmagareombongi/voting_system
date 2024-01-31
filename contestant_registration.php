<?php
// Include the database connection file
require_once('db_connect.php');

// Function to safely execute a query with prepared statements
function executeQuery($conn, $sql, $params = []) {
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    if ($params) {
        $stmt->bind_param(...$params);
    }

    $stmt->execute();

    if ($stmt->error) {
        die('Error executing statement: ' . $stmt->error);
    }

    return $stmt;
}

// Get employee suggestions based on the search query
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    $query = '%' . $_GET['q'] . '%';

    $sql = "SELECT emp_id, emp_name, username FROM employees WHERE emp_name LIKE ? OR email LIKE ? OR username LIKE ?";
    $params = ['sss', $query, $query, $query];

    $stmt = executeQuery($conn, $sql, $params);

    $employeeSuggestions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode($employeeSuggestions);
    exit();
}

// Fetch employee names for the dropdown
$sqlEmployees = "SELECT emp_id, emp_name FROM employees";
$stmtEmployees = executeQuery($conn, $sqlEmployees);
$employees = $stmtEmployees->get_result()->fetch_all(MYSQLI_ASSOC);
$stmtEmployees->close();

// Fetch position names for the dropdown
$sqlPositions = "SELECT position_id, position_name FROM positions";
$stmtPositions = executeQuery($conn, $sqlPositions);
$positions = $stmtPositions->get_result()->fetch_all(MYSQLI_ASSOC);
$stmtPositions->close();

// Process contestant registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employee_dropdown'];
    $empName = $_POST['emp_name'];
    $positionId = $_POST['position_dropdown'];

    // Check if the contestant with the same emp_id and position_id already exists
    $sqlCheck = "SELECT * FROM contestant WHERE emp_id = ? AND position_id = ?";
    $paramsCheck = ['ii', $employeeId, $positionId];

    $stmtCheck = executeQuery($conn, $sqlCheck, $paramsCheck);
    $existingContestant = $stmtCheck->get_result()->fetch_assoc();
    $stmtCheck->close();

    // If contestant already exists, provide feedback
    if ($existingContestant) {
        echo '<p>Error: This contestant is already registered for the selected position.</p>';
    } else {
        // Fetch position details based on the selected position_id
        $sqlPosition = "SELECT position_name FROM positions WHERE position_id = ?";
        $paramsPosition = ['i', $positionId];

        $stmtPosition = executeQuery($conn, $sqlPosition, $paramsPosition);
        $positionDetails = $stmtPosition->get_result()->fetch_assoc();

        // Check if position details are fetched successfully
        if ($positionDetails) {
            $positionName = $positionDetails['position_name'];

            $sql = "INSERT INTO contestant (emp_id, contestant_name, position_id, position_name) VALUES (?, ?, ?, ?)";
            $params = ['isss', $employeeId, $empName, $positionId, $positionName];

            $stmt = executeQuery($conn, $sql, $params);

            // Redirect or provide feedback as needed
            if ($stmt->affected_rows > 0) {
                echo '<p>Contestant registered successfully!</p>';
            } else {
                echo '<p>Error registering contestant. Please try again.</p>';
            }

            $stmtPosition->close();
            $stmt->close();
        } else {
            echo '<p>Error fetching position details. Please try again.</p>';
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script defer src="register_contestant.js"></script>
    <title>Contestant Registration</title>
</head>
<body>
    <header>
        <h1>Contestant Registration</h1>
    </header>

    <section id="contestant-form">
        <form action="contestant_registration.php" method="post">
            <label for="search_employee">Search Employee:</label>
            <input type="text" id="search_employee" name="search_employee" placeholder="Enter Name, Email, or Username">

            <!-- Drop-down list to select an employee -->
            <select id="employee_dropdown" name="employee_dropdown">
                <?php foreach ($employees as $employee): ?>
                    <option value="<?= $employee['emp_id'] ?>"><?= $employee['emp_name'] ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Display selected employee details -->
            <label for="employee_name">Employee Name:</label>
            <input type="text" id="employee_name" name="emp_name" readonly>

            <label for="position_dropdown">Select Position:</label>
            <!-- Drop-down list to select a position -->
            <select id="position_dropdown" name="position_dropdown">
                <?php foreach ($positions as $position): ?>
                    <option value="<?= $position['position_id'] ?>"><?= $position['position_name'] ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Display selected position details -->
            <label for="position_id">Position ID:</label>
            <input type="text" id="position_id" name="position_id" readonly>

            <label for="position_name">Position Name:</label>
            <input type="text" id="position_name" name="position_name" readonly>

            <button type="submit">Save Contestant</button>
        </form>
    </section>

    <footer>
        <p>Contact support: support@magadisacco.com</p>
    </footer>

    <script src="register_contestant.js"></script>
</body>
</html>
