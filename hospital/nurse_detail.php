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
        <div id="side-nav" class="sidenav">
        <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>

        <div class="nav">
            <div class="D">
                <a class="hometitle">Nurse</a>
                <?php
                session_start();
                include('config.php');

                if (isset($_GET['dID'])) {
                    $doctor_id = $_GET['dID'];
                    $query = "SELECT * FROM nurse WHERE dID = ?";
                    $stmt = mysqli_prepare($link, $query);
                    mysqli_stmt_bind_param($stmt, "s", $doctor_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            $doctor = mysqli_fetch_assoc($result);
                            // 检查当前登录用户是否有权限编辑该医生的资料
                            if (isset($_SESSION['username']) && $_SESSION['username'] === $doctor['dID']) {
                                ?>
                                <a href="edit_nurse.php?dID=<?php echo $doctor['dID']; ?>"><i class="fa-solid fa-pencil"></i>Edit Nurse</a>
                                <?php
                            }
                        } else {
                            echo "Doctor not found.";
                        }
                        mysqli_free_result($result);
                    } else {
                        echo "Error:" . mysqli_error($link);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Doctor ID not provided.";
                }
                ?>
            </div>
        </div>

        <?php
        $dID = isset($_GET['dID']) ? $_GET['dID'] : '';

        if ($dID) {
            $sql = "SELECT s.dID, s.first_name, s.last_name, s.hName, s.contact, n.period
                    FROM staff s
                    LEFT JOIN nurse n ON s.dID = n.dID
                    WHERE s.dID = ?";
            
            $stmt = $link->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $dID);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc(); ?>
                    <div class="all">
                        <div class="provider_info">
                            <div class="profile_picture">
                                <img src="doc1.jpg" alt="doc1">
                            </div>
                            <div class="name_info">
                                <h1><?php echo $row["first_name"]. "," . $row["last_name"]; ?></h1>
                                <p>Period:<?php echo $row["period"]; ?>years</p>
                                <hr>
                                <div class="contact">
                                    <p>Contact:<?php echo $row["contact"]; ?></p>
                                </div>
                                <div class="locations">
                                    <h2>Location</h2>
                                    <p><?php echo $row["hName"]; ?></p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <?php
                } else {
                    echo "No relevant data found.";
                }
                $stmt->close();
            } else {
                echo "Database query preparation failed: " . $link->error;
            }
        } else {
            echo "dID parameter missing";
        }
       
        ?>
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
                // 查詢排班資訊，包含醫生的相關資訊
                $sql = "SELECT schedule.*, staff.first_name, staff.last_name 
                        FROM schedule 
                        INNER JOIN staff ON staff.dID = schedule.dID
                        INNER JOIN nurse ON nurse.dID = schedule.dID  
                        WHERE staff.dID = :doctorID
                        ORDER BY schedule.day, schedule.time";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':doctorID', $doctorID, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // 如果查詢結果不為空，則顯示排班表
                if (count($result) > 0) {
                    echo "<table border='1'>";
                    echo "<tr><th>Day</th><th>Time</th><th>Patiemt</th></tr>";
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["day"] . "</td>";
                        echo "<td>" . $row["time"] . "</td>";
                        echo "<td>" . $row["patient"]. "</td>";
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

    <div class="last">
        <div class="footer">
            <p class="end">©2024 University of Medical Center</p>
        </div>
    </div>

</body>

</html>
