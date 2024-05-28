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
        include('config.php');

        // 检查是否存在关键字参数
        if (isset($_GET['query'])) {
            // 获取用户输入的关键字并进行转义以防止 SQL 注入
            $keyword = mysqli_real_escape_string($link, $_GET['query']);

            // 查询医生信息，使用 GROUP BY 进行分组
            $query = "
                SELECT staff.dID, first_name, last_name, period 
                FROM staff 
                JOIN nurse ON staff.dID = nurse.dID 
                WHERE first_name LIKE '%$keyword%' 
                OR last_name LIKE '%$keyword%' 
                OR period LIKE '%$keyword%' 
                GROUP BY staff.dID, first_name, last_name, period
            ";
            $result = mysqli_query($link, $query);

            // 检查查询是否成功
            if (!$result) {
                echo "<p>Error: " . mysqli_error($link) . "</p>";
            }

            // 显示搜索结果
            if (mysqli_num_rows($result) > 0) {
                echo "<ul>";
                while ($doctor = mysqli_fetch_assoc($result)) {
                    // 构建医生的姓名
                    $name = $doctor['last_name'] . ", " . $doctor['first_name'];
                    echo "<li><a href='nurse_detail.php?dID=" . $doctor['dID'] . "' class='search-and-edit'>" . $name . " - " . $doctor['period'] . "</a></li>";
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
