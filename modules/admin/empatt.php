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
        if (isset($_GET['res'])) {
            if ($_GET['res'] == 'success') {
                echo '<script>alert("Successfully done")</script>';
            }
            if ($_GET['res'] == 'fail') {
                echo '<script>alert("Failed Try Again")</script>';
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
                .linking {
                    background-color: #ddffff;
                    padding: 7px;
                    text-decoration: none;
                }

                .linking:hover {
                    background-color: #3355f0;
                    color: white;
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
                    width: 200px;
                }

                input:hover {
                    background-color: #8fbc8f;
                }

                input[type=submit]:hover {
                    background-color: #3355f0;
                    color: white;
                }

            </style>
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
        <br>
        <div align="center" style="background-color:#6fc47a;padding: 15px">
            <a href="empatt.php?addattendance=true" class="linking">Add Attendance</a>
            <!-- Removed the link for updating attendance -->
        </div>
        <style>

            .form-container {
                text-align: center; /* Center everything in the container */
            }

            .form-row {
                margin-bottom: 5px; /* Some space between rows */
            }

            .form-row label {
                display: inline-block;
                margin-right: 5px;
                width: 120px; /* Adjust this value for alignment */
                text-align: right; /* Right align to make the colons align */
            }

            .form-row input {
                display: inline-block;
                margin: 5px;
            }
        </style>

        <?php if (isset($_GET['addattendance'])) { ?>
            <div align="center" class="form-container">
                <h2>Mark Employee Attendance</h2>
                <form method="post">

                    <div class="form-row">
                        <label for="eid">  EID :</label>
                        <select name="eid">
                            <option value="none">Select EID</option>
                            <?php
                            $sql_get_emp = "SELECT * FROM emp WHERE NOT position='*' order by eid";
                            $sql_get_emp_q = mysqli_query($conn, $sql_get_emp);
                            while ($empeid = mysqli_fetch_assoc($sql_get_emp_q)) {
                                ?>
                                <option value="<?php echo $empeid['eid']; ?>"><?php echo $empeid['eid'] ?></option>
                            <?php } ?>
                        </select></div>
                    <div class="form-row">
                        <label for="status"> Status:</label>
                        <select name="status">
                            <option>Select One</option>
                            <option value="p">Present</option>
                            <option value="a">Absent</option>
                        </select>
                        <div class="form-row">
                            <br> <label for="timetoin">Time To IN: </label>
                            <input type="text" name="timetoin" placeholder="Time To In">
                        </div>
                        <div class="form-row">
                            <label for="timeto"> Time To Leave: </label>
                            <input type="text" name="timetoout" placeholder="Time To Leave">
                        </div>

                        <br><br><input type="submit" name="mark" value="Mark">
                </form>
            </div>

            <?php
            if (isset($_POST['mark'])) {
                $get_eid = $_POST['eid'];
                $get_timein = $_POST['timetoin'];
                $get_timeout = $_POST['timetoout'];
                $get_status = $_POST['status'];
                $date = date('Y-m-d');

                $sql_get_results = "SELECT * FROM att WHERE eid='$get_eid' AND date='$date' ";
                $sql_get_results_q = mysqli_query($conn, $sql_get_results);
                $neeh = mysqli_num_rows($sql_get_results_q);
                if ($neeh > 0) {
                    echo '<script>alert("Attendance Already Marked")</script>';
                } else {
                    $insert_into_att = "INSERT INTO att(eid, date, timetocome, timetogo, bywhom, status ) VALUES ('$get_eid','$date','$get_timein','$get_timeout','$eid','$get_status')";
                    $insert_into_att_q = mysqli_query($conn, $insert_into_att);
                    if ($insert_into_att_q) {
                        echo '<script>alert("Successfully done")</script>';
                        echo '<script>location.href="empatt.php?addattendance=true"</script>';
                    } else {
                        echo '<script>alert("Something went wrong")</script>';
                        echo '<script>location.href="empatt.php"</script>';
                    }
                }
            }

        }

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
        <?php
    } else {
        ?>
        <h1>Your account is deactivated by admin due to some reasons. kindly contact Admin for further.</h1>
        <?php
    }
} else {
    header("Location: ../../index.php");
}

?>
