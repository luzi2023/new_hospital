<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="search.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <a id="fish" href="doctor.php" class="back-to-home">Back to Doctor List</a>

        <div id="aki">
            <form action="search.php" method="get">
                <input type="text" id="query" name="query" placeholder="Search more...">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <h1>Search Results</h1>

    <?php
    try {
        include('config.php');

        if (isset($_GET['query'])) {
            $keyword = mysqli_real_escape_string($link, $_GET['query']);

            $query = "
                SELECT staff.dID, first_name, last_name, period 
                FROM staff 
                JOIN nurse ON staff.dID = nurse.dID 
                WHERE first_name LIKE '%$keyword%' 
                OR last_name LIKE '%$keyword%' 
                OR period LIKE '%$keyword%' 
                GROUP BY staff.dID, first_name, last_name, period
            ";
            $result = mysqli_query($link, $query);

            if (!$result) {
                echo "<p>Error: " . mysqli_error($link) . "</p>";
            }

            if (mysqli_num_rows($result) > 0) {
                echo "<ul>";
                while ($doctor = mysqli_fetch_assoc($result)) {
                    $name = $doctor['last_name'] . ", " . $doctor['first_name'];
                    echo "<li><a href='nurse_detail.php?dID=" . $doctor['dID'] . "' class='search-and-edit'>" . $name . " - " . $doctor['period'] . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No results found.</p>";
            }
        } else {
            echo "<p>Please enter a keyword in the search box above.</p>";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

</body>

</html>
