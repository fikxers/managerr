<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Gasciti - Sign Up</title>
  
	<?php
		require('db.php');
		// If form submitted, insert values into the database.
		if (isset($_REQUEST['username'])){
			$username = stripslashes($_REQUEST['username']); // removes backslashes
			$username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
			$email = stripslashes($_REQUEST['email']);
			$email = mysqli_real_escape_string($con,$email);
			$password = stripslashes($_REQUEST['password']);
			$password2 = stripslashes($_REQUEST['rpassword']);
			$pin = stripslashes($_REQUEST['pin']);
			$phone = stripslashes($_REQUEST['phone']);
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
			$query = "INSERT into `users` (username, password, email, trn_date,pin,phone) VALUES ('$username', '".md5($password)."', '$email', '$trn_date',$pin,$phone)";
			$result = mysqli_query($con,$query);
			if($result){
				echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
			}
			}
		}else{
	?>
  <?php include('header.php'); ?>
  <!--/ About Star /-->
  <section class="section-about">
    <div class="container">
      <div class="row">
      
        <div class="col-md-12 section-t8">
          <div class="row">
            <!--<div class="col-md-6 col-lg-5">
              <img src="img/about-2.jpg" alt="" class="img-fluid">
            </div>-->
            <div class="col-lg-2  d-none d-lg-block">
              <div class="title-vertical d-flex justify-content-start">
                <span>   </span>
              </div>
            </div>
            <div class="col-md-10 col-lg-8 section-md-t3">
              <div class="title-box-d">
                <h3 class="title-d">My Account /
                  <span class="color-d">Sign Up</span> </h3>
              </div>
            <p>Please fill your details to signup or Login using the link provided.</p>
            <div class="form">
                <form action="" method="post" name="login">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <input type="text" name="username" class="form-control form-control-lg form-control-a" placeholder="Username" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                      <div class="validation"></div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <input name="email" type="email" class="form-control form-control-lg form-control-a" placeholder="Email" data-rule="email" data-msg="Please enter a valid email">
                      <div class="validation"></div>
                    </div>
                  </div>
				  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-lg form-control-a" placeholder="Password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                      <div class="validation"></div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <input name="rpassword" type="password" class="form-control form-control-lg form-control-a" placeholder="Repeat password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                      <div class="validation"></div>
                    </div>
                  </div>
				  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <input type="password" name="pin" class="form-control form-control-lg form-control-a" placeholder="4-DIGIT PIN" data-rule="len:4" data-msg="Please enter 4 chars">
                      <div class="validation"></div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <span>Please ensure you keep this PIN safe! It is required for <b><i>password recovery.</i></b> </span>
                    </div>
                  </div>
				  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <input type="phone" name="phone" class="form-control form-control-lg form-control-a" placeholder="Phone" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                      <div class="validation"></div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="form-group">
                      <span>Have an account already? </span><a id="linka" href="login.php">Login</a>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-a">Sign Up</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
  <!--/ About End /-->

  <?php include('footer.html'); ?>
  <?php } ?>

</body>
</html>
