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
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
        </div>

        <div>
            <?php
            if (isset($_GET['eID'])) {
                $equip_ID = $_GET['eID'];

                $query = "SELECT * FROM Equipment WHERE eID = $equip_ID";
                $result = mysqli_query($link, $query);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $equip = mysqli_fetch_assoc($result);
                        ?>
            <h1>No. <?php echo $equip['eID']; ?> Equipment</h1>
            <p>Name: <?php echo $equip['eName']; ?></p>
            <p>Purchase Date: <?php echo $equip['purchaseDate']; ?></p>
            <p>Status: <?php echo $equip['useStatus']; ?></p>
            <p>Manufacturer: <?php echo $equip['manufacturer']; ?></p>
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</body>

</html>