	<!DOCTYPE html>
	<?php 
	  use PHPMailer\PHPMailer\PHPMailer;
	  use PHPMailer\PHPMailer\SMTP;
	  use PHPMailer\PHPMailer\Exception;

	  require 'PHPMailer/src/Exception.php';
	  require 'PHPMailer/src/PHPMailer.php';
	  require 'PHPMailer/src/SMTP.php';

	  $title='Recover Password'; include('header.php'); 
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
              <p>If you have a difficulty with the link you can copy and paste this link on your browser: <b>https://HAIVEN.net/reset-password.php?token=' . $token . '&email=' . $to . '</b></p>
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

	  //if (isset($_POST['email'])){
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
	?>	

			<!-- start banner Area -->
			<section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								<?php echo $title; ?>				
							</h1>	
							<p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="contact.php"> <?php echo $title; ?></a></p>
						</div>	
					</div>
				</div>
			</section>
			<!-- End banner Area -->				  

			<!-- Start contact-page Area -->
			<section class="contact-page-area"><br>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<form action="" method="POST">
							  <div class="form-group"><label>Enter Your Email</label> <input type="email" class="form-control" placeholder="johndoe@mail.com" name="email"></div>
							  <div class="form-group">
							    <input type="submit" class="btn btn-success" value="Send">
							    <input type="reset" class="btn btn-primary" value="Clear">
							  </div>
							</form>
						</div>
					</div>
				</div><br><br>	
			</section>
			<!-- End contact-page Area -->

			<?php include('footer.php'); ?>	
		</body>
	</html>