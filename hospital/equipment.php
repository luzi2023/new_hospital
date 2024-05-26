<?php
include('config.php');
$sql = "SELECT * FROM equipment JOIN users WHERE userID = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $dID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
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
    <div class="container-fluid"></div>
    <div class="tab">
        <a href="index.php"><button class="tablinks">Home</button></a>
    </div>
    <div class="tab_fix"></div>
    <div class="container-fluid3">
        <div id="side-nav" class="sidenav">
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
        <h1>Equipments List <a href="add_equipment.php"><button class="equip_Abtn">Add Equipment</button></a></h1>
        <div class="dropdown">
            <button onclick="myFunction()" class="equipment-search-button">Sort in</button>
            <div id="myDropdown" class="dropdown-content">
                <p onclick="sort('most_used')">The most used</p>
                <p onclick="sort('common_combination')">The most used combination</p>
                <p onclick="sort('default')">Default</p>
            </div>
        </div>
        <form id="sortForm" method="GET" action="">
            <input type="hidden" name="sort" id="sortInput">
        </form>
        <form action="equipment_search.php">
            <label for="search"></label>
            <input type="submit" value="Search" class="equipment-search-button">
        </form>

        <?php
        $Option = isset($_GET['sort']) ? $_GET['sort'] : 'default';

        switch ($Option) {
            case 'most_used':
                $sort = "SELECT e.eID, e.eName, e.purchaseDate, e.manufacturer, e.useStatus,
                        COUNT(t.usedEquip) AS usedEquip_count
                        FROM equipment AS e
                        LEFT JOIN treatment AS t ON e.eName = t.usedEquip
                        GROUP BY e.eID, e.eName, e.purchaseDate, e.manufacturer, e.useStatus
                        ORDER BY usedEquip_count DESC";
                break;
            case 'common_combination':
                $sort = "SELECT e.eName, t.tName, m.mName,
                        COUNT(*) AS used_count 
                        FROM medical_history AS mh
                        JOIN treatment AS t ON mh.treatment = t.tName 
                        JOIN medication AS m ON mh.prescription = m.mName
                        JOIN equipment AS e ON t.usedEquip = e.eName
                        GROUP BY e.eName, t.tName, m.mName
                        ORDER BY used_count DESC
                        LIMIT 10";
                break;
            default:
                $sort = "SELECT * FROM equipment";
                break;
        }

        $result = mysqli_query($link, $sort);
        ?>

        <table class="equipment-table">
            <thead>
                <tr>
                    <?php if ($Option == 'common_combination'): ?>
                        <th>Equipment Name</th>
                        <th>Treatment Name</th>
                        <th>Medicine Name</th>
                        <th>Number of combination Used</th>
                    <?php else: ?>
                        <th>eID</th>
                        <th>eName</th>
                        <th>Purchase Date</th>
                        <th>Status</th>
                        <th>Manufacturer</th>
                        <th>Reservation</th>
                        <?php if ($Option == 'most_used'): ?>
                            <th>Number of Treatment Used</th>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($Option == 'common_combination') {
                            ?>
                            <tr>
                                <td><?php echo $row['eName']; ?></td>
                                <td><?php echo $row['tName']; ?></td>
                                <td><?php echo $row['mName']; ?></td>
                                <td><?php echo $row['used_count']; ?></td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr>
                                <td><a href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['eID']; ?></a></td>
                                <td><a href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['eName']; ?></a></td>
                                <td><?php echo $row['purchaseDate']; ?></td>
                                <td><?php echo $row['useStatus']; ?></td>
                                <td><?php echo $row['manufacturer']; ?></td>
                                <td><a href="equipment_reserve.php?eID=<?php echo $row['eID']; ?>&dID=<?php echo $dID; ?>">Reserve</a></td>
                                <?php if ($Option == 'most_used'): ?>
                                    <td><?php echo $row['usedEquip_count']; ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>

    </div>
    <script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function sort(value) {
        document.getElementById("sortInput").value = value;
        document.getElementById("sortForm").submit();
    }

    window.onclick = function(event) {
        if (!event.target.matches('.equipment-search-button')) {
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
</body>

</html>
