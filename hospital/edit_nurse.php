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
            <a href="index.php" id="home">Home</a>
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
    $query = "SELECT * FROM staff JOIN nurse WHERE staff.dID = nurse.dID AND nurse.dID = ?";

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

mysqli_close($link);
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

            <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete nurse ID: <?php echo $doctor_id?>?");
            }
            </script>
        </div>
    </div>
</body>

</html>
