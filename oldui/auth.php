<?php
/*
Author: Javed Ur Rehman
Website: http://www.allphptricks.com/
*/
?>

<?php
	if(!isset($_SESSION["username"])){
		$welcome = "";
		$button_value = "<a href='login.php' class='nav-link'>Login</a>";
	}
	else{
		$welcome = "Welcome back, ".$_SESSION['username']; 
		$button_value = "<a href='logout.php' class='nav-link'>Logout</a>";
	}
?>
