<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/4bfa319983.js" crossorigin="anonymous"></script>
    <title>Local hospital</title>
    <?php
    include('config.php');
    ?>
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

        <h1>Equipments List</h1>
        <form action="equipment_search.php" method="post">
            <label for="search"></label>
            <input type="text" class="equipment-search-box" name="search"
                value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
            <input type="submit" value="Search" class="equipment-search-button">

            <div class="search-checkbox">
                <label><input type="checkbox" name="fields[]" value="eID" checked> eID</label>
                <label><input type="checkbox" name="fields[]" value="eName" checked> Name</label>
                <label><input type="checkbox" name="fields[]" value="purchaseDate" checked> Purchase Date</label>
                <label><input type="checkbox" name="fields[]" value="manufacturer" checked> Manufacturer</label>

            </div>
        </form>
        <div class="equipment-body-list">
            <table class="equipment-table">
                <tr>
                    <th>eID</th>
                    <th>eName</th>
                    <th>purchase date</th>
                    <th>Status</th>
                    <th>manufacturer</th>
                </tr>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $search_value = $_POST["search"];
                    $fields = $_POST["fields"];

                    $query = "SELECT * FROM equipment WHERE ";
                    $conditions = [];

                    foreach ($fields as $field) {
                        $conditions[] = "$field LIKE '%$search_value%'";

                    }
                    $query .= implode(" OR ", $conditions);

                    $result = mysqli_query($link, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                <tr>
                    <td><a href="
                equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['eID']; ?></a>
                    </td>
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
                        } else {
                        echo "<tr><td colspan='3'>No results found.</td></tr>";
                    }
                }
                ?>
            </table>
        </div>
        <?php
    ?>



</body>

</html>