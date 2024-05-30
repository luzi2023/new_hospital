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
        <a href="index.php"><button class="tablinks">Home</button></a>
        <button class="tablinks" onclick="openCity(event, 'visualize')">Visualization</button>
        <button class="tablinks" onclick="openCity(event, 'medicine')">Medicine List</button>
    </div>

    <div id="medicine" class="tabcontent">
        <div id="list_body">
            <h1>Medicine List</h1>
            <a id='addbtn' href="add_medicine.php">Add Medicine</a>
            <div class="dropdown">
                <button onclick="myFunction()" class="medicine-sort-button">Sort in ▼</button>
                <div id="myDropdown" class="dropdown-content">
                    <p onclick="sort('most_used')">The most used</p>
                    <p onclick="sort('default')">Default</p>
                </div>
            </div>
            <form id="sortForm" method="GET" action="">
                <input type="hidden" name="sort" id="sortInput">
            </form>

            <div class="search">
                <form action="search_medicine.php" method="get">
                    <input type="text" id="search" name="query" placeholder="Search something?">
                    <button id="btn" type="submit">Search</button>
                </form>
            </div>

            <?php
            include('config.php');
            $Option = isset($_GET['sort']) ? $_GET['sort'] : 'default';

            switch ($Option) {
                case 'most_used':
                    $sort = "SELECT m.mID, m.mName, m.mType, COUNT(DISTINCT mh.pNo) AS patient_count
                            FROM medication AS m
                            JOIN medical_history AS mh ON m.mName = mh.prescription
                            GROUP BY m.mID, m.mName, m.mType
                            ORDER BY patient_count DESC;";
                    break;
                case 'default':
                    $sort = "SELECT m.mID, m.mName, m.mType FROM medication AS m";
                    break;
                default:
                    $sort = "SELECT m.mID, m.mName, m.mType FROM medication AS m";
                    break;
            }

            $result = mysqli_query($link, $sort);

            if (mysqli_num_rows($result) > 0) {
                echo '<div class="hospital-list">'; 
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
            <div class="hospital">
                <a href="medicine_detail.php?mID=<?php echo $row['mID']; ?>" class="medicine-link">
                    <img src="th.jpg" alt="Medication Image">
                    <div>
                        <p><strong>Medication Name:</strong> <?php echo $row['mName']; ?></p>
                        <p><strong>Type:</strong> <?php echo $row['mType']; ?></p>
                        <?php if ($Option == 'most_used') { ?>
                        <p><strong>Patient Count:</strong> <?php echo $row['patient_count']; ?></p>
                        <?php } ?>
                    </div>
                </a>
            </div>
            <?php
                }
                echo '</div>'; 
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
            <button onclick="update('desc')" id="sortButtonAsc">Descending</button>
            <button onclick="update('asc')" id="sortButtonDesc">Ascending</button>
            <div id="typeviz"></div>
            <p>Heatmap Between Pregnancy Grade and Medicine Type</p>
            <div id="heatmapviz"></div>
        </div>
    </div>
</body>
<script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

function sort(value) {
    // Set the value of the hidden input field
    document.getElementById("sortInput").value = value;
    // Submit the form
    document.getElementById("sortForm").submit();
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.medicine-sort-button')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
</script>

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

let originalData, currentOrder = 'original';


d3.csv("./dataset/medicine.csv").then(function(data) {
    const typeCounts = d3.rollup(data, v => v.length, d => d.mType);
    const typeCountsArray = Array.from(typeCounts, ([key, value]) => ({
        key,
        value
    }));
    originalData = typeCountsArray.filter(d => d.value >= 50)

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
        .domain(originalData.map(d => d.key))
        .padding(.1);

    svg.append("g")
        .attr("class", "y-axis")
        .call(d3.axisLeft(y));

    bar = svg.selectAll("rect")
        .data(originalData)
        .join("rect")
        .attr("x", 0)
        .attr("y", d => y(d.key))
        .attr("width", 0)
        .attr("height", y.bandwidth())
        .style("fill", "#3a7da7");

    svg.selectAll("rect")
        .transition()
        .duration(800)
        .attr("width", function(d) {
            return x(d.value);
        })
        .delay(function(d, i) {
            return (i * 100)
        });

    d3.select("#sortButtonAsc").on("click", function() {
        update(currentOrder === 'asc' ? 'original' : 'asc');
    });
    d3.select("#sortButtonDesc").on("click", function() {
        update(currentOrder === 'desc' ? 'original' : 'desc');
    });
})

function update(order) {
    d3.csv("./dataset/medicine.csv").then(function(data) {
        const typeCounts = d3.rollup(data, v => v.length, d => d.mType);
        const typeCountsArray = Array.from(typeCounts, ([key, value]) => ({
            key,
            value
        }));
        const originalData = typeCountsArray.filter(d => d.value >= 50)
        currentOrder = order;

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
            .padding(.1);

        if (order === 'desc') {
            originalData.sort((a, b) => a.value - b.value);
        } else if (order === 'asc') {
            originalData.sort((a, b) => b.value - a.value);
        }
        y.domain(originalData.map(d => d.key));

        svg.select(".y-axis")
            .transition()
            .duration(1000)
            .call(d3.axisLeft(y));

        bar.data(originalData)
            .transition()
            .duration(1000)
            .attr("y", d => y(d.key))
            .attr("width", d => x(d.value));
    })
}

d3.csv("./dataset/medicine.csv").then(function(data) {
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
    console.log(myGroups)

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
        .interpolator(d3.interpolateGnBu)
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

    const hovertext = d3.select("#heatmapviz")
        .append("div")
        .attr("class", "hovertext")
        .style("opacity", 0)
        .style("background-color", "white")
        .style("border-width", "1px")
        .style("border-radius", "5px")
        .style("border", "solid")
        .style("padding", "5px")
        .style("pointer-events", "none")
        .style("top", "500px")
        .style("left", "500px")
        .style("position", "absolute");

    svg1.selectAll("rect")
        .on("mouseover", (event, d) => {
            hovertext.style("opacity", 1)
            d3.select(event.currentTarget)
                .style("stroke", "black")
                .style("stroke-width", "2px")
                .style("opacity", 1)
        })
        .on("mousemove", (event, d) => {
            hovertext.html("The value of this cell:<br>Medicine Type: " + d.mType +
                    "<br>Pregnancy Grade: " + d.pregnancy_grade + "<br>Counts: " + d.count)
                .style("top", (event.pageY - 100) + "px")
                .style("left", (event.pageX) + "px")
        })
        .on("mouseout", (event, d) => {
            hovertext.style("opacity", 0)
            d3.select(event.currentTarget)
                .style("stroke", "none")
                .style("opacity", 0.8)
        })


})
</script>

</html>
