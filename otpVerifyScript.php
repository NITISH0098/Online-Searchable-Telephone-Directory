<?php
    require("includes/common.php");
    session_start();
  
    if (isset($_SESSION['set']) ) {

      if($_SESSION['userType']=='admin')
         {header('location: admin/manage-users.php');}
     if($_SESSION['userType']=='user')
         {header('location: user/userProfile.php');}
  }

    if(isset($_POST['resend']))
       {
       /*  $to=$_SESSION['email'];
        $subject="OTP FOR ONLINE TELEPHONE DIRECTORY";
        $headers  = 'From: csm20015@tezu.ac.in' . "\r\n" .
                    'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=utf-8';
         */
           include 'includes/includeOTP.php';
       }
elseif(isset($_POST['submit']))
  {
   $otpbyuser = $_POST['otpbyuser'];
   if($otpbyuser==$_SESSION['otp'])
      {
        unset($_SESSION['otp']);
        if($_SESSION['userType']=='admin')
        {
          
            $_SESSION['set']='set';
            header('location: admin/manage-users.php');
        }
        if($_SESSION['userType']=='user')
        {
            
            $_SESSION['set']='set';
            header('location: user/userProfile.php');
        }
      }
    else
      {
        $error='Please enter the valid OTP';
        header('location: otpVerify.php?error=' . $error);
      }
  }
?>