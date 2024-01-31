<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Employee Registration</title>
</head>
<body>
    <header>
        <h1>Employee Registration</h1>
    </header>

    <section id="registration-form">
        <form action="process_registration.php" method="post">
            <label for="emp_name">Full Name:</label>
            <input type="text" id="emp_name" name="emp_name" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="role">Role:</label>
            <input type="text" id="role" name="role" required>

            <button type="submit">Register</button>
        </form>
    </section>

    <footer>
        <p>Contact support: support@magadisacco.com</p>
    </footer>
</body>
</html>
