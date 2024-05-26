<?php
include('config.php');

if (isset($_GET['eID'])) {
    $equip_ID = $_GET['eID'];

    $query = "SELECT * FROM equipment WHERE eID = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $equip_ID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $equip = mysqli_fetch_assoc($result);
        } else {
            echo "Equipment not found.";
            exit;
        }
    } else {
        echo "Error: " . mysqli_error($link);
        exit;
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equip_ID = $_POST['eID'];
    $eName = $_POST['eName'];
    $purchaseDate = $_POST['purchaseDate'];
    $useStatus = $_POST['useStatus'];
    $manufacturer = $_POST['manufacturer'];

    $update_query = "UPDATE equipment SET eName = ?, purchaseDate = ?, useStatus = ?, manufacturer = ? WHERE eID = ?";
    $update_stmt = mysqli_prepare($link, $update_query);
    mysqli_stmt_bind_param($update_stmt, "ssssi", $eName, $purchaseDate, $useStatus, $manufacturer, $equip_ID);

    if (mysqli_stmt_execute($update_stmt)) {
        header("Location: equipment_view.php?eID=" . $equip_ID);
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($update_stmt);
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Edit Equipment</title>
</head>

<body>
    <div class="container-fluid">
    </div>
    <div class="tab">
        <a href="index.php"><button class="tablinks">Home</button></a>
    </div>
    <div class="tab_fix"></div>
    <div class="container-fluid2">
        <div id="side-nav" class="sidenav">
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
        <h1>Edit Equipment</h1>
        <form action="" method="post" enctype="multipart/form-data" class="changing-formEquip">
            <label>
                <span>eID:</span>
                <p><?php echo $equip['eID'] ?></p>
                <input type="hidden" name="eID" value="<?php echo $equip['eID']; ?>">
            </label>
            <label>
                <span>Equipment Name:</span>
                <input type="text" name="eName" value="<?php echo $equip['eName']; ?>"><br>
            </label>
            <label>
                <span>Purchase Date:</span>
                <input class="pDate" type="date" name="purchaseDate" value="<?php echo $equip['purchaseDate']; ?>"><br>
            </label>
            <label>
                <span>Status:</span>
                <select name="useStatus" required>
                    <option value="Repaired" <?php if ($equip['useStatus'] == 'Repaired') echo 'selected'; ?>>Repaired</option>
                    <option value="Normal" <?php if ($equip['useStatus'] == 'Normal') echo 'selected'; ?>>Normal</option>
                </select>
            </label>
            <label>
                <span>Manufacturer:</span>
                <input type="text" name="manufacturer" value="<?php echo $equip['manufacturer']; ?>"><br>
            </label>
            <input type="submit" class="equip_Ebtn" value="Update">
        </form>
    </div>
</body>

</html>
