<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/4bfa319983.js" crossorigin="anonymous"></script>
    <title>Local hospital</title>
    <script src="all.js"></script>
</head>


<body>
    <body onload="openCity(event, 'doctor')">
    <div class="container-fluid">
         <!--<div id="login">
            <form method="post" action="doctor.php">
                User:
                <input type="text" name="username">
                Password:
                <input type="password" name="password">
                <input type="submit" value="Login" name="submit">
                <a href="register.php">Register now</a>
                <?php if(isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
            </form>
        </div> 
        -->

        <!-- 其他內容 -->
    </div>
    <div class="container-fluid">
        <!-- <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.php">register now</a>
            </form>
        </div> -->
        <div id="side-nav" class="sidenav">
            <a href="index.php" id="home">Home</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
        <!-- Tab links -->
        <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'doctor')">Doctor List</button>
        <button class="tablinks" onclick="openCity(event, 'nurse')">Nurse List</button>
        </div>
        <div id="doctor" class="tabcontent">
            <div id="list_body">
                <h1>Doctor List</h1>
                <div class="doctor_menu">
                    <a href="add_doctor.php"></i>Add doctor</a>
                </div>
                <div class="search">
                <form action="search.php" method="get">
                <input type="text" id="search" name="query" placeholder="Search something?">
                 <button id="btn" type="submit">Search</button>
                 </form>
                </div>

                <?php
                
                include('config.php');

                $query = "SELECT * FROM staff, Doctor WHERE staff.dID = Doctor.dID";
                $query_run =mysqli_query($link, $query);

                ?>
                <div class="print_doc">
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                            ?>
                    <a href="staff_detail.php?dID=<?php echo $row['dID']?>">
                        <div class="current_list">
                            <img src="<?php if (file_exists($row['dImage'])) {echo $row['dImage'];} else {echo "default.png";} ?>"
                                alt="Dr.<?php $row['first_name']?>'s head shot">
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

        <div id="nurse" class="tabcontent">
            <div id="list_body">
                <h1>Nurse List</h1>
                <div class="doctor_menu">
                    <a href="add_nurse.php"></i>Add nurse</a>
                </div>
                <div class="search">
                <form action="search_nurse.php" method="get">
                <input type="text" id="search" name="query" placeholder="Search something?">
                 <button id="btn" type="submit">Search</button>
                 </form>
                </div>

                <?php


                $query = "SELECT * FROM staff, nurse  WHERE staff.dID = nurse.dID";
                $query_run =mysqli_query($link, $query);

                ?>
                <div class="print_doc">
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                            ?>
                    <a href="nurse_detail.php?dID=<?php echo $row['dID']?>">
                        <div class="current_list">
                            <img src="<?php if (file_exists($row['dImage'])) {echo $row['dImage'];} else {echo "default.png";} ?>"
                                alt="Dr.<?php $row['first_name']?>'s head shot">
                            <p><?php echo $row['last_name'].', '.$row['first_name']?> </p>
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