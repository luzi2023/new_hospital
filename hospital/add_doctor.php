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
                <a href="register.html">register now</a>
            </form>
        </div>
        <div id="side-nav" class="sidenav">
            <a href="index.html" id="home">Home</a>
            <a href="doctor.php" id="doctors">Doctors</a>
            <a href="" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
        </div> -->

        <div id="body">
            <h1>Add New Doctor</h1>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['doctor_id'], $_POST['first_name'], $_POST['last_name'], $_POST['speciality'])) {
                    $doctor_id = $_POST['doctor_id'];
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $speciality = $_POST['speciality'];
                    if (!empty($_POST['image'])) {
                        $image_path = $_POST['image'];
                    } else {
                        $image_path = 'default.png';
                    }

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
            <form method="post" action="add_doctor.php" onsubmit="confirmAdd()">
                <label for="doctor_id">Doctor ID:</label><br>
                <input type="text" id="doctor_id" name="doctor_id" required><br>
                <label for="first_name">First Name:</label><br>
                <input type="text" id="first_name" name="first_name" required><br>
                <label for="last_name">Last Name:</label><br>
                <input type="text" id="last_name" name="last_name" required><br>
                <label for="speciality">Speciality:</label><br>
                <input type="text" id="speciality" name="speciality" required><br>
                <label for="photo">Image</label><br>
                <input type="file" name="image"><br><br>
                <input type="submit" value="Add Doctor">
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