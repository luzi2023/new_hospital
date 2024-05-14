<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="styles.css" />

    <title>Local hospital</title>

    <?php
    include('config.php');
    ?>
</head>

<body>
    <div class="container-fluid2">
        <!-- <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.php">register now</a>
            </form>
        </div>-->
        <div id="side-nav" class="sidenav">
            <a href="index.php" id="home">Home</a>
            <a href="doctor.php" id="doctors">Doctors</a>
            <a href="" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>

        <div id="body">
            <h2 class="form-title">Add New Doctor</h2>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['doctor_id'], $_POST['first_name'], $_POST['last_name'], $_POST['speciality'], $_FILES['image'])) {
                    $doctor_id = $_POST['doctor_id'];
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $speciality = $_POST['speciality'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $upload_dir = "uploads/";

                    // get file name and its extension name
                    $original_filename = $_FILES['image']['name'];
                    $extension = pathinfo($original_filename, PATHINFO_EXTENSION);

                    // generate the file name
                    $file_name = $doctor_id . "_" . $extension;

                    $image_path = $upload_dir . $file_name;

                    // upload the file
                    move_uploaded_file($file_tmp, $image_path);

                    $query = "INSERT INTO Doctor (dID, first_name, last_name, speciality, dImage) VALUES ('$doctor_id', '$first_name', '$last_name', '$speciality', '$image_path')";

                    if (mysqli_query($link, $query)) {
                        // echo "Doctor information inserted successfully.";
                        ?>
            <!-- <br>
            <a href="doctor.php">Back to Doctors</a> -->
            <?php
                    } else {
                        // echo "ERROR: Could not able to execute $query." . mysqli_error($link);
                    }

                    mysqli_close($link);
                } else {
                    echo "ERROR: Incomplete data received.";
                }
            }
            ?>
            <form method="post" action="add_doctor.php" onsubmit="confirmAdd()" enctype="multipart/form-data"
                class="changing-form">
                <label>
                    <span for="doctor_id">Doctor ID:</span>
                    <input type="text" id="doctor_id" name="doctor_id" class="input-column" required>
                </label>
                <label>
                    <span for="first_name">First Name:</span>
                    <input type="text" id="first_name" name="first_name" required>
                </label>
                <label>
                    <span for="last_name">Last Name:</span>
                    <input type="text" id="last_name" name="last_name" required>
                </label>
                <label>
                    <span for="speciality">Speciality:</span>
                    <input type="text" id="speciality" name="speciality" required>
                </label>
                <label>
                    <span>Hospital:</span>
                    <select name="hName" class="hospital-drag-list">
                        <option value="Marshall Medical Centers">Marshall Medical Centers</option>
                        <option value="Greene County Hospital">Greene County Hospital</option>
                    </select>
                </label>

                <label class="add-img-position">
                    <span for="photo">Image</span>
                    <input type="file" name="image">
                </label>
                <label>
                    <span>&nbsp;</span>
                    <input type="submit" value="Add Doctor" class="button">
                </label>
            </form>
            <script>
            function confirmAdd() {
                return confirm("Do you want to create a doctor?");
            }
            </script>
        </div>
    </div>
</body>

</html>