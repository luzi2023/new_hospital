<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="medicine.css" />

    <script src="all.js"></script>
    <script src="https://d3js.org/d3.v6.js"></script>
    <title>Local hospital</title>
</head>

<body onload="openCity(event, 'medicine')">
    <div class="container-fluid">
        <div id="side-nav" class="sidenav">
            <a href="medicine.php" id="home">Medicine</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
    </div>
    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'medicine')">Medicine List</button>
        <button class="tablinks" onclick="openCity(event, 'visualize')">Visualization</button>
    </div>

    <div id="medicine" class="tabcontent">
        <div id="list_body">
            <h1>Medicine List</h1>
            <div class="search">
                <form action="search_medicine.php" method="get">
                    <input type="text" id="search" name="query" placeholder="Search something?">
                    <button id="btn" type="submit">Search</button>
                </form>
            </div>

            <?php
            include('config.php');

            $query = "SELECT mID, mName, mType FROM medication";
            $query_run = mysqli_query($link, $query);

            if (mysqli_num_rows($query_run) > 0) {
                echo '<div class="hospital-list">'; // 新增外層 div
                while ($row = mysqli_fetch_assoc($query_run)) {
            ?>
            <div class="hospital">
                <a href="medicine_detail.php?mID=<?php echo $row['mID']; ?>" class="medicine-link">
                    <img src="th.jpg" alt="Medication Image">
                    <div>
                        <p><strong>Medication Name:</strong> <?php echo $row['mName']; ?></p>
                        <p><strong>Type:</strong> <?php echo $row['mType']; ?></p>
                    </div>
                </a>
            </div>
            <?php
                }
                echo '</div>'; // 關閉外層 div
            } else {
                echo "No hospitals found.";
            }
            ?>
        </div>
    </div>

    <div id="visualize" class="tabcontent">
        <div id="list_body">
            <h1>Visualization</h1>
            <p>Medicine Type</p>
            <div id="typeviz"></div>
        </div>
    </div>
</body>
<script>
const margin = {
    top: 40,
    right: 20,
    bottom: 40,
    left: 90
};
const width = 500 - margin.left - margin.right;
const height = 400 - margin.top - margin.bottom;
const svg = d3.select("#typeviz")
    .append("svg")
    .attr("width", 600)
    .attr("height", 425)
    .append("g")
    .attr("transform", `translate(120, ${margin.top})`);

d3.csv("./dataset/medicine.csv").then(function(data) {
    const typeCounts = d3.rollup(data, v => v.length, d => d.mType);
    const typeCountsArray = Array.from(typeCounts, ([key, value]) => ({
        key,
        value
    }));
    const filted = typeCountsArray.filter(d => d.value >= 50)


    const x = d3.scaleLinear()
        .domain([0, 6000])
        .range([0, width])
    svg.append("g")
        .attr("transform", `translate(0, ${height})`)
        .call(d3.axisBottom(x))
        .selectAll("text")
        .attr("transform", "translate(-10,0)rotate(-45)")
        .style("text-anchor", "end");
    const y = d3.scaleBand()
        .range([0, height])
        .domain(filted.map(d => d.key))
        .padding(.1);
    svg.append("g")
        .call(d3.axisLeft(y));

    svg.selectAll("rect")
        .data(filted)
        .join("rect")
        .attr("x", 0)
        .attr("y", d => y(d.key))
        .attr("width", d => x(d.value))
        .attr("height", y.bandwidth())


})
</script>

</html>