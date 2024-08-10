<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Update Password</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700" rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">

    <link rel="stylesheet" href="../fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
   <!-- Theme Style -->
   <link rel="stylesheet" href="../css/style.css"><link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
</head>
<body>

<section class="site-section">
 <div class="container">
   <?php
    session_start();
    // connect to the database
    include ('../db.php');
    $id = $_GET['id'];
    $op = $_GET['op'];//1-Assign**2-Confirm***3-Delete***4-Feedback

    if (isset($_POST['pswd'])){
    	$pswd = stripslashes($_REQUEST['password']);
      $query = "UPDATE users SET password='".md5($pswd)."' WHERE email='".$id."'";
      $result = mysqli_query($con,$query);
      if($result){
        echo "<script>alert('Password changed.');</script>";
        echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      }
      else{
        //echo "<script>alert('Error Assigning Job');</script>"; 
        echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      }
    }
    else if (isset($_POST['cancel'])){
  	 echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>";
    }
    else if (isset($_POST['intruder'])){
     echo "<script type='text/javascript'>window.top.location='../logout.php';</script>";
    }
    else{
      switch ($op) {
        case 1:
          echo "<h1>Update Resident Password</h1>";
          echo '<form class="" action="" method="POST">
            <div class="form-group">
              <label for="password">New Password</label>
              <input type="password" name="password" class="form-control" required/>
            </div>
            <div class="form-group">
              <button type="submit" name="pswd" class="btn btn-primary"> Update</button> 
              <a class="btn btn-primary" href="javascript:history.go(-1)" title="Return to previous page">&laquo; Cancel</a>
            </div>
          </form>';
          break;
        case 2:
          echo "<h1>Update Manager Password</h1>";
          echo '<form class="" action="" method="POST">
            <div class="form-group">
              <label for="password">New Password</label>
              <input type="password" name="password" class="form-control" required/>
            </div>
            <div class="form-group">
              <button type="submit" name="pswd" class="btn btn-primary"> Update</button> 
              <a class="btn btn-primary" href="javascript:history.go(-1)" title="Return to previous page">&laquo; Cancel</a>
            </div>
          </form>';
          break;
        default:
          echo "<h1 class='text-danger'>Wrong URL</h1>";
          echo '<form class="" action="" method="POST">
            <div class="form-group">
              <button type="submit" name="intruder" class="btn btn-primary">Back to Previous Page</button>
            </div>
          </form>';
          }
      }
    ?>
    </div>
  </section>
</body>
</html>