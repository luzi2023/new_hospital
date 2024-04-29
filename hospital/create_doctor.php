<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include('config.php')
    ?>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['dID']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['speciality'])) {
            $doctor_id = $_POST['dID'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $speciality = $_POST['speciality'];

            $check_dID = "SELECT * FROM Doctor WHERE dID = '$doctor_id' ";
            $check_result = mysqli_query($link, $check_dID);
            if (mysqli_num_rows($check_result) > 0) {
                echo "ERROR: Doctor with ID $doctor_id already exists. Please try another doctor ID";
                mysqli_free_result($check_result);
                mysqli_close($link);
                exit();
            }

            $query = "INSERT INTO `doctor`(`dID`, `first_name`, `last_name`, `speciality`) VALUES ('$doctor_id', '$first_name', '$last_name', '$speciality')";

            $create_success = mysqli_query($link, $query);

            if ($create_success) {
                echo "Create doctor successfully!";
                ?>
    <br>
    <a href="doctor.php">Back to Doctors</a>
    <?php
            } else {
                echo "ERROR: Could not able to execute $query." . mysqli_error($link);
            }
        } else {
            echo "ERROR: Please enter valid information.";
        }
        mysqli_close($link);
    }
    ?>
</body>

</html>