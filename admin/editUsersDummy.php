<?php
include('../includes/common.php');
error_reporting(0);
session_start();
if (!isset($_SESSION['set'])) {
    header('location: ../index.php');
}


//$des='';
$desig = '';
$eids = $_GET['uid'];
$fn = $_GET['fn'];
$ln = $_GET['ln'];
$desig = $_GET['desig'];
$role = $_GET['role'];
$dept = $_GET['des'];
$em = $_GET['em'];
$phn = $_GET['phn'];
$phn1 = $_GET['phn1'];
$successmsg = '';
$errormsg = '';

// echo $_SESSION['eeid'];
?>
<?php
if (isset($_POST['submit'])) {
    $idupdate = $_GET['uid'];
    //echo $idupdate;
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $desig = $_POST['desig'];
    $dept = $_POST['dept'];
    $mailid = $_POST['mailid'];
    $role = $_POST['role'];
    $phn = $_POST['phn'];
    $phn1 = $_POST['phn1'];

    $query =  mysqli_query($con, "UPDATE employee SET fname = '$fname', lname = '$lname ', designation = '$desig' WHERE eid = '$idupdate'");
    //echo "UPDATE employee SET fname = '$fname', lname = '$lname ', designation = '$desig' WHERE eid = '$idupdate'";
    $query1 = mysqli_query($con,  "UPDATE emailid SET mailid= '$mailid' WHERE eid='$idupdate'");

    $query2 = mysqli_query($con, "UPDATE callerid SET phone= '$phn' WHERE eid='$idupdate' AND callerid.locationstatus='office'");

    $query3 = mysqli_query($con, "UPDATE callerid SET phone= '$phn1' WHERE eid='$idupdate' AND callerid.locationstatus='home'");

    //$query4 = mysqli_query($con, "UPDATE location SET description= '$dept' WHERE eid='$idupdate'");

    $queryR = "SELECT role FROM emprole WHERE eid='$idupdate'";
    $resultR = mysqli_query($con, $queryR) or die(mysqli_errno($con));
    $rowR = mysqli_fetch_array($resultR);

    if (mysqli_num_rows($resultR) > 0) {
        $query5 = mysqli_query($con, "UPDATE emprole SET role= '$role' WHERE eid='$idupdate'");
        //echo "UPDATE emprole SET role= '$role' WHERE eid='$idupdate";
    } else {
        $query6 = "INSERT INTO emprole(eid,lid,role) VALUES('" . $idupdate . "','" . $dept . "','" . $role . "')";
        //echo  $query6;
        $result6 = mysqli_query($con, $query6) or die(mysqli_errno($con));
    }

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
                                <h4 class="mb"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php printf($fn); ?>'s Profile</h4>
                                <form class="form-horizontal row-fluid" method="POST" name="profile">
                                    <div class="control-group">
                                        <label class="control-label"><b>First Name</b></label>
                                        <div class="controls">
                                            <input type="text" name="fname" required="required" value="<?php printf($fn); ?>" class="span8 tip">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="basicinput"><b>Last Name</b> </label>
                                        <div class="controls">
                                            <input type="text" name="lname" required="required" value="<?php printf($ln); ?>" class="span8 tip">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Department </label>
                                        <div class="controls">
                                            <select name="Dept" id="Dept" class="span8 tip" required>
                                                <?php
                                                $queryLo = "SELECT * FROM location";
                                                $resultLo = mysqli_query($con, $queryLo) or die(mysqli_errno($con));
                                                printf("<option selected disabled>" . $dept . "</option>");
                                                while ($rowLo = mysqli_fetch_array($resultLo)) {

                                                    printf("<option value=" . $rowLo["lid"] . ">" . $rowLo["description"] . "</option>");
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Designation</label>
                                        <div class="controls">
                                            <select name="desig" id="desig" class=" span8 tip" required>
                                                <option value="<?php printf($ln); ?>" selected disabled><?php printf($desig); ?></option>
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
                                                <option  value="<?php printf($role); ?>"selected disabled><?php printf($role); ?></option>
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
                                            <input type="tel" placeholder="Enter Phone No" name="phn" id="phn" value="<?php printf($phn); ?>" class=" span8 tip" maxlength="4" minlength="4" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label"><b>Phone Number(Home)</b> </label>
                                        <div class="controls">
                                            <input type="tel" placeholder="Enter Phone No" name="phn1" id="phn1" value="<?php printf($phn1); ?>" class=" span8 tip" maxlength="4" minlength="4">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Official Email </label>
                                        <div class="controls">
                                            <input type="mail" name="mailid" required="required" value="<?php printf($em); ?>" class="span8 tip">
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

<?php //} 
?>