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
            background-color: #3355f0;
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
            background-color:#3355f0 ; 
        }
        th,td{
            width: 200px;
        }

        hr{
            width: 60%;
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
        <a href="view.php">View Employee Details</a>
        <a href="update_password.php">Update Password</a>
        <a href="../../logout.php">Logout</a>
</div>
<br><br>
<div align="center" style="background-color:#6fc47a; padding: 10px">
    <a href="view.php?students=true" class="linking">Search employee details</a>
</div>
<br><br>
<?php
    if(isset($_GET['students'])){ ?>
        <div align="center">
            <form method="post">
                <b>Employee ID (EID): </b><input type="text" name="studentid"  required><br>
                <br><input type="submit" name="search_student" value="Submit">
            </form>
            <br>
            <hr style="border-bottom:3px solid green">
        </div>
        <?php
        if(isset($_POST['search_student'])){
            $sql_get_id = mysqli_real_escape_string($conn,$_POST['studentid']);
            $search_student = "SELECT * FROM emp WHERE eid='$sql_get_id'";
            $search_student_q = mysqli_query($conn,$search_student);
            $search_student_q_ch = mysqli_num_rows($search_student_q);
            if ($search_student_q_ch <= 0){
                echo '<h3 align="center" style="color: red">Wrong SID</h3>';
            }else{
                $as = mysqli_fetch_assoc($search_student_q);
                ?>
                <br><div align="center">
                    <p><b>SID: </b><?php echo $as['eid']; ?></p>
                    <p><b>Name: </b><?php echo $as['fname'].' '.$as['lname']; ?></p>
                    <p><b>Mobile: </b><?php echo $as['mobile']; ?></p>
                    <p><b>Address: </b><?php echo $as['address']; ?></p>
                    </div>
            <?php }
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
}else{
    ?>
    <h1>Your account is deactivated by admin due to some reasons. kindly contact Admin for further.</h1>
    <?php
}
}else{
    header("Location: ../../index.php");
}

?>