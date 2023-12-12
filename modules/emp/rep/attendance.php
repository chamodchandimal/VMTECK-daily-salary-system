<?php

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    include("../../../config/database.php");

    $id = $_SESSION['id'];
    $eid = $_SESSION['username'];
    
    // Check if the account is active
    $accountStatusSql = "SELECT * FROM emp WHERE eid = '$eid'";
    $accountStatusResult = mysqli_query($conn, $accountStatusSql);

    if ($accountStatusResult && $row = mysqli_fetch_assoc($accountStatusResult)) {
        $status = $row['status'];

        if ($status == 'yes' || $status == 'Yes') {
            // Display the HTML content only if the account is active
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
                            <?php echo $row['fname'] . " " . $row['lname'] . " (" . strtoupper($eid) . ")" ?></a>
                    </div>
                </div>
                <br><br>
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="profile.php">
                        <?php echo $row['fname'] . " " . $row['lname'] . " (" . strtoupper($eid) . ")" ?></a>
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
                    // Fetch data from the 'sal' table for the current month
                    $currentMonth = date('m');
                    $salSql = "SELECT * FROM sal WHERE eid = '$eid' AND MONTH(payday) = '$currentMonth'";
                    $salResult = mysqli_query($conn, $salSql);

                    if ($salResult) {
                        // Initialize total variables
                        $totalCollection = $totalOnePercent = $totalBonus = $totalExpenses = $totalAdvance = $totalSalary = 0;

                        while ($salRow = mysqli_fetch_assoc($salResult)) {
                            // Display details for the current month
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
                    } else {
                        echo "<p>Error fetching salary details.</p>";
                    }
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
            // Display a message if the account is deactivated
            ?>
            <!DOCTYPE html>
            <html>
            <body>
                <h1>Your account is deactivated by admin due to some reasons. Kindly contact Admin for further assistance.</h1>
            </body>
            </html>
            <?php
        }
    } else {
        echo "<p>Error fetching account status.</p>";
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
