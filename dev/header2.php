<!-- <?php session_start();
	// Check if the user is logged in
  	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $title != 'Managerr Accounts') {
	    // Redirect the user to another page
	    login();
	}
	checkRememberMeCookie();
	function login() {
	    if($_SESSION['admin_type'] == 'student'){
	      echo "<script type='text/javascript'>window.top.location='hostel/room.php';</script>"; exit;
	    }
	    else if($_SESSION['admin_type'] == 'security'){
	      $query = "SELECT name FROM `security_team` WHERE email='".$_SESSION['email']."'";
	      $result = mysqli_query($con,$query) or die(mysqli_error());
	      $_SESSION['secname'] = $result->fetch_object()->name;
	      echo "<script type='text/javascript'>window.top.location='security/';</script>"; exit;
	    }
	    else if($_SESSION['admin_type'] == 'hmgr'){
	      echo "<script type='text/javascript'>window.top.location='hostel/hostel_mgr.php';</script>"; exit;
	    }
	    else{ echo "<script type='text/javascript'>window.top.location='flash.php';</script>"; exit; }
	}
	// Function to check if the remember me cookie is set and valid
	function checkRememberMeCookie() {
	    if (isset($_COOKIE['remember_me'])) {
	        $cookie = $_COOKIE['remember_me'];
	        $cookieParts = explode(':', $cookie);
	        $userId = $cookieParts[0];
	        $token = $cookieParts[1];

	        // Verify the token and user ID (example logic)
	        if (isValidToken($userId, $token)) {
	        	$_SESSION['logged_in'] = true;
	          // The cookie is valid, perform the necessary login actions (example)
	          loginUser($userId, $token);
	        }
	    }
	}
	// Example functions for validation and login actions (replace with your own logic)
	function isValidToken($userId, $token) {
		include('db.php');
	    // Add your validation logic here
	    $query = "SELECT * FROM `users` WHERE email='".$userId."' and remember_token='".$token."'";
	  	$result = mysqli_query($con,$query) or die(mysqli_error());
	  	$rows = mysqli_num_rows($result);
	  	if($rows==1)
	    {
	      // $_SESSION['admin_type'] = $_COOKIE['type']; $_SESSION['email'] = $_COOKIE['username'];
	      // echo "<script type='text/javascript'>window.top.location='flash.php';</script>"; exit;
	      return true;
	    }
	    else{
	      // echo "<script type='text/javascript'>window.top.location='login.php';</script>"; exit;
	      return false;
	    }
	    // Verify that the token matches the user ID and is valid in your database
	}
	function loginUser($userId, $token) {
			include('db.php');
		  // Add your login actions here
		  $sql = "SELECT admin_type FROM `users` WHERE email='".$userId."' and remember_token='".$token."'";
		  $code = mysqli_query($con,$sql) or die(mysql_error()); $_SESSION['email'] = $userId;
		  $_SESSION['admin_type'] = $code->fetch_object()->admin_type;  
		  // Log the user in or set the necessary session variables
		  // echo 'User with ID ' . $userId . ' logged in successfully.';
		  if($_SESSION['admin_type'] == 'student'){
				echo "<script type='text/javascript'>window.top.location='hostel/room.php';</script>"; exit;
			}
			else if($_SESSION['admin_type'] == 'security'){
				$query = "SELECT name FROM `security_team` WHERE email='".$_SESSION['email']."'";
				$result = mysqli_query($con,$query) or die(mysqli_error());
				$_SESSION['secname'] = $result->fetch_object()->name;
				echo "<script type='text/javascript'>window.top.location='security/';</script>"; exit;
			}
			else if($_SESSION['admin_type'] == 'hmgr'){
				echo "<script type='text/javascript'>window.top.location='hostel/hostel_mgr.php';</script>"; exit;
			}
			else{ echo "<script type='text/javascript'>window.top.location='flash.php';</script>"; exit; }
	}
	/*header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache');*/
	//include('pwabuilder-sw-register.js');
	require('db.php'); //require('check_token_script.php'); 
	if(isset($_SESSION["username"]) || isset($_SESSION["email"]))
		$button_value = "<a href='logout.php' class='nav-link'>Logout</a>";
	else
		$button_value = "<a href='login.php' class='nav-link'>Login</a>";
?> -->
<!DOCTYPE html>
<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/favicon.ico">
		<!-- Author Meta -->
		<meta name="Managerr" content="Managerr">
		<!-- Meta Description -->
		<meta name="description" content="Managerr is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead.">
		<!-- Meta Keyword -->
		<meta name="about" content="Managerr is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead.">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>Managerr | <?php echo $title; ?></title>
		<!-- Manifest for A2HS -->
		<!-- <link rel="manifest" href="manifest.webmanifest" /> -->
		<link rel="manifest" href="manifest.json" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="theme-color" content="#ffffff">


    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,400,300,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito Sans:100,200,400,300,500,600,700" rel="stylesheet">
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="css/linearicons.css">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/bootstrap.css">
			<link rel="stylesheet" href="css/magnific-popup.css">
			<link rel="stylesheet" href="css/nice-select.css">							
			<link rel="stylesheet" href="css/animate.min.css">
			<link rel="stylesheet" href="css/owl.carousel.css">
			<link rel="stylesheet" href="css/main.css">
			<style>
			@media (max-width: 768px) {
			  .float-left-sm {
				float: left;
			  }
			}
			@media (min-width: 769px) {
			  .float-right {
				float: right;
			  }
			}
			.add-button {
			  position: absolute;
			  top: 1px;
			  left: 1px;
			}
			.hidden {
			  display: none !important;
			}

			#installContainer {
			  position: absolute;
			  bottom: 1em;
			  display: flex;
			  justify-content: center;
			  width: 100%;
			}

			#installContainer button {
			  background-color: inherit;
			  border: 1px solid white;
			  color: white;
			  font-size: 1em;
			  padding: 0.75em;
			}
			</style>
		</head>
		<body>	
			  
