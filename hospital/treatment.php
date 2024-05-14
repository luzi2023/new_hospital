<?php
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/4bfa319983.js" crossorigin="anonymous"></script>
    <title>Local hospital</title>

</head>

<body>
    <div class="container-fluid">
        <!-- <div id="login">
            <form method="post" action="doctor.php">
                User:
                <input type="text" name="username">
                Password:
                <input type="password" name="password">
                <input type="submit" value="Login" name="submit">
                <a href="register.php">Register now</a>
                <?php
                // if(isset($error_message)) { echo "<p class='error'>$error_message</p>"; }
                ?>
            </form>
        </div> -->

        <!-- 其他內容 -->
    </div>
    <div class="container-fluid3">
        <!--<div id="login">
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
        <h1>Treatment Option</h1>
        <!-- search front, back end -->
        <form action="treatment_search.php">
            <label for="search"></label>
            <!-- <input type="text" class="treatment-search-box" name="search"> -->
            <input type="submit" value="Search" class="treatment-search-button">
            <!-- <div class="search-checkbox">
        <label for="cID">
            <input type="checkbox" name="cID" value="chargeID">chargeID
        </label>
        <label for="tName">
            <input type="checkbox" name="tName" value="tName" checked>tName
        </label>
        <label for="tType">
            <input type="checkbox" name="tType" value="tType">tType
        </label>
    </div> -->
        </form>

        <!-- option list -->
        <?php
    $query = "SELECT * FROM option_info";
    $action = mysqli_query($link, $query);
    ?>
        <table class="treatment-table">
            <tr>
                <th>chargeID</th>
                <th>tName</th>
                <th>
                    <label for="type">tType</label>
                </th>
            </tr>
            <div class="treatment-body-list">
                <?php
        if (mysqli_num_rows($action) > 0) {
            foreach ($action as $row) {
                ?>
                <tr>

                    <td><a
                            href="treatment_view.php?chargeID=<?php echo $row['chargeID']; ?>"><?php echo $row['chargeID']; ?></a>
                    </td>
                    <td><a
                            href="treatment_view.php?chargeID=<?php echo $row['chargeID']; ?>"><?php echo $row['tName']; ?></a>
                    </td>
                    <td><a
                            href="treatment_view.php?chargeID=<?php echo $row['chargeID']; ?>"><?php echo $row['tType']; ?></a>
                    </td>

                </tr>
                <?php
            }
        }
        ?>
        </table>
    </div>


    </div>
</body>

</html>