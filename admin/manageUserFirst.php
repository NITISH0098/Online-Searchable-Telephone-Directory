<?php

session_start();
include('../includes/common.php');
if(!isset($_SESSION['set']))
  {
      header('location: ../index.php');
  }

else
{
    if (isset($_GET['uid']) && $_GET['action'] == 'del') {
        $userid = $_GET['uid'];
        $query = mysqli_query($con, "DELETE FROM employee WHERE eid='$userid'");
        $query1 = mysqli_query($con, "DELETE FROM emailid WHERE eid='$userid'");
        $query2 = mysqli_query($con, "DELETE FROM callerid WHERE eid='$userid'");
        header('location:manage-users.php');
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Admin| Manage Users</title>
        <link type="text/css" href="include/theme.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.min.css">
    </head>

    <body>
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <?php include('include/sidebar.php'); 
                          include('include/searchbar.php')
                    ?>
                    <div>
                        <br>
                        <div class="content">

                            <div class="module">
                                <div class="module-body table">
                              <?php include '../includes/searchFunction.php';?>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
<?php } ?>

    </html>
