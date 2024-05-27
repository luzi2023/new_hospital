<?php
include('config.php');

if (isset($_GET['mID'])) {
    $mID = $_GET['mID'];

    $delete_query = "DELETE FROM medication WHERE mID = ?";
    $stmt = mysqli_prepare($link, $delete_query);
    mysqli_stmt_bind_param($stmt, "s", $mID);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: medicine.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($link);
?>
