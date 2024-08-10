<?php  $title='Reset Password'; include('header.php');

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

<section class="work-process-area pt-20 pb-20">
    <div class="m-auto col-lg-10">
        <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
                <a href="index.php"><img src="img/logo.png" height="40px" alt="" title="" /></a><br>
                <!--<small class="text-muted"><i>Ensuring exceptional service delivery for less</i></small>-->
            </div>
            <nav id="nav-menu-container">
              <ul class="nav-menu">
                <li class="login-btn menu-active "><a href="login.php">LOG IN</a></li>
                <li class="get-started-btn"><a href="signup.php">GET STARTED</a></li>
              </ul>
            </nav>
        </div>
    </div>
</section>

<!-- Start contact-page Area -->
<div class="body-wrapper-signup">
    <section class="pt-20 pb-20">

        <div class="m-auto col-lg-10 pad-0">
            <div class="">

            </div>
            <h1 class="login-title blue-color">Create New Password</h1>

            <div class="">
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
                </form>
            </div>
        </div>
    </section>
</div>

<?php 
    } //end if expired
    else{
      echo "<script>alert('Password Link Expired. The link is valid for 24 hours only.');</script>";
      echo "<script type='text/javascript'>window.top.location='recover_password.php';</script>";
    }// token has expired
  } //end else
} //end if token

else{    
  echo "<script>alert('Error: Password Reset Not Requested.');</script>";
  echo "<script type='text/javascript'>window.top.location='login.php';</script>";
}

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
include('footer.php'); 
?>