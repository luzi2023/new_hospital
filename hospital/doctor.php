<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="styles.css" />

    <title>Local hospital</title>
</head>

<body>
    <div class="container-fluid">
        <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.html">register now</a>
            </form>
        </div>
        <div id="side-nav" class="sidenav">
            <a href="index.php" id="home">Home</a>
            <a href="doctor.php" id="doctors">Doctors</a>
            <a href="" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
        </div>

        <div id="body">
            <h1>Doctor List</h1>
            <div class="doctor_menu">
                <a href="add_doctor.php">Add doctor</a>
            </div>

            <?php
            include('config.php');

            $query = "SELECT * FROM Doctor";
            $query_run =mysqli_query($link, $query);

            ?>
            <div class="print_doc">
                <?php
                if (mysqli_num_rows($query_run) > 0) {
                    foreach ($query_run as $row) {
                        ?>
                <a href="edit_doctor.php?dID=<?php echo $row['dID']?>">
                    <div class="current_list">
                        <img src="<?php echo $row['dImage']; ?>" alt="Dr.<?php $row['first_name']?>'s head shot">
                        <p> <?php echo $row['last_name'].', '.$row['first_name']?> </p>
                        <p> <?php echo $row['speciality'] ?> </p>
                    </div>
                </a>
                <?php
                    }
                } else {
                    echo "Sorry, there is no existed doctor.";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>