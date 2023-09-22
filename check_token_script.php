<?php
  // require('db.php');
  if(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['type'])){
    $query = "SELECT * FROM `users` WHERE email='".$_COOKIE['username']."' and remember_token='".$_COOKIE['password']."'";
  	$result = mysqli_query($con,$query) or die(mysqli_error());
  	$rows = mysqli_num_rows($result);
  	if($rows==1)
    {
      $_SESSION['admin_type'] = $_COOKIE['type']; $_SESSION['email'] = $_COOKIE['username'];
      echo "<script type='text/javascript'>window.top.location='flash.php';</script>"; exit;
    }
    else{
      echo "<script type='text/javascript'>window.top.location='login.php';</script>"; exit;
    }
  }
  // else{
  // 	echo "<script type='text/javascript'>window.top.location='login.php';</script>"; exit;
  // }
?>