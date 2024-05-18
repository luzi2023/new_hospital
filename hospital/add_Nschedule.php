<?php
    include('config.php');

    // add
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['sID']) && isset($_POST['day']) && isset($_POST['time']) && isset($_POST['doctor_id'])) {
            $sID = $_POST['sID'];
            $doctor_id = $_POST['doctor_id'];
            $day = $_POST['day'];
            $time = $_POST['time'];

            $query = "INSERT INTO schedule (sID, dID, day, time) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $query);
            if (!$stmt) {
                die("Failed to prepare statement: " . mysqli_error($link));
            }
            mysqli_stmt_bind_param($stmt, "ssss", $sID, $doctor_id, $day, $time);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header("Location: edit_nurse.php?dID=" . $doctor_id);
                exit();
            } else {
                echo "Error: Failed to insert schedule into the database.";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Missing schedule information.";
        }
        mysqli_close($link);
    }
    ?>