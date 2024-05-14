<?php
include('config.php');

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // 使用參數化查詢來防止 SQL 注入攻擊
    $sql = "SELECT * FROM users WHERE userID=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($user=mysqli_fetch_assoc($result)){
        // 驗證密碼是否正確
        if(password_verify($password, $user["password"])){
            // 登入成功，導向到 doctor.php 頁面
            header("Location: login.php");
            exit();
        } else {
            // 密碼不匹配的錯誤訊息
            $error_message = "Password does not match!";
        }
    } else {
        // 使用者名稱不存在的錯誤訊息
        $error_message = "Username is not valid!";
    }
}
?>



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
    <!--<div class="container-fluid">
         <div id="login">
            <form method="post" action="doctor.php">
                User:
                <input type="text" name="username">
                Password:
                <input type="password" name="password">
                <input type="submit" value="Login" name="submit">
                <a href="register.php">Register now</a>
                <?php if(isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
            </form>
        </div> -->

        <!-- 其他內容 -->
    </div>
    <div class="container-fluid">
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
            <a href="" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
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

                <?php


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
                    <a href="add_doctor.php"></i>Add nurse</a>
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
                    <a href="staff_detail.php?dID=<?php echo $row['dID']?>">
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
    <div class="search">
        <form action="search.php" method="get">
            <!-- <label for="search">Enter some keyword:</label><br> -->
            <input type="text" id="search" name="query" placeholder="Search something?">
            <button id="btn" type="submit">Search</button>
        </form>
    </div>
</body>

</html>