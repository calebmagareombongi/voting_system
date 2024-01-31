<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['emp_id'])) {
    header('Location: login.php');
    exit();
}
?>
