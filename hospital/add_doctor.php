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
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>

        <div id="body">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['doctor_id'], $_POST['first_name'], $_POST['last_name'], $_POST['speciality'], $_FILES['image'])) {
                    $doctor_id = $_POST['doctor_id'];
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $speciality = $_POST['speciality'];
                    $contact = $_POST['contact'];
                    $About = $_POST['About'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $upload_dir = "uploads/";
            
                    $original_filename = $_FILES['image']['name'];
                    $extension = pathinfo($original_filename, PATHINFO_EXTENSION);
            
                    $file_name = $doctor_id . "_" . $extension;
            
                    $image_path = $upload_dir . $file_name;
            
                    move_uploaded_file($file_tmp, $image_path);
            
                    $query_staff = "INSERT INTO staff (dID, first_name, last_name,contact, dImage) VALUES ('$doctor_id', '$first_name', '$last_name','$contact', '$image_path')";
            
                    if (mysqli_query($link, $query_staff)) {
                        $query_doctor = "INSERT INTO doctor (dID, speciality,About) VALUES ('$doctor_id', '$speciality','$About')";
                        if (mysqli_query($link, $query_doctor)) {

                            header("Location: staff_detail.php?dID=$doctor_id");
                            exit();
                            ?>
                            <div class="doctor-info">
                                <img src="<?php echo $image_path; ?>" alt="Doctor Image">
                                <h3><?php echo $first_name . ", " . $last_name; ?></h3>
                                <p><?php echo $speciality; ?></p>
                            </div>
                            <?php
                        } else {
                            echo "Error: " . $query_doctor . "<br>" . mysqli_error($link);
                        }
                    } else {
                        echo "Error: " . $query_staff . "<br>" . mysqli_error($link);
                    }
            
                    mysqli_close($link);
                } else {
                    echo "ERROR: Incomplete data received.";
                }
            }
            ?>
            <h2 class="form-title">Add New Doctor</h2>
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
                    <span for="contact">Conact:</span>
                    <input type="text" id="contact" name="contact" required>
                </label>
                <label>
                    <span for="About">About:</span>
                    <input type="text" id="About" name="About" required>
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
            <!-- <script>
            function confirmAdd() {
                return confirm("Do you want to create a doctor?");
            }
            </script> -->
        </div>
    </div>
</body>

</html>
