<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/4bfa319983.js" crossorigin="anonymous"></script>

    <title>Local hospital</title>
</head>

<body>
    <?php
    try{
        $db = new PDO("mysql:dbname=hospital;port=3316", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $all_content=$db->query("SELECT * FROM doctor");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Initialize the session
    session_start();

    // Check if the user is already logged in, if yes then redirect him to welcome page
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: welcome.php");
        exit;  //記得要跳出來，不然會重複轉址過多次
    }
    ?>

    <div class="container-fluid">
        <!-- <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.html">register now</a>
            </form>
        </div> -->
        <div id="side-nav" class="sidenav">
            <a href="index.php" id="home">Home</a>
            <a href="doctor.php" id="doctors">Doctors</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
        <!-- <div id="login">
            {% if user.is_authenticated %}
            <p>User: {{ user.get_username }}</p>
            <p>
            <form id="logout-form" method="post" action="{% url 'admin:logout' %}">
                {% csrf_token %}
                <button type="submit" class="btn btn-link">Logout</button>
            </form>
            {% else %}
            <p><a href="{% url 'login' %}?next={{ request.path }}">Login</a></p>
            {% endif %}
        </div>
        {% endblock %} -->
        <div id="body">
            <div class="nav">
                <div class="plus">
                    <i class="fa-solid fa-plus"></i>
                    <a class="hometitle">Hospital Homepage</a>
                    <a id="log"><i class="fa-solid fa-user"></i>Login</a>
                </div>
            </div>
            <div class="positionfixed"></div>
            
            <p class = "care">We Care About Your Health</p>
            <div class = "detail">
                <img class="picture" src="health.jpg" alt="health">
                
            </div>
            <div class="fix1"></div>
            <div class="decor1">
                <img class="picture" src="medical.jpg" alt="medical">
            </div>
            <div class="fix2"></div>
            <div class="about">
                <div class="line">
                    <hr>
                </div>
                <div class="item">
                    <p>About</p>
                </div>
                <div class="line">
                    <hr>
                </div>
            </div>
            <div class="decor2">
                <div class="backfix"></div>
                <div class="back">
                    <p class="function">Our hospital management system is a comprehensive solution that encompasses
                        hospital, treatment, patient, doctor, registration, case files, equipment, medication, and
                        examination items, among other essential data. Our goal is to provide more comprehensive and
                        professional medical services through this system, enhancing the quality of healthcare and
                        meeting the needs of patients.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="last">
        <div class="footer">
            <p class="end"><i class="fa-regular fa-envelope"></i>Contact us : joshuji@gmail.com</p>
        </div>
    </div>

</body>

</html>