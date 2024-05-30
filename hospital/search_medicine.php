<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="search_medicine.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <a href="medicine.php" class="back-to-home">Back to Medication List</a>

        <div id="aki">
            <form action="search_medicine.php" method="get">
                <input type="text" id="query" name="query" placeholder="Search more...">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <h1>Search Results</h1>
    <?php
    include('config.php');

    if (isset($_GET['query'])) {
        $keyword = mysqli_real_escape_string($link, $_GET['query']);

        $query = "
            SELECT mID, mName, mType FROM medication 
            WHERE mName LIKE '%$keyword%' 
            GROUP BY mName, mType
        ";
        $result = mysqli_query($link, $query);

        if (!$result) {
            echo "<p>Error: " . mysqli_error($link) . "</p>";
        }

        if (mysqli_num_rows($result) > 0) {
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li><a href='medicine_detail.php?mID=" . $row['mID'] . "'>" . $row['mName'] . " - " . $row['mType'] . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No results found.</p>";
        }
    } else {
        echo "<p>Please enter a keyword in the search box above.</p>";
    }

    mysqli_close($link);
    ?>
</body>

</html>
