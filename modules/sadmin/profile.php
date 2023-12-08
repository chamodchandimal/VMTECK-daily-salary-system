<?php



session_start();
include ("../../config/database.php");
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    $id = $_SESSION['id'];
    $eid = $_SESSION['username'];
    $sql_profile = "SELECT * FROM emp WHERE eid = '$eid'";
    $sql_profile_check = mysqli_query($conn, $sql_profile);
    $sql_profile_check_result = mysqli_num_rows($sql_profile_check);
    while($rows = mysqli_fetch_assoc($sql_profile_check)){
        $fname = $rows['fname'];
        $lname = $rows['lname'];
        $email = $rows['email'];
        $mobile = $rows['mobile'];
        
    }

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>VMTECK</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <style>
           body{
                margin-top: 10px;
                margin-left: 10px;
                margin-right: 10px;
            }
           a{
                text-decoration: none;
            }
            a:hover{
                text-decoration: none;
            }
        </style>
    </head>
    <body>
    <div class="header" style="background-color:#2e8b57 ;">

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
    <br><br><br>
    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                    <img src="images/default_pic.png" alt="stack photo" class="img">
                </div>
                <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                    <div class="container" style="border-bottom:5px  solid green">
                        <h2><?php echo $fname.' '.$lname.' '; ?></h2>
                    </div>
                    <hr>
                    <div class="container details">
                        <p><span class="glyphicon glyphicon-earphone one" style="width:50px;"></span><?php echo $mobile; ?></p></li>
                        <p><span class="glyphicon glyphicon-envelope one" style="width:50px;"></span><?php echo $email; ?></p></li>
        </div>
                </div>
            </div>
        </div>
        
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
<?php } ?>