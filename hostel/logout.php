<?php
session_start(); 
//include "config.php";
require('../db.php');

if(isset($_SESSION['email'])){
   // Delete token 
   $uname = mysqli_real_escape_string($con,$_SESSION['email']);
   
   //mysqli_query($con, "delete from user_token where username = '".$uname."'");
   mysqli_query($con,"update users set logged_in=0 where email='".$_SESSION['email']."'");
   
   // Destroy session
   session_destroy();
   header('Location: ../login.php');
}else{
   header('Location: ../login.php');
}