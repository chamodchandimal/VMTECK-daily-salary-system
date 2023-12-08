<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VMTECK</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
            font-size: 15px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }

        input,
        button,
        select {
            padding: 5px;
            border: 2px solid green;
            border-radius: 10px;
            margin: 2px;
        }

        input[type=submit],
        button {
            width: 100px;
        }

        input:hover {
            background-color: #8fbc8f;
        }

        input[type=submit]:hover,
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
    <div class="header" style="background-color: #2e8b57;">
        <span style="font-size: 30px; cursor: pointer" class="logo" onclick="openNav()">&#9776; Menu</span>
        <div class="header-right">
            <?php
            session_start();
            if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
                include("../../config/database.php");
                $eid = $_SESSION['username'];
                $sql = "SELECT * FROM emp WHERE eid = '$eid'";
                $result = mysqli_query($conn, $sql);
                $resultcheck = mysqli_num_rows($result);
                if ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $fname = ucfirst($row['fname']);
                    $lname = ucfirst($row['lname']);
                    
                    $status = $row['status'];
                    echo "<a href='profile.php'>" . $fname . " " . $lname . " (" . strtoupper($eid) . ")</a>";
                }
            }
            ?>
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

    <div class="content" align="center">
        <h1>Salary Details</h1>
        <form method="get">
            <h2><label for="eid">Select Employee ID:</label>
                <select name="eid" id="eid">
                    <option value="">Select an Employee ID</option>
                    <?php
                    include("../../config/database.php");
                    $eidQuery = "SELECT DISTINCT eid FROM sal";
                    $eidResult = mysqli_query($conn, $eidQuery);
                    while ($eidRow = mysqli_fetch_assoc($eidResult)) {
                        $selected = ($_GET['eid'] == $eidRow['eid']) ? 'selected' : '';
                        echo "<option value='{$eidRow['eid']}' $selected>{$eidRow['eid']}</option>";
                    }
                    ?>
                </select>
                <h2><input type="submit" name="submitEid" value="Search"></h2>
        </form>
        <table>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Payday</th>
                <th>Collection</th>
                <th>1%</th>
                <th>Bonus</th>
                <th>Expenses</th>
                <th>Advance</th>
                <th>Adjusted Salary</th>
            </tr>
            <?php
            if (isset($_GET['submitEid'])) {
                $searchedEid = $_GET['eid'];
                $currentMonth = date('n');
                $currentYear = date('Y');
                $salaryQuery = "SELECT * FROM sal WHERE eid = '$searchedEid' AND MONTH(payday) = $currentMonth AND YEAR(payday) = $currentYear";
                $salaryResult = mysqli_query($conn, $salaryQuery);
                $totalSalary = 0;
                $totalOnePercent = 0;
                $totalBonus = 0;
                $totalExpenses = 0;
                $totalAdvance = 0;
                while ($salaryRow = mysqli_fetch_assoc($salaryResult)) {
                    $employeeName = $salaryRow['name'];
                    echo "<tr>";
                    echo "<td>" . $salaryRow['eid'] . "</td>";
                    echo "<td>" . $salaryRow['name'] . "</td>";
                    echo "<td>" . $salaryRow['payday'] . "</td>";
                    echo "<td>LKR " . number_format($salaryRow['Collection'], 2) . "</td>";
                    $onePercent = $salaryRow['Collection'] * 0.01;
                    echo "<td>LKR " . number_format($onePercent, 2) . "</td>";
                    echo "<td>LKR " . number_format($salaryRow['Bonus'], 2) . "</td>";
                    echo "<td>LKR " . number_format($salaryRow['Expenses'], 2) . "</td>";
                    echo "<td>LKR " . number_format($salaryRow['Advance'], 2) . "</td>";
                    $adjustedSalary = $salaryRow['salary'] - $salaryRow['Expenses'];
                    echo "<td>LKR " . number_format($adjustedSalary, 2) . "</td>";
                    echo "</tr>";
                    $totalSalary += $adjustedSalary;
                    $totalOnePercent += $onePercent;
                    $totalBonus += $salaryRow['Bonus'];
                    $totalExpenses += $salaryRow['Expenses'];
                    $totalAdvance += $salaryRow['Advance'];
                }
                echo "<tr class='total'>";
                echo "<td colspan='4'>Total:</td>";
                echo "<td>LKR " . number_format($totalOnePercent, 2) . "</td>";
                echo "<td>LKR " . number_format($totalBonus, 2) . "</td>";
                echo "<td>LKR " . number_format($totalExpenses, 2) . "</td>";
                echo "<td>LKR " . number_format($totalAdvance, 2) . "</td>";
                echo "<td>LKR " . number_format($totalSalary, 2) . "</td>";
                echo "</tr>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='eid' value='$searchedEid'>";
                echo "<input type='hidden' name='name' value='$employeeName'>";
                echo "<input type='hidden' name='month' value='$currentMonth'>";
                echo "<input type='hidden' name='year' value='$currentYear'>";
                echo "<input type='hidden' name='total' value='$totalSalary'>";
                echo "<input type='submit' name='submit' value='Save'>";
                echo "</form>";
            }
            ?>
            <?php
            if (isset($_POST['submit'])) {
                $eid = $_POST['eid'];
                $name = $_POST['name'];
                $month = $_POST['month'];
                $year = $_POST['year'];
                $total = $_POST['total'];
                include("../../config/database.php");
                $insertQuery = "INSERT INTO tot (eid, name, month, year, total) VALUES ('$eid', '$name', '$month', '$year', '$total')";
                if (mysqli_query($conn, $insertQuery)) {
                    echo "Data saved successfully.";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
            ?>
        </table>
        <br><br><br>
        <div align="center">
            <button onclick="printTable()">Print</button>
        </div>
    </div>
</body>

</html>
