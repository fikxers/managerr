<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';	
	session_start();
	checkRememberMeCookie(); 
	$title='Login'; 
	if(isset($_SESSION["username"]) || isset($_SESSION["email"])) 
	  $button_value = "<a href='logout.php' class='nav-link'>Logout</a>";
	else $button_value = "<a href='login.php' class='nav-link'>Login</a>";
	// Check if the user is logged in
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $title != 'Managerr Accounts') {
	  // Redirect the user to another page
	  login();
	}

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
		
  	// Function to generate a random token
  	function generate_token()
	{
        //$validator = bin2hex(random_bytes(32));
	    $str = random_bytes(12);
		$random_password = password_hash($str, PASSWORD_DEFAULT);
   	    return $random_password;
	}
	function generateToken() {
	    $tokenLength = 32; // Set the desired token length
	    $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	    $token = '';
	    for ($i = 0; $i < $tokenLength; $i++) {
	        $token .= $charset[rand(0, strlen($charset) - 1)];
	    }
	    return $token;
	}
	// Function to set the remember me cookie
	function setRememberMeCookie($userId, $token) {
	    // $token = generateToken();
	    $_SESSION['user'] = $userId; $_SESSION['token'] = $token;
	    //header('Location: testcookie.php');
		echo "<script type='text/javascript'>window.top.location='testcookie.php';</script>"; exit; 
	    // $expiry = time() + (30 * 24 * 60 * 60); // Set the cookie expiry (e.g., 30 days)
	    // setcookie('remember_me', $userId . ':' . $token, $expiry, '/');
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
	// send notification via 
	function notification($to, $m) {
	  	$msg = ' 
          <html> 
          <head> 
              <title>Successful Signup Notification</title> 
          </head> 
          <body>'.$m.'  
			 <hr><p>Thank you for choosing Managerr.</p> 
          </body> 
          </html>'; 
	  	//Create a new PHPMailer instance
			$mail = new PHPMailer();
			//Set PHPMailer to use the sendmail transport
			$mail->isSendmail();
			//Set who the message is to be sent from
			$mail->setFrom('support@managerr.net', 'Managerr Support');
			//Set an alternative reply-to address
			$mail->addReplyTo('info@managerr.net', 'Managerr Support');
			//Set who the message is to be sent to
			$mail->addAddress($to);//$mail->addAddress('ypolycarp@gmail.com');
			//Set the subject line
			$mail->Subject = 'Successful Signup';
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML($msg);//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
			//Replace the plain text body with one created manually
			$mail->AltBody = 'Signup successful. Welcome on board.';
			//Attach an image file
			//$mail->addAttachment('images/phpmailer_mini.png');

			$mail->send();
	}
  	function send_email($user_email,$msg){
	  	//$to = 'user@example.com'; 
			$from = 'support@managerr.net'; 
			$fromName = 'Managerr Support Team'; 
			 
			$subject = "Managerr - Reset Password"; 
			 
			$htmlContent = ' 
			    <html> 
			    <head> 
			        <title>Password Reset</title> 
			    </head> 
			    <body> 
			        '.$msg.'
			    </body> 
			    </html>'; 
			 
			// Set content-type header for sending HTML email 
			$headers = "MIME-Version: 1.0" . "\r\n"; 
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
			 
			// Additional headers 
			$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
			// $headers .= 'Cc: welcome@example.com' . "\r\n"; 
			// $headers .= 'Bcc: welcome2@example.com' . "\r\n"; 
			 
			// Send email 
			if(mail($user_email, $subject, $htmlContent, $headers)){ 
		    echo "<script>alert('You have registered successfully. Please contact Estate Admin to activate your profile.');</script>";
				echo "<script type='text/javascript'>window.top.location='login.php';</script>";
			}else{ 
			  // echo 'Email sending failed.'; 
			  $errorMessage = error_get_last()['message'];
				echo "<script>alert('Error: ".$errorMessage."');</script>";
		    echo "<script type='text/javascript'>window.top.location='recover_password.php';</script>";
			}
      //echo RandomString(20);
   }
	include('db.php');
	//User Login
    if (isset($_POST['login'])){
  	  $email = stripslashes($_REQUEST['email']); 
  	  $email = mysqli_real_escape_string($con,$email); 
  	  $password = stripslashes($_REQUEST['password']);
  	  $password = mysqli_real_escape_string($con,$password);
  	  //Checking is user existing in the database or not
      $query = "SELECT * FROM `users` WHERE email='$email' and password='".md5($password)."'";
  	  $result = mysqli_query($con,$query) or die(mysqli_error());
  	  $rows = mysqli_num_rows($result);
  	  $q = "SELECT logged_in FROM `users` WHERE email='$email' and password='".md5($password)."'";
	    $r = mysqli_query($con,$q) or die(mysqli_error());
	    // $logged_in = $r->fetch_object()->logged_in; 
	    // $q = "SELECT status FROM `users` WHERE email='$email' and password='".md5($password)."'";
	    // $r = mysqli_query($con,$q) or die(mysqli_error());
	    // $status = $r->fetch_object()->status;
	    //if user exists
      if($rows==1)
      {
      	$_SESSION['email'] = $email; $_SESSION['logged_in'] = true; 
      	$_SESSION['admin_type'] = $result->fetch_object()->admin_type;
      	//if remember me selected
      	if(isset($_POST["remember"])) {
			$token = generateToken();
			$query = "UPDATE users SET `remember_token`='".$token."' WHERE email='".$email."'";
			$r = mysqli_query($con,$query) or die(mysqli_error()); //$rs = mysqli_num_rows($r);
			setRememberMeCookie($email, $token);
		} 
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
			//include('hostel/functions.php'); $token = getToken(10);
			$_SESSION['email'] = $email;
			echo "<script type='text/javascript'>window.top.location='hostel/hostel_mgr.php';</script>"; exit;
		}
		// else if($_SESSION['admin_type'] == 'event-mgr'){
		// 	$_SESSION['email'] = $_SESSION['username'] = $email;
		// 	echo "<script type='text/javascript'>window.top.location='event-manager/';</script>"; exit;
		// }
		else{ echo "<script type='text/javascript'>window.top.location='flash.php';</script>"; exit; }
      }
	  //user doesnt exist
      else{
  		echo "<script>alert('Username/password is incorrect.');</script>";
		echo "<script type='text/javascript'>window.top.location='login.php';</script>";
		//echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
	   }
    }
    else if (isset($_REQUEST['signup'])){
			$email = stripslashes($_REQUEST['email']);
			$email = mysqli_real_escape_string($con,$email);
			$password = stripslashes($_REQUEST['password']);
			$password2 = stripslashes($_REQUEST['rpassword']);
			$admin_type = 'flat';//stripslashes($_REQUEST['admin_type']);
			$phone = stripslashes($_REQUEST['phone']);
			$name = stripslashes($_REQUEST['name']);
			$flat_no = $_REQUEST['flat_no'];
			$block_no = $_REQUEST['block_no'];
			$estate_code = $_REQUEST['estate_code'];
			if(trim($password)=='' || trim($password2)=='')
			{
				echo('All fields are required!');
				header('Location: login.php');
			}
			else if($password != $password2)
			{
				echo('Passwords do not match!');
				header('Location: login.php');
			}
			else{
				$password = mysqli_real_escape_string($con,$password);
				if( ! ini_get('date.timezone') )
				{
					date_default_timezone_set('Africa/Lagos');
				}
				$trn_date = date("Y-m-d H:i:s");
				$query = "INSERT into `users` (email, password, admin_type,status) VALUES ('".$email."', '".md5($password)."', '$admin_type',0)";
				$query2 = "INSERT into `flats` (email,flat_no,block_no,estate_code,phone,owner,created_at) VALUES ('".$email."','$flat_no','$block_no', '$estate_code','$phone','$name','$trn_date')";
				$check = "select * from `users` where email='".$email."'";
				$check_sql = "select * from `flats` where flat_no='".$flat_no."' and block_no='".$block_no."' and estate_code='".$estate_code."'";
				$res = $con->query($check_sql); $res2 = $con->query($check);
				if ($res->num_rows > 0 || $res2->num_rows > 0) {
				  echo "<script>alert('Warning:: Flat/Resident Email already registered.');</script>";
				  echo "<script type='text/javascript'>window.top.location='login.php';</script>";
				}
				else{
				  $result = mysqli_query($con,$query);
				  $result2 = mysqli_query($con,$query2);
				  if($result2 && $result){
					//mail(to,subject,message,headers,parameters);
					// the message
					$msg = "<p>Dear ".$name.",<br><br>You have successfully registered on Managerr.<br><hr>Welcome on board!<p>";

					// use wordwrap() if lines are longer than 70 characters
					$msg = wordwrap($msg,70);

					// send email
					//mail($email,"Successful Registration on managerr.net",$msg);

					//send_email($email,$msg);
					notification($email,$msg);
					echo "<script>alert('You have registered successfully. Please contact Estate Admin to activate your profile.');</script>";
					echo "<script type='text/javascript'>window.top.location='login.php';</script>";
				  }
				  else{
					$error = 'Signup was unsuccessful. '.mysqli_error($con);
					echo '<script type="text/javascript">alert("'.$error.'");</script>';
					//echo "<script>alert('Signup was unsuccessful.');</script>";
					echo "<script type='text/javascript'>window.top.location='login.php';</script>";
				  }
				  $con->close();
				}
			}
	  }
    else{
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
		<link rel="manifest" href="manifest.json">
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
			<!-- start banner Area -->
			<section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								<?php echo $title; ?>				
							</h1>	
							<p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="login.php"> <?php echo $title; ?></a></p>
						</div>	
					</div>
				</div>
			</section>
			<!-- End banner Area -->				  
			<br>
			<!-- Start contact-page Area -->
			<section class="contact-page-area">
				<div class="container">					
					<div class="row">
						<div class="col-lg-12">
							<nav>
							  <div class="nav nav-tabs" id="nav-tab" role="tablist">
								<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Login</a>
								<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Sign Up</a>
								<!-- <a class="nav-item nav-link" id="nav-event-tab" data-toggle="tab" href="#event-mgr" role="tab" aria-controls="nav-profile" aria-selected="false">Event Mgr Sign Up</a> -->
							  </div>
							</nav>
							<div class="tab-content" id="nav-tabContent">
							  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
								<form class="form-area" action="" method="post" class="contact-form text-right"><br>
									<div class="row">	
										<div class="col-lg-4 form-group">
											<input name="email" placeholder="Enter Email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" class="common-input mb-20 form-control" required="" type="email">
										</div>
										<div class="col-lg-3 form-group">
											<input name="password" placeholder="Password" class="common-input mb-20 form-control" required="" type="password">
										</div>
										<div class="col-lg-3">
											<span>Forgot Password? </span><a id="linka" href="recover_password.php">Click here</a><br>
											<input type="checkbox" name="remember" />  Remember me  
										</div>
										<div class="col-lg-2">
											<div class="alert-msg" style="text-align: left;"></div>
											<button type="submit" name="login" class="genric-btn primary btn-lg circle" style="float: left;">Login</button>											
										</div>
									</div>
								</form>
							  </div>
							  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><br>
								<form class="form-area" id="register" action="" method="post" class="contact-form text-right">
									<div class="row">	
										<div class="col-lg-6 form-group">
											<input name="name" placeholder="Full name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Full name'" class="common-input mb-20 form-control" required="" type="text">
											<input name="email" placeholder="Email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">
											<input name="phone" placeholder="Phone" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone number'" class="common-input mb-20 form-control" required="" type="text">
											<select class="common-input mb-20 form-control" id="selest" data-style="btn-light" data-live-search="true" data-actions-box="true" required name="estate_code" >
											  <option value="">Select Estate/Hostel</option>
											  <?php include ('db.php');
												$sql="select estate_code,estate_name from estates"; 
												$result = $con->query($sql);; 
											    while($row = $result->fetch_assoc()) { ?>
												  <option value="<?php echo $row['estate_code']; ?>"><?php echo $row['estate_name']; ?></option>
											  <?php } ?>
											</select>
										</div>
										<div class="col-lg-6 form-group">
										    <input name="flat_no" type="text"  class="common-input mb-20 form-control" maxlength="4" placeholder="Flat/House No. E.g 2B"/>
											<input name="block_no" type="text" class="common-input mb-20 form-control" maxlength="4" placeholder="Block/Street No. E.g: 6"/>
											<input type="password" name="password" class="common-input mb-20 form-control" required placeholder="Password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
											<div class="validation"></div>
											<input name="rpassword" type="password" class="common-input mb-20 form-control" required placeholder="Repeat password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
											<div class="validation"></div>
										</div>
										<div class="col-lg-12">
											<div class="alert-msg" style="text-align: left;"></div>
											<button type="submit" name="signup" class="genric-btn primary circle" style="float: right;">Sign Up</button>
										</div>
									</div>
								</form>
							  </div>
							  <!-- <div class="tab-pane fade show" id="event-mgr" role="tabpanel" aria-labelledby="nav-event-tab">
								<form class="form-area" action="" method="post" class="contact-form text-right"><br>
									<div class="row">	
										<div class="col-lg-6 form-group">
											<input name="name" placeholder="Full name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Full name'" class="common-input mb-20 form-control" required="" type="text">										
											<input name="email" placeholder="Email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">
											<input name="phone" placeholder="Phone" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone number'" class="common-input mb-20 form-control" required="" type="text">
										</div>
										<div class="col-lg-6 form-group">
											<input name="address" type="text" class="common-input mb-20 form-control" placeholder="Full Address"/>
											<input type="password" name="password" class="common-input mb-20 form-control" required placeholder="Password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
											<div class="validation"></div>
											<input name="rpassword" type="password" class="common-input mb-20 form-control" required placeholder="Repeat password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
											<div class="validation"></div>
										</div>
										<div class="col-lg-12">
											<div class="alert-msg" style="text-align: left;"></div>
											<button type="submit" name="eventsignup" class="genric-btn primary circle" style="float: right;">Sign Up</button>
										</div>
									</div>
								</form>
							  </div> -->
							</div>
						</div>
					</div>
				</div>	
			</section><br>
			<!-- End contact-page Area -->

			<?php include('footer.php'); } ?>	
		</body>
	</html>