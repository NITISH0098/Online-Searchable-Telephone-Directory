<?php
error_reporting(0);
include('../includes/common.php');
session_start();
if (isset($_SESSION['set']) == 0) {
    header('location:../index.php');
} else {
    $successmsg = '';
    $errormsg = '';

?>
    <?php
    $queryUP = "SELECT eid FROM admin WHERE adminmail='" . $_SESSION['email'] . "'";
   // echo $queryUP;
    $resultUP = mysqli_query($con, $queryUP) or die(mysqli_errno($con));
    $rowUP = mysqli_fetch_array($resultUP);
    if (isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $desig = $_POST['desig'];
        $mailid = $_POST['mailid'];
        $phn = $_POST['phn'];
        $phn1 = $_POST['phn1'];
        $query =  mysqli_query($con, "UPDATE employee SET fname = '$fname', lname = '$lname ', designation = '$desig' WHERE eid = '" . $rowUP['eid'] . "'");
        // echo "UPDATE employee SET fname = '$fname', lname = '$lname ', designation = '$desig' WHERE eid = '" . $rowUP['eid'] . "'";
        $query1 = mysqli_query($con, "UPDATE emailid SET mailid= '$mailid' WHERE eid='" . $rowUP['eid'] . "'");

        $query2 = mysqli_query($con, "UPDATE callerid SET phone= '$phn' WHERE eid='" . $rowUP['eid'] . "' AND callerid.locationstatus='office'");

        $query3 = mysqli_query($con, "UPDATE callerid SET phone= '$phn1' WHERE eid='" . $rowUP['eid'] . "' AND callerid.locationstatus='home'");

        if ($query) {
            //echo "UPDATE employee SET fname = '$fname', lname = '$lname ', designation = '$desig' WHERE eid = '$eids'";
            //printf("UPDATE callerid SET phone= '$phn1' WHERE eid='$idupdate' AND callerid.locationstatus='home'");
            $successmsg = "Update Successfully !!";
        } else {
            $errormsg = "Profile not updated !!";
        }
    }


    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Profile</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--external css-->
        <link type="text/css" href="include/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="include/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="include/theme.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    </head>

    <body>
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <?php include("include/sidebar.php"); ?>
                    <div class="span9">
                        <div class="content">
                            <div class="module">
                                <?php
                                $query = "SELECT eid FROM admin WHERE adminmail='" . $_SESSION['email'] . "'";
                                //echo $query;
                                $result = mysqli_query($con, $query) or die(mysqli_errno($con));

                                while ($row = mysqli_fetch_array($result)) {
                                    $queryEmp = "SELECT * FROM employee WHERE eid='" . $row['eid'] . "'";
                                    //echo $queryEmp;
                                    $resultEmp = mysqli_query($con, $queryEmp) or die(mysqli_errno($con));
                                    $rowEmp = mysqli_fetch_array($resultEmp);

                                    $queryOM = "SELECT mailid FROM emailid WHERE eid='" . $row['eid'] . "'";
                                    $resultOM = mysqli_query($con, $queryOM) or die(mysqli_errno($con));
                                    $rowOM = mysqli_fetch_array($resultOM);

                                    $queryOP = "SELECT phone FROM callerid WHERE eid='" . $row['eid'] . "' AND callerid.locationstatus ='office'";
                                    $resultOP = mysqli_query($con, $queryOP) or die(mysqli_errno($con));
                                    $rowOP = mysqli_fetch_array($resultOP);

                                    $queryOP1 = "SELECT phone FROM callerid WHERE eid='" . $row['eid'] . "' AND callerid.locationstatus ='home'";
                                    $resultOP1 = mysqli_query($con, $queryOP1) or die(mysqli_errno($con));
                                    $rowOP1 = mysqli_fetch_array($resultOP1);

                                    $queryD = "SELECT description FROM location WHERE lid='" . $rowEmp['lid'] . "'";
                                    $resultD = mysqli_query($con, $queryD) or die(mysqli_errno($con));
                                    $rowD = mysqli_fetch_array($resultD);

                                    $queryR = "SELECT role FROM emprole WHERE eid='" . $row['eid'] . "'";
                                    $resultR = mysqli_query($con, $queryR) or die(mysqli_errno($con));
                                    $rowR = mysqli_fetch_array($resultR);
                                ?>

                                    <?php if ($successmsg) { ?>
                                        <div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <b>Well done!</b> <?php printf(htmlentities($successmsg)); ?>
                                        </div>
                                    <?php } ?>

                                    <?php if ($errormsg) { ?>
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <b>ERROR!</b> </b> <?php printf(htmlentities($errormsg)); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="module-head">
                                        <h3><i class="fa fa-angle-right"></i> Profile info</h3>
                                    </div>
                                    <div class="module-body">
                                        <h4 class="mb"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php printf($rowEmp['fname']); ?>'s Profile</h4>
                                        <form class="form-horizontal row-fluid" method="POST" name="profile">
                                            <div class="control-group">
                                                <label class="control-label"><b>First Name</b></label>
                                                <div class="controls">
                                                    <input type="text" name="fname" required="required" value="<?php printf($rowEmp['fname']); ?>" class="span8 tip">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="basicinput"><b>Last Name</b> </label>
                                                <div class="controls">
                                                    <input type="text" name="lname" required="required" value="<?php printf($rowEmp['lname']); ?>" class="span8 tip">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Department </label>
                                                <div class="controls">

                                                    <select name="Department" id="Department" class="span8 tip" required>

                                                        <?php
                                                        $queryLo = "SELECT lid FROM location";
                                                        $resultLo = mysqli_query($con, $queryLo) or die(mysqli_errno($con));
                                                        printf("<option selected disabled>" . $rowD["description"] . "</option>");
                                                        while ($rowLo = mysqli_fetch_array($resultLo)) {

                                                            printf("<option value=" . $rowLo["lid"] . ">" . $rowLo["lid"] . "</option>");
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Designation </label>
                                                <div class="controls">
                                                    <select name="desig" id="desig" class=" span8 tip" required>

                                                        <option selected disabled><?php printf($rowEmp['designation']); ?></option>
                                                        <option value="HOD">HOD</option>
                                                        <option value="professor">Professor</option>
                                                        <option value="associate professor">Associate Professor</option>
                                                        <option value="assistant professor">Assistant Professor</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label"><b>Role</b> </label>
                                                <div class="controls">
                                                    <select name="role" id="role" class="span8 tip">
                                                        <option selected disabled><?php printf($rowR['role']); ?></option>
                                                        <option value="Vice-chancellor">Vice-chancellor</option>
                                                        <option value="Pro Vice-Chancellor">Pro Vice-Chancellor</option>
                                                        <option value="Dean">Dean</option>
                                                    
                                                        <optgroup label="Administrative Offices">
                                                            <option value="Finance Officer">Finance Officer</option>
                                                            <option value="Deputy Registrar">Deputy Registrar</option>
                                                            <option value="Joint Registrar">Joint Registrar</option>
                                                            <option value="Asistant Resigstrar">Asistant Resigstrar</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label"><b>Phone Number(Office)</b> </label>
                                                <div class="controls">
                                                    <input type="tel" placeholder="Enter Phone No" name="phn" id="phn" value="<?php printf($rowOP['phone']); ?>" class=" span8 tip" maxlength="4" minlength="4" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label"><b>Phone Number(Home)</b> </label>
                                                <div class="controls">
                                                    <input type="tel" placeholder="Enter Phone No" name="phn1" id="phn1" value="<?php printf($rowOP1['phone']); ?>" class=" span8 tip" maxlength="4" minlength="4">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Official Email </label>
                                                <div class="controls">
                                                    <input type="text" name="mailid" required="required" value="<?php printf($rowOM['mailid']); ?>" class="span8 tip">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">
                                                    <button type="submit" name="submit" class="btn btn-success">Edit Details</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>

    </html>
<?php
                                }
?>
<?php
}
?>