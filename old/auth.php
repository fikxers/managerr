<?php
/*
Author: Javed Ur Rehman
Website: http://www.allphptricks.com/
*/
?>

<?php
	//session_start();
	if(!isset($_SESSION["username"])){
		$welcome = "";//header("Location: login.php");
		$button_value = "<a href='login.php' class='nav-link'>Login</a>";
		//exit(); 
	}
	else{
		$welcome = "Welcome back, ".$_SESSION['username']; 
		//$welcome = "Welcome back, ".$_SESSION['email'];
		$button_value = "<a href='logout.php' class='nav-link'>Logout</a>";
	}
?>
