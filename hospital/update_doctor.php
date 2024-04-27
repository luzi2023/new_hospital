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
    ?> -->
</head>

<body>
    <div class="container-fluid">
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
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['first_name'], $_POST['last_name'], $_POST['speciality'])) {
                    $doctor_id = $_POST['doctor_id'];
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $speciality = $_POST['speciality'];

                    $query = "UPDATE Doctor SET first_name='$first_name', last_name='$last_name', speciality='$speciality' WHERE dID='$doctor_id' ";

                    if (mysqli_query($link, $query)) {
                        echo "Doctor information updated successfully.";
                    } else {
                        echo "ERROR: Could not able to execute $query." . mysqli_error($link);
                    }

                    mysqli_close($link);
                } else {
                    echo "ERROR: Incomplete date received.";
                }
            }
            ?>
        </div>
    </div>
</body>

</html>