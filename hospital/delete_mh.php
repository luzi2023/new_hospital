<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mhID']) && isset($_POST['pNo'])) {
    $mhID = $_POST['mhID'];
    $pNo = $_POST['pNo'];


    $delete_query = "DELETE FROM medical_history WHERE mhID = ?";
    $stmt = mysqli_prepare($link, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $mhID);

    if (mysqli_stmt_execute($stmt)) {
        // 重新導向到患者頁面並傳遞患者編號
        header("Location: patient.php?pNo=" . $pNo);
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($link);
?>


