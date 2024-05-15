<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="hospital.css" />
    
    <title>Local hospital</title>
</head>

<body>
    <div class="container-fluid">
        <div id="side-nav" class="sidenav">
            <a href="index.php" id="home">Home</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
    </div>

    <div id="doctor" class="tabcontent">
        <div id="list_body">
            <h1>Hospital List</h1>

            <?php
            include('config.php');

            $query = "SELECT hName, hAddress FROM hospital";
            $query_run = mysqli_query($link, $query);

            if (mysqli_num_rows($query_run) > 0) {
                echo '<div class="hospital-list">'; // 新增外層 div
                foreach ($query_run as $row) {
            ?>
                    <div class="hospital">
                        <img src="pc.jpg" alt="Hospital Image">
                        <div>
                            <p><strong>Hospital Name:</strong> <?php echo $row['hName']; ?></p>
                            <p><strong>Address:</strong> <?php echo $row['hAddress']; ?></p>
                        </div>
                    </div>
            <?php
                }
                echo '</div>'; // 關閉外層 div
            } else {
                echo "No hospitals found.";
            }
            ?>
        </div>
    </div>

    <div class="search">
        <form action="hospital_search.php" method="get">
            <input type="text" id="search" name="query" placeholder="Search something?">
            <button id="btn" type="submit">Search</button>
        </form>
    </div>
</body>

</html>
