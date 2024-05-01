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
            <a href="doctor.php" id="doctors">Doctors</a>
            <a href="" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
        </div> -->

        <div id="body">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['first_name'], $_POST['last_name'], $_POST['speciality'])) {
                    $doctor_id = $_POST['doctor_id'];
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $speciality = $_POST['speciality'];

                    // check if user upload a new file
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
                        $get_image_path = "SELECT dImage FROM Doctor WHERE dID='$doctor_id'";
                        $result = mysqli_query($link, $get_image_path);
                        $row = mysqli_fetch_assoc($result);
                        $image_url = $row['dImage'];
                    }

                    $query = "UPDATE Doctor SET first_name='$first_name', last_name='$last_name', speciality='$speciality', dImage='$image_url' WHERE dID='$doctor_id' ";

                    if (mysqli_query($link, $query)) {
                        echo "Doctor information updated successfully!<br><br>";
                        echo "Redirect back to doctor page in 3 sec...";
                    } else {
                        echo "ERROR: Could not able to execute $query." . mysqli_error($link);
                    }
                }

            }
            ?>
        </div>
    </div>
</body>

</html>