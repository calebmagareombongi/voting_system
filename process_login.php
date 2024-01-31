<?php
session_start();

       // Include the database connection file
       $conn = require_once('db_connect.php');

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $getUserQuery = $conn->prepare("SELECT emp_id, emp_name, username, password, role FROM employees WHERE username = ?");
    $getUserQuery->bind_param("s", $username);

    $getUserQuery->execute();
    $getUserQuery->store_result();

    if ($getUserQuery->num_rows === 1) {
        $getUserQuery->bind_result($emp_id, $emp_name, $username, $hashedPassword, $role);
        $getUserQuery->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Store user details in the session for auditing
            $_SESSION['user_id'] = $emp_id;
            $_SESSION['username'] = $username;
            $_SESSION['emp_name'] = $emp_name;
            $_SESSION['role'] = $role;

            // Log user login timestamp
            $logQuery = $conn->prepare("INSERT INTO login_log (emp_id, login_timestamp) VALUES (?, NOW())");
            $logQuery->bind_param("i", $emp_id);
            $logQuery->execute();

            // Redirect based on the user's role
            if ($role === 'returning officer') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }
            exit();
        }
    }

    // Redirect back to login page on failure
    echo '<p>Login failed. Please check your credentials.</p>';

    $getUserQuery->close();
    $conn->close();
}
?>
