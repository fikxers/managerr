<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include('auth.php'); $title="Resident Profile";
if($_SESSION['admin_type'] == 'admin') { include('admin_sidebar.php'); }
else if($_SESSION['admin_type'] == 'mgr') { include('mgr_sidebar.php'); }
else if($_SESSION['admin_type'] == 'flat') { include('flat_sidebar.php'); }
require('../db.php');

if (isset($_POST['update'])){    
  $fullname = $_POST['fullname']; $flat = $_POST['flat']; $block = $_POST['block']; 
	$query = "UPDATE flats set owner = '".$fullname."',flat_no = '".$flat."',block_no = '".$block."' WHERE email = '".$_SESSION['email']."'";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Profile updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='profile.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error: ".mysqli_error()."');</script>";
	  echo "<script type='text/javascript'>window.top.location='profile.php';</script>"; exit;
	}
}
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
	    <div class="card-body">
				<form action="" method="POST">
				  <div class="form-row">
					<div class="form-group col-lg-4">
						<label>Update Flat/House No.</label>
					  <input type="text" name="flat" value="<?php echo $_SESSION['flat_no']; ?>" class="form-control" placeholder="Flat/House No." />
					</div>
					<div class="form-group col-lg-4">
						<label>Update Block/Street No.</label>
					  <input type="text" name="block" value="<?php echo $_SESSION['block_no']; ?>" class="form-control" placeholder="Block/Street No." />
					</div>
					<div class="form-group col-lg-4">
						<label>Update Your Name</label>
					  <input type="text" name="fullname" value="<?php echo $_SESSION['owner']; ?>" class="form-control" placeholder="New name" />
					</div>
					<div class="form-group col-lg-12">
					  <input type="submit" name="update" value="Update Profile" class="btn btn-block btn-outline-info">
					</div>
				  </div>
				</form>	
		  </div>
		</div>
  </div>
</div><!-- end row -->
<!-- container -->
</div><!-- Page content Wrapper -->
</div><!-- content -->
<?php include('footer.php'); ?>
</html>
