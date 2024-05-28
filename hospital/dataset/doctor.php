<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/4bfa319983.js" crossorigin="anonymous"></script>
    <title>Local hospital</title>
    <script src="all.js"></script>
    <script src="https://d3js.org/d3.v6.js"></script>
</head>


<body>

    <body onload="openCity(event, 'visualize')">
        <div class="container-fluid">
            <!--<div id="login">
            <form method="post" action="doctor.php">
                User:
                <input type="text" name="username">
                Password:
                <input type="password" name="password">
                <input type="submit" value="Login" name="submit">
                <a href="register.php">Register now</a>
                <?php if(isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
            </form>
        </div>
        -->

        </div>
        <div class="container-fluid">
            <!-- <div id="login">
            <form method="post" action="login.php">User:
                <input type="text" name="username">Password:
                <input type="text" name="password">
                <input type="submit" value="login" name="submit">
                <a href="register.php">register now</a>
            </form>
        </div> -->
            <div id="side-nav" class="sidenav">
                <a href="medicine.php" id="home">Medicine</a> <a href="doctor.php" id="doctors">Staffs</a>
                <a href="equipment.php" id="equipments">Equipments</a>
                <a href="treatment.php" id="treatments">Treatments</a>
            </div>
            <!-- Tab links -->
            <div class="tab">
                <a href="index.php"><button class="tablinks">Home</button></a>
                <button class="tablinks" onclick="openCity(event, 'visualize')">Visualization</button>
                <button class="tablinks" onclick="openCity(event, 'doctor')">Doctor List</button>
                <button class="tablinks" onclick="openCity(event, 'nurse')">Nurse List</button>
            </div>
            <div class="tab_fix"></div>
            <div id="doctor" class="tabcontent">
                <div id="list_body">
                    <h1>Doctor List</h1>
                    <div class="doctor_menu">
                        <a href="add_doctor.php"></i>Add doctor</a>
                    </div>
                    <div class="search">
                        <form action="search.php" method="get">
                            <input type="text" id="search" name="query" placeholder="Search something?">
                            <button id="btn" type="submit">Search</button>
                        </form>
                    </div>

                    <?php

                include('config.php');

                $query = "SELECT * FROM staff, Doctor WHERE staff.dID = Doctor.dID";
                $query_run =mysqli_query($link, $query);

                ?>
                    <div class="print_doc">
                        <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                            ?>
                        <a href="staff_detail.php?dID=<?php echo $row['dID']?>">
                            <div class="current_list">
                                <img src="<?php if (file_exists($row['dImage'])) {echo $row['dImage'];} else {echo "default.png";} ?>"
                                    alt="Dr.<?php $row['first_name']?>'s head shot">
                                <p> <?php echo $row['last_name'].', '.$row['first_name']?> </p>
                                <p> <?php echo $row['speciality'] ?> </p>
                            </div>
                        </a>
                        <?php
                        }
                    } else {
                        echo "Sorry, there is no existed doctor.";
                    }
                    ?>
                    </div>
                </div>
            </div>

            <div id="nurse" class="tabcontent">
                <div id="list_body">
                    <h1>Nurse List</h1>
                    <div class="doctor_menu">
                        <a href="add_nurse.php"></i>Add nurse</a>
                    </div>
                    <div class="search">
                        <form action="search_nurse.php" method="get">
                            <input type="text" id="search" name="query" placeholder="Search something?">
                            <button id="btn" type="submit">Search</button>
                        </form>
                    </div>

                    <?php


                $query = "SELECT * FROM staff, nurse  WHERE staff.dID = nurse.dID";
                $query_run =mysqli_query($link, $query);

                ?>
                    <div class="print_doc">
                        <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                            ?>
                        <a href="nurse_detail.php?dID=<?php echo $row['dID']?>">
                            <div class="current_list">
                                <img src="<?php if (file_exists($row['dImage'])) {echo $row['dImage'];} else {echo "default.png";} ?>"
                                    alt="Dr.<?php $row['first_name']?>'s head shot">
                                <p><?php echo $row['last_name'].', '.$row['first_name']?> </p>
                            </div>
                        </a>
                        <?php
                        }
                    } else {
                        echo "Sorry, there is no existed doctor.";
                    }
                    ?>
                    </div>
                </div>
            </div>

            <div id="visualize" class="tabcontent">
                <div id="list_body">
                    <h1>Visualization</h1>
                    <p>Statistic of Patients</p>
                    <select id="patientselectButton"></select>
                    <div id="patientviz">
                        <div class="drag-text"></div>
                    </div>
                    <p>Statistic of Diagnosis</p>
                    <!-- <button onclick="update(data1)">Data 1</button>
                    <button onclick="update(data2)">Data 2</button> -->
                    <div id="prescriptionviz"></div>
                </div>
            </div>
            <script>
            const margin = {
                top: 40,
                right: 20,
                bottom: 40,
                left: 90
            };
            const width = 500 - margin.left - margin.right;
            const height = 400 - margin.top - margin.bottom;
            const svg = d3.select("#patientviz")
                .append("svg")
                .attr("width", 500)
                .attr("height", 425)
                .append("g")
                .attr("transform", `translate(${margin.left}, ${margin.top})`);

            const svg1 = d3.select("#prescriptionviz")
                .append("svg")
                .attr("width", 550)
                .attr("height", 425)
                .append("g")
                .attr("transform", `translate(250, 200)`);


            d3.csv("./dataset/Patient.csv").then(function(data) {
                const allGroup = ["Age", "Gender"];

                d3.select("#patientselectButton")
                    .selectAll("myOptions")
                    .data(allGroup)
                    .enter()
                    .append("option")
                    .text(function(d) {
                        return d;
                    })
                    .attr("value", function(d) {
                        return d;
                    })

                const x = d3.scaleBand()
                    .range([0, width])
                    .padding(0.3);
                const xAxis = svg.append("g")
                    .attr("transform", `translate(0, ${height})`);
                const y = d3.scaleLinear()
                    .range([height, 0]);
                const yAxis = svg.append("g");

                function ageGrouping(age) {
                    if (age < 10) return "0-10";
                    else if (age < 20) return "10-20";
                    else if (age < 30) return "20-30";
                    else if (age < 40) return "30-40";
                    else if (age < 50) return "40-50";
                    else if (age < 60) return "50-60";
                    else if (age < 70) return "60-70";
                    else if (age < 80) return "70-80";
                    else return "80+";
                }

                const ageGroups = [{
                        range: "0-10",
                        patients: []
                    },
                    {
                        range: "10-20",
                        patients: []
                    },
                    {
                        range: "20-30",
                        patients: []
                    },
                    {
                        range: "30-40",
                        patients: []
                    },
                    {
                        range: "40-50",
                        patients: []
                    },
                    {
                        range: "50-60",
                        patients: []
                    },
                    {
                        range: "60-70",
                        patients: []
                    }, {
                        range: "70-80",
                        patients: []
                    }, {
                        range: "80+",
                        patients: []
                    }
                ]

                const genderGroups = [{
                    gender: "Male",
                    patients: []
                }, {
                    gender: "Female",
                    patients: []
                }]

                data.forEach(d => {
                    if (d.age < 10) ageGroups[0].patients.push(d.pNo);
                    else if (d.age >= 10 && d.age < 20) ageGroups[1].patients.push(d.pNo);
                    else if (d.age >= 20 && d.age < 30) ageGroups[2].patients.push(d.pNo);
                    else if (d.age >= 30 && d.age < 40) ageGroups[3].patients.push(d.pNo);
                    else if (d.age >= 40 && d.age < 50) ageGroups[4].patients.push(d.pNo);
                    else if (d.age >= 50 && d.age < 60) ageGroups[5].patients.push(d.pNo);
                    else if (d.age >= 60 && d.age < 70) ageGroups[6].patients.push(d.pNo);
                    else if (d.age >= 70 && d.age < 80) ageGroups[7].patients.push(d.pNo);
                    else if (d.age >= 80) ageGroups[8].patients.push(d.pNo);
                    if (d.gender == "M") genderGroups[0].patients.push(d.pNo);
                    else if (d.gender == "F") genderGroups[1].patients.push(d.pNo);
                });

                function genderGrouping(gender) {
                    if (gender == 'M') return "Male";
                    else return "Female";
                }

                function update(selectedGroup) {
                    if (selectedGroup === "Age") {

                        svg.selectAll("rect").remove();

                        const ageCounts = d3.rollup(data, v => v.length, d => ageGrouping(d.age));
                        const ageCountsArray = Array.from(ageCounts, ([key, value]) => ({
                            key,
                            value
                        }));

                        x.domain(['0-10', '10-20', '20-30', '30-40', '40-50', '50-60', '60-70', '70-80',
                            '80+'
                        ]);
                        y.domain([0, 11]);

                        xAxis.transition().duration(1000).call(d3.axisBottom(x));

                        yAxis.transition().duration(1000).call(d3.axisLeft(y));

                        const bar = svg.selectAll("mybar")
                            .data(ageCountsArray, d => d.key)
                            .enter()
                            .append("rect")
                            .attr("x", function(d) {
                                return x(d.key);
                            })
                            .attr("y", function(d) {
                                return y(0);
                            })
                            .style("fill", "#3a7da7")
                            // .transition()
                            // .duration(1000)
                            .attr("width", x.bandwidth())
                            .attr("height", function(d) {
                                return height - y(0);
                            });

                        svg.selectAll("rect")
                            .transition()
                            .duration(800)
                            .attr("y", function(d) {
                                return y(d.value)
                            })
                            .attr("height", function(d) {
                                return height - y(d.value);
                            })
                            .delay(function(d, i) {
                                console.log(i);
                                return (i * 100)
                            })

                        // Create the brush behavior.
                        // .on("start brush end", ...) 是指定當刷選開始、進行中和結束時要執行的回調函式
                        svg.call(d3.brush().on("start brush end", ({
                            selection
                        }) => {
                            // 創建一個空陣列 value，用於存儲刷選器選擇的數據
                            let value = [];
                            // if (selection) { ... }: 檢查是否有選擇區域
                            if (selection) {
                                const [
                                    [x0, y0],
                                    [x1, y1]
                                ] = selection;
                                // value = bar ...: 選擇所有 .bar 元素，並根據刷選區域過濾出符合條件的元素。
                                //      對於符合條件的元素，將其顏色設置為橙色，並將其數據添加到 value 陣列中。
                                value = bar
                                    .style("fill", "#3a7da7")
                                    .filter(ageCountsArray => x(ageCountsArray.key) + x
                                        .bandwidth() >= x0 &&
                                        x(ageCountsArray.key) <= x0 + (x1 - x0) &&
                                        y(ageCountsArray.value) + (height - y(ageCountsArray
                                            .value)) >= y0 &&
                                        y(ageCountsArray.value) <= y0 + (y1 - y0))
                                    .style("fill", "orange")
                                    .data();


                                // 清空之前的tooltip
                                d3.select("#patientviz").selectAll(".drag-text").remove();

                                let selectedPatients = [];
                                value.forEach(v => {
                                    const patientGroup = ageGroups.find(group => group
                                        .range === v.key);
                                    if (patientGroup) {
                                        selectedPatients = selectedPatients.concat(
                                            patientGroup.patients);
                                    }

                                });

                                const selectedPatientsInfo = data.filter(patient => selectedPatients
                                    .includes(patient.pNo));
                                const dragtext = d3.select("#patientviz").append("div")
                                    .attr("class", "dragpatient-container");

                                // 显示选定的病患信息
                                selectedPatientsInfo.forEach((patient, index) => {
                                    dragtext
                                        .append("p")
                                        .attr("class", "drag-text")
                                        .style("position", "absolute")
                                        .style("left", "800px")
                                        .style("top",
                                            `${200 + index * 55}px`) // 每个<p>元素垂直位置错开
                                        .style("background", "white")
                                        .style("padding", "5px")
                                        .style("border", "1px solid #d3d3d3")
                                        .style("border-radius", "5px")
                                        .style("color", "black")
                                        .style("pointer-events", "none")
                                        .style("z-index", "0")
                                        .style("opacity", 0.9)
                                        .style("margin-top", "5px")
                                        .html(
                                            `Patient No: ${patient.pNo}<br>Patient Age: ${patient.age}`
                                        );
                                });


                            }
                        }));



                    } else if (selectedGroup === "Gender") {

                        svg.selectAll("rect").remove();

                        const genderCounts = d3.rollup(data, v => v.length, d => genderGrouping(d
                            .gender));
                        const genderCountsArray = Array.from(genderCounts, ([key, value]) => ({
                            key,
                            value
                        }));

                        x.domain(['Male', 'Female']);
                        y.domain([0, 28]);

                        xAxis.transition().duration(1000).call(d3.axisBottom(x));

                        yAxis.transition().duration(1000).call(d3.axisLeft(y));

                        const bar = svg.selectAll("mybar")
                            .data(genderCountsArray, d => d.key)
                            .join("rect")
                            .attr("x", d => x(d.key))
                            .attr("y", d => y(d.value))
                            .style("fill", "#3a7da7")
                            .transition()
                            .duration(1000)
                            .attr("width", x.bandwidth())
                            .attr("height", d => height - y(d.value));

                        svg.selectAll("rect")
                            .data(genderGroups)
                            .on("mouseover", (event, d) => {
                                const tooltip = d3.select("body").append("div")
                                    .attr("class", "tooltip")
                                    .style("position", "absolute")
                                    .style("background", "white")
                                    .style("padding", "5px")
                                    .style("border", "1px solid #d3d3d3")
                                    .style("border-radius", "5px")
                                    .style("pointer-events", "none")
                                    .style("z-index", "10")
                                    .style("opacity", 0);
                                tooltip.html(d.patients.join(", "))
                                    .style("left", (event.pageX + 5) + "px")
                                    .style("top", (event.pageY - 28) + "px")
                                    .transition()
                                    .duration(200)
                                    .style("opacity", .9);
                            })
                            .on("mousemove", function(event) {
                                d3.select(".tooltip")
                                    .style("left", (event.pageX + 5) + "px")
                                    .style("top", (event.pageY - 28) + "px");
                            })
                            .on("mouseout", function() {
                                d3.select(".tooltip").remove();
                            });

                    }
                }
                d3.select("#patientselectButton").on("change", function(event, d) {
                    const selectedOption = d3.select(this).property("value");
                    update(selectedOption);
                });

                update(allGroup[0]);
            });

            d3.csv("./dataset/medical_history(N).csv").then(function(data) {
                d3.csv("./dataset/medicine.csv").then(function(e) {

                    const radius = Math.max(width, height) / 2 - margin.top;

                    const prescriptCounts = d3.rollup(data, v => v.length, d => d
                        .prescription);
                    const aggregatedData = Array.from(prescriptCounts, ([prescription,
                        count
                    ]) => ({
                        prescription,
                        count
                    }));

                    const color = d3.scaleOrdinal()
                        .range(d3.schemeDark2);


                    const pie = d3.pie()
                        .value(d => d.count)
                        (aggregatedData);

                    const filteredPieData = pie.filter(d => d.data.count >= 3);
                    // const hoveredPieData = pie.filter(d => d.data.count <= 3);

                    const arc = d3.arc()
                        .innerRadius(radius * 0.45)
                        .outerRadius(radius * 0.8)

                    const outerArc = d3.arc()
                        .innerRadius(radius * 0.9)
                        .outerRadius(radius * 1)

                    // Append the pie chart slices
                    svg1.selectAll("path")
                        .data(pie)
                        .enter()
                        .append("path")
                        .attr("d", arc)
                        .attr("fill", d => color(d.data.prescription))
                        .attr("stroke", "white")
                        .style("stroke-width", "2px")
                        .style("opacity", 0.7)

                        .data(pie)
                        .on("mouseover", (event, d) => {
                            d3.select(event.currentTarget)
                                .attr("stroke", d => color(d.data.prescription))
                                .attr("stroke-width", "200px");
                            const hovertext = d3.select("#prescriptionviz").append(
                                    "div")
                                .attr("class", "hovertext")
                                .style("position", "absolute")
                                .style("background", "white")
                                .style("padding", "10px")
                                .style("border", "1px solid black")
                                .style("border-radius", "5px")
                                .style("pointer-events", "none")
                                .style("font-size", "30px")
                                .style("z-index", "10")
                                .style("opacity", 0);
                            hovertext.html(d.data.prescription)
                                .style("left", "150px")
                                .style("top", "750px")
                                .transition()
                                .duration(200)
                                .style("opacity", .9);
                            hovertext.append("p")
                                .html("※click dounut slice to see more")
                                .style("font-size", "15px")
                                .style("margin-top", "10px")
                                .style("margin-buttom", "0px")
                        })

                        .on("click", (event, d) => {
                            const existingHovertext = d3.select(".hovertext");
                            if (!existingHovertext.empty()) {
                                existingHovertext.remove();
                            } else {

                                const hovertext = d3.select("#prescriptionviz").append(
                                        "div")
                                    .attr("class", "hovertext")
                                    .style("position", "absolute")
                                    .style("background", "white")
                                    .style("padding", "10px")
                                    .style("border", "1px solid black")
                                    .style("border-radius", "5px")
                                    // .style("pointer-events", "none")
                                    .style("font-size", "30px")
                                    .style("z-index", "20")
                                    .style("opacity", 0);

                                hovertext.html(d.data.prescription)
                                    .style("left", "150px")
                                    .style("top", "750px")
                                    .transition()
                                    .duration(200)
                                    .style("opacity", .9);

                                const link = e.find(e => e.mName === d.data.prescription);
                                const total_link = "medicine_detail.php?mID=" + link.mID;
                                console.log(link.mID)
                                hovertext.append("p")
                                    .attr("class", "moreinformation")
                                    .html(`Medicine ID: ${link.mID}<br>`)
                                hovertext.append("p")
                                    .attr("class", "moreinformation")
                                    .html(`Side Effect: ${link.side_effect}<br>`)
                                hovertext.append("a")
                                    .html("go to the page →")
                                    .attr("href", total_link)
                                    .style("font-size", "15px")
                                    .style("margin-top", "4px");
                            }
                        })

                        // .on("click", (event, d) => {
                        //     d3.select(".hovertext").hide();
                        // })

                        .on("mouseout", (event, d) => {
                            d3.select(".hovertext").remove()
                            d3.select(event.currentTarget)
                                .attr("stroke", "white")
                                .style("stroke-width", "2px")

                        })




                    svg1.selectAll("allPolylines")
                        .data(filteredPieData)
                        .join("polyline")
                        .attr("stroke", "#474747")
                        .style("fill", "none")
                        .attr("stroke-width", 1)
                        .attr("points", function(d) {
                            const firstPos = arc.centroid(d)
                            const secondPos = outerArc.centroid(d)
                            const thirdPos = outerArc.centroid(d);
                            const midangle = d.startAngle + (d.endAngle - d
                                .startAngle) / 2
                            thirdPos[0] = radius * 0.95 * (midangle < Math.PI ? 1 : -1);
                            return [firstPos, secondPos, thirdPos]
                        })

                    svg1.selectAll("allLabels")
                        .data(filteredPieData)
                        .join("text")
                        .text(d => d.data.prescription)
                        .attr("transform", function(d) {
                            const pos = outerArc.centroid(d);
                            const midangle = d.startAngle + (d.endAngle - d
                                .startAngle) / 2
                            pos[0] = radius * 0.99 * (midangle < Math.PI ? 1 : -1);
                            return `translate(${pos})`;
                        })
                        .style('text-anchor', function(d) {
                            const midangle = d.startAngle + (d.endAngle - d
                                .startAngle) / 2
                            return (midangle < Math.PI ? 'start' : 'end')
                        })
                })
            });
            </script>
    </body>

</html>