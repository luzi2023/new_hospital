<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="search_medicine.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <!-- 返回首页的按钮 -->
        <a href="medicine.php" class="back-to-home">Back to Medication List</a>

        <!-- 搜索框 -->
        <div id="aki">
            <form action="search_medicine.php" method="get">
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
        // 获取用户输入的关键字并进行转义以防止 SQL 注入
        $keyword = mysqli_real_escape_string($link, $_GET['query']);

        // 查询药物信息并进行分组
        $query = "
            SELECT mID, mName, Type FROM medication 
            WHERE mName LIKE '%$keyword%' 
            GROUP BY mName, Type
        ";
        $result = mysqli_query($link, $query);

        // 检查查询是否成功
        if (!$result) {
            echo "<p>Error: " . mysqli_error($link) . "</p>";
        }

        // 显示搜索结果
        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li><a href='medicine_detail.php?mID=" . $row['mID'] . "'>" . $row['mName'] . " - " . $row['Type'] . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No results found.</p>";
        }
    } else {
        echo "<p>Please enter a keyword in the search box above.</p>";
    }

    // 关闭数据库连接
    mysqli_close($link);
    ?>
</body>

</html>
