<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$dID = isset($_GET['userID']) ? $_GET['userID'] : '';

/*if (!$dID && isset($_SESSION['userID'])) {
    $dID = $_SESSION['userID'];
    header("Location: index.php?dID=" . urlencode($dID));
    exit;
}*/

include('config.php');

try {
    $db = new PDO("mysql:host=localhost;dbname=hospital;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $all_content = $db->query("SELECT * FROM doctor");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/4bfa319983.js" crossorigin="anonymous"></script>
    <title>Local hospital</title>
</head>
<body>
    <div class="container-fluid">
        <div id="side-nav" class="sidenav">
            <a href="medicine.php?dID=<?php echo urlencode($dID); ?>" id="home">Medicine</a>
            <a href="doctor.php?dID=<?php echo urlencode($dID); ?>" id="doctors">Staffs</a>
            <a href="equipment.php?dID=<?php echo urlencode($dID); ?>" id="equipments">Equipments</a>
            <a href="treatment.php?dID=<?php echo urlencode($dID); ?>" id="treatments">Treatments</a>
        </div>
        <div id="body">
            <div class="nav">
                <div class="plus">
                    <i class="fa-solid fa-plus"></i>
                    <a class="hometitle">Hospital Homepage</a>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <a href="logout.php" id="log"><i class="fa-solid fa-user"></i>Logout</a>
                    <?php else: ?>
                        <a href="login.php" id="log"><i class="fa-solid fa-user"></i>Login</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="positionfixed"></div>
            
            <p class="care">We Care About Your Health</p>
            <div class="detail">
                <img class="picture" src="health.jpg" alt="health">
            </div>
            <div class="fix1"></div>
            <div class="decor1">
                <img class="picture" src="medical.jpg" alt="medical">
            </div>
            <div class="fix2"></div>
            <div class="about">
                <div class="line">
                    <hr>
                </div>
                <div class="item">
                    <p>About</p>
                </div>
                <div class="line">
                    <hr>
                </div>
            </div>
            <div class="decor2">
                <div class="backfix"></div>
                <div class="back">
                    <p class="function">Our hospital management system is a comprehensive solution that encompasses hospital, treatment, patient, doctor, registration, case files, equipment, medication, and examination items, among other essential data. Our goal is to provide more comprehensive and professional medical services through this system, enhancing the quality of healthcare and meeting the needs of patients.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="last">
        <div class="footer">
            <p class="end"><i class="fa-regular fa-envelope"></i>Contact us : joshuji@gmail.com</p>
        </div>
    </div>
</body>
</html>
