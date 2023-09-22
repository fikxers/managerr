<?php
  session_start();
  //echo '<script type="text/javascript">alert("'.$_SESSION['email'].'");</script>';
  if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    exit(); 
  }
?>
