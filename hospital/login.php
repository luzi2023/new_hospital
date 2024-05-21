<?php
include('config.php');
session_start();

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // 使用参数化查询来防止 SQL 注入攻击
    $sql = "SELECT * FROM users WHERE userID=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // 检查是否有查询到用户
    if($user){
        // 验证密码是否正确
        if(password_verify($password, $user["password"])){
            // 登录成功，将用户信息存入 session
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username; 
            header("Location: index.php"); // 重定向到首页
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
    <link rel="stylesheet" href="signin.css" />
    <title>Local hospital</title>
</head>

<body>
    <div id="login">
        <form method="post" action="login.php">
            User:
            <input type="text" name="username">Password:
            <input type="password" name="password">
            <input type="submit" value="Login" name="submit">
            <a href="register.php">Register now</a>
            <?php if(isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
        </form>
    </div>
</body>

</html>
