<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['employee_id'])) {
    header('Location: login.php');
    exit();
}

       // Include the database connection file
       $conn = require_once('db_connect.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input (you should use prepared statements)
    $selectedPosition = $_POST['position'] ?? null;
    $employeeId = $_SESSION['employee_id'];

    // Check if the member has already voted for a position
    $checkQuery = "SELECT * FROM votes WHERE employee_id = $employeeId AND position = $selectedPosition";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows === 0) {
        // Member hasn't voted for this position yet
        $insertQuery = "INSERT INTO votes (employee_id, position, vote_datetime) VALUES ($employeeId, $selectedPosition, NOW())";
        $insertResult = $conn->query($insertQuery);

        if ($insertResult === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Vote submitted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error submitting vote.']);
        }
    } else {
        // Member has already voted for this position
        echo json_encode(['success' => false, 'message' => 'You have already voted for this position.']);
    }

    $conn->close();
    exit;
}
?>
