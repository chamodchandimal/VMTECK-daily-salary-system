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
        if(isset($_GET['res'])) {
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
                .linking{
                    background-color: #ddffff;
                    padding: 7px;
                    text-decoration: none;
                }
                .linking:hover{
                    background-color:#3355f0;
                    color: white;
                }

                input,button,select{
                    padding: 5px;
                    border: 2px solid green;
                    border-radius: 10px;
                    margin: 2px;
                }
                input[type=submit],button{
                    width: 200px;
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
            <a href="addemp.php?addemp=true" class="linking">Add Employee</a>
            <a href="addemp.php?updateemp=true" class="linking">Update Employee</a>
        </div>

        <?php if(isset($_GET['addemp'])) {
                    $sql = "SELECT eid FROM emp ORDER BY eid DESC LIMIT 1";
                    $sql_q = mysqli_query($conn, $sql);
                    $ro = mysqli_fetch_assoc($sql_q);
                    $eid_get_from_sql = $ro['eid'];
                    function increment($sid)
                    {
                        return ++$sid[1];
                    }

            $eid_get_from_sql = preg_replace_callback("|(\d+)|", "increment", $eid_get_from_sql);

                    ?>
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
        width: 150px; 
        text-align: right; 
    }
    
    .form-row input,
    .form-row select {
        display: inline-block;
        margin: 5px;  
    }
</style>

<div class="form-container">
    <h3>Add Employee</h3>
    <form method="post">
        <div class="form-row">
            <label for="eid"><b>EID:</b></label>
            <input type="text" name="eid" id="eid" value="<?php echo $eid_get_from_sql; ?>" disabled>
        </div>
        
        <div class="form-row">
            <label for="fname"><b>First name:</b></label>
            <input type="text" name="fname" id="fname" placeholder="First Name">
        </div>

        <div class="form-row">
            <label for="lname"><b>Last name:</b></label>
            <input type="text" name="lname" id="lname" placeholder="Last Name">
        </div>

        <div class="form-row">
            <label for="email"><b>Email:</b></label>
            <input type="email" name="email" id="email" placeholder="Email">
        </div>

        <div class="form-row">
            <label for="mobile"><b>Mobile:</b></label>
            <input type="text" name="mobile" id="mobile" placeholder="Mobile">
        </div>

        <div class="form-row">
            <label for="address"><b>Address:</b></label>
            <input type="text" name="address" id="address" placeholder="Address">
        </div>

        <div class="form-row">
            <label for="dateofjoining"><b>Date Of Joining:</b></label>
            <input type="date" name="dateofjoining" id="dateofjoining">
        </div>

        <div class="form-row">
            <label for="position"><b>Position:</b></label>
            <select name="position" id="position">
                <option value="none">Select Position</option>
                <option value="Rep">Rep</option>
                <option value="Driver">Driver</option>
                <option value="Cash">Cash Collector</option>
            </select>
        </div>

        <input type="submit" name="add" value="Submit" style=font-size:20px;font-weight:bold;>
    </form>
</div>

</form>

                    </div>
                    <?php
                    if (isset($_POST['add'])) {
                        $te_fname = $_POST['fname'];
                        $te_lname = $_POST['lname'];
                        $te_email = $_POST['email'];
                        $te_mobile =$_POST['mobile'];
                        $te_address = $_POST['address'];
                        $te_dateofjoining = $_POST['dateofjoining'];
                        $te_position = $_POST['position'];
                        
                        
                        $sql_get_insert = "INSERT INTO emp (eid, fname, lname, email, mobile, address, position, dateofjoining, status) VALUES ('$eid_get_from_sql','$te_fname','$te_lname','$te_email','$te_mobile','$te_address','$te_position','$te_dateofjoining','yes')";
                        $sql_get_insert_quary = mysqli_query($conn, $sql_get_insert);
                        $insert_into_users = "INSERT INTO users (username, password, type) VALUES ('$eid_get_from_sql','$eid_get_from_sql','emp')";
                        $insert_into_users_check = mysqli_query($conn,$insert_into_users);
                        if ($sql_get_insert_quary AND $insert_into_users_check) {
                            echo '<script>location.href="addemp.php?res=success"</script>';
                        } else {
                            echo '<script>location.href="addemp.php?res=fail"</script>';
                        }

                    }
        }
        if(isset($_GET['updateemp']) OR isset($_GET['eid'])) {
            ?>
            <div align="center">
                <form method="get">
                   <br> Employee Id (EID): <input type="text" name="eid" placeholder=" ">
                    <br>
                    <input type="submit" name="update">
                </form>
            </div>

            <?php
            if (isset($_GET['eid'])) {
                $get_eid = mysqli_real_escape_string($conn, $_GET['eid']);
                if ($eid != $get_eid) {
                    $sql_query_search = "SELECT * FROM emp WHERE eid='$get_eid' ";
                    $sql_query_search_result = mysqli_query($conn, $sql_query_search);
                    $sql_query_search_result_check = mysqli_num_rows($sql_query_search_result);
                    if ($sql_query_search_result_check > 0) {
                        $rowss = mysqli_fetch_assoc($sql_query_search_result);
                        if ($rowss['position'] != 'sadmin') {
                            ?>
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
        width: 110px; 
        text-align: right; 
    }

    .form-row input {
        display: inline-block;
        margin: 5px;
    }
</style>

<div class="form-container">
    <h3>Update Details - <span style="color: blue"><?php echo $get_eid ?></span></h3>
    <form method="post">

        <div class="form-row">
            <label><b>EID:</b></label>
            <input type="text" name="eid" value="<?php echo $rowss['eid']; ?>" disabled>
        </div>

        <div class="form-row">
            <label><b>First name:</b></label>
            <input type="text" name="fname" value="<?php echo $rowss['fname']; ?>">
        </div>

        <div class="form-row">
            <label><b>Last name:</b></label>
            <input type="text" name="lname" value="<?php echo $rowss['lname']; ?>">
        </div>

        <div class="form-row">
            <label><b>Email:</b></label>
            <input type="email" name="email" value="<?php echo $rowss['email']; ?>">
        </div>

        <div class="form-row">
            <label><b>Mobile:</b></label>
            <input type="text" name="mobile" value="<?php echo $rowss['mobile']; ?>">
        </div>

        <div class="form-row">
            <label><b>Address:</b></label>
            <input type="text" name="address" value="<?php echo $rowss['address']; ?>">
        </div>

        <div class="form-row">
            <input type="submit" name="update" value="Update">
        </div>
    </form>

    <a href="addemp.php?res=fail">
        <input type="submit" name="Cancel" value="Cancel">
    </a>
</div>

                            <?php
                            if (isset($_POST['update'])) {
                                $te_fname = $_POST['fname'];
                                $te_lname = $_POST['lname'];
                                $te_email = $_POST['email'];
                                $te_mobile = $_POST['mobile'];
                                $te_address = $_POST['address'];
                                
                                $sql_q_update = "UPDATE emp SET fname='$te_fname',lname='$te_lname',email='$te_email',mobile='$te_mobile',address='$te_address' WHERE eid='$get_eid' ";
                                $sql_q_update_query = mysqli_query($conn, $sql_q_update);
                                if ($sql_q_update_query) {
                                    echo '<script>location.href="addemp.php?res=success"</script>';
                                } else {
                                    echo '<script>location.href="addemp.php?res=fail"</script>';
                                }
                            }

                        } else{
                            echo '<script>alert("You Can not Update Super Admin\'s Details Enter Another")</script>';
                        }
                    }else {
                        echo '<script>alert("Wrong EID")</script>';
                    }
                }else{
                    echo '<script>alert("You Can not Update Your Details Enter Another")</script>';
                }
            }
        }?>

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
    }else{
        ?>
        <h1>Your account is deactivated by admin due to some reasons. kindly contact Admin for further.</h1>
        <?php
    }
}else{
    header("Location: ../../index.php");
}

?>