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
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>

       
    
        <div class="nav">
                <div class="D">
                    <!-- <i class="fa-solid fa-plus"></i> -->
                    <a class="hometitle">Doctor</a>
                    <?php
include('config.php');

// 检查是否设置了dID参数
if (isset($_GET['dID'])) {
    // 将dID参数转换为整数
    $doctor_id = $_GET['dID'];

    // 查询医生信息
    $query = "SELECT * FROM doctor WHERE dID = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $doctor_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 检查查询是否成功
    if ($result) {
        // 检查是否有医生记录
        if (mysqli_num_rows($result) > 0) {
            // 获取医生数据
            $doctor = mysqli_fetch_assoc($result);
            // 显示编辑链接
            ?>
            <a href="edit_doctor.php?dID=<?php echo $doctor['dID']; ?>"><i class="fa-solid fa-pencil"></i>Edit Doctor</a>
            <?php
        } else {
            // 如果未找到医生记录，则显示消息
            echo "Doctor not found.";
        }
        
        // 释放结果集
        mysqli_free_result($result);
    } else {
        // 如果查询失败，则显示错误消息
        echo "Error:" . mysqli_error($link);
    }

    // 关闭prepared statement
    mysqli_stmt_close($stmt);
} else {
    // 如果未设置dID参数，则显示错误消息
    echo "Doctor ID not provided.";
}



// 关闭数据库连接

?>
                </div>
        </div>

        
        <div class = "all">
            <div class="provider_info">
                <div class="profile_picture">
                    <img src="doc1.jpg" alt="doc1">
                </div>
                <div class="name_info">
                    <h1>Kim Bruce Abell, M.D.</h1>
                    <p>Family Medicine , Primary Care</p>
                    <hr>
                    <div class="contact">
                        <p>Office: (585) 598-8505</p>
                        <p>Fax: (585) 598-8122</p>
                    </div>
                    <div class="locations">
                        <h2>Locations</h2>
                        <p>Penfield Family Medicine</p>
                        <p>2212 Penfield Road, Suite 100</p>
                        <p>Penfield, NY 14526</p>
                    </div>
                </div>
            </div>

            <div class="about_me">
                <h2>About Me</h2>
                <p>Dr. Abell received his medical degree from the University of Vermont College of Medicine. He completed his
                    internship and residency at Fletcher Allen Health Care at the University of Vermont in 1999. He is certified
                    by the Board of Family Medicine. He was inducted into the Fellowship of the American...</p>
            </div>
            
            <div class="Certified_Specialties">
                <h2>Certified Specialties</h2>
                <p>Family Medicine - American Board of Family Medicine</p>
            </div>

            <div class="credentials">
                <h2>Credentials</h2>
                <p>Residency, Family Medicine, Fletcher Allen Health Care. 1997 - 1999</p>
                <p>Internship, Family Medicine, Fletcher Allen Health Care. 1996 - 1997</p>
            </div>

            <div class="Awards">
                <h2>Awards</h2>
                <p>Excellence in Family Medicine Mentorship. 2018</p>
                <p>Resident Teacher Award, Society of Teachers of Family Medicine. 1999</p>
                <p>Vermont Initiative for Rural Health Informatics and Telemedicine Award. 1999</p>
                <p>John P. Lord M.D. '42 Scholarship for Career in Family Practice. 1996</p>
            </div>

            <div class="publications">
                <h2>Publications</h2>
                <h3>Journal Articles</h3>
                <p>HS Cuckle; NJ Walk; JW Densem; JA Canick; KB Abell.</p>
                <p>British Journal of Obstetrics & Gynecology. 1991; 98: 1160-1162.</p>
            </div>
        </div>
    </div>

    

    <div class="schedule-info">
    <h2>Schedule</h2>
    <?php
try {
    $db = new PDO("mysql:host=localhost;dbname=hospital;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 取得 URL 中的 dID 參數
    $doctorID = isset($_GET['dID']) ? $_GET['dID'] : '';

    if ($doctorID) {
        // 查詢對應醫生的排班信息
        $sql = "SELECT schedule.*, staff.first_name, staff.last_name 
                FROM schedule 
                INNER JOIN staff ON staff.dID = schedule.dID 
                WHERE staff.dID = :doctorID
                ORDER BY schedule.day, schedule.time";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':doctorID', $doctorID, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 如果查詢結果不為空，則顯示排班表
        if (count($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Day</th><th>Time</th><th>Patient</th></tr>";
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row["day"] . "</td>";
                echo "<td>" . $row["time"] . "</td>";
                echo "<td>" . $row["patient"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No schedule information available for this doctor.";
        }
    } else {
        echo "Doctor ID is missing.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


</div>



    <!-- <footer>
        <nav>
            <ul>
                <li><a href="#">About UR Medicine</a></li>
                <li><a href="#">Equity & Anti-Racism Action Plan</a></li>
                <li><a href="#">Newsroom</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </nav>
        <p>©2024 University of Medical Center</p>
    </footer> -->

    <?php

if (isset($_GET['dID'])) {
    // 將dID參數轉換為整數
    $doctor_id = $_GET['dID'];

    $patients_query = "SELECT patient.pNo, patient.pname
                        FROM patient 
                        JOIN doctor ON patient.doctorID = doctor.dID
                        WHERE doctor.dID = '$doctor_id'";

    $patients_result = mysqli_query($link, $patients_query);

    if(mysqli_num_rows($patients_result) > 0) {
        // 如果有病患
        echo "<h2 id='patient-heading'>My patients</h2>";
        echo "<ul id='patient-list'>";
        while($patient_row = mysqli_fetch_assoc($patients_result)) {
            // 顯示病患的連結
            echo "<li><a href='patient.php?pNo={$patient_row['pNo']}'>{$patient_row['pname']}</a></li>";
        }
        echo "</ul>";
    } else {
        // 如果沒有病患
        echo "<p id='nope'>No patients found!</p>";
    }
} else {
    // 如果未設置dID參數
    echo "<p>No doctor ID specified.</p>";
}


mysqli_close($link);
?>

    <div class="last">
        <div class="footer">
            <p class="end">©2024 University of Medical Center</p>
        </div>
    </div>

<body>

</html>