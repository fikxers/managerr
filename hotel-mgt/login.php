<!doctype html>
<?php
  session_start();
  include('db.php');
  if (isset($_POST['email'])){
    $email = stripslashes($_REQUEST['email']); 
    $password = stripslashes($_REQUEST['password']);
    //Checking is user existing in the database or not
    $query = "SELECT * FROM `users` WHERE email='$email' and password='".md5($password)."'";
    $result = mysqli_query($con,$query) or die(mysqli_error());
    $rows = mysqli_num_rows($result);
    //if user exists
    if($rows==1)
    {
      $_SESSION['email'] = $email; 
      $_SESSION['admin_type'] = $result->fetch_object()->admin_type;
      if($_SESSION['admin_type'] == 'admin'){
        echo "<script type='text/javascript'>window.top.location='admin/index.php';</script>"; exit;
      }
      if($_SESSION['admin_type'] == 'hotelmgr'){
        echo "<script type='text/javascript'>window.top.location='mgr/index.php';</script>"; exit;
      }
      else{ 
        echo "<script>alert('User does not exist.');</script>";
        echo "<script type='text/javascript'>window.top.location='login.php';</script>"; exit; 
      }
    }
    //user doesnt exist
    else{
      echo "<script>alert('Username/password is incorrect.');</script>";
      echo "<script type='text/javascript'>window.top.location='login.php';</script>";
    }
  }
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | HAIVEN Hotel Management</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/auth.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <a href="index.php"><img class="brand" src="../img/logo.png" height="43" alt="bootstraper logo"></a>
                    </div>
                    <h6 class="mb-4 text-muted">Login to your account</h6>
                    <form action="" method="POST">
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email adress</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3 text-start">
                            <div class="form-check">
                              <input class="form-check-input" name="remember" type="checkbox" value="" id="check1">
                              <label class="form-check-label" for="check1">
                                Remember me on this device
                              </label>
                            </div>
                        </div>
                        <!-- <button class="btn btn-primary shadow-2 mb-4">Login</button> -->
                        <input type="submit" name="login" class="btn btn-primary shadow-2 mb-4" value="Login">
                    </form>
                    <!-- <p class="mb-2 text-muted">Forgot password? <a href="forgot-password.html">Reset</a></p>
                    <p class="mb-0 text-muted">Don't have account yet? <a href="signup.html">Signup</a></p> -->
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>