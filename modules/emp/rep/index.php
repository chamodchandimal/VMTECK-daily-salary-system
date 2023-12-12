<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    include("../../../config/database.php");
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

    $ydate = date('Y-m-d');
    if ($status == 'yes' || $status == 'Yes') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>VMTECK</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
            <style>
                /* Add CSS styles for the table to create borders */
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

                th {
                    font-weight: bold;
                }

                .total-row {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
        <div class="header" style="background-color: #2e8b57;">
            <span style="font-size:30px;cursor:pointer" class="logo" onclick="openNav()">&#9776; Menu</span>
            <div class="header-right">
                <a href="profile.php">
                    <?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            </div>
        </div>
        <br><br>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="profile.php">
                <?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="index.php">Home</a>
            <a href="attendance.php">Accountings</a>
            <a href="update_password.php">Update Password</a>
            <a href="../../../logout.php">Logout</a>
        </div>

        <!-- Add a table with the specified columns -->
        <table>
            <tr>
                <th>Date</th>
                <th>Collection (LKR)</th>
                <th>1% (LKR)</th>
                <th>Bonus (LKR)</th>
                <th>Expenses (LKR)</th>
                <th>Advance (LKR)</th>
                <th>Salary (LKR)</th>
            </tr>
            <?php
            // Fetch data from the 'sal' table for the current day
            $salSql = "SELECT * FROM sal WHERE eid = '$eid' AND payday = '$ydate'";
            $salResult = mysqli_query($conn, $salSql);

            $totalCollection = 0;
            $totalOnePercent = 0;
            $totalBonus = 0;
            $totalExpenses = 0;
            $totalAdvance = 0;
            $totalSalary = 0;

            while ($salRow = mysqli_fetch_assoc($salResult)) {
                echo "<tr>";
                echo "<td>" . $salRow['payday'] . "</td>";
                echo "<td>" . formatCurrency($salRow['Collection']) . "</td>";
                $onePercent = $salRow['Collection'] * 0.01;
                echo "<td>" . formatCurrency($onePercent) . "</td>";
                echo "<td>" . formatCurrency($salRow['Bonus']) . "</td>";
                echo "<td>" . formatCurrency($salRow['Expenses']) . "</td>";
                echo "<td>" . formatCurrency($salRow['Advance']) . "</td>";
                echo "<td>" . formatCurrency($salRow['salary']) . "</td>";
                echo "</tr>";

                // Accumulate totals
                $totalCollection += $salRow['Collection'];
                $totalOnePercent += $onePercent;
                $totalBonus += $salRow['Bonus'];
                $totalExpenses += $salRow['Expenses'];
                $totalAdvance += $salRow['Advance'];
                $totalSalary += $salRow['salary'];
            }

            // Display totals row
            echo "<tr class='total-row'>";
            echo "<td>Total</td>";
            echo "<td>" . formatCurrency($totalCollection) . "</td>";
            echo "<td>" . formatCurrency($totalOnePercent) . "</td>";
            echo "<td>" . formatCurrency($totalBonus) . "</td>";
            echo "<td>" . formatCurrency($totalExpenses) . "</td>";
            echo "<td>" . formatCurrency($totalAdvance) . "</td>";
            echo "<td>" . formatCurrency($totalSalary) . "</td>";
            echo "</tr>";
            ?>
        </table>

        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }
        </script>

        </body>
        </html>
        <?php
    } else {
        ?>
        <h1>Your account is deactivated by admin due to some reasons. Kindly contact Admin for further.</h1>
        <?php
    }
} else {
    header("Location: ../../../index.php");
}

function formatCurrency($amount)
{
    // Format amount as LKR
    return "LKR " . number_format($amount, 2);
}
?>
