<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="hospital_search.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <!-- 返回首页的按钮 -->
        <a id="fish" href="hospital.php" class="back-to-home">Back to Hospital List</a>

        <!-- 搜索框 -->
        <div id="aki">
            <form action="hospital_search.php" method="get">
                <input type="text" id="query" name="query" placeholder="Search more...">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <h1>Search Results</h1>

    <?php
    // 连接数据库
    include('config.php');

    // 检查是否存在关键字参数
    if (isset($_GET['query'])) {
        // 获取用户输入的关键字
        $keyword = $_GET['query'];

        // 查询医院信息
        $query = "SELECT * FROM hospital WHERE hName LIKE '%$keyword%' OR hAddress LIKE '%$keyword%'";
        $result = mysqli_query($link, $query);

        // 显示搜索结果
        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li><strong>Hospital Name:</strong> " . $row['hName'] . "<br><strong>Address:</strong> " . $row['hAddress'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No results found.</p>";
        }
    } else {
        echo "<p>Please enter a keyword in the search box above.</p>";
    }
    ?>

</body>

</html>
