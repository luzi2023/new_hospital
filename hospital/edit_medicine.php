<?php
include('config.php');

if (isset($_GET['mID'])) {
    $mID = $_GET['mID'];
   

    $query = "SELECT * FROM medication WHERE mID = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $mID); // Changed to string type
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $medicine = mysqli_fetch_assoc($result);
            
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
    $mID = $_POST['mID'];
    $mName = $_POST['mName'];
    $mType = $_POST['mType'];
    $mCode = $_POST['mCode'];
    $side_effect = $_POST['side_effect'];
    $indication = $_POST['indication'];
    $drug_warning = $_POST['drug_warning'];
    $ingredient = $_POST['ingredient'];
    $dosage = $_POST['dosage'];
    $pregnancy_grade = $_POST['pregnancy_grade'];

    $update_query = "UPDATE medication SET mName = ?, mType = ?, mCode = ?, side_effect = ?, indication = ?, drug_warning = ?, ingredient = ?, dosage = ?, pregnancy_grade = ? WHERE mID = ?";
    $update_stmt = mysqli_prepare($link, $update_query);
    mysqli_stmt_bind_param($update_stmt, "ssssssssss", $mName, $mType, $mCode, $side_effect, $indication, $drug_warning, $ingredient, $dosage, $pregnancy_grade, $mID);

    if (mysqli_stmt_execute($update_stmt)) {
        header("Location: medicine_detail.php?mID=" . $mID);
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
    <title>Edit Medicine</title>
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
        <h1>Edit Medicine</h1><a href="delete_medicine.php?mID=<?php echo $medicine['mID']; ?>"><button class="equip_Dbtn">Delete</button></a>
        <form action="" method="post" enctype="multipart/form-data" class="changing-formEquip">
            <label>
                <span>mID:</span>
                <p><?php echo $medicine['mID'] ?></p>
                <input type="hidden" name="mID" value="<?php echo $medicine['mID']; ?>">
            </label>
            <label>
                <span>Medicine Name:</span>
                <input type="text" name="mName" value="<?php echo $medicine['mName']; ?>"><br>
            </label>
            <label>
                <span>Medicine Type:</span>
                <input type="text" name="mType" value="<?php echo $medicine['mType']; ?>"><br>
            </label>
            <label>
                <span>Medicine Code:</span>
                <input type="text" name="mCode" value="<?php echo $medicine['mCode']; ?>"><br>
            </label>
            <label>
                <span>Side Effect:</span>
                <input type="text" name="side_effect" value="<?php echo $medicine['side_effect']; ?>"><br>
            </label>
            <label>
                <span>Indication:</span>
                <input type="text" name="indication" value="<?php echo $medicine['indication']; ?>"><br>
            </label>
            <label>
                <span>Drug Warning:</span>
                <input type="text" name="drug_warning" value="<?php echo $medicine['drug_warning']; ?>"><br>
            </label>
            <label>
                <span>Ingredient:</span>
                <input type="text" name="ingredient" value="<?php echo $medicine['ingredient']; ?>"><br>
            </label>
            <label>
                <span>Dosage:</span>
                <input type="text" name="dosage" value="<?php echo $medicine['dosage']; ?>"><br>
            </label>
            <label>
                <span>Pregnancy Grade:</span>
                <input type="text" name="pregnancy_grade" value="<?php echo $medicine['pregnancy_grade']; ?>"><br>
            </label>
            <input type="submit" class="equip_Ebtn" value="Update">
        </form>
       

    </div>
</body>

</html>
