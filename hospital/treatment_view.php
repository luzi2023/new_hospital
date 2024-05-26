<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Treatment Details</title>
    <?php include('config.php'); ?>
</head>

<body>
    <div class="container-fluid2">
        <div id="side-nav" class="sidenav">
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
        <div id="body">
            <?php
            if (isset($_GET['tID'])) {
                $tID = $_GET['tID'];

                $stmt = $link->prepare("SELECT * FROM treatment WHERE tID = ?");
                $stmt->bind_param("s", $tID);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $treatment = $result->fetch_assoc();
                    ?>
                    <h1><?php echo htmlspecialchars($treatment['tName']); ?> </h1>
                    <p>ID: <?php echo htmlspecialchars($treatment['tID']); ?></p>
                    <p>Type: <?php echo htmlspecialchars($treatment['tType']); ?></p>
                    <p>Used Equipment: <?php echo htmlspecialchars($treatment['usedEquip']); ?></p>
                    <a id='akibtn'href="edit_treatment.php?tID=<?php echo $treatment['tID']; ?>" class="edit-btn">Edit</a>
                    <form action="delete_treatment.php" method="POST" style="display: inline;">
                        <input type="hidden" name="tID" value="<?php echo htmlspecialchars($treatment['tID']); ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
            <?php
                } else {
                    echo "<p>No treatment found with that ID.</p>";
                }
            } else {
                echo "<p>No treatment ID provided.</p>";
            }
            ?>
        </div>
    </div>
</body
