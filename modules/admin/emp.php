<?php

session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    include("../../config/database.php");
    $id = $_SESSION['id'];
    $eid = $_SESSION['username'];
    $sql = "SELECT * FROM emp WHERE eid = '$eid'";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    if($row = mysqli_fetch_assoc($result)){
        $fname= ucfirst($row['fname']);
        $lname = ucfirst($row['lname']);
        
        $status = $row['status'];
    }
    if($status == 'yes' || $status == 'Yes') {
    }else{
        header("Location: ../../index.php");
    }
}
    
    ?>
        
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VMTECK</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <style>
        /* Add this style to your CSS file or inside a <style> block */
        .table {
            border-collapse: collapse;
            width: 80%; /* Adjust the width as needed */
            margin: 0 auto; /* Center the table horizontally */
            margin-top: 20px; /* Adjust the margin-top to move the table down */
        }

        .table th, .table td {
            border: 1px solid #ddd; /* Add borders to table cells */
            padding: 8px;
            text-align: center; /* Center-align text in cells */
        }

        /* Style for the search date label */
        label#date {
            font-weight: bold;
            text-align: center;
            display: block; /* Ensure it takes the full width */
        }

        /* Style for the search button */
        input[type="date"] {
            display: block;
            margin: 0 auto;
        }

        input[type="submit"] {
            display: block;
            margin: 0 auto;
        }

        /* Style for the side navigation menu */
        .sidenav {
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111 ;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 30px;
            margin-left: 50px;
        }
    </style>
</head>
<body>
<div class="header"style="background-color: #2e8b57;" >
    <span style="font-size:30px;cursor:pointer" class="logo" onclick="openNav()">&#9776; Menu</span>
    <div class="header-right">
                <a href="profile.php">
                    <?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            </div>
    
</div>
<div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="index.php">Home</a>
            <a href="emp.php">Registration</a>
            <a href="empatt.php">Attendance</a>
            <a href="emp.php">Review</a>
            <a href="sal.php">Payroll Rep</a>
            <a href="bsal.php">Payroll </a>
            <a href="viewsal.php">Daily Payroll</a>
            <a href="viewsalid.php">Update Payroll</a>
            <a href="slip.php">Pay sheet</a>
            <a href="update_password.php">Update Password</a>
            <a href="../../logout.php">Logout</a>
</div>
<br>
<style>
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .input-group {
        display: flex;
        align-items: center;
        margin-top: 10px;  /* Added to give some space between the label and the inputs */
    }

    input[type="date"] {
        padding: 10px;
        font-size: 16px;
        border: 2px solid #555;
        border-radius: 5px;
        margin-right: 20px;  /* Added to space out the date input and submit button */
    }

    input[type="submit"] {
        padding: 10px 15px;
        font-size: 16px;
        background-color: #007BFF;
        border: none;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>

<form method="POST" action="">
    <label for="date" id="date">Select Date:</label>
    <div class="input-group">
        <input type="date" id="date" name="attendance_date">
        <input type="submit" value="Search">
    </div>
</form>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "uws";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_POST['attendance_date'])) {
    $selected_date = $_POST['attendance_date'];
} else {
    $selected_date = date("Y-m-d");
}

$sql = "SELECT * FROM att WHERE DATE(date) = '$selected_date'";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

?>

<table class="table" style="background-color:#6fc47a  ;"> <!-- Add inline style for background color -->
    <thead>
    <tr>
        <th colspan="3" style="font-size: 24px;">Attendance Report - <?php echo $selected_date; ?></th>
    </tr>
    <tr>
        <th>EID</th>
        <th>In time</th>
        <th>Out time</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($result->num_rows == 0) {
        echo "<tr><td colspan='3'>No attendance for this date.</td></tr>";
    } else {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["eid"] . "</td>
                <td>" . $row["timetocome"] . "</td>
                <td>" . $row["timetogo"] . "</td>
            </tr>";
        }
    }
    ?>
    </tbody>
</table>
<?php
$connection->close();
?>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "300px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
</body>
</html>

    