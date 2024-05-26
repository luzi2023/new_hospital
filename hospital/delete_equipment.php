<?php
include('config.php');

if (isset($_GET['eID'])) {
    $equip_ID = $_GET['eID'];

    $delete_query = "DELETE FROM equipment WHERE eID = ?";
    $stmt = mysqli_prepare($link, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $equip_ID);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: equipment.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($link);
?>
