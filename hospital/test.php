<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Patients</title>
</head>
<body>
    <h1>Hospital Patients</h1>
    <ul>
        <?php
        include('config.php');
        // 查询病患列表，只选择 pNo 为 '100125' 的病患
        $sql = "SELECT * FROM patient WHERE pNo='102867'";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            // 输出匹配的病患姓名和链接
            while($row = $result->fetch_assoc()) {
                echo "<li><a href='patient.php?pNo=" . $row["pNo"] . "'>" . $row["pName"] . "</a></li>";
            }
        } else {
            echo "0 results";
        }
        $link->close();
        ?>
    </ul>
</body>
</html>
