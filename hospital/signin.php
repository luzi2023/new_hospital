<?php
include_once('config.php');

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // 使用參數化查詢來防止 SQL 注入攻擊
    $sql = "SELECT * FROM users WHERE userID=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // 檢查是否有查詢到使用者
    if($user = mysqli_fetch_assoc($result)){
        // 驗證密碼是否正確
        if(password_verify($password, $user["password"])){
            // 登入成功，導向到醫生頁面
            header("Location: login.php?userID=" . $user["userID"]);
            exit();
        } else {
            // 密碼不匹配的錯誤訊息
            $error_message = "Password does not match!";
        }
    } else {
        // 使用者名稱不存在的錯誤訊息
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
        <form method="post" action="signin.php">
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
