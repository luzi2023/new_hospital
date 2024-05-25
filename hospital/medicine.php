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

<body onload="openCity(event, 'visualize')">
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
            <button onclick="update('desc')">Descending</button>
            <button onclick="update('asc')">Ascending</button>
            <div id="typeviz"></div>
            <p>Heatmap Between Pregnancy Grade and Medicine Type</p>
            <div id="heatmapviz"></div>
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

const svg1 = d3.select("#heatmapviz")
    .append("svg")
    .attr("width", 550)
    .attr("height", 425)
    .append("g")
    .attr("transform", `translate(110, 50)`);


d3.csv("./dataset/medicine.csv").then(function(data) {
    const typeCounts = d3.rollup(data, v => v.length, d => d.mType);
    const typeCountsArray = Array.from(typeCounts, ([key, value]) => ({
        key,
        value
    }));
    const filted = typeCountsArray.filter(d => d.value >= 50)

    const x = d3.scaleLinear()
        .domain([0, 5050])
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
        .attr("class", "y-axis")
        .call(d3.axisLeft(y));

    bar = svg.selectAll("rect")
        .data(filted)
        .join("rect")
        .attr("x", 0)
        .attr("y", d => y(d.key))
        .attr("width", 0)
        .attr("height", y.bandwidth())
        .style("fill", "black");

    svg.selectAll("rect")
        .transition()
        .duration(800)
        .attr("width", function(d) {
            return x(d.value);
        })
        .delay(function(d, i) {
            return (i * 100)
        })
})

function update(order) {
    d3.csv("./dataset/medicine.csv").then(function(data) {
        const typeCounts = d3.rollup(data, v => v.length, d => d.mType);
        const typeCountsArray = Array.from(typeCounts, ([key, value]) => ({
            key,
            value
        }));
        const filted = typeCountsArray.filter(d => d.value >= 50)

        const x = d3.scaleLinear()
            .domain([0, 5050])
            .range([0, width])
        svg.append("g")
            .attr("transform", `translate(0, ${height})`)
            .call(d3.axisBottom(x))
            .selectAll("text")
            .attr("transform", "translate(-10,0)rotate(-45)")
            .style("text-anchor", "end");
        const y = d3.scaleBand()
            .range([0, height])
            .padding(10);


        filted.sort((a, b) => order === 'asc' ? a.value - b.value : b.value - a.value);
        y.domain(filted.map(d => d.key));
        console.log(filted)

        svg.select(".y-axis")
            .transition()
            .duration(1000)
            .call(d3.axisLeft(y));

        bar.data(filted)
            .transition()
            .duration(1000)
            .attr("y", d => y(d.key))
            .attr("width", d => x(d.value));
    })
}

d3.csv("./dataset/Medicine.csv").then(function(data) {
    const typeCounts = d3.rollup(data, v => v.length, d => d.mType);
    const typeCountsArray = Array.from(typeCounts, ([key, value]) => ({
        key,
        value
    }));

    const filteredTypes = typeCountsArray.filter(d => d.value >= 50).map(d => d.key);
    const allPregnancyGrades = Array.from(new Set(data.map(d => d.pregnancy_grade)));


    const heatMapData = [];
    allPregnancyGrades.forEach(pregnancy_grade => {
        filteredTypes.forEach(mType => {
            heatMapData.push({
                pregnancy_grade,
                mType,
                count: 0
            });
        });
    });


    d3.rollup(data.filter(d => filteredTypes.includes(d.mType)),
        v => v.length,
        d => d.pregnancy_grade,
        d => d.mType).forEach((types, pregnancy_grade) => {
        types.forEach((count, mType) => {
            const entry = heatMapData.find(d => d.pregnancy_grade === pregnancy_grade && d
                .mType === mType);
            if (entry) {
                entry.count = count;
            }
        });
    });


    const myGroups = Array.from(new Set(heatMapData.map(d => d.pregnancy_grade)));
    const myVars = Array.from(new Set(heatMapData.map(d => d.mType)));

    console.log(heatMapData)
    // console.log(myVars)

    const x = d3.scaleBand()
        .range([0, width])
        .domain(myGroups)
        .padding(0.05);
    svg1.append("g")
        .attr("transform", `translate(0, ${height})`)
        .call(d3.axisBottom(x).tickSize(0))
        .select(".domain").remove()
    const y = d3.scaleBand()
        .range([height, 0])
        .domain(myVars)
        .padding(0.05);
    svg1.append("g")
        .call(d3.axisLeft(y).tickSize(0))
        .select(".domain").remove()

    const Color = d3.scaleSequential()
        .interpolator(d3.interpolatePlasma)
        .domain([0, d3.max(heatMapData, d => d.count)]);

    svg1.selectAll()
        .data(heatMapData)
        .enter()
        .append("rect")
        .attr("x", d => x(d.pregnancy_grade))
        .attr("y", d => y(d.mType))
        .attr("rx", 4)
        .attr("ry", 4)
        .attr("width", x.bandwidth())
        .attr("height", y.bandwidth())
        .style("fill", d => Color(d.count))
        .style("stroke-width", 5)
        .style("stroke", "none")
        .attr("class", "cell")


})
</script>

</html>