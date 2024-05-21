<?php
include('config.php');
session_start();

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Use parameterized queries to prevent SQL injection attacks
    $sql = "SELECT * FROM users WHERE userID=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Check if user exists
    if ($user) {
        // Verify password
        if (password_verify($password, $user["password"])) {
            // Successful login, store user info in session
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['userID'] = $user['userID']; // Assuming dID is fetched from the user record

            // Redirect to home page with dID parameter
            header("Location: index.php?dID=" . urlencode($user['userID']));
            exit();
        } else {
            $error_message = "Password does not match!";
        }
    } else {
        $error_message = "Username is not valid!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Local hospital</title>
</head>
<body>
    <div id="login">
        <form method="post" action="login.php">
            User:
            <input type="text" name="username" required>
            Password:
            <input type="password" name="password" required>
            <input type="submit" value="Login" name="submit">
            <a href="register.php">Register now</a>
            <?php if(isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
        </form>
    </div>
</body>
</html>
