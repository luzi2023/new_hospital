<?php
include('config.php');

if (isset($_GET['tID'])) {
    $tID = $_GET['tID'];
   

    $query = "SELECT * FROM treatment WHERE tID = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $tID); // Changed to string type
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $treatment = mysqli_fetch_assoc($result);
            
        } else {
            echo "Treatment not found.";
            exit;
        }
    } else {
        echo "Error: " . mysqli_error($link);
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "tID not set.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tID'], $_POST['tName'], $_POST['tType'], $_POST['usedEquip'])) {
        $tID = $_POST['tID'];
        $tName = $_POST['tName'];
        $tType = $_POST['tType'];
        $usedEquip = $_POST['usedEquip'];

        $update_query = "UPDATE treatment SET tName = ?, tType = ?, usedEquip = ? WHERE tID = ?";
        $update_stmt = mysqli_prepare($link, $update_query);
        mysqli_stmt_bind_param($update_stmt, "ssss", $tName, $tType, $usedEquip, $tID); // Changed to string types

        if (mysqli_stmt_execute($update_stmt)) {
            header("Location: treatment_view.php?tID=" . $tID);
            exit();
        } else {
            echo "Error: " . mysqli_error($link);
        }

        mysqli_stmt_close($update_stmt);
    } else {
        echo "Form data missing.";
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Edit Treatment</title>
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
        <h1>Edit Treatment</h1>
        <form action="" method="post" enctype="multipart/form-data" class="changing-formEquip">
            <label>
                <span>tID:</span>
                <p><?php echo $treatment['tID'] ?></p>
                <input type="hidden" name="tID" value="<?php echo $treatment['tID']; ?>">
            </label>
            <label>
                <span>Treatment Name:</span>
                <input type="text" name="tName" value="<?php echo $treatment['tName']; ?>"><br>
            </label>
            <label>
                <span>Treatment Type:</span>
                <input class="pDate" type="text" name="tType" value="<?php echo $treatment['tType']; ?>"><br>
            </label>
            <label>
                <span>Used Equipment:</span>
                <input class="pDate" type="text" name="usedEquip" value="<?php echo $treatment['usedEquip']; ?>"><br>
            </label>
            <input type="submit" class="equip_Ebtn" value="Update">
        </form>
    </div>
</body>

</html>
