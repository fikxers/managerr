<?php 
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	session_start();
	
	/*header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache');*/
	require('db.php');
	// Check if the user is logged in
	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $title != 'HAIVEN Accounts') {
  //if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
	    // Redirect the user to another page
	    login();
	}
	else if(!isset($_SESSION['logged_in']) && $title == 'HAIVEN Accounts'){
		echo "<script type='text/javascript'>window.top.location='login.php';</script>";
	}

	// if ($title != 'HAIVEN Accounts'){ checkRememberMeCookie(); }

	//LOGIN PROCESS
	if ($title=='Login'){
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
			  //if user exists
	      if($rows==1)
	      {
	      	$_SESSION['email'] = $email; $_SESSION['logged_in'] = true; 
	      	$_SESSION['admin_type'] = $result->fetch_object()->admin_type;
	      	//if remember me selected
	      	// if(isset($_POST["remember"])) {
					// 	$token = generateToken();
					// 	$query = "UPDATE users SET `remember_token`='".$token."' WHERE email='".$email."'";
					// 	$r = mysqli_query($con,$query) or die(mysqli_error()); //$rs = mysqli_num_rows($r);
					// 	setRememberMeCookie($email, $token);
					// } 
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
					else if($_SESSION['admin_type'] == 'hotelmgr'){
						$_SESSION['email'] = $email;
						echo "<script type='text/javascript'>window.top.location='users/hotel_mgr.php';</script>"; exit;
					}
					else{ echo "<script type='text/javascript'>window.top.location='flash.php';</script>"; exit; }
		    }
			  //user doesnt exist
		    else{
		  		echo "<script>alert('Username/password is incorrect.');</script>";
					echo "<script type='text/javascript'>window.top.location='login.php';</script>";
			  }
      }
	}

	//SIGN UP
	if ($title=='Sign Up'){
		if (isset($_REQUEST['signup'])){
			$email = stripslashes($_REQUEST['email']);
			$email = mysqli_real_escape_string($con,$email);
			$password = stripslashes($_REQUEST['password']);
			$password2 = stripslashes($_REQUEST['rpassword']);
			$admin_type = stripslashes($_REQUEST['admin_type']);//'flat';
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
				if($admin_type == 'mgr'){
					$query2 = "INSERT into `estate_manager` (`name`, `estate`, `phone`, `email`, `created_at`) VALUES ('".$name."','$estate_code','$phone','".$email."','$trn_date')";
					$check_sql = "select * from `estate_manager` where email='".$email."' and estate_code='".$estate_code."'";
				}
				$res = $con->query($check_sql); $res2 = $con->query($check);
				if ($res->num_rows > 0 || $res2->num_rows > 0) {
				  echo "<script>alert('Warning:: User Email already registered.');</script>";
				  echo "<script type='text/javascript'>window.top.location='login.php';</script>";
				}
				else{
				  $result = mysqli_query($con,$query);
				  $result2 = mysqli_query($con,$query2);
				  if($result2 && $result){
					//mail(to,subject,message,headers,parameters);
					// the message
					$msg = "<p>Dear ".$name.",<br><br>You have successfully registered on HAIVEN.<br><hr>Welcome on board!<p>";

					// use wordwrap() if lines are longer than 70 characters
					$msg = wordwrap($msg,70);

					// send email
					//mail($email,"Successful Registration on HAIVEN.net",$msg);

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
	}

	//RECOVER PASSWORD
	if($title=='Recover Password'){
		if(isset($_POST) & !empty($_POST)){
			$email_to = $_POST['email'];
			//https://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/
			$token  = RandomString(50); 
			//$new_password = md5($token);
			$query = "SELECT * FROM `users` WHERE `email`='".$email_to."'";
			$result = mysqli_query($con,$query) or die(mysqli_error());
		  $rows = mysqli_num_rows($result);
		  if($rows==1){
				$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
	  		$expDate = date("Y-m-d H:i:s",$expFormat);
		   	// Insert Temp Table
				mysqli_query($con, "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`) VALUES ('".$email_to."', '".$token."', '".$expDate."');");
		   	sendmail($email_to, $token);
			}
			else{
			  echo "<script>alert('User does not exist.');</script>";
			  echo "<script type='text/javascript'>window.top.location='login.php';</script>";
			}
	  }
	}

	function RandomString($length) {
		$keys = array_merge(range(0,9), range('a', 'z'));
		$key = "";
		for($i=0; $i < $length; $i++) {
			$key .= $keys[mt_rand(0, count($keys) - 1)];
		}
		return $key;
	}
	function sendmail($to,$token)  {
	  $msg = ' 
          <html> 
          <head> 
              <title>Password Reset</title> 
          </head> 
          <body> 
              <p>Hello,</p> <br>
              <p>Please click on <a target="_blank" href="https://HAIVEN.net/reset-password.php?token=' . $token . '&email=' . $to . '">this link</a> to reset your password.</p><br><br>
              <p>If you have a difficulty with the link you can copy and paste this link on your browser: <b>https://fikxers.com/reset-password.php?token=' . $token . '&email=' . $to . '</b></p>
              <p>If you did not request this forgotten password email, no action is needed, your password will not be reset. However, you may want to log into your account and change your security password as someone may have guessed it.</p>
          </body> 
          </html>'; 
	  //Create a new PHPMailer instance
		$mail = new PHPMailer();
		//Set PHPMailer to use the sendmail transport
		$mail->isSendmail(); //$mail->IsSMTP(); 
		//Set who the message is to be sent from
		$mail->setFrom('support@HAIVEN.net', 'HAIVEN Support');
		//Set an alternative reply-to address
		$mail->addReplyTo('info@HAIVEN.net', 'HAIVEN Support');
		//Set who the message is to be sent to
		$mail->addAddress($to);//$mail->addAddress('ypolycarp@gmail.com');
		//Set the subject line
		$mail->Subject = 'Password Reset';
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($msg);//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
		    //echo 'Mailer Error: ' . $mail->ErrorInfo;
		    echo "<script>alert('Error: ".$mail->ErrorInfo."');</script>";
			echo "<script type='text/javascript'>window.top.location='recover_password.php';</script>";
		} else {
		    //echo 'Message sent!';
		    echo "<script>alert('Check email for reset token.');</script>";
			echo "<script type='text/javascript'>window.top.location='recover_password.php';</script>";
		}
	}
	function send_booking_mail($to,$hotel,$fullname,$room_no)  {
      $msg = ' 
          <html> 
          <head> 
              <title>Hotel Room Booked via HAIVEN</title> 
          </head> 
          <body> 
              <p>Hello '.$fullname.',</p> <br><br>
              <p>You have successfully booked Room '.$room_no.' in '.$hotel.'.</p><br><br>
              <h5>Enjoy your stay.</h5><br><br>
              <p>Powered by <a target="_blank" href="HAIVEN.net">HAIVEN</a></p>
          </body> 
          </html>'; 
      //Create a new PHPMailer instance
        $mail = new PHPMailer();
        //Set PHPMailer to use the sendmail transport
        $mail->isSendmail(); //$mail->IsSMTP(); 
        //Set who the message is to be sent from
        $mail->setFrom('support@HAIVEN.net', 'HAIVEN');
        //Set an alternative reply-to address
        $mail->addReplyTo('info@HAIVEN.net', 'HAIVEN');
        //Set who the message is to be sent to
        $mail->addAddress($to);//$mail->addAddress('ypolycarp@gmail.com');
        //Set the subject line
        $mail->Subject = 'Hotel Booking Successful';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($msg);//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually
        $mail->AltBody = 'You have successfully booked Room via HAIVEN!';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors
        if (!$mail->send()) {
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            echo "<script>alert('Error: ".$mail->ErrorInfo."');</script>";
            echo "<script type='text/javascript'>window.top.location='index.php';</script>";
        } else {
            //echo 'Message sent!';
            echo "<script>alert('Check email for reset token.');</script>";
            echo "<script type='text/javascript'>window.top.location='index.php';</script>";
        }
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
	    else if($_SESSION['admin_type'] == 'hotelmgr'){
	      echo "<script type='text/javascript'>window.top.location='users/hotel_mgr.php';</script>"; exit;
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
		//include('db.php');
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
	// send notification email 
	function notification($to, $m) {
	  	$msg = ' 
          <html> 
          <head> 
              <title>Successful Signup Notification</title> 
          </head> 
          <body>'.$m.'  
			 		<hr><p>Thank you for choosing HAIVEN.</p> 
          </body> 
          </html>'; 
	  	//Create a new PHPMailer instance
			$mail = new PHPMailer();
			//Set PHPMailer to use the sendmail transport
			$mail->isSendmail();
			//Set who the message is to be sent from
			$mail->setFrom('support@HAIVEN.net', 'HAIVEN Support');
			//Set an alternative reply-to address
			$mail->addReplyTo('info@HAIVEN.net', 'HAIVEN Support');
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
			$from = 'support@HAIVEN.net'; 
			$fromName = 'HAIVEN Support Team'; 
			 
			$subject = "HAIVEN - Reset Password"; 
			 
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
	//include('pwabuilder-sw-register.js');
	//require('check_token_script.php'); 
	if(isset($_SESSION["username"]) || isset($_SESSION["email"])){
	  $button_value = '<li class="get-started-btn"><a href="logout.php">LOG OUT</a></li>';
	}
	else{
    // if($title=="Hotel Management"){
	  // 	$button_value = "<a href='hotel-mgt/login.php' class='nav-link'>Login</a>";
	  // }else{
		//   $button_value = '<li class="login-btn"><a href="login.php">LOG IN</a></li>';
    //   $button_value .= '<li class="get-started-btn"><a href="signup.php">GET STARTED</a></li>';
	  // } 
	  $button_value = '<li class="login-btn"><a href="login.php">ADMIN</a></li>';
    $button_value .= '<li class="get-started-btn"><a href="signup.php">RESIDENT</a></li>';        
	}
?>