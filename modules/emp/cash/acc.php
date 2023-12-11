<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    require_once("../../../config/database.php");
    $id = $_SESSION['id'];
    $eid = $_SESSION['username'];

    
    $sql = "SELECT * FROM emp WHERE eid = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $eid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $fname = ucfirst($row['fname']);
        $lname = ucfirst($row['lname']);
        
    }

    
    $currentDate = date('Y-m-d');

    
    $salData = array();
    $salQuery = "SELECT payday AS date, bonus, expenses, advance, salary FROM sal WHERE eid = ?";
    $salStmt = mysqli_prepare($conn, $salQuery);
    mysqli_stmt_bind_param($salStmt, "s", $eid);
    mysqli_stmt_execute($salStmt);
    $salResult = mysqli_stmt_get_result($salStmt);
    while ($salRow = mysqli_fetch_assoc($salResult)) {
        $salData[] = $salRow;
    }
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
        </style>
    </head>
    <body>
        <div class="header" style="background-color: #2e8b57;">
            <span style="font-size:30px;cursor:pointer" class="logo" onclick="openNav()">&#9776; Menu</span>
            <div class="header-right">
                <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            </div>
        </div>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="index.php">Home</a>
            <a href="acc.php">Attendance</a>
            <a href="update_password.php">Update Password</a>
            <a href="../../../logout.php">Logout</a>
        </div>
        <br><br>
        
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Bonus</th>
                    <th>Expenses</th>
                    <th>Advance</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($salData as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['bonus'] . "</td>";
                    echo "<td>" . $row['expenses'] . "</td>";
                    echo "<td>" . $row['advance'] . "</td>";
                    echo "<td>" . $row['salary'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
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
    header("Location: ../../../index.php");
}
?>
