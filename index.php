<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script defer src="dashboard.js"></script>
    <title>Dashboard</title>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['emp_name']; ?>!</h1>
    </header>

    <section id="dashboard-content">
        <p>This is your dashboard. Enjoy your stay!</p>
    </section>

    <footer>
        <p>Contact support: support@magadisacco.com</p>
    </footer>
</body>
</html>
