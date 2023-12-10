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
        <!DOCTYPE html
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>VMTECK</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
            
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

        <div align="center">
            <table cellpadding="15px">
                <tr>

                    <?php
                    $sql_find_eid = "SELECT count(eid) AS total_eid FROM emp WHERE position='Rep '";
                    $sql_find_eid_get=mysqli_query($conn,$sql_find_eid);
                    $sql_find_eid_total = mysqli_fetch_assoc($sql_find_eid_get);
                    ?>
                    <th><div style="background-color:  #6fc47a ; color:black; padding-left:70px;padding-right: 70px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Reps</h3><p><?php echo $sql_find_eid_total['total_eid'];?></p></div></th>

                    <?php
                    $sql_find_eid = "SELECT count(eid) AS total_eid FROM emp WHERE position='Driver ' ";
                    $sql_find_eid_get=mysqli_query($conn,$sql_find_eid);
                    $sql_find_eid_total = mysqli_fetch_assoc($sql_find_eid_get);
                    ?>
                    <th><div style="background-color: #6fc47a ; color: black; padding-left:58px;padding-right: 58px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Drivers</h3><p><?php echo $sql_find_eid_total['total_eid']; ?></p></div></th>

                    <?php
                    $sql_find_eid = "SELECT count(eid) AS total_eid FROM emp WHERE position='cash' ";
                    $sql_find_eid_get=mysqli_query($conn,$sql_find_eid);
                    $sql_find_eid_total = mysqli_fetch_assoc($sql_find_eid_get);
                    ?>
                    <th><div style="background-color: #6fc47a ; color: black; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Cash Collectors</h3><p><?php echo $sql_find_eid_total['total_eid']?></p></div></th>

                </tr>
            </table>
        </div>

        <div align="center" style="background-color: white; padding: 5px;">
            <table border="1" cellpadding="7px" style=" background-color: #edefee;">
                <tr height="60px"style="background-color:#bbbdbc;">
                    <th width="250px">Position</th>
                    <th width="250px">Name</th>
                    <th width="250px">Employee ID</th>
                    
                </tr>
                <?php
                    $get_batch_information = "SELECT * FROM emp";
                    $get_batch_information_query = mysqli_query($conn,$get_batch_information);
                    while($rwo = mysqli_fetch_assoc($get_batch_information_query)){
                ?>
                        <tr>
                            <th><?php echo $rwo['position']?></th>
                            <th><?php echo ucfirst($rwo['fname' ])?></th>
                            <th><?php echo $rwo['eid']?></th>
                            
                        </tr>
                      <?php }  ?>
            </table>
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