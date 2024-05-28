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
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>

        <h1>Treatment Option</h1>
        <form action="treatment_search.php" method="post">
            <label for="search"></label>
            <input type="text" class="treatment-search-box" name="search"
                value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
            <input type="submit" value="Search" class="treatment-search-button-inpage">

            <div class="search-checkbox">
                <label><input type="checkbox" name="fields[]" value="tID" checked> tID</label>
                <label><input type="checkbox" name="fields[]" value="tName" checked> tName</label>
                <label><input type="checkbox" name="fields[]" value="tType" checked> tType</label>
            </div>
        </form>

        <div class="treatment-body-list">
            <table class="treatment-table">
                <tr>
                    <th>tID</th>
                    <th>tName</th>
                    <th>tType</th>
                </tr>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $search_value = $_POST["search"];
                    $fields = $_POST["fields"];

                    $query = "SELECT * FROM treatment WHERE ";
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
                treatment_view.php?tID=<?php echo $row['tID']; ?>"><?php echo $row['tID']; ?></a>
                    </td>
                    <td><a href="treatment_view.php?tID=<?php echo $row['tID']; ?>"><?php echo $row['tName']; ?></a>
                    </td>
                    <td><a href="treatment_view.php?tID=<?php echo $row['tID']; ?>"><?php echo $row['tType']; ?></a>
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