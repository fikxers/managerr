<?php require('db.php'); ?>
<!doctype html>
<html lang="en">
  <head>
    <title>Fikxers &mdash; Login</title>
    
	<?php
  	  ob_start();
	  session_start();
      if (isset($_POST['email'])){
  		$email = stripslashes($_REQUEST['email']); 
  		$email = mysqli_real_escape_string($con,$email); 
  		$password = stripslashes($_REQUEST['password']);
  		$password = mysqli_real_escape_string($con,$password);
  	    //Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE email='$email' and password='".md5($password)."'";
  		$result = mysqli_query($con,$query) or die(mysql_error());
  		$rows = mysqli_num_rows($result);

        if($rows==1){
  			//$_SESSION['email'] = $result->fetch_object()->email;
  			$_SESSION['admin_type'] = $result->fetch_object()->admin_type;
			if($_SESSION['admin_type'] == 'admin'){
				$_SESSION['email'] = $email;
  			   echo "<script type='text/javascript'>window.top.location='users/index.php';</script>"; exit;
			}
			else if($_SESSION['admin_type'] == 'flat'){
				$_SESSION['email'] = $email;
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
      else if($_SESSION['admin_type'] == 'student'){
        $_SESSION['email'] = $email;
           echo "<script type='text/javascript'>window.top.location='users/room.php';</script>"; exit;
      }
      else if($_SESSION['admin_type'] == 'hmgr'){
        $_SESSION['email'] = $email;
           echo "<script type='text/javascript'>window.top.location='users/hostel_mgr.php';</script>"; exit;
      }
		    //header("Location: refill.php"); // Redirect user to index.php
        }else{
  		  echo "<script>alert('Username/password is incorrect.');</script>";
		  echo "<script type='text/javascript'>window.top.location='login.php';</script>";
		  //echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
  	    }
      }else{
    ?>
	<?php include('header.php'); ?>
    <!-- END header -->
	

    <section class="site-section">
      <div class="container">
        <div class="row mb-4">
          <div class="col-md-6">
            <h1>Login</h1>
          </div>
        </div>
        <div class="row blog-entries">
          <div class="col-md-12 col-lg-12 main-content">
            
            <form action="" method="post">
             <div class="row"> 
               <div class="col-md-4 form-group">
                      <label for="email">Email</label>
                      <input type="email" name="email" class="form-control ">
               </div>
			   <div class="col-md-4 form-group">
                      <label for="name">Password</label>
                      <input type="password" name="password" class="form-control ">
               </div>
			   <div class="col-md-4 form-group"></div>
			   <div class="col-md-4 mb-3">
                    <div class="form-group">
                      <span>Forgot Password? </span><a id="linka" href="recover_password.php">Click here</a>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="form-group">
                      <span>Do no have an account? </span><a id="linka" href="signup.php">Sign Up</a>
                    </div>
                  </div>
               <div class="col-md-4 form-group"></div>
					<div class="col-md-4 form-group">
                      <input type="submit" value="Login" class="btn btn-primary">
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