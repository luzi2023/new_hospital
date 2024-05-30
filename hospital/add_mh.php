<?php
include('config.php');

// 生成唯一的Medical History ID
do {
    $mhID = mt_rand(70001, 99999); // 生成一個六位數的隨機數字
    // 檢查新生成的ID是否已存在於資料庫中
    $sql_check = "SELECT mhID FROM medical_history WHERE mhID = '$mhID'";
    $result_check = $link->query($sql_check);
} while ($result_check->num_rows > 0);

if(isset($_POST['submit'])) {
    $pNo = $_POST['pNo'];
    $date = $_POST['date'];
    $treatment = $_POST['treatment'];
    $diagnosis = $_POST['diagnosis'];
    $prescription = $_POST['prescription'];

    $sql = "INSERT INTO medical_history (mhID, pNo, date, treatment, diagnosis, prescription) 
            VALUES ('$mhID', '$pNo', '$date', '$treatment', '$diagnosis', '$prescription')";

    if ($link->query($sql) === TRUE) {
        header("Location: patient.php?pNo=$pNo");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}

$link->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medical History</title>
    <link rel="stylesheet" href="add_mh.css">
</head>
<body>
    <h1>Add Medical History</h1>
    <form action="add_mh.php" method="POST">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        
        <label for="treatment">Treatment:</label>
        <input type="text" id="treatment" name="treatment" required><br><br>
        
        <label for="diagnosis">Diagnosis:</label>
        <input type="text" id="diagnosis" name="diagnosis" required><br><br>
        
        <label for="prescription">Prescription:</label>
        <input type="text" id="prescription" name="prescription" required><br><br>
        
        <input type="hidden" name="pNo" value="<?php echo $_GET['pNo']; ?>">
        
        <input type="submit" name="submit" value="Confirmed">
    </form>
</body>
</html>
