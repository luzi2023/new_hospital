<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eID = $_POST['eID'];
    $eName = $_POST['eName'];
    $purchaseDate = $_POST['purchaseDate'];
    $useStatus = $_POST['useStatus'];
    $manufacturer = $_POST['manufacturer'];

    $insert_query = "INSERT INTO equipment (eID, eName, purchaseDate, useStatus, manufacturer) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($link, $insert_query);
    mysqli_stmt_bind_param($insert_stmt, "issss", $eID, $eName, $purchaseDate, $useStatus, $manufacturer);

    if (mysqli_stmt_execute($insert_stmt)) {
        header("Location: equipment.php"); // 重定向到设备列表页面或其他页面
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($insert_stmt);
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Add New Equipment</title>
</head>

<body>
    <div class="container-fluid"></div>
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
        <h1>Add New Equipment</h1>
        <form action="" method="post" enctype="multipart/form-data" class="changing-formEquip">
            <label>
                <span>eID:</span>
                <input type="text" name="eID" required><br>
            </label>
            <label>
                <span>Equipment Name:</span>
                <input type="text" name="eName" required><br>
            </label>
            <label>
                <span>Purchase Date:</span>
                <input class="pDate" type="date" name="purchaseDate" required><br>
            </label>
            <label>
                <span>Status:</span>
                <select name="useStatus" required>
                    <option value="Repaired">Repaired</option>
                    <option value="Normal">Normal</option>
                </select>
            </label>
            <label>
                <span>Manufacturer:</span>
                <input type="text" name="manufacturer" required><br>
            </label>
            <input type="submit" class="equip_Ebtn" value="Add Equipment">
        </form>
    </div>
</body>

</html>
