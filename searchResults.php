<?php
require('includes/common.php');
session_start();
if (isset($_SESSION['set']) ) {

    if($_SESSION['userType']=='admin')
       {header('location: admin/manage-users.php');}
   if($_SESSION['userType']=='user')
       {header('location: user/userProfile.php');}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>HOME| ONLINE TELEPHONE DIRECTORY</title>
        <link href="css/bootstrap.css" rel="stylesheet">
         <link href="css/style.css" rel="stylesheet"> 
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.min.css">
    
    </head>
    <body style="padding-top: 50px;">
      <div class="container">
        <?php
        include 'includes/header.php';
        include 'includes/searchbar.php';

        ?>
            <div class="row decor_bg">
                <div style="padding-top: 50px;">
                        <?php
                        include 'includes/searchFunction.php';
                           
                        ?>
                    </table>
                </div>
            </div>
        </div>

      </div>    
    </body> 
</html>
