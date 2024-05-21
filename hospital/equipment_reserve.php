<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$dID = $_SESSION['dID'];

if (!isset($_GET['eID'])) {
    header("Location: equipment.php?dID=" . urlencode($dID));
    exit;
}

include('config.php');

$equipment_id = $_GET['eID'];

//add
if (isset($_POST['add_reservation'])) {
    $date = $_POST['date'];
    $time = $_POST['time'];

    //check if the same
    $check_query = "SELECT * FROM reservation WHERE eID=? AND date=? AND time=?";
    $check_stmt = mysqli_prepare($link, $check_query);
    if ($check_stmt === false) {
        die("SQL statement preparation failed: " . mysqli_error($link));
    }
    mysqli_stmt_bind_param($check_stmt, "sss", $equipment_id, $date, $time);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Error: This equipment is already reserved at the selected date and time.";
    } else {
        $query = "INSERT INTO reservation (dID, eID, date, time) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);
        if ($stmt === false) {
            die("SQL statement preparation failed: " . mysqli_error($link));
        }
        mysqli_stmt_bind_param($stmt, "ssss", $dID, $equipment_id, $date, $time);
        if (mysqli_stmt_execute($stmt)) {
            echo "Reservation added successfully.";
        } else {
            echo "Error adding reservation: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_stmt_close($check_stmt);
}

//delete
if (isset($_POST['delete_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    $query = "DELETE FROM reservation WHERE rID=? AND dID=?";
    $stmt = mysqli_prepare($link, $query);
    if ($stmt === false) {
        die("SQL statement preparation failed: " . mysqli_error($link));
    }
    mysqli_stmt_bind_param($stmt, "ss", $reservation_id, $dID);
    if (mysqli_stmt_execute($stmt)) {
        echo "Reservation deleted successfully.";
    } else {
        echo "Error deleting reservation: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}

//update
if (isset($_POST['update_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    //check if the same
    $check_query = "SELECT * FROM reservation WHERE eID=? AND date=? AND time=? AND rID!=?";
    $check_stmt = mysqli_prepare($link, $check_query);
    if ($check_stmt === false) {
        die("SQL statement preparation failed: " . mysqli_error($link));
    }
    mysqli_stmt_bind_param($check_stmt, "ssss", $equipment_id, $date, $time, $reservation_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        echo "This equipment is already reserved at the selected date and time.";
    } else {
        $query = "UPDATE reservation SET date=?, time=? WHERE rID=? AND dID=?";
        $stmt = mysqli_prepare($link, $query);
        if ($stmt === false) {
            die("SQL statement preparation failed: " . mysqli_error($link));
        }
        mysqli_stmt_bind_param($stmt, "ssss", $date, $time, $reservation_id, $dID);
        if (mysqli_stmt_execute($stmt)) {
            // echo "Reservation updated successfully.";
        } else {
            echo "Error updating reservation: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_stmt_close($check_stmt);
}

//show reservation
$query = "SELECT * FROM reservation WHERE eID=?";
$stmt = mysqli_prepare($link, $query);
if ($stmt === false) {
    die("SQL statement preparation failed: " . mysqli_error($link));
}
mysqli_stmt_bind_param($stmt, "s", $equipment_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Reservations</title>
</head>
<body>
    <div class="container-fluid3">
        <div id="side-nav" class="sidenav">
            <a href="index.php" id="home">Home</a>
            <a href="doctor.php" id="doctors">Staffs</a>
            <a href="equipment.php" id="equipments">Equipments</a>
            <a href="treatment.php" id="treatments">Treatments</a>
        </div>
        
        <h1>Reservations for Equipment <?php echo htmlspecialchars($equipment_id); ?></h1>
        <table class="reservation-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars(date('H:i', strtotime($row['time']))); ?></td>
                    <td><?php echo htmlspecialchars($row['dID']); ?></td>
                    <td>
                        <?php if ($row['dID'] == $dID) { ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="reservation_id" value="<?php echo $row['rID']; ?>">
                            <input type="date" name="date" value="<?php echo $row['date']; ?>" required>
                            <input type="time" name="time" value="<?php echo $row['time']; ?>" required>
                            <input type="submit" name="update_reservation" value="Update">
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="reservation_id" value="<?php echo $row['rID']; ?>">
                            <input type="submit" name="delete_reservation" value="Delete">
                        </form>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class = "addReservation">
            <h2>Add Reservation</h2>
            <form method="post">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
                <input type="submit" name="add_reservation" value="Add">
            </form>
        </div>
    </body>
</html>
