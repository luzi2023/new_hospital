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
    <div class="container-fluid2">
        <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.php">register now</a>
            </form>
        </div>
        <div id="side-nav" class="sidenav">
            <a href="index.php" id="home">Home</a>
            <a href="doctor.php" id="doctors">Doctors</a>
            <a href="" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
        </div>

        <div id="body">

            <?php
            if (isset($_GET['dID'])) {
                $doctor_id = $_GET['dID'];

                $query = "SELECT * FROM Doctor WHERE dID = '$doctor_id'";
                $result = mysqli_query($link, $query);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $doctor = mysqli_fetch_assoc($result);
                        ?>
            <h2 id="inline-delete" class="form-title">Update Doctor</h2>

            <form action="delete_doctor.php" method="post" onsubmit="return confirmDelete()" id="inline-delete"
                class="changing-form">
                <label>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor['dID']; ?>">
                    <input type="submit" value="Delete" class="button-delete">
                </label>
            </form>

            <form action="update_doctor.php" method="post" enctype="multipart/form-data" class="changing-form">
                <label>
                    <span>Doctor ID:
                    </span>
                    <p><?php echo $doctor['dID'] ?></p>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor['dID']; ?>">
                </label>
                <label>
                    <span> First name:</span>
                    <input type="text" name="first_name" value="<?php echo $doctor['first_name']; ?>">
                </label>
                <label>
                    <span>Last name:</span>
                    <input type="text" name="last_name" value="<?php echo $doctor['last_name']; ?>">
                </label>
                <label>
                    <span>Speciality:</span>
                    <input type="text" name="speciality" value="<?php echo $doctor['speciality']; ?>">
                </label>
                <label>
                    <br>
                    <span>Image:</span>
                    <img src="<?php if (file_exists($doctor['dImage'])) {echo $doctor['dImage'];} else {echo "default.png";} ?>"
                        alt="Dr. <?php echo $doctor['first_name'] ?>'s photo">
                    <input type="file" name="image">
                    <?php
                        if (isset($_FILES['image'])) {
                            $file_tmp = $_FILES['image']['tmp_name'];
                            $upload_dir = "uploads/";
                            move_uploaded_file($file_tmp, $upload_dir . $doctor_id);
                            $file_name = $doctor_id . "_" . $_FILES['image']['name'];
                            $image_path = $upload_dir . $file_name;
                        }
                        ?>
                </label>
                <label>
                    <input type="submit" class="button-submit">
                </label>
            </form>

            <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete doctor ID: <?php echo $doctor_id?>?");
            }
            </script>

            <?php
                    } else {
                        echo "error:" . mysqli_error($link);
                    }
                    mysqli_free_result($result);
                }
            }
            mysqli_close($link);
            ?>
        </div>

</body>

</html>