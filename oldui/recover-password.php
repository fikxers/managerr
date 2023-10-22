	<!DOCTYPE html>
	<?php $title='Change Password'; include('header.php'); 
	  if(isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"]=="update")){
		$pass1 = mysqli_real_escape_string($con,$_POST["pass1"]);
		$pass2 = mysqli_real_escape_string($con,$_POST["pass2"]);
		$email = $_POST["email"];
		$curDate = date("Y-m-d H:i:s");
		if ($pass1!=$pass2){
		  echo '<div class="alert alert-danger" role="alert">Password do not match, both password should be same.</div>';
		  //echo "<script>alert('Password do not match, both password should be same.');</script>";
		  //echo "<script type='text/javascript'>window.top.location='login.php';</script>";
		}
		else{
		  $pass1 = md5($pass1);
		  mysqli_query($con,"UPDATE `users` SET `password`='".$pass1."' WHERE `email`='".$email."';");	
          mysqli_query($con,"DELETE FROM `password_reset_temp` WHERE `email`='".$email."';");	
		  echo "<script>alert('Congratulations! Your password has been updated successfully..');</script>";
		  echo "<script type='text/javascript'>window.top.location='login.php';</script>";
		}		
	  }
	  if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){
		$key = $_GET["key"];
		$email = $_GET["email"];
		$query = mysqli_query($con,"SELECT * FROM `password_reset_temp` WHERE `key`='".$key."' and `email`='".$email."';");
		$result = mysqli_query($con,$query) or die(mysql_error());
  		$rows = mysqli_num_rows($result);
        if($rows==0){ 
		  echo "<script>alert('Invalid Link.');</script>";
		  echo "<script type='text/javascript'>window.top.location='login.php';</script>";
		}
		else{
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
							<form method="post" action="" name="update">
								<input type="hidden" name="action" value="update" />
								<br /><br />
								<label><strong>Enter New Password:</strong></label><br />
								<input type="password" name="pass1" id="pass1" maxlength="15" required />
								<br /><br />
								<label><strong>Re-Enter New Password:</strong></label><br />
								<input type="password" name="pass2" id="pass2" maxlength="15" required/>
								<br /><br />
								<input type="hidden" name="email" value="<?php echo $email;?>"/>
								<input type="submit" id="reset" value="Reset Password" />
							</form>
						</div>
					</div>
				</div><br><br>	
			</section>
			<!-- End contact-page Area -->

			<?php include('footer.php'); 
		}
	  }
			?>	
		</body>
	</html>