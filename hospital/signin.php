<?php
include('config.php');

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // 使用參數化查詢來防止 SQL 注入攻擊
    $sql = "SELECT * FROM users WHERE userID=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($user=mysqli_fetch_assoc($result)){
        // 验证密码是否正确
        if(password_verify($password, $user["password"])){
            // 登录成功，重定向到 doctor.php 页面，并传递userID参数
            echo "Login successful! userID: " . $user['userID']; // 调试信息
            header("Location: doctor.php?userID=".$user['userID']);
            exit();
        } else {
            // 密码不匹配的错误消息
            $error_message = "Password does not match!";
        }
    } else {
        // 用户名不存在的错误消息
        $error_message = "Username is not valid!";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="signin.css" />
    <script src="https://kit.fontawesome.com/4bfa319983.js" crossorigin="anonymous"></script>
    <title>Local hospital</title>
</head>

<body>
        <div id="login">
            <form method="post" action="doctor.php">User:
                <input type="text" name="username">Password:
                <input type="password" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.php">register now</a>
            </form>
        </div>
</body>
</html>