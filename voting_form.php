<?php
session_start();

// Include the database connection file
$conn = require_once('db_connect.php');
require_once('authenticate.php');

// Initialize variables
$empId = $_SESSION['emp_id']; // Get the employee ID dynamically
$errorMessage = '';

// Check if employee has already voted
$sqlCheckVote = "SELECT * FROM votes WHERE emp_id = '$empId'";
$resultCheckVote = $conn->query($sqlCheckVote);

if ($resultCheckVote->num_rows > 0) {
    $errorMessage = "You have already voted.";
} else {
    // Get employee details
    $sqlEmpDetails = "SELECT emp_name FROM employees WHERE emp_id = '$empId'";
    $resultEmpDetails = $conn->query($sqlEmpDetails);
    $empDetails = $resultEmpDetails->fetch_assoc();

    // Fetch contestants for display, considering only approved positions
    $sqlContestants = "
        SELECT c.contestant_id, c.contestant_name, c.position_id, p.position_name, p.position_type
        FROM contestant c
        JOIN positions p ON c.position_id = p.position_id
        WHERE p.approved = 'yes'
        ORDER BY p.position_type, c.contestant_id
    ";
    $resultContestants = $conn->query($sqlContestants);

    // Display form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Voting Form</title>
    </head>
    <body>
        <header>
            <h1>Voting Form</h1>
        </header>

        <section id="voting-form">
            <?php if ($errorMessage): ?>
                <p class="error"><?= $errorMessage ?></p>
            <?php else: ?>
                <form id="votingForm" action="process_vote.php" method="post">
                    <?php while ($row = $resultContestants->fetch_assoc()): ?>
                        <div class="contestant-container">
                            <!-- Contestant image goes here -->
                            <img src="contestant_images/<?= $row['contestant_id'] ?>.jpg" alt="<?= $row['contestant_name'] ?>">

                            <!-- Contestant caption -->
                            <p class="caption">Name: <?= $row['contestant_name'] ?></p>

                            <!-- Position description -->
                            <p class="position-description"><?= $row['position_name'] ?> - <?= $row['position_type'] ?></p>

                            <!-- Radio button for voting -->
                            <label>
                                <input type="radio" name="vote" value="<?= $row['contestant_id'] ?>">
                                Vote
                            </label>
                        </div>
                    <?php endwhile; ?>
                    <button type="submit">Submit Vote</button>
                </form>
            <?php endif; ?>
        </section>

        <footer>
            <p>Contact support: support@magadisacco.com</p>
        </footer>
    </body>
    </html>
    <?php
}

// Close the database connection
$conn->close();
?>
