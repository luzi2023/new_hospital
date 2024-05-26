<?php
    include('config.php');

    function isScheduleOverlap($link, $doctor_id, $day, $time){
        $query = "SELECT COUNT(*) AS count FROM schedule WHERE dID = ? AND day = ? AND time = ?";
        $stmt = mysqli_prepare($link, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $doctor_id, $day, $time);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $count);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
            return $count > 0;
        } else {
            die("Failed to prepare statement: " . mysqli_error($link));
        }
    }

    // add
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['sID']) && isset($_POST['day']) && isset($_POST['time']) && isset($_POST['doctor_id'])) {
            $sID = $_POST['sID'];
            $doctor_id = $_POST['doctor_id'];
            $day = $_POST['day'];
            $time = $_POST['time'];

            // Check if there is a schedule overlap
            if (!isScheduleOverlap($link, $doctor_id, $day, $time)) {
                // Insert the schedule into the database
                $query = "INSERT INTO schedule (sID, dID, day, time) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($link, $query);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ssss", $sID, $doctor_id, $day, $time);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                } else {
                    die("Failed to prepare statement: " . mysqli_error($link));
                }
            }
            // Redirect to edit_doctor.php regardless of success or failure
            header("Location: edit_nurse.php?dID=" . $doctor_id);
            exit();
        }
        mysqli_close($link);
    }
    ?>