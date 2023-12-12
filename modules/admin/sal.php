<?php
session_start();
include("../../config/database.php");

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $eid = $_SESSION['username'];
    $sql = "SELECT * FROM emp WHERE eid = '$eid'";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);

    if ($resultcheck > 0) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $fname = ucfirst($row['fname']);
        $lname = ucfirst($row['lname']);
        
        $status = $row['status'];

        if ($status == 'yes' || $status == 'Yes') {
            $eidOptions = array();
            $eidQuery = "SELECT DISTINCT eid FROM emp WHERE position = 'Rep'";
            $eidResult = mysqli_query($conn, $eidQuery);

            while ($eidRow = mysqli_fetch_assoc($eidResult)) {
                $eidOptions[] = $eidRow['eid'];
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $selectedEid = $_POST['Eid'];
                $payday = $_POST['Payday'];
                $collection = isset($_POST['Collection']) ? floatval($_POST['Collection']) : 0;
                $bonus = isset($_POST['Bonus']) ? floatval($_POST['Bonus']) : 0;
                $expenses = isset($_POST['Expenses']) ? floatval($_POST['Expenses']) : 0;
                $advance = isset($_POST['Advance']) ? floatval($_POST['Advance']) : 0;

                // Extract month and year from the Payday input
                $paydayDate = date_create($payday);
                $month = date_format($paydayDate, 'm');
                $year = date_format($paydayDate, 'Y');

                $totalSalary = $collection * 0.01 + $bonus - $expenses - $advance;

                $nameQuery = "SELECT CONCAT(fname, ' ', lname) AS fullname FROM emp WHERE eid = '$selectedEid'";
                $nameResult = mysqli_query($conn, $nameQuery);
                $nameRow = mysqli_fetch_assoc($nameResult);
                $name = $nameRow['fullname'];

                if (!empty($selectedEid) && !empty($name) && !empty($payday) && $collection >= 0 && $bonus >= 0 && $expenses >= 0 && $advance >= 0) {
                    $insertQuery = "INSERT INTO sal (Eid, Name, Payday, Collection, Bonus, Expenses, Advance, Salary, Month, Year) VALUES ('$selectedEid', '$name', '$payday', '$collection', '$bonus', '$expenses', '$advance', '$totalSalary', '$month', '$year')";

                    if (mysqli_query($conn, $insertQuery)) {
                        echo "<script>alert('Salary added');</script>";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                } else {
                    echo "All fields are required, and numeric fields should be non-negative.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .linking {
            background-color: #ddffff;
            padding: 7px;
            text-decoration: none;
        }

        .linking:hover {
            background-color: #3355f0;
            color: white;
        }

        input, button, select {
            padding: 5px;
            border: 2px solid green;
            border-radius: 10px;
            margin: 2px;
        }

        input[type=submit], button {
            width: 150px;
        }

        input:hover {
            background-color: #8fbc8f;
        }

        input[type=submit]:hover {
            background-color: #3355f0;
            color: white;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VMTECK</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
<div class="header" style="background-color: #2e8b57;">
    <span style="font-size:30px;cursor:pointer" class="logo" onclick="openNav()">&#9776; Menu </span>
    <div class="header-right">
        <a href="profile.php">
            <?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
    </div>
</div>
<div id="mySidenav" class="sidenav">
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
<br><br>
<style>
    .form-container {
        text-align: center;
    }

    .form-row {
        margin-bottom: 5px;
    }

    .form-row label {
        display: inline-block;
        margin-right: 5px;
        width: 100px;
        text-align: right;
    }

    .form-row input,
    .form-row select {
        display: inline-block;
        margin: 2px; /* Adjusted margin to keep the previous positions */
    }
</style>
<div class="content" align="center">
    <div class="form-container">
        <form action="" method="POST">
            <table class="input-table">
                <div class="form-row">
                    <label for="Payday">Payday:</label>
                    <input type="date" id="Payday" name="Payday" required>
                </div>
                <div class="form-row">
                    <label for="Eid">Employee ID:</label>
                    <select id="Eid" name="Eid" onchange="updateName()" required>
                        <option value="">Select Employee ID</option>
                        <?php
                        foreach ($eidOptions as $option) {
                            echo "<option value=\"$option\">$option</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-row">
                    <label for="Name">Name:</label>
                    <input type="text" id="Name" name="Name" readonly>
                </div>
                <div class="form-row">
                    <label for="Collection">Collection:</label>
                    <input type="number" id="Collection" name="Collection" oninput="calculateSalary()" required>
                </div>
                <div class="form-row">
                    <label for="Bonus">Bonus:</label>
                    <input type="number" id="Bonus" name="Bonus" oninput="calculateSalary()" required>
                </div>
                <div class="form-row">
                    <label for="Expenses">Expenses:</label>
                    <input type="number" id="Expenses" name="Expenses" oninput="calculateSalary()" required>
                </div>
                <div class="form-row">
                    <label for="Advance">Advance:</label>
                    <input type="number" id="Advance" name="Advance" oninput="calculateSalary()" required>
                </div>
                <div class="form-row">
                    <label for="Salary">Salary:</label>
                    <input type="text" id="Salary" name="Salary" readonly>
                </div>
                <br><br><br>
                <div class="form-row">
                    <input type="submit" value="Submit">
                </div>
            </table>
        </form>
    </div>
</div>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "300px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    function updateName() {
        var selectedEid = document.getElementById("Eid").value;
        var name = "";

        <?php
        echo "switch (selectedEid) {";
        foreach ($eidOptions as $option) {
            $nameQuery = "SELECT CONCAT(fname, ' ', lname) AS fullname FROM emp WHERE eid = '$option'";
            $nameResult = mysqli_query($conn, $nameQuery);
            $nameRow = mysqli_fetch_assoc($nameResult);
            $name = $nameRow['fullname'];
            echo "case '$option':";
            echo "name = '$name';";
            echo "break;";
        }
        echo "}
        ";
        ?>

        document.getElementById("Name").value = name;
    }

    function calculateSalary() {
        var collection = parseFloat(document.getElementById("Collection").value) || 0;
        var bonus = parseFloat(document.getElementById("Bonus").value) || 0;
        var expenses = parseFloat(document.getElementById("Expenses").value) || 0;
        var advance = parseFloat(document.getElementById("Advance").value) || 0;
        var totalSalary = collection * 0.01 + bonus - expenses - advance;
        document.getElementById("Salary").value = totalSalary.toFixed(2);
    }
</script>
</body>
</html>
