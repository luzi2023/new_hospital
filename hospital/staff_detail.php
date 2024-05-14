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
                    <a href="edit_doctor.php?=<?php echo $doctor ?>"><i class="fa-solid fa-pencil"></i>edit doctor</a>
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

                    // 查詢排班資訊，包含醫生的相關資訊
                    $sql = "SELECT schedule.*, staff.first_name, staff.last_name 
                            FROM schedule 
                            INNER JOIN staff ON staff.dID = schedule.dID 
                            ORDER BY schedule.day, schedule.time";
                    $result = $db->query($sql);

                    // 如果查詢結果不為空，則顯示排班表
                    if ($result->rowCount() > 0) {
                        echo "<table border='1'>";
                        echo "<tr><th>Day</th><th>Time</th><th>Patiemt</th></tr>";
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row["day"] . "</td>";
                            echo "<td>" . $row["time"] . "</td>";
                            echo "<td>" . $row["patient"]. "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No schedule information available.";
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

    <div class="last">
        <div class="footer">
            <p class="end">©2024 University of Medical Center</p>
        </div>
    </div>

<body>

</html>