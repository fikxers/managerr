<?php
   session_start();
   $email = $_SESSION['email'];
   if(session_destroy()) {
      include('db.php');
      $query = "UPDATE users SET `remember_token`=NULL WHERE email='".$email."'";
      $r = mysqli_query($con,$query) or die(mysqli_error($con));
      if($r){
         setcookie("username","", time() - 1); 
         setcookie("password","",time() - 1);
         setcookie ("type","",time() - 1);
      }
      header("Location: login.php");
   }
?>