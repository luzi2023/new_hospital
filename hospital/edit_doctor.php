<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="styles.css" />

    <title>Local hospital</title>
</head>

<body>
    <div class="container-fluid2">
        <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.php">register now</a>
            </form>
        </div>
        <div id="side-nav" class="sidenav">
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>

        <div id="body">
            <?php
            include('config.php');

            if (isset($_GET['dID'])) {
                // 将 dID 参数转换为整数
                $doctor_id = $_GET['dID'];

                // 使用 prepared statement 来避免 SQL 注入攻击
                $query = "SELECT * FROM staff JOIN doctor WHERE staff.dID = doctor.dID AND doctor.dID = ?";

                // 准备 SQL 查询
                $stmt = mysqli_prepare($link, $query);

                // 绑定参数
                mysqli_stmt_bind_param($stmt, "s", $doctor_id);

                // 执行查询
                mysqli_stmt_execute($stmt);

                // 获取结果
                $result = mysqli_stmt_get_result($stmt);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $doctor = mysqli_fetch_assoc($result);
                        // 在这里输出编辑表单，使用 $doctor 中的信息
                    } else {
                        echo "Doctor not found.";
                    }
                    mysqli_free_result($result);
                } else {
                    echo "Error:" . mysqli_error($link);
                }

                // 关闭 prepared statement
                mysqli_stmt_close($stmt);
            }

            
            ?>


            <h2 id="inline-delete" class="form-title">Update Doctor</h2>

            <form action="delete_doctor.php" method="post" onsubmit="return confirmDelete()" id="inline-delete"
                class="changing-form">
                <label>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor['dID']; ?>">
                    <input type="submit" value="Delete" class="button-delete">
                </label>
            </form>

            <form action="update_doctor.php" method="post" enctype="multipart/form-data" class="changing-form">
                <label>
                    <span>Doctor ID:
                    </span>
                    <p><?php echo $doctor['dID'] ?></p>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor['dID']; ?>">
                </label>
                <!-- 其他表单元素 -->

            </form>

            <script>
                function confirmDelete() {
                    return confirm("Are you sure you want to delete doctor ID: <?php echo $doctor_id ?>?");
                }
            </script>

            <?php
            // Get doctor schedule information
            $query = "SELECT sID, dID, day, time, patient FROM schedule WHERE dID = ? ORDER BY day, time";
            $stmt = mysqli_prepare($link, $query);
            if (!$stmt) {
                die("Failed to prepare statement: " . mysqli_error($link));
            }
            mysqli_stmt_bind_param($stmt, "s", $doctor_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table border='1'>";
                echo "<tr><th>sID</th><th>Day</th><th>Time</th><th>Patient</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["sID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["day"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["time"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["patient"]) . "</td>";
                    echo "<td>
                            <form method='post' action='delete_schedule.php'>
                                <input type='hidden' name='schedule_id' value='" . htmlspecialchars($row['sID']) . "'>
                                <input type='hidden' name='doctor_id' value='" . htmlspecialchars($doctor_id) . "'>
                                <input type='submit' value='Delete' class='button-delete'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No schedule information available.";
            }
            ?>

            <?php
            mysqli_free_result($result);
            mysqli_stmt_close($stmt);
            mysqli_close($link);
            ?>

            <h2 class="form-title">Add Schedule</h2>
            <form action="add_schedule.php" method="post" enctype="multipart/form-data" class="changing-form2">
                <!-- Add a hidden input field to pass the doctor_id -->
                <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                <label>
                    <!-- 其他表单元素 -->
                </label>
                <input type="submit" value="Add Schedule" class="button">
            </form>
        </div>
    </div>
</body>

</html>
