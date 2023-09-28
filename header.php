<?php session_start();
	// Check if the user is logged in
  	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $title != 'Managerr Accounts') {
	    // Redirect the user to another page
	    login();
	}
	checkRememberMeCookie();
	function login() {
	    include('db.php');
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
	    include('db.php');
	    if (isset($_COOKIE['remember_me'])) {
	        $cookie = $_COOKIE['remember_me'];
	        $cookieParts = explode(':', $cookie);
	        $userId = $cookieParts[0];
	        $token = $cookieParts[1];
	        // Verify the token and user ID (example logic)
	        if (isValidToken($userId, $token)) {
	        	$_SESSION['logged_in'] = true;
	        	$_SESSION['email'] = $userId;
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
		  $code = mysqli_query($con,$sql) or die(mysql_error()); 
		  $_SESSION['email'] = $userId;
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
?>
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


		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
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
			  <header id="header" id="home">
		  		<div class="header-top">
		  			<div class="container">
				  		<div class="row">
				  			<div class="col-lg-6 col-sm-6 col-4 header-top-left no-padding">
				  				<ul>
									<li><a href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter"></i></a></li>
									<!--<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
									<li><a href="#"><i class="fa fa-behance"></i></a></li>-->
				  				</ul>
				  			</div>
				  			<div class="col-lg-6 col-sm-6 col-8 header-top-right no-padding">
				  				<a href="tel:08037852881">08037852881 | 07026000053</a>
				  				<a href="mailto:support@managerr.net">support@Managerr.net</a>			
				  			</div>
				  		</div>			  					
		  			</div>
				</div>
			    <div class="container main-menu">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="index.php"><img src="img/logo.png" height="100px" alt="" title="" /></a><br>
						<!--<small class="text-muted"><i>Ensuring exceptional service delivery for less</i></small>-->
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <?php if($title=='Managerr Accounts'){ ?>		          
				          <!-- <li><a href="reset-password.php">Reset Password</a></li> -->
						  <li><a href="login.php"><?php echo $button_value ?></a></li>
						  <?php } else { ?>
						  <li class="menu-active"><a href="index.php">Home</a></li>
				          <li><a href="about.php">Overview</a></li>
				          <!--<li><a href="services.php">Services</a></li>
				          <li><a href="feedback.php">Feedback</a></li>
				          <li class="menu-has-children"><a href="">Blog</a>
				            <ul>
				              <li><a href="blog-home.php">Blog Home</a></li>
				              <li><a href="blog-single.php">Blog Single</a></li>
				            </ul>
				          </li>
						  <button type="button" class="btn btn-outline-primary btn-lg">REQUEST A SERVICE</button>-->							          
			              <li><a href="how-it-works.php">How it works</a></li>			          
				          <li><a href="contact.php">Contact Us</a></li>
						  <li><a href="login.php"><?php echo $button_value ?></a></li>
						  <li><a class="btn btn-large btn-outline-danger" href="login.php">REQUEST A SERVICE</a></li>
						  <?php } ?>
				        </ul>
				      </nav><!-- #nav-menu-container -->		
					  <!--<a href="login.php"><button class="genric-btn primary float-left-sm float-right" >REQUEST A SERVICE</button></a>	-->				  
			    	</div>
			    </div>
			  </header><!-- #header --><br><br><br>