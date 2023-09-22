<!DOCTYPE html>
  	<?php $title='Reset Password'; include('header.php'); 
	$email=""; $expDate = ""; $curDate = "";
	if ( isset($_GET["token"]) && isset($_GET["email"])){
	  $token = $_GET["token"]; $email = $_GET["email"]; $curDate = date("Y-m-d H:i:s");
	  $query = mysqli_query($con, "SELECT * FROM `password_reset_temp` WHERE `key`='".$token."'");
	  $rows = mysqli_num_rows($query);
	  if ($rows==0){	 
	  	echo "<script>alert('Error: Expired or Wrong Password Reset Link.');</script>";
		echo "<script type='text/javascript'>window.top.location='recover_password.php';</script>";
	  }
	  else{
	  	$row = mysqli_fetch_assoc($query); $expDate = $row['expDate']; 
	  	//$row = mysqli_fetch_assoc($query); $_SESSION["email"] = $row['email'];
	    if ($expDate >= $curDate){
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
					    <div class="card m-b-30">
					      <div class="card-body">
							<div id = 'ajaxDiv'></div>
							<form action="" method="POST" name="update">
							  <div class="form-row">
								<div class="form-group col-lg-4">
								  <input type="password" name="newpass" class="form-control" placeholder="Enter new password" required />
								</div>
								<input type="hidden" name="email" value="<?php echo $email; ?>"/>
								<div class="form-group col-lg-4">
								  <input type="password" name="confirmpass" class="form-control" placeholder="Confirm new password" required />
								</div>
								<div class="form-group col-lg-4">
								  <input type="submit" name="passreset" value="Reset Password" class="btn btn-block btn-outline-info">
								</div>
							  </div>
							</form>	<?php //echo $title; echo $email; ?>	
						  </div>
						</div>
					  </div>
					</div><!-- end row -->
				</div><br><br>	
			</section>
			<!-- End contact-page Area -->
	<?php 
		} //end if expired
		else{
		  echo "<script>alert('Password Link Expired. The link is valid for 24 hours only.');</script>";
		  echo "<script type='text/javascript'>window.top.location='recover_password.php';</script>";
		}// token has expired
	  } //end else
	} //end if token

	if(isset($_POST["email"]) && isset($_POST["confirmpass"]) ){
		$msg=""; $email = $_POST["email"];
		$pass1 = mysqli_real_escape_string($con,$_POST["newpass"]);
		$pass2 = mysqli_real_escape_string($con,$_POST["confirmpass"]);
		//$curDate = date("Y-m-d H:i:s");
		if ($pass1!=$pass2){
		  $msg= "Passwords do not match, both password should be same.";
		  $page = "reset-password";
		}
		else{
		  $r = mysqli_query($con, "UPDATE `users` SET `password`='".md5($pass1)."' WHERE `email`='".$email."'");
		  if ($r){
		  	$msg = "Password Reset Successful."; $page = "login";
		  	$r = mysqli_query($con,"DELETE FROM `password_reset_temp` WHERE `email`='".$email."';");
		  }
		  else{
		  	$msg = "Error: ". mysqli_error($con); $page = "reset-password";
		  }
		}
		echo "<script>alert('".$msg."');</script>";
		echo "<script type='text/javascript'>window.top.location='".$page.".php';</script>";
	}
	include('footer.php'); ?>	
	</body>
</html>