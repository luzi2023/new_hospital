<html lang="en">

<head>
    <!-- <meta charset="UTF-8">
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
    <?php
    header("Refresh: 3; url=doctor.php");
    ?>
    <div class="redirect-message">
        <br>
        <!-- <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.php">register now</a>
            </form>
        </div>
        <div id="side-nav" class="sidenav">
            <a href="index.html" id="home">Home</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div> -->

        <div id="body">
        <?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['period'], $_POST['doctor_id'],$_POST['contact'])) {
        $doctor_id = $_POST['doctor_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $period = $_POST['period'];
        $contact = $_POST['contact'];

        // check if user uploaded a new file
        if ($_FILES['image']['size'] > 0) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $upload_dir = "uploads/";

            // get file name and its extension name
            $original_filename = $_FILES['image']['name'];
            $extension = pathinfo($original_filename, PATHINFO_EXTENSION);

            // generate the file name
            $file_name = $doctor_id . "." . $extension;

            $image_url = $upload_dir . $file_name;

            // upload the file
            move_uploaded_file($file_tmp, $image_url);
        } else {
            $get_image_path = "SELECT dImage FROM staff WHERE dID='$doctor_id'";
            $result = mysqli_query($link, $get_image_path);
            $row = mysqli_fetch_assoc($result);
            $image_url = $row['dImage'];
        }

        // Start a transaction
        mysqli_autocommit($link, false);

        $first_name = mysqli_real_escape_string($link, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($link, $_POST['last_name']);
        $contact = mysqli_real_escape_string($link, $_POST['contact']);
        
        $query1 = "UPDATE staff SET first_name='$first_name', last_name='$last_name',contact='$contact', dImage='$image_url' WHERE dID='$doctor_id'";
        $query2 = "UPDATE nurse SET period='$period' WHERE dID='$doctor_id'";


        $success = true;

        // Execute the queries
        if (!mysqli_query($link, $query1) || !mysqli_query($link, $query2)) {
            $success = false;
        }

        // Commit or rollback the transaction based on success
        if ($success) {
            mysqli_commit($link);
            echo "Nurse information updated successfully!<br><br>";
            echo "Redirect back to doctor page in 3 sec...";
        } else {
            mysqli_rollback($link);
            echo "ERROR: Could not able to execute update queries.";
        }

        // Enable autocommit
        mysqli_autocommit($link, true);
    }
}

?>

        </div>
    </div>
</body>

</html>