<?php
// 包含資料庫連接設定
include('config.php');

if (isset($_GET['mhID'])) {
    $mhID = $_GET['mhID'];

    // 取得當前病例資料
    $sql = "SELECT * FROM medical_history WHERE mhID=" . $mhID;
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No medical history found for the given ID.";
        exit();
    }
} else {
    echo "No mhID provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $treatment = $_POST["treatment"];
    $diagnosis = $_POST["diagnosis"];
    $prescription = $_POST["prescription"];

    // 更新病例資料
    $sql = "UPDATE medical_history SET date='$date', treatment='$treatment', diagnosis='$diagnosis', prescription='$prescription' WHERE mhID=" . $mhID;

    if ($link->query($sql) === TRUE) {
        echo "Record updated successfully";
        // 可以選擇重新導向至其他頁面
         header("Location: patient.php?pNo=" . $row["pNo"]);
    } else {
        echo "Error updating record: " . $link->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Medical History</title>
    <link rel="stylesheet" href="edit_mh.css" />
</head>
<body>
    <h2>Edit Medical History</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?mhID=' . $mhID; ?>">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $row["date"]; ?>" required><br>

        <label for="treatment">Treatment:</label>
        <input type="text" id="treatment" name="treatment" value="<?php echo $row["treatment"]; ?>" required><br>

        <label for="diagnosis">Diagnosis:</label>
        <input type="text" id="diagnosis" name="diagnosis" value="<?php echo $row["diagnosis"]; ?>" required><br>

        <label for="prescription">Prescription:</label>
        <input type="text" id="prescription" name="prescription" value="<?php echo $row["prescription"]; ?>" required><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
