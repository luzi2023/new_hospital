<div class="container-wrapper">
<?php
if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $errors = array();

    if(empty($username) || empty($password)){
        array_push($errors, "All fields are required!");
    }
    if(strlen($password) < 6){
        array_push($errors, "Password must be at least 6 characters!");
    }

    require_once "config.php";
    $sql_check_user = "SELECT COUNT(*) AS count FROM staff WHERE dID = ?";
    $stmt_check_user = mysqli_stmt_init($link);
    $preparestmt_check_user = mysqli_stmt_prepare($stmt_check_user, $sql_check_user);
    if($preparestmt_check_user){
        mysqli_stmt_bind_param($stmt_check_user, "s", $username);
        mysqli_stmt_execute($stmt_check_user);
        mysqli_stmt_bind_result($stmt_check_user, $count);
        mysqli_stmt_fetch($stmt_check_user);
        if($count == 0){
            array_push($errors, "UserID is not available!");
        }
        mysqli_stmt_close($stmt_check_user);
    } else {
        die("Something went wrong!");
    }

    if(count($errors) > 0){
        foreach($errors as $error){
            echo "<div class='container'>$error</div>";
        }
    }

    else{
        $sql = "INSERT INTO users (userID, password) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($link);
        $preparestmt = mysqli_stmt_prepare($stmt, $sql);
        if($preparestmt){
            mysqli_stmt_bind_param($stmt, "ss", $username, $passwordHash);
            mysqli_stmt_execute($stmt);
            echo "<div class='container1'>You are registered successfully!</div>";
        }
        else{
            die("Something went wrong!");
        }
    }
}
?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="register.css" rel="stylesheet">
        <title>User Registration</title>
    </head>

    <body>
        <a id="back-to-home" href="doctor.php">Back to Home Page</a>
        <div class="container2">
            <h2>User Registration</h2>
            <form method="post" action="register.php">
                <input type="text" name="username" placeholder="UserID">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" name="submit" value="Register">
            </form>
        </div>
</div>

</body>

</html>