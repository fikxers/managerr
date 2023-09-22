<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include('auth.php'); $title="Reset Password";
if($_SESSION['admin_type'] == 'admin') { include('admin_sidebar.php'); }
else if($_SESSION['admin_type'] == 'mgr') { include('mgr_sidebar.php'); }
else if($_SESSION['admin_type'] == 'flat') { include('flat_sidebar.php'); }
require('../db.php');

if (isset($_POST['passreset'])){    
    $newpass = $_POST['newpass']; 
	$query = "UPDATE users set password = '".md5($newpass)."' WHERE email = '".$_SESSION['email']."'";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('New password set successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='reset_password.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error: ".mysqli_error()."');</script>";
	  echo "<script type='text/javascript'>window.top.location='reset_password.php';</script>"; exit;
	}
}
if($_SESSION['admin_type'] == 'flat') {  ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-body">
		<div id = 'ajaxDiv'></div>
		<form action="" method="POST">
		  <div class="form-row">
			<div class="form-group col-lg-6">
			  <input type="password" name="newpass" class="form-control" placeholder="Enter new password" required />
			</div>
			<div class="form-group col-lg-6">
			  <input type="submit" name="passreset" value="Reset Password" class="btn btn-block btn-outline-info">
			</div>
		  </div>
		</form>	
	  </div>
	</div>
  </div>
</div><!-- end row -->

<?php } ?>
<!-- container -->
</div><!-- Page content Wrapper -->
</div><!-- content -->
<?php include('footer.php'); ?>
</html>
