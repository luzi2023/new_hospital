<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="styles.css" />

    <title>Local hospital</title>

    <?php
    include('config.php');
    ?>
</head>

<body>
    <div class="container-fluid2">
        <!-- <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.php">register now</a>
            </form>
        </div> -->
        <div id="side-nav" class="sidenav">
        <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>

        <div id="body">

    <?php
    if (isset($_GET['schedule_id'])) {
        $schedule_id = $_GET['schedule_id'];

        // 假設你已經連接到了資料庫
        // 在這裡執行查詢以獲取班表資訊

        // 假設你已經從資料庫中獲取了班表資訊並存儲在 $schedule 變數中
        // 在這裡顯示班表資訊並提供編輯表單
        ?>

        <h2 id="inline-delete" class="form-title">Update Schedule</h2>

        <form action="delete_schedule.php" method="post" onsubmit="return confirmDelete()" id="inline-delete"
            class="changing-form">
            <label>
                <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">
                <input type="submit" value="Delete" class="button-delete">
            </label>
        </form>

        <form action="update_schedule.php" method="post" class="changing-form">
            <label>
                <span>Schedule ID:</span>
                <p><?php echo $schedule['schedule_id']; ?></p>
                <input type="hidden" name="schedule_id" value="<?php echo $schedule['schedule_id']; ?>">
            </label>
            <label>
                <span>Day:</span>
                <input type="text" name="day" value="<?php echo $schedule['day']; ?>">
            </label>
            <label>
                <span>Time:</span>
                <input type="text" name="time" value="<?php echo $schedule['time']; ?>">
            </label>
            <label>
                <span>Doctor ID:</span>
                <input type="text" name="doctor_id" value="<?php echo $schedule['dID']; ?>">
            </label>
            <label>
                <input type="submit" value="Update" class="button-submit">
            </label>
        </form>

        <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete schedule ID: <?php echo $schedule_id; ?>?");
        }
        </script>

    <?php
    } else {
        echo "Schedule ID not provided.";
    }
    ?>
</div>

</body>

</html>

<!-- 提交表單 -->
<!-- <h2>Add New Schedule:</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="day">Day:</label>
        <input type="text" id="day" name="day"><br>

        <label for="time">Time:</label>
        <input type="text" id="time" name="time"><br>

        <label for="doctor_id">Patient:</label>
        <input type="text" id="doctor_id" name="doctor_id"><br> -->
