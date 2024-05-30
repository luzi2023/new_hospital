<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tID'])) {
    $tID = $_POST['tID'];

    $delete_query = "DELETE FROM treatment WHERE tID = ?";
    $stmt = mysqli_prepare($link, $delete_query);
    mysqli_stmt_bind_param($stmt, "s", $tID);

    if (mysqli_stmt_execute($stmt)) {
        ob_clean();
        header("Location: treatment.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($link);
?>
