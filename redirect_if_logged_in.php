<?php
	//make user redirect to appropriate page if logged in
	if( isset($_SESSION["admin_type"]) && isset($_SESSION["email"]) ){
		$home = 'index';
		if($_SESSION['admin_type'] == 'student'){ $home = 'hostel/room'; }
		else if($_SESSION['admin_type'] == 'security'){ $home = 'security/index'; }
		else if($_SESSION['admin_type'] == 'hmgr'){ $home = 'hostel/hostel_mgr'; }
		else{ $home = 'flash';}
		echo "<script type='text/javascript'>window.top.location='".$home.".php';</script>";
	}
?>