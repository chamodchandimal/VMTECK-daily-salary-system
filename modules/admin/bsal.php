<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    include("../../config/database.php");
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
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>VMTECK</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
            <style>
            input,button,select{
                    padding: 5px;
                    border: 2px solid green;
                    border-radius: 10px;
                    margin: 2px;
                    width: 100px;
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
        <div align="center">
            
        </div>
        <br>
        <div align="center" style="background-color:#edefee; padding: 10px;">
            <form method="post">
                <h2><label for="eid">Select Employee ID:</label> 
                <select name="eid" id="eid">
                    <?php
                    $eid_query = "SELECT DISTINCT eid FROM emp WHERE position = 'Cash' OR position = 'Driver'";
                    $eid_result = mysqli_query($conn, $eid_query);
                    while ($eid_row = mysqli_fetch_assoc($eid_result)) {
                        echo '<option value="' . $eid_row['eid'] . '">' . $eid_row['eid'] . '</option>';
                         }
                    ?>
                    </h2>
               </select>
               <h2> <input type="submit" value="Search"></h2>
            </form>
            <?php
            if (isset($_POST['eid'])) {
                $search_eid = mysqli_real_escape_string($conn, $_POST['eid']);
                $query = "SELECT * FROM emp WHERE eid = '$search_eid'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo '<form method="post">';
                    echo '<table border="1" cellpadding="5px">';
                    echo '<tr><th width="250px">Position</th><th width="250px">Name</th><th width="250px">Employee ID</th>';
                    echo '<th width="250px">Basic</th><th width="250px">Bonus</th><th width="250px">Expenses</th>';
                    echo '<th width="250px">Advance</th><th width="250px">Salary</th></tr>';

                    while ($row = mysqli_fetch_assoc($result)) {
                        $employeeId = $row['eid'];
                        $employeeName = ucfirst($row['fname']) . ' ' . ucfirst($row['lname']);
                        echo '<tr>';
                        echo '<th>' . $row['position'] . '</th>';
                        echo '<th>' . $employeeName . '</th>';
                        echo '<th>' . $employeeId . '</th>';
                        echo '<td><input type="number" name="basic_' . $employeeId . '" id="basic_' . $employeeId . '" oninput="calculateSalary(\'' . $employeeId . '\')"></td>';
                        echo '<td><input type="number" name="bonus_' . $employeeId . '" id="bonus_' . $employeeId . '" oninput="calculateSalary(\'' . $employeeId . '\')"></td>';
                        echo '<td><input type="number" name="expenses_' . $employeeId . '" id="expenses_' . $employeeId . '" oninput="calculateSalary(\'' . $employeeId . '\')"></td>';
                        echo '<td><input type="number" name="advance_' . $employeeId . '" id="advance_' . $employeeId . '" oninput="calculateSalary(\'' . $employeeId . '\')"></td>';
                        echo '<td><input type="text" name="salary_' . $employeeId . '" id="salary_' . $employeeId . '" readonly></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '<br><input type="submit" name="save" value="Save "></br>';
                    echo '</form>';
                } else {
                    echo "No results found.";
                }
            }
            ?>
        </div>
        <script>
            function calculateSalary(employeeId) {
                var basic = parseFloat(document.getElementById('basic_' + employeeId).value) || 0;
                var bonus = parseFloat(document.getElementById('bonus_' + employeeId).value) || 0;
                var expenses = parseFloat(document.getElementById('expenses_' + employeeId).value) || 0;
                var advance = parseFloat(document.getElementById('advance_' + employeeId).value) || 0;
                var salary = basic + bonus - expenses - advance;

                // Round the salary to two decimal places
                salary = salary.toFixed(2);

                document.getElementById('salary_' + employeeId).value = salary;
            }

            function openNav() {
                document.getElementById("mySidenav").style.width = "300px";
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
        <h1>Your account is deactivated by admin due to some reasons. Kindly contact Admin for further assistance.</h1>
        <?php
    }
} else {
    header("Location: ../../index.php");
}

if (isset($_POST['save'])) {
    
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'basic_') !== false) {
            $employeeId = str_replace('basic_', '', $key);
            $basic = $_POST['basic_' . $employeeId];
            $bonus = $_POST['bonus_' . $employeeId];
            $expenses = $_POST['expenses_' . $employeeId];
            $advance = $_POST['advance_' . $employeeId];

            
            $query = "SELECT fname, lname FROM emp WHERE eid = '$employeeId'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $employeeName = ucfirst($row['fname']) . ' ' . ucfirst($row['lname']);

            
            $date = date("Y-m-d");
            $month = date("n");
            $year = date("Y");
            $insert_query = "INSERT INTO sal (eid, name, salary, bonus, expenses, advance, payday, month, year) VALUES ('$employeeId', '$employeeName', '$basic', '$bonus', '$expenses', '$advance', '$date', '$month', '$year')";
            mysqli_query($conn, $insert_query);
            echo "Data saved successfully.";
        }
    }
}
?>
