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
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
        <h1>Equipments List</h1>
        <form action="equipment_search.php">
            <label for="search"></label>
            <input type="submit" value="Search" class="treatment-search-button">
        </form>
        <?php
        $query = "SELECT * FROM Equipment";
        $result = mysqli_query($link, $query);
        ?>
        <table class="equipment-table">
            <th>eID</th>
            <th>eName</th>
            <th>purchase date</th>
            <th>Status</th>
            <th>manufacturer</th>
            <div class="equipment-table-list">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    foreach ($result as $row) {
                        ?>
                <tr>
                    <td><a href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['eID']; ?></a></td>
                    <td><a href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['eName']; ?></a>
                    </td>
                    <td><a
                            href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['purchaseDate']; ?></a>
                    </td>
                    <td><a href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['useStatus']; ?></a>
                    </td>
                    <td><a
                            href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['manufacturer']; ?></a>
                    </td>

                </tr>
                <?php
                    }
                }
                ?>
            </div>
        </table>
</body>

</html>