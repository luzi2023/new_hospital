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
    <?php
    header("Refresh: 3; url=doctor.php");
    ?>
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
            <a href="index.html" id="home">Home</a>
            <a href="doctor.php" id="doctors">Doctors</a>
            <a href="" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
        </div>

        <div class="redirect-message">
            <?php
            if (isset($_POST['doctor_id'])) {
                $doctor_id = $_POST['doctor_id'];

                $query = "DELETE FROM Doctor WHERE dID = '$doctor_id'";

                $delete_success = mysqli_query($link, $query);

                if ($delete_success) {
                    echo "Doctor information deleted sucessfully!<br><br>";
                    echo "Redirect back to doctor page in 3 sec...";
                    ?>
            <!-- <br><br>
            <a href="doctor.php">Back to Doctors</a> -->
            <?php
                } else {
                    echo "Seems there's a problem when deleting...";
                }
            } else {
                echo "There's no existed doctor";
            }
            mysqli_close($link);
            ?>
        </div>

    </div>
</body>

</html>