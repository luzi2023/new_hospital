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
    <div class="tab">
        <a href="index.php"><button class="tablinks">Home</button></a>
    </div>
    <div class="tab_fix"></div>
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
        <a id='addbtn'href="add_treatment.php"></i>Add treatment</a>
        <!-- search front, back end -->
        <div class="dropdown">
            <button onclick="myFunction()" class="treatment-search-button">Sort in ▼</button>
            <div id="myDropdown" class="dropdown-content">
                <p onclick="sort('most_used')">The most used</p>
                <p onclick="sort('default')">Default</p>
            </div>
        </div>
        <form id="sortForm" method="GET" action="">
            <input type="hidden" name="sort" id="sortInput">
        </form>
        <form action="treatment_search.php" class="button-form">
            <label for="search"></label>
            <input type="submit" value="Search" class="treatment-search-button">
        </form>

        <!-- option list -->
        <?php
        $Option = isset($_GET['sort']) ? $_GET['sort'] : 'default';

        switch($Option) {
        case 'most_used':
            $sort = "SELECT t.tID, t.tName, t.tType, COUNT(m.treatment) AS treatment_count
        FROM treatment AS t
        LEFT JOIN medical_history AS m ON BINARY m.treatment LIKE CONCAT('%', t.tName, '%')
        GROUP BY t.tID
        ORDER BY treatment_count DESC";
            break;
        case 'default':
            $sort = "SELECT * FROM treatment";
            break;
        default:
            $sort = "SELECT * FROM treatment";
            break;
        }

        // Execute the query
        $result = mysqli_query($link, $sort);
        ?>

        <table class="treatment-table">
            <thead>
                <tr>
                    <th>tID</th>
                    <th>tName</th>
                    <th>tType</th>
                    <?php if ($Option == 'most_used'): ?>
                    <th>Number of Patients Used</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    foreach ($result as $row) {
                        ?>
                <tr>
                    <td><a href="treatment_view.php?tID=<?php echo $row['tID']; ?>"><?php echo $row['tID']; ?></a></td>
                    <td><a href="treatment_view.php?tID=<?php echo $row['tID']; ?>"><?php echo $row['tName']; ?></a>
                    </td>
                    <td><a href="treatment_view.php?tID=<?php echo $row['tID']; ?>"><?php echo $row['tType']; ?></a>
                    </td>
                    <?php if ($Option == 'most_used'): ?>
                    <td><?php echo $row['treatment_count']; ?></td>
                    <?php endif; ?>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='4'>No results found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

function sort(value) {
    // Set the value of the hidden input field
    document.getElementById("sortInput").value = value;
    // Submit the form
    document.getElementById("sortForm").submit();
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.treatment-search-button')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
</script>

</html>
