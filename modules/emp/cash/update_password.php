<?php

session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    include("../../../config/database.php");
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

    $ydate =date('Y-m-d');
    if($status == 'yes' || $status == 'Yes') {
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
                }
                input[type=submit],button{
                    width: 200px;
                }
                input:hover{
                    background-color:#8fbc8f ;
                }
                input[type=submit]:hover{
                    background-color: #3355f0 ;
                    color:
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
        <a href="acc.php">Accountings</a>
        <a href="update_password.php">Update Password</a>
        <a href="../../../logout.php">Logout</a>
        </div>
        <style>
    .password-form {
        text-align: center;  
    }
    
    .password-form label {
        display: inline-block;
        width: 150px;  
        text-align: right;  
    }

    .password-form input[type="password"] {
        margin-bottom: 10px;  
    }
</style>
        <div align="center">
<h4 style="font-size: 28px;">Update Password -<span style="color: blue;"> <?php echo $eid?></span></h4>

    <form class="password-form" method="post">
        <label for="oldpassword"><b>Old Password:</b></label>
        <input type="password" id="oldpassword" name="oldpassword" placeholder="Enter Old Password" required><br>
        
        <label for="newpassword_one"><b>New Password:</b></label>
        <input type="password" id="newpassword_one" name="newpassword_one" placeholder="Enter New Password" required><br>
        
        <label for="newpassword_again"><b>Confirm Password:<b></label>
        <input type="password" id="newpassword_again" name="newpassword_again" placeholder="Confirm Password" required><br>
        
      <br><br>  <input type="submit" name="changepassword" value="Change Password">
    </form>
</div>


        <?php
        if(isset($_POST['changepassword'])){
            $get_old_password=$_POST['oldpassword'];
            $get_new_password=$_POST['newpassword_one'];
            $get_new_password_again=$_POST['newpassword_again'];

            $searvh_pass = "SELECT * FROM users WHERE username='$eid' AND password='$get_old_password'";
            $searvh_pass_get = mysqli_query($conn,$searvh_pass);
            $searvh_pass_check = mysqli_num_rows($searvh_pass_get);
            if($searvh_pass_check > 0){
                if($get_new_password===$get_new_password_again){
                    $update_users = "UPDATE users SET password='$get_new_password' WHERE username='$eid' AND type='emp'";
                    $update_users_q = mysqli_query($conn,$update_users);
                    if($update_users_q){
                        echo '<script>alert("Password Update Success")</script>';
                    }else{
                        echo '<script>alert("SomeThing Went Wrong. Try Again after some time")</script>';
                    }
                }else{
                    echo '<p align="center" style="color: red">*password and confirm password does not match</p>';
                }
            }else{
                echo '<p align="center" style="color: red">*old password is wrong</p>';
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
    header("Location: ../../../index.php");
}

?>