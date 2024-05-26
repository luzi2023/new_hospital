<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="styles.css" />
    <title>Local hospital</title>
    <?php include('config.php'); ?>
</head>

<body>
    <div class="container-fluid2">
        <div id="side-nav" class="sidenav">
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>

        <div class="equip_detail">
            <?php
            if (isset($_GET['eID'])) {
                $equip_ID = $_GET['eID'];
                $query = "SELECT * FROM Equipment WHERE eID = $equip_ID";
                $result = mysqli_query($link, $query);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $equip = mysqli_fetch_assoc($result);
                        ?>
                        <h1>No. <?php echo $equip['eID']; ?> Equipment<a href="delete_equipment.php?eID=<?php echo $equip['eID']; ?>"><button class="equip_Dbtn">Delete</button></a></h1>
                        <p>Name: <?php echo $equip['eName']; ?></p>
                        <p>Purchase Date: <?php echo $equip['purchaseDate']; ?></p>
                        <p>Status: <?php echo $equip['useStatus']; ?></p>
                        <p>Manufacturer: <?php echo $equip['manufacturer']; ?></p>
                        <a href="edit_equipment.php?eID=<?php echo $equip['eID']; ?>"><button class="equip_Ebtn">Edit</button></a>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</body>

</html>
