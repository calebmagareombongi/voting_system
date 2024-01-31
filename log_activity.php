<?php
session_start();
 // Include the database connection file
  $conn = require_once('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $activity = $_POST['activity'];
        $keyStrokes = $_POST['keyStrokes'] ?? '';
        $cursorMovement = $_POST['cursorMovement'] ?? '';
        $ipAddress = $_SERVER['REMOTE_ADDR'];



        $user_id = $_SESSION['user_id'];

        // Log the activity to the user_logs table
        $logQuery = $conn->prepare("INSERT INTO user_logs (user_id, activity, key_strokes, cursor_movement, ip_address, log_timestamp) VALUES (?, ?, ?, ?, ?, NOW())");
        $logQuery->bind_param("issss", $user_id, $activity, $keyStrokes, $cursorMovement, $ipAddress);
        $logQuery->execute();

        $logQuery->close();
        $conn->close();
    }
}
?>
