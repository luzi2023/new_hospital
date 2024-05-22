<?php
session_start();

// 檢查用戶是否已登入，否則重定向到登入頁面
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// 從會話中取得 userID
$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : '';

// 檢查查詢字符串中的 dID 是否已設置且匹配會話中的 userID
if (!isset($_GET['dID']) || $_GET['dID'] !== $userID) {
    // 重定向到相同頁面並附加正確的 dID
    header("Location: " . $_SERVER['PHP_SELF'] . "?dID=" . urlencode($userID));
    exit;
}

// 獲取 URL 中的 dID 參數
$dID = $_GET['dID'];

include('config.php');

// 獲取設備信息的 SQL 查詢
$sql = "SELECT * FROM equipment JOIN users WHERE userID = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $dID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <?php
                // if(isset($error_message)) { echo "<p class='error'>$error_message</p>"; }
                ?>
            </form>
        </div> -->

        <!-- 其他內容 -->
    </div>
    <div class="container-fluid3">
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
        <h1>Equipments List</h1>
        <form action="equipment_search.php">
            <label for="search"></label>
            <input type="submit" value="Search" class="treatment-search-button">
        </form>
        <?php
        $query = "SELECT * FROM Equipment";
        $result = mysqli_query($link, $query);
        ?>
        <table class="equipment-table">
            <th>eID</th>
            <th>eName</th>
            <th>purchase date</th>
            <th>Status</th>
            <th>manufacturer</th>
            <th>Reservation</th>
            <div class="equipment-table-list">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    foreach ($result as $row) {
                        ?>
                <tr>
                    <td><a href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['eID']; ?></a></td>
                    <td><a href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['eName']; ?></a>
                    </td>
                    <td><a
                            href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['purchaseDate']; ?></a>
                    </td>
                    <td><a href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['useStatus']; ?></a>
                    </td>
                    <td><a
                            href="equipment_view.php?eID=<?php echo $row['eID']; ?>"><?php echo $row['manufacturer']; ?></a>
                    </td>
                    <td><a
                            href="equipment_reserve.php?eID=<?php echo $row['eID']; ?>&dID=<?php echo $dID; ?>">Reserve</a>
                    </td>

                </tr>
                <?php
                    }
                }
                ?>
            </div>
        </table>
    </div>

    <div id="visualize" class="tabcontent">
        <div id="list_body">
            <h1>Visualization</h1>
            <div id="statusviz"></div>
        </div>
    </div>
</body>
<script>
const margin = {
    top: 40,
    right: 20,
    bottom: 40,
    left: 90
};
const width = 500 - margin.left - margin.right;
const height = 400 - margin.top - margin.bottom;
const svg = d3.select("#statusviz")
    .append("svg")
    .attr("width", 500)
    .attr("height", 425)
    .append("g")
    .attr("transform", `translate(${margin.left}, ${margin.top})`);
</script>

</html>