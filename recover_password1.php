	<!DOCTYPE html>
	<?php $title='Recover Password'; include('header.php'); 
	  function RandomString($length) {
		$keys = array_merge(range(0,9), range('a', 'z'));
		$key = "";
		for($i=0; $i < $length; $i++) {
			$key .= $keys[mt_rand(0, count($keys) - 1)];
		}
		return $key;
	  }
      //echo RandomString(20);
	  if (isset($_POST['email'])){
		$email_to = $_POST['email'];
		
		//https://codingcyber.org/send-forgotten-password-by-mail-using-php-and-mysql-35/
		$token  = RandomString(20); 
		$link = "https://managerr.net/reset-password.php?key='.$token.'&email='.$email.'&action=reset";
		mysqli_query($con, "INSERT INTO `password_reset_temp` (`email`, `key`) VALUES ('".$email."', '".$key."');");
		$output='<p>Dear user,</p>';
		$output.='<p>Please click on the following link to reset your password.</p>';
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<p><a href="https://managerr.net/reset-password.php?key='.$token.'&email='.$email_to.'&action=reset" target="_blank">https://managerr.net/reset-password.php?key='.$token.'&email='.$email_to.'&action=reset</a></p>';		
		$output.='<p>-------------------------------------------------------------</p>';
		$output.='<p>Please be sure to copy the entire link into your browser.</p>';
		$output.='<p>If you did not request this forgotten password email, no action 
		is needed, your password will not be reset. However, you may want to log into 
		your account and change your security password as someone may have guessed it.</p>';   	
		$output.='<p>Thanks,</p>';
		$output.='<p>Realeng Tech Team</p>';
		$body = $output; 
		$subject = "Password Recovery - managerr.net";
		$fromserver = "support@managerr.net"; 
		mail($email_to, $subject, $body, $fromserver) or die("Error!");
		//echo '<script type="text/javascript">alert("'.$link.'");</script>';
		echo "<script>alert('An email has been sent to you with instructions on how to reset your password.');</script>";
		echo "<script type='text/javascript'>window.top.location='login.php';</script>";
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
							  <div class="form-group"><label>Email</label> <input type="text"  class="form-control" name="email"></div>
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