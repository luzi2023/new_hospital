<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="styles.css" />

    <title>Local hospital</title>

    <?php
    include('config.php');
    ?>
</head>

<body>
    
    <div class="redirect-message">
        <!-- <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.html">register now</a>
            </form>
        </div> -->
        <div id="side-nav" class="sidenav">
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
        </div>

        <div class="redirect-message">
        <?php
            
       

        if (isset($_POST['doctor_id'])) {
            $doctor_id = $_POST['doctor_id'];

            // First, set doctorID to NULL in all associated patients
            $update_query = "UPDATE patient SET doctorID = NULL WHERE doctorID = '$doctor_id'";
            $update_success = mysqli_query($link, $update_query);

            if ($update_success) {
                // Now, delete the doctor from the doctor table
                $delete_doctor_query = "DELETE FROM doctor WHERE dID = '$doctor_id'";
                $delete_doctor_success = mysqli_query($link, $delete_doctor_query);
                $delete_staff_query = "DELETE FROM staff WHERE dID = '$doctor_id'";
                $delete_staff_success = mysqli_query($link, $delete_staff_query);

                if ($delete_doctor_success) {
                    // Finally, delete the doctor from the staff table
                    if ($delete_staff_success) {
                        echo "Doctor information and related staff information deleted successfully!<br><br>";
                        header("Location: doctor.php");
                        exit();
                    } else {
                        echo "Failed to delete related staff information.";
                    }
                } else {
                    echo "Failed to delete doctor information.";
                }
            } else {
                echo "Failed to update patient records.";
            }
        } else {
            echo "No doctor ID provided for deletion.";
        }

        mysqli_close($link);
        ?>
        </div>
    </div>
</body>

</html>
