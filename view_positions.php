<?php
       // Include the database connection file
       $conn = require_once('db_connect.php');

// Handle position approval
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve'])) {
    $positionId = $_POST['position_id'];
    
    // Update the 'approved' value to 'yes' in the positions table
    $sqlApprovePosition = "UPDATE positions SET approved = 'yes' WHERE position_id = $positionId";
    $conn->query($sqlApprovePosition);
}

// Fetch positions for display
$sqlPositions = "SELECT * FROM positions";
$resultPositions = $conn->query($sqlPositions);

// Display positions
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>View Positions</title>
</head>
<body>
    <header>
        <h1>View Positions</h1>
    </header>

    <section id="positions-list">
        <table>
            <thead>
                <tr>
                    <th>Position ID</th>
                    <th>Position Name</th>
                    <th>Position Description</th>
                    <th>Position Type</th>
                    <th>Approved</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultPositions->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['position_id'] ?></td>
                        <td><?= $row['position_name'] ?></td>
                        <td><?= $row['position_description'] ?></td>
                        <td><?= $row['position_type'] ?></td>
                        <td><?= $row['approved'] ?></td>
                        <td>
                            <form action="view_positions.php" method="post">
                                <input type="hidden" name="position_id" value="<?= $row['position_id'] ?>">
                                <button type="submit" name="approve" value="yes">Approve</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>Contact support: support@magadisacco.com</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
