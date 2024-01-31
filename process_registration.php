<?php
       // Include the database connection file
       $conn = require_once('db_connect.php');
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_name = $_POST['emp_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Use prepared statements to prevent SQL injection
    $insertQuery = $conn->prepare("INSERT INTO employees (emp_name, username, password, email, role) VALUES (?, ?, ?, ?, ?)");
    $insertQuery->bind_param("sssss", $emp_name, $username, $password, $email, $role);

    if ($insertQuery->execute()) {
        echo '<p>Registration successful! <a href="login.php">Login</a></p>';
    } else {
        echo '<p>Error in registration. Please try again.</p>';
    }

    $insertQuery->close();
    $conn->close();
}

?>
