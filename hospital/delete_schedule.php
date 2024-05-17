<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['schedule_id']) && isset($_POST['doctor_id'])) {
        $schedule_id = $_POST['schedule_id'];
        $doctor_id = $_POST['doctor_id'];

        // Use prepared statements to prevent SQL injection
        $query = "DELETE FROM schedule WHERE sID = ?";
        $stmt = mysqli_prepare($link, $query);
        if (!$stmt) {
            die("Failed to prepare statement: " . mysqli_error($link));
        }
        mysqli_stmt_bind_param($stmt, "s", $schedule_id); // Bind 'sID' as a string
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            header("Location: edit_doctor.php?dID=" . $doctor_id);
            exit();
        } else {
            echo "Error: Failed to delete schedule.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Missing schedule_id or doctor_id.";
    }
    mysqli_close($link);
}
?>
