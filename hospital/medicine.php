<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="medicine.css" />
    
    <title>Local hospital</title>
</head>

<body>
    <div class="container-fluid">
        <div id="side-nav" class="sidenav">
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
    </div>

    <div id="doctor" class="tabcontent">
        <div id="list_body">
            <h1>Medicine List</h1>

            <?php
            include('config.php');

            $query = "SELECT mID, mName, mType FROM medication";
            $query_run = mysqli_query($link, $query);

            if (mysqli_num_rows($query_run) > 0) {
                echo '<div class="hospital-list">'; // 新增外層 div
                while ($row = mysqli_fetch_assoc($query_run)) {
            ?>
                    <div class="hospital">
                        <a href="medicine_detail.php?mID=<?php echo $row['mID']; ?>" class="medicine-link">
                            <img src="th.jpg" alt="Medication Image">
                            <div>
                                <p><strong>Medication Name:</strong> <?php echo $row['mName']; ?></p>
                                <p><strong>Type:</strong> <?php echo $row['mType']; ?></p>
                            </div>
                        </a>
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
        <form action="search_medicine.php" method="get">
            <input type="text" id="search" name="query" placeholder="Search something?">
            <button id="btn" type="submit">Search</button>
        </form>
    </div>
</body>

</html>
