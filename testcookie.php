<?php
// Set the cookie
session_start(); 
setcookie('remember_me', $_SESSION['user'] . ':' . $_SESSION['token'], time() + (365 * 24 * 60 * 60), '/');
// setcookie('cookie_name', 'cookie_value', time() + 3600, '/');

// Redirect to another page
//header('Location: flash.php'); exit;

if($_SESSION['admin_type'] == 'student'){
	echo "<script type='text/javascript'>window.top.location='hostel/room.php';</script>"; exit;
}
else if($_SESSION['admin_type'] == 'security'){
    include('db.php');
	$query = "SELECT name FROM `security_team` WHERE email='".$_SESSION['email']."'";
	$result = mysqli_query($con,$query) or die(mysqli_error());
	$_SESSION['secname'] = $result->fetch_object()->name;
	echo "<script type='text/javascript'>window.top.location='security/';</script>"; exit;
}
else if($_SESSION['admin_type'] == 'hmgr'){
	echo "<script type='text/javascript'>window.top.location='hostel/hostel_mgr.php';</script>"; exit;
}
else{ echo "<script type='text/javascript'>window.top.location='flash.php';</script>"; exit; }
?>