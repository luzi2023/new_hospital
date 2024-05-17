<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="patient.css" />
    <title>Patient Details</title>
</head>
<body>
<?php


if (isset($_GET['pNo'])) {
    // 将 pNo 参数转为整型以确保安全
    $patient_no = (int)$_GET['pNo'];

    // 查询与该病患关联的医生 ID
    $docs_query = "SELECT doctor.dID
                   FROM doctor 
                   JOIN patient ON patient.doctorID = doctor.dID
                   WHERE patient.pNo = '$patient_no'";

    $docs_result = mysqli_query($link, $docs_query);

    if (mysqli_num_rows($docs_result) > 0) {
        while ($doc_row = mysqli_fetch_assoc($docs_result)) {
            // 生成指向医生详细页面的链接
            $doctor_id = $doc_row['dID'];
            echo "<a href='staff_detail.php?dID={$doctor_id}'>Back to details page</a>";
        }
    } else {
        // 如果没有找到与该病患关联的医生
        echo "<p id='nope'>No doctor found for this patient!</p>";
    }
} else {
    // 如果没有设置 pNo 参数
    echo "<p>No patient number specified.</p>";
}


?>


</body>
</html>

    <div class="container">
        <h1>Patient Details</h1>
        <div class="patient-info">
            <?php
            $pNo = $_GET['pNo'];
            $showPatientData = isset($_GET['show']) && $_GET['show'] === 'true';

            if ($showPatientData) {
                echo '<button onclick="window.location.href=\'patient.php?pNo=' . $pNo . '&show=false\'">Hide Patient Data</button>';
            } else {
                echo '<button onclick="window.location.href=\'patient.php?pNo=' . $pNo . '&show=true\'">Show Patient Data</button>';
            }

            if ($showPatientData) {
                $sql = "SELECT * FROM patient WHERE pNo=" . $pNo;
                $result = $link->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<div class='patient-container'>";
                    echo "<h2>Name: " . $row["pName"] . "</h2>";
                    echo "<p>Address: " . $row["pAddress"] . "</p>";
                    echo "<p>Age: " . $row["age"] . "</p>";
                    echo "<p>Gender: " . $row["gender"] . "</p>";
                    echo "<p>Birthdate: " . $row["birthdate"] . "</p>";
                    echo "<p>Phone: " . $row["phone"] . "</p>";
                    echo "<p>Allergen: " . $row["allergen"] . "</p>";
                    echo "</div>";
                } else {
                    echo "<p>Patient not found</p>";
                }
            }
            ?>
        </div>
        
        <?php
        $sql = "SELECT * FROM medical_history WHERE pNo=" . $pNo;
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='medical-history-container'>";
            echo "<h2>Medical History</h2>";
            echo "<ul>";
            while($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "<p>Medical History ID: " . $row["mhID"] . "</p>";
                echo "<p>Patient ID: " . $row["pNo"] . "</p>";
                echo "<p>Date: " . $row["date"] . "</p>";
                echo "<p>Treatment: " . $row["treatment"] . "</p>";
                echo "<p>Diagnosis: " . $row["diagnosis"] . "</p>";
                echo "<p>Prescription: " . $row["prescription"] . "</p>";
                echo "</li>";
            }
            echo "</ul>";
            echo '<button onclick="window.location.href=\'add_mh.php?pNo=' . $pNo . '\'">Add Medical History</button>';
            echo "</div>";
        } else {
            echo "<p>No medical history available</p>";
        }
        ?>
    </div>
</body>
</html>
