<?php require('db.php'); ?>
<!doctype html>
<html lang="en">
  <head>
    <title>Fikxers &mdash; Sign Up</title>
    
	<?php
		if (isset($_REQUEST['email'])){
			$email = stripslashes($_REQUEST['email']);
			$email = mysqli_real_escape_string($con,$email);
			$password = stripslashes($_REQUEST['password']);
			$password2 = stripslashes($_REQUEST['rpassword']);
			$admin_type = stripslashes($_REQUEST['admin_type']);
			$phone = stripslashes($_REQUEST['phone']);
			$name = stripslashes($_REQUEST['name']);
			$flat_no = stripslashes($_REQUEST['flat_no']);
			$block_no = stripslashes($_REQUEST['block_no']);
			$estate_code = stripslashes($_REQUEST['estate_code']);
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
				//$password2=$_POST['rpassword'];
				if( ! ini_get('date.timezone') )
				{
					date_default_timezone_set('Africa/Lagos');
				}
				$trn_date = date("Y-m-d H:i:s");
				$query = "INSERT into `users` (email, password, admin_type) VALUES ('$email', '".md5($password)."', '$admin_type')";
				$query2 = "";
				
				/*if($admin_type == 'admin'){
					$_SESSION['email'] = $email;
				   echo "<script type='text/javascript'>window.top.location='users/index.php';</script>"; exit;
				}*/
				if($admin_type == 'flat'){
				  $query2 = "INSERT into `flats` (email,flat_no,block_no,estate_code,phone,owner,created_at) VALUES ('$email',$flat_no,$block_no, '$estate_code','$phone','$name','$trn_date')";
				}
				else if($admin_type == 'mgr'){
				  $query2 = "INSERT into `estate_manager` (name, estate, phone,email, created_at) VALUES ('$name','$estate_code','$phone','$email', '$trn_date')";
				}
				/*else if($admin_type == 'fixer'){
					$_SESSION['email'] = $email;
				   echo "<script type='text/javascript'>window.top.location='users/fixer.php';</script>"; exit;
				}*/
				$result = mysqli_query($con,$query);
				$result2 = mysqli_query($con,$query2);
				if($result2 && $result){
					echo "<script>alert('You are registered successfully.');</script>";
					echo "<script type='text/javascript'>window.top.location='login.php';</script>";
					//echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
				}
				else{
					echo "<script>alert('Signup was unsuccessful.');</script>";
				}
			}
		}else{
	?>
	<?php include('header.php'); ?>
    <!-- END header -->
	

    <section class="site-section">
      <div class="container">
        <div class="row mb-4">
          <div class="col-md-6">
            <h1>Sign Up</h1>
          </div>
        </div>
        <div class="row blog-entries">
          <div class="col-md-12 col-lg-12 main-content">
            
            <form action="" method="post" name="login">
                <div class="row">
                  <div class="col-md-3 mb-3">
                    <div class="form-group">
                      <input name="name" type="text" class="form-control form-control-lg form-control-a" required placeholder="Full name">
                    </div>
                  </div>
				  <div class="col-md-3 mb-3">
                    <div class="form-group">
                      <input name="email" type="email" class="form-control form-control-lg form-control-a" required placeholder="Email" data-rule="email" data-msg="Please enter a valid email">
                      <div class="validation"></div>
                    </div>
                  </div>
				  <div class="col-md-3 mb-3">
                    <div class="form-group">
                      <input name="phone" type="text" class="form-control form-control-lg form-control-a" required placeholder="Phone"/>
                    </div>
                  </div>
				  <div class="col-md-3 mb-3">
                    <div class="form-group">
                      <input name="flat_no" type="text" class="form-control form-control-lg form-control-a" placeholder="Flat No. (Flats only!)"/>
                    </div>
                  </div>
				  <div class="col-md-3 mb-3">
                    <div class="form-group">
                      <input name="block_no" type="text" class="form-control form-control-lg form-control-a" placeholder="Block No. (Flats only!)"/>
                    </div>
                  </div>
				  <div class="col-md-3 mb-3">
				    <div class="form-group">
						<select class="form-control form-control-lg form-control-a" required name="estate_code" >
						  <option value="">Select Estate Code</option>
						  <?php include ('../db.php');
							$sql="select estate_code from estates"; 
							$result = $con->query($sql);; 
							while($row = $result->fetch_assoc()) { ?>
						  <option value="<?php echo $row['estate_code']; ?>"><?php echo $row['estate_code']; ?></option><?php } ?>
						</select>
				    </div>
				  </div>
				  <div class="col-md-3 mb-3">
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-lg form-control-a" required placeholder="Password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                      <div class="validation"></div>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="form-group">
                      <input name="rpassword" type="password" class="form-control form-control-lg form-control-a" required placeholder="Repeat password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                      <div class="validation"></div>
                    </div>
                  </div>
				  <div class="col-md-4 mb-3">
                    <div class="form-group">
                      <input type="radio" required name="admin_type" value="flat"> Flat
					  <input type="radio" required name="admin_type" value="mgr"> Estate Manager
					  <!--<input type="radio" name="admin_type" value="fixer"> Fixer-->
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="form-group">
                      <span>Have an account already? </span><a id="linka" href="login.php">Login</a>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                  </div>
                </div>
              </form>
          </div>
          <!-- END main-content -->
        </div>
      </div>
    </section>
  
    <?php include('footer.php'); ?>
    <!-- END footer -->
    
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>

    
    <script src="js/main.js"></script>
	<?php } ob_end_flush(); ?>
  </body>
</html>