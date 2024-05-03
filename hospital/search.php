<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="search.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <!-- 返回首页的按钮 -->
        <a id="fish" href="doctor.php" class="back-to-home">Back to Doctor List</a>

        <!-- 搜索框 -->
        <div id="aki">
            <form action="search.php" method="get">
                <input type="text" id="query" name="query" placeholder="Search more...">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <h1>Search Results</h1>

    <?php
    // 连接数据库
    try {
        // $db = new PDO("mysql:host=localhost;dbname=hospital", "root", "");
        // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        include('config.php');

        // 检查是否存在关键字参数
        if(isset($_GET['query'])) {
            // 获取用户输入的关键字
            $keyword = $_GET['query'];

            // 查询医生信息
            $query = "SELECT * FROM Doctor WHERE first_name LIKE '%$keyword%' OR last_name LIKE '%$keyword%' OR speciality LIKE '%$keyword%' ";
            $result = mysqli_query($link, $query);
            // $stmt = $db->prepare($query);
            // $stmt->execute();
            // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 显示搜索结果
            // if(count($result) > 0) {
            if (mysqli_num_rows($result) > 0) {
                echo "<ul>";
                foreach ($result as $doctor) {
                    // 构建医生的姓名
                    ?>
    <a href="edit_doctor.php?dID=<?php echo $doctor['dID']?>" class="search-and-edit">
        <?php
                    $name = $doctor['first_name'] . ", " . $doctor['last_name'];
                    echo "<li>".$name." - ".$doctor['speciality']."</li>";
                    ?>
    </a>
    <?php
                }
                echo "</ul>";
            } else {
                echo "<p>No results found.</p>";
            }
        } else {
            echo "<p>Please enter a keyword in the search box above.</p>";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

</body>

</html>