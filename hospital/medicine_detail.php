<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medication Detail</title>
    <link rel="stylesheet" href="medicine_detail.css" />
    <a href="medicine.php"><button class="back-to-home">Back to Medication List</button></a>
</head>

<body>
    <div class="container">
        <h1>Medication Detail</h1>
        

        <?php
        // 连接数据库
        include('config.php');

        // 检查是否存在药物ID参数
        if (isset($_GET['mID'])) {
            // 获取药物ID
            $mID = $_GET['mID'];

            // 查询药物详细信息
            $query = "SELECT * FROM medication WHERE mID = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("s", $mID); // 使用字符串类型 "s"
            $stmt->execute();
            $result = $stmt->get_result();

            // 显示药物详细信息
            if ($result->num_rows > 0) {
                $medication = $result->fetch_assoc();
        ?>
                <div class="medication-details">
                
                    <img src="th.jpg" alt="Medication Image" class="medication-image">
                    <p><strong>Medication Name:</strong> <?php echo $medication['mName']; ?></p>
                    <p><strong>Medication Type:</strong> <?php echo $medication['mType']; ?></p>
                    <p><strong>Medication Code:</strong> <?php echo $medication['mCode']; ?></p>
                    <p><strong>Side Effect:</strong> <?php echo $medication['side_effect']; ?></p>
                    <p><strong>Indication:</strong> <?php echo $medication['indication']; ?></p>
                    <p><strong>Ingredient:</strong> <?php echo $medication['ingredient']; ?></p>
                    <p><strong>Dosage:</strong> <?php echo $medication['dosage']; ?></p>
                    <p><strong>Pregnancy Grade:</strong> <?php echo $medication['pregnancy_grade']; ?></p>
                    <a href="edit_medicine.php?mID=<?php echo $medication['mID']; ?>"><button class="aki">Edit</button></a>
                </div>
        <?php
            } else {
                echo "<p>No medication found for this ID.</p>";
            }

            $stmt->close();
        } else {
            echo "<p>No medication ID provided.</p>";
        }

        $link->close();
        ?>
    </div>
</body>

</html>
