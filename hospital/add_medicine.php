<?php
include('config.php');

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

    $insert_query = "INSERT INTO medication (mID, mName, mType, mCode, side_effect, indication, drug_warning, ingredient, dosage, pregnancy_grade) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($link, $insert_query);
    mysqli_stmt_bind_param($insert_stmt, "ssssssssss", $mID, $mName, $mType, $mCode, $side_effect, $indication, $drug_warning, $ingredient, $dosage, $pregnancy_grade);

    if (mysqli_stmt_execute($insert_stmt)) {
        header("Location: medicine.php"); 
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
    <title>Add New Medicine</title>
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
        <h1>Add New Medicine</h1>
        <form action="" method="post" enctype="multipart/form-data" class="changing-formEquip">
            <label>
                <span>mID:</span>
                <input type="text" name="mID" required><br>
            </label>
            <label>
                <span>Medicine Name:</span>
                <input type="text" name="mName" required><br>
            </label>
            <label>
                <span>Medicine Type:</span>
                <input type="text" name="mType" required><br>
            </label>
            <label>
                <span>Medicine Code:</span>
                <input type="text" name="mCode" required><br>
                
            </label>
            <label>
                <span>Side Effect:</span>
                <input type="text" name="side_effect" required><br>
            </label>
            <label>
                <span>Indication:</span>
                <input type="text" name="indication" required><br>
            </label>
            <label>
                <span>Drug Warning:</span>
                <input type="text" name="drug_warning" required><br>
            </label>
            <label>
                <span>Ingredient:</span>
                <input type="text" name="ingredient" required><br>
            </label>
            <label>
                <span>Dosage:</span>
                <input type="text" name="dosage" required><br>
            </label>
            <label>
                <span>Pregnancy grade:</span>
                <input type="text" name="pregnancy_grade" required><br>
            </label>
            <input type="submit" class="equip_Ebtn" value="Add Medicine">
        </form>
    </div>
</body>

</html>
