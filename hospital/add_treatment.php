<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add_treatment.css" />
    <title>Add Treatment</title>
</head>
<body>
    <h2>Add New Treatment</h2>
    <form action="add_treatment.php" method="POST">
        <input type="hidden" id="tID" name="tID" value="<?php echo generate_treatment_id(); ?>">
        <!-- This will generate a unique treatment ID for each new entry -->
        <label for="tName">Treatment Name:</label>
        <input type="text" id="tName" name="tName" required>
        <br>
        <label for="tType">Treatment Type:</label>
        <input type="text" id="tType" name="tType" required>
        <br>
        <label for="usedEquip">Used Equipment:</label>
        <input type="text" id="usedEquip" name="usedEquip" required>
        <br>
        <input type="submit" value="Add Treatment">
    </form>

    <?php
    // Include your database connection file
    include('config.php');

    function generate_treatment_id() {
        // Generate a random ID starting with "T" followed by four random digits
        return "T" . mt_rand(1000, 9999);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tID = $_POST['tID'];
        $tName = $_POST['tName'];
        $tType = $_POST['tType'];
        $usedEquip = $_POST['usedEquip'];

        // Validate the inputs (simple validation)
        if (!empty($tName) && !empty($tType)) {
            // Prepare and bind
            $stmt = $link->prepare("INSERT INTO treatment (tID, tName, tType, usedEquip) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $tID, $tName, $tType, $usedEquip);
            

            if ($stmt->execute()) {
                header("Location: treatment.php");
                exit;
            } else {
                echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p style='color: red;'>Please fill in all fields.</p>";
        }
    }

    // Close the database connection
    $link->close();
    ?>
</body>
</html>
