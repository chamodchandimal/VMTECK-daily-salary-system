<?php
session_start();
include("../../config/database.php");

// Initialize variables
$selectedEID = "";
$monthData = array_fill_keys([
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
], 0);

// Define an associative array to map month numbers to month names
$monthNumberToName = [
    '1' => 'January',
    '2' => 'February',
    '3' => 'March',
    '4' => 'April',
    '5' => 'May',
    '6' => 'June',
    '7' => 'July',
    '8' => 'August',
    '9' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
];

$totalSalary = 0;

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $id = $_SESSION['id'];
    $eid = $_SESSION['username'];

    $sql = "SELECT * FROM emp WHERE eid = '$eid'";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);

    if ($row = mysqli_fetch_assoc($result)) {
        $fname = ucfirst($row['fname']);
        $lname = ucfirst($row['lname']);
        
        $status = $row['status'];
    }

    if ($status == 'yes' || $status == 'Yes') {
        if (isset($_POST['searchEID'])) {
            $selectedEID = $_POST['searchEID'];

            // Build SQL query to retrieve total from the "tot" table
            $sql = "SELECT month, total FROM tot WHERE eid = '$selectedEID'";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $monthData[$monthNumberToName[$row['month']]] = $row['total'];
                $totalSalary += $row['total'];
            }
        }
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
        body {
            text-align: center;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            text-align: left; /* Reset text alignment for the content */
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #bbbdbc;
        }

        tr:nth-child(even) {
            background-color: #edefee;
        }

        input, button, select {
            padding: 5px;
            border: 2px solid green;
            border-radius: 10px;
            margin: 2px;
        }

        input[type=submit], button {
            width: 100px;
        }

        input:hover {
            background-color: #8fbc8f;
        }

        input[type=submit]:hover {
            background-color: #3355f0;
            color: white;
        }

        button:hover {
            background-color: #3355f0;
            color: white;
        }
    </style>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "300px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function printTable() {
            window.print();
        }
    </script>
</head>
<body>
<div class="header" style="background-color: #2e8b57;" align="left">
    <span style="font-size:30px;cursor:pointer" class="logo" onclick="openNav()">&#9776; Menu</span>
    <div class="header-right">
        <a href="profile.php">
            <?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?>
        </a>
    </div>
</div>
<div id="mySidenav" class="sidenav" align="left" >
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
    <a href="index.php">Home</a>
            <a href="addemp.php">Registration</a>
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
<div class="container">
    <div class="search-container" align="center">
        <form method="POST">
            <h2><label for="searchEID">Select Employee ID:</label>
            <select name="searchEID" id="searchEID">
                <option value="">Select EID</option></h2>
                <?php
                $query = "SELECT DISTINCT eid FROM tot"; // Assuming EIDs are in the "tot" table
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['eid'] == $selectedEID) ? 'selected' : '';
                    echo "<option value='" . $row['eid'] . "' $selected>" . $row['eid'] . "</option>";
                }
                ?>
            </select>
            <br><br>
            <button type="submit">Search</button>

            <!-- Add a Print button here -->
            <button type="button" onclick="printTable()">Print</button>
        </form>
    </div>
    <table>
        <tr>
            <th>Month</th>
            <th>Total Salary</th>
        </tr>
        <?php
        foreach ($monthData as $month => $total) {
            echo "<tr>";
            echo "<td>$month</td>";
            echo "<td>$total</td>";
            echo "</tr>";
        }
        ?>
        <tr>
            <td><strong>Total</strong></td>
            <td><strong><?php echo number_format($totalSalary, 2) . ' LKR'; ?></strong></td>
        </tr>
    </table>
</div>
</body>
</html>
