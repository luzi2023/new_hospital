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
        <!--<div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.php">register now</a>
            </form>
        </div>-->
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
                $doctor_id = $_GET['dID'];
                $query = "SELECT * FROM staff JOIN nurse WHERE staff.dID = nurse.dID AND nurse.dID = ?";
                $stmt = mysqli_prepare($link, $query);
                mysqli_stmt_bind_param($stmt, "s", $doctor_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $doctor = mysqli_fetch_assoc($result);
                    } else {
                        echo "Nurse not found.";
                    }
                    mysqli_free_result($result);
                } else {
                    echo "Error: " . mysqli_error($link);
                }
                mysqli_stmt_close($stmt);
            }

            function isScheduleOverlap($link, $doctor_id, $day, $time){
                $query = "SELECT COUNT(*) AS count FROM schedule WHERE dID = ? AND day = ? AND time = ?";
                $stmt = mysqli_prepare($link, $query);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $doctor_id, $day, $time);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $count);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                    return $count > 0;
                } else {
                    die("Failed to prepare statement: " . mysqli_error($link));
                }
            }

            if (isset($_POST['update_schedule'])) {
                $schedule_id = $_POST['schedule_id'];
                $day = $_POST['day'];
                $time = $_POST['time'];

                if (!isScheduleOverlap($link, $doctor_id, $day, $time)) {
                    $update_query = "UPDATE schedule SET day=?, time=? WHERE sID=?";
                    $update_stmt = mysqli_prepare($link, $update_query);
                    mysqli_stmt_bind_param($update_stmt, "sss", $day, $time, $schedule_id);
                    mysqli_stmt_execute($update_stmt);
                    mysqli_stmt_close($update_stmt);
                }
                // Redirect to edit_nurse.php regardless of success or failure
                header("Location: edit_nurse.php?dID=" . $doctor_id);
                exit();
            }
            ?>



            <h2 id="inline-delete" class="form-title">Update Nurse</h2>

            <form action="delete_nurse.php" method="post" onsubmit="return confirmDelete()" id="inline-delete"
                class="changing-form">
                <label>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor['dID']; ?>">
                    <input type="submit" value="Delete" class="button-delete">
                </label>
            </form>

            <form action="update_nurse.php" method="post" enctype="multipart/form-data" class="changing-form">
                <label>
                    <span>Nurse ID:
                    </span>
                    <p><?php echo $doctor['dID'] ?></p>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor['dID']; ?>">
                </label>
                <label>
                    <span> First name:</span>
                    <input type="text" name="first_name" value="<?php echo $doctor['first_name']; ?>">
                </label>
                <label>
                    <span>Last name:</span>
                    <input type="text" name="last_name" value="<?php echo $doctor['last_name']; ?>">
                </label>
                <label>
                    <span>Period:</span>
                    <input type="text" name="period" value="<?php echo $doctor['period']; ?>">
                </label>
                <label>
                    <span>Contact:</span>
                    <input type="text" name="contact" value="<?php echo $doctor['contact']; ?>">
                </label>
                <label>
                    <span>Hospital:</span>
                    <select name="hName" class="hospital-drag-list">
                        <option value="Marshall Medical Centers">Marshall Medical Centers</option>
                        <option value="Greene County Hospital">Greene County Hospital</option>
                    </select>
                </label>

                <label>
                    <br>
                    <span>Image:</span>
                    <img src="<?php if (file_exists($doctor['dImage'])) {echo $doctor['dImage'];} else {echo "default.png";} ?>"
                        alt="Dr. <?php echo $doctor['first_name'] ?>'s photo">
                    <input type="file" name="image">
                    <?php
                        if (isset($_FILES['image'])) {
                            $file_tmp = $_FILES['image']['tmp_name'];
                            $upload_dir = "uploads/";
                            move_uploaded_file($file_tmp, $upload_dir . $doctor_id);
                            $file_name = $doctor_id . "_" . $_FILES['image']['name'];
                            $image_path = $upload_dir . $file_name;
                        }
                        ?>
                </label>
                <label>
                    <input type="submit" class="button-submit">
                </label>
            </form>

            <?php
            $query = "SELECT sID, dID, day, time, patient FROM schedule WHERE dID = ? ORDER BY day, time";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, "s", $doctor_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                echo "<form method='post'>";
                echo "<table border='1'>";
                echo "<tr><th>sID</th><th>Day</th><th>Time</th><th>Actions</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["sID"]) . "</td>";
                    echo "<td>
                            <input type='hidden' name='schedule_id' value='" . htmlspecialchars($row["sID"]) . "'>
                            <select name='day'>";
                    for ($i = 1; $i <= 7; $i++) {
                        echo "<option value='$i'" . ($row["day"] == $i ? ' selected' : '') . ">$i</option>";
                    }
                    echo "      </select>
                          </td>";
                    echo "<td>
                            <select name='time'>
                                <option value='morning'" . ($row["time"] == 'morning' ? ' selected' : '') . ">morning</option>
                                <option value='afternoon'" . ($row["time"] == 'afternoon' ? ' selected' : '') . ">afternoon</option>
                                <option value='evening'" . ($row["time"] == 'evening' ? ' selected' : '') . ">evening</option>
                            </select>
                          </td>";
                    echo "<td>
                            <input type='submit' name='update_schedule' value='Update' class='button-submit'>
                            <form method='post' action='delete_Nschedule.php' style='display:inline;'>
                                <input type='hidden' name='schedule_id' value='" . htmlspecialchars($row['sID']) . "'>
                                <input type='hidden' name='doctor_id' value='" . htmlspecialchars($doctor_id) . "'>
                                <input type='submit' value='Delete' class='button-delete'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</form>";
            } else {
                echo "No schedule information available.";
            }
            mysqli_free_result($result);
            mysqli_stmt_close($stmt);
            mysqli_close($link);
            ?>

            <h2 class="form-title">Add Schedule</h2>
            <form action="add_Nschedule.php" method="post" enctype="multipart/form-data" class="changing-form2">
                <!-- Add a hidden input field to pass the doctor_id -->
                <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                <label>
                    <span>sID:</span>
                    <input type="text" name="sID" class="input-column">
                </label>
                <label>
                    <span>Day:</span>
                    <select name="day" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select>
                </label>
                <label>
                    <span>Time:</span>
                    <select name="time" required>
                        <option value="Morning">morning</option>
                        <option value="Afternoon">afternoon</option>
                        <option value="Evening">evening</option>
                    </select>
                </label>
                <input type="submit" value="Add Schedule" class="button">
            </form>
        </div>
    </div>
</body>
</html>
