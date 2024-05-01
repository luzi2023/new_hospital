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
        if(strlen($password) < 8){
            array_push($errors, "Password must be at least 8 characters!");
        }

        if(count($errors) > 0){
            foreach($errors as $error){
                echo "<div class='container'>$error</div>";
            }
        }

        else{
            require_once "config.php";
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = mysqli_stmt_init($link);
            $preparestmt = mysqli_stmt_prepare($stmt, $sql);
            if($preparestmt){
                mysqli_stmt_bind_param($stmt, "ss", $username, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='container'>You are registered successfully!</div>";
                //header("Location: doctor.php");
                 // 確保後續的程式碼不會執行
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
        <div class="container">
            <h2>User Registration</h2>
            <form method="post" action="register.php">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" name="submit" value="Register">
            </form>
        </div>
</div>

</body>

</html>