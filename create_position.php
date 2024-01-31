<?php
// Include the database connection file
$conn = require_once('db_connect.php');

// Initialize variables
$positionName = $positionDescription = $positionType = '';
$error = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $positionName = $_POST['position_name'];
    $positionDescription = $_POST['position_description'];
    $positionType = $_POST['position_type'];

    // Validate the number of positions based on the type
    $sqlCount = "SELECT COUNT(*) AS count FROM positions WHERE position_type = '$positionType'";
    $resultCount = $conn->query($sqlCount);
    $row = $resultCount->fetch_assoc();
    $count = $row['count'];

    if (($positionType == 'board_membership' && $count >= 4) || ($positionType == 'nomination_committee' && $count >= 2)) {
        $error = "Cannot add more positions of type $positionType.";
    } else {
        // Insert position details into the database
        $sqlInsert = "INSERT INTO positions (position_name, position_description, position_type) 
                      VALUES ('$positionName', '$positionDescription', '$positionType')";
        $resultInsert = $conn->query($sqlInsert);

        if ($resultInsert) {
            // Redirect or provide feedback as needed
            header('Location: admin.php');
            exit();
        } else {
            $error = "Error inserting position details. Please try again.";
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
    <title>Insert Position</title>
</head>
<body>
    <header>
        <h1>Insert Position</h1>
    </header>

    <section id="position-form">
        <form action="create_position.php" method="post">
            <label for="position_name">Position Name:</label>
            <input type="text" id="position_name" name="position_name" required>

            <label for="position_description">Position Description:</label>
            <textarea id="position_description" name="position_description" rows="4" required></textarea>

            <label for="position_type">Position Type:</label>
            <select id="position_type" name="position_type" required>
                <option value="board_membership">Board Membership</option>
                <option value="nomination_committee">Nomination Committee</option>
            </select>

            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <button type="submit">Add Position</button>
        </form>
    </section>

    <footer>
        <p>Contact support: support@magadisacco.com</p>
    </footer>
</body>
</html>