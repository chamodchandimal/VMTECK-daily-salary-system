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
    }
    if ($status == 'yes' || $status == 'Yes') {
        
        if (isset($_GET['date'])) {
            $selectedDate = $_GET['date'];
        } else {
            $selectedDate = date("Y-m-d"); 

        
        $salaryQuery = "SELECT * FROM sal WHERE payday = '$selectedDate'";
        $salaryResult = mysqli_query($conn, $salaryQuery);

        
        $totalSalary = 0;
        $totalOnePercent = 0;
        $totalBonus = 0;
        $totalExpenses = 0;
        $totalAdvance = 0;

        ?>

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

                th, td {
                    border: 1px solid black;
                    text-align: left;
                    padding: 8px;
                }

                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }

                .total {
                    font-weight: bold;
                    
                }
                input,button,select{
                    padding: 5px;
                    border: 2px solid green;
                    border-radius: 10px;
                    margin: 2px;
                }
                input[type=submit],button{
                    width: 100px;
                }
                input:hover{
                    background-color:#8fbc8f ;
                }
                input[type=submit]:hover{
                    background-color:#3355f0;
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
            </script>
        </head>
        <body>
        <div class="header" style="background-color: #2e8b57;">
    <span style="font-size: 30px; cursor: pointer" class="logo" onclick="openNav()">&#9776; Menu</span>
    <div class="header-right">
        <a href="profile.php">
        <?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
    </div>
</div>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="profile.php"><?php echo $fname . " " . $lname . " ( " . $eid . ")" ?></a>
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
            <h1>Daily Payroll Details</h1>
                        <form method="get">
              <h2>  <label for="date">Select Date:</label>
                <input type="date" name="date" id="date" value="<?php echo $selectedDate; ?>"></h2>
                <input type="submit" name="submitDate" value="Search " style="width: 125px; height: 30px;">
            </form>
            <br>
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
                    <th>Salary</th>
                </tr>
                <?php
                while ($salaryRow = mysqli_fetch_assoc($salaryResult)) {
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
                    echo "<td>LKR " . number_format($salaryRow['salary'], 2) . "</td>";

                    echo "</tr>";

                    
                    $totalSalary += $salaryRow['salary'];
                    $totalOnePercent += $onePercent;
                    $totalBonus += $salaryRow['Bonus'];
                    $totalExpenses += $salaryRow['Expenses'];
                    $totalAdvance += $salaryRow['Advance'];
                }
                ?>
                <tr class="total">
                    <td colspan="4">Total:</td>
                    <td>LKR <?php echo number_format($totalOnePercent, 2); ?></td>
                    <td>LKR <?php echo number_format($totalBonus, 2); ?></td>
                    <td>LKR <?php echo number_format($totalExpenses, 2); ?></td>
                    <td>LKR <?php echo number_format($totalAdvance, 2); ?></td>
                    <td>LKR <?php echo number_format($totalSalary, 2); ?></td>
                </tr>
            </table>
        </div>
        </body>
        </html>
        <?php
    }
}
?>
