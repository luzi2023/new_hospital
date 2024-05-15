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
    <?php
    header("Refresh: 3; url=doctor.php");
    ?>
    <div class="redirect-message">
        <!-- <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.html">register now</a>
            </form>
        </div> -->
        <div id="side-nav" class="sidenav">
            <a href="index.html" id="home">Home</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
        </div>

        <div class="redirect-message">
        <?php


if (isset($_POST['doctor_id'])) {
    $doctor_id = $_POST['doctor_id'];

    // 使用外键约束删除医生信息和相关的员工信息
    $delete_query = "DELETE nurse, staff FROM nurse 
                    LEFT JOIN staff ON nurse.dID = staff.dID 
                    WHERE nurse.dID = '$doctor_id'";

    $delete_success = mysqli_query($link, $delete_query);

    if ($delete_success) {
        echo "Nurse information and related staff information deleted successfully!<br><br>";
        echo "Redirecting back to doctor page in 3 seconds...";
        // 最后进行页面重定向
        header("Refresh: 3; url=doctor.php");
        exit();
    } else {
        echo "Seems there's a problem when deleting...";
    }
} else {
    echo "No doctor ID provided for deletion.";
}

mysqli_close($link);
?>

        </div>

    </div>
</body>

</html>