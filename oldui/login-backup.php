	<!DOCTYPE html>
	<?php session_start(); $title='Login'; include('header.php'); 
	  //ob_start();
	  
	  /*ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);*/
      if (isset($_POST['login'])){
  		$email = stripslashes($_REQUEST['email']); 
  		$email = mysqli_real_escape_string($con,$email); 
  		$password = stripslashes($_REQUEST['password']);
  		$password = mysqli_real_escape_string($con,$password);
        $query = "SELECT * FROM `users` WHERE email='$email' and password='".md5($password)."' and status=1";
  		$result = mysqli_query($con,$query) or die(mysql_error());
  		$rows = mysqli_num_rows($result);

        if($rows==1){
		    //echo "<script type='text/javascript'>window.top.location='login.php';</script>";
  			$_SESSION['admin_type'] = $result->fetch_object()->admin_type;
			if($_SESSION['admin_type'] == 'admin'){
				$_SESSION['email'] = $email;
				//echo '<script type="text/javascript">alert("Email: '.$_SESSION['email'].'");</script>';
  			   //echo "<script type='text/javascript'>window.top.location='users/page2.php';</script>"; exit;
			   echo "<script type='text/javascript'>window.top.location='users/index.php';</script>"; exit;
			}
			else if($_SESSION['admin_type'] == 'flat'){
				$_SESSION['email'] = $email;
				//echo "<script>alert('Flat.');</script>";
  			   echo "<script type='text/javascript'>window.top.location='users/flat.php';</script>"; exit;
			}
			else if($_SESSION['admin_type'] == 'mgr'){
				$_SESSION['email'] = $email;
  			   echo "<script type='text/javascript'>window.top.location='users/estate_mgr.php';</script>"; exit;
			}
			else if($_SESSION['admin_type'] == 'fixer'){
				$_SESSION['email'] = $email;
  			   echo "<script type='text/javascript'>window.top.location='users/fixer.php';</script>"; exit;
			}
        }else{
  		  echo "<script>alert('Username/password is incorrect OR Resident yet to be approved.');</script>";
		  echo "<script type='text/javascript'>window.top.location='login.php';</script>";
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
				header('Location: register.php');
			}
			else if($password != $password2)
			{
				echo('Passwords do not match!');
				header('Location: register.php');
			}
			else{
				$password = mysqli_real_escape_string($con,$password);
				if( ! ini_get('date.timezone') )
				{
					date_default_timezone_set('Africa/Lagos');
				}
				$trn_date = date("Y-m-d H:i:s");
				$query = "INSERT into `users` (email, password, admin_type,status) VALUES ('$email', '".md5($password)."', '$admin_type',0)";
				$query2 = "INSERT into `flats` (email,flat_no,block_no,estate_code,phone,owner,created_at) VALUES ('$email',$flat_no,$block_no, '$estate_code','$phone','$name','$trn_date')";
				/*$query2 = "";
				if($admin_type == 'flat'){
				  $check_sql = "select email from flats where flat_no=$flat_no and block_no=$block_no and estate_code='$estate_code'";
				  $res = mysqli_query($con,$check_sql);
				  if($res){
					echo "<script>alert('Warning:: Flat already registered.');</script>";
				    echo "<script type='text/javascript'>window.top.location='login.php';</script>";
				  }
				  $query2 = "INSERT into `flats` (email,flat_no,block_no,estate_code,phone,owner,created_at) VALUES ('$email',$flat_no,$block_no, '$estate_code','$phone','$name','$trn_date')";
				}
				else if($admin_type == 'mgr'){
				  $query2 = "INSERT into `estate_manager` (name, estate, phone,email, created_at) VALUES ('$name','$estate_code','$phone','$email', '$trn_date')";
				}*/
				$check = "select * from `users` where email='".$estate_code."'";
				$check_sql = "select * from `flats` where flat_no=$flat_no and block_no=$block_no and estate_code='".$estate_code."'";
				//$res = mysqli_query($con,$check_sql);
				$res = $con->query($check_sql); $res2 = $con->query($check);
				if ($res->num_rows > 0 || $res2->num_rows > 0) {//if($res){
				  //$con->close();
				  //echo '<script type="text/javascript">alert("'.$check_sql.'");</script>';
				  //echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
				  echo "<script>alert('Warning:: Flat/Resident Email already registered.');</script>";
				  echo "<script type='text/javascript'>window.top.location='login.php';</script>";
				  
				}
				else{
				  $result = mysqli_query($con,$query);
				  $result2 = mysqli_query($con,$query2);
				  if($result2 && $result){
					$con->close();
					echo "<script>alert('You are registered successfully.');</script>";
					echo "<script type='text/javascript'>window.top.location='login.php';</script>";
				  }
				  else{
					$con->close();
					$error = 'Signup was unsuccessful. '.mysqli_error($con);
					echo '<script type="text/javascript">alert("'.$error.'");</script>';
					//echo "<script>alert('Signup was unsuccessful.');</script>";
					echo "<script type='text/javascript'>window.top.location='login.php';</script>";
				  }
				}
			}
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
										</div>
										<div class="col-lg-2">
											<div class="alert-msg" style="text-align: left;"></div>
											<button type="submit" name="login" class="genric-btn primary btn-lg circle" style="float: left;">Login</button>											
										</div>
									</div>
								</form>
							  </div>
							  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><br>
								<form class="form-area " action="" method="post" class="contact-form text-right">
									<div class="row">	
										<div class="col-lg-6 form-group">
											<input name="name" placeholder="Full name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Full name'" class="common-input mb-20 form-control" required="" type="text">
										
											<input name="email" placeholder="Email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">

											<input name="phone" placeholder="Phone" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone number'" class="common-input mb-20 form-control" required="" type="text">
											
											<input name="flat_no" type="number"  class="common-input mb-20 form-control" placeholder="Flat No."/>
										</div>
										<div class="col-lg-6 form-group">
											<input name="block_no" type="number" class="common-input mb-20 form-control" placeholder="Block No."/>
											
											<select class="common-input mb-20 form-control" required name="estate_code" >
											<option value="">Select Estate Code</option>
											<?php include ('../db.php');
												$sql="select estate_code from estates"; 
												$result = $con->query($sql);; 
												while($row = $result->fetch_assoc()) { ?>
												  <option value="<?php echo $row['estate_code']; ?>"><?php echo $row['estate_code']; ?></option><?php } ?>
											</select>
											<input type="password" name="password" class="common-input mb-20 form-control" required placeholder="Password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
											<div class="validation"></div>
											
											<input name="rpassword" type="password" class="common-input mb-20 form-control" required placeholder="Repeat password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
											<div class="validation"></div>
											<!--<div class="form-group">
											  <input type="radio" required name="admin_type" value="flat"> Flat
											  <input type="radio" required name="admin_type" value="mgr"> Estate Manager
											</div>-->
										</div>
										<div class="col-lg-12">
											<div class="alert-msg" style="text-align: left;"></div>
											<button type="submit" name="signup" class="genric-btn primary circle" style="float: right;">Sign Up</button>											
										</div>
									</div>
								</form>
							  </div>
							</div>
						</div>
					</div>
				</div>	
			</section><br>
			<!-- End contact-page Area -->

			<?php include('footer.php'); } ?>	
		</body>
	</html>