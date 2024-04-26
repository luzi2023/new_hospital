<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" />

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
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: welcome.php");
        exit;  //記得要跳出來，不然會重複轉址過多次
    }
    ?>

    <div class="container-fluid">
         <div id="login">
             <form method="post" action="login.php">User:
             <input type="text" name="username">Password:
             <input type="text" name="password">
             <input type="submit" value="login" name="submit">
             <a href="register.html">register now</a>
             </form>
         </div>
        <div id="side-nav" class="sidenav">
            <a href="index.html" id="home">Home</a>
            <a href="doctor.php" id="doctors">Doctors</a>
            <a href="" id="equipments">Equipments</a>
            <a href="" id="about">About</a>
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
        <div>
        <h1><strong>Hospital Homepage</strong></h1>
        <br>
        <h2>Dynamic content</h2>
        <p>The hospital has the following details:</p>
        <ul>
        <li><strong>Doctors:</strong> {{ num_doc }}</li>
        <li><strong>Medications:</strong> {{ num_medication }}</li>
        <li><strong>In-use Equipment:</strong> {{ num_equipment }}</li>
</div>
    </div>

</body>

</html>