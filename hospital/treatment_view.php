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
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
        <div id="body">
            <?php
            if (isset($_GET['tID'])) {
                $cID = $_GET['tID'];

                $query = "SELECT * FROM treatment WHERE tID = '$cID'";
                $result = mysqli_query($link, $query);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $treatment = mysqli_fetch_assoc($result);
                        ?>
            <h1><?php echo $treatment['tName']; ?> </h1>
            <p>ID: <?php echo $treatment['tID']; ?></p>
            <p>Type: <?php echo $treatment['tType']; ?></p>

            <?php
                    }
                }
            }
            ?>
        </div>
    </div>

</body>

</html>