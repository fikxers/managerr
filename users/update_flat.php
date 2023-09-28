<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Update Flat</title>
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
 <br>
 <h3>Update <?php echo $_GET['owner']; ?></h3>

<?php
  // connect to the database
  include ('../db.php');
  $id = $_GET['id']; $phone = $_GET['phone']; $owner = $_GET['owner']; 
  $flat = $_GET['flat']; $block = $_GET['block'];$meter = $_GET['meter'];
  
  $sql = "SELECT * FROM flats WHERE email = '$id'";
  $result = $con->query($sql);
  
  
  if (isset($_POST['update'])){
		if($_REQUEST['owner'] != ""){
		  $owner = stripslashes($_REQUEST['owner']);
		}
		if($_REQUEST['phone'] != ""){
		  $phone = stripslashes($_REQUEST['phone']);
		}
		if($_REQUEST['flat'] != ""){
		  $flat = stripslashes($_REQUEST['flat']);
		}
		if($_REQUEST['block'] != ""){
		  $block = stripslashes($_REQUEST['block']);
		}
		if($_REQUEST['meter'] != ""){
		  $meter = stripslashes($_REQUEST['meter']);
		}
		$status = $_REQUEST['status'];
		$change_status = "UPDATE users set status=$status WHERE email = '$id'";
		if( isset($_REQUEST['password']) ){
		  $password = stripslashes($_REQUEST['password']);
		  $change_status = "UPDATE users set status=$status,password='".md5($password)."' WHERE email = '$id'";
		}
		$result3 = mysqli_query($con,$change_status); 
		
		$query = "UPDATE flats set owner='".$owner."',phone='".$phone."',flat_no = '".$flat."',block_no = '".$block."',meter_pan='".$meter."' WHERE email = '$id'";
		$result2 = mysqli_query($con,$query); 
		if($result2 && $result3){
		  echo "<script>alert('Flat updated successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Error updating flat.');</script>";
		  //echo "<script type='text/javascript'>window.top.location='view_equipments.php';</script>"; exit;
		}
  }
  else if (isset($_POST['cancel'])){
	 echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>";
  }
  else{
  // display records if there are records to display
  if ($result->num_rows > 0)
  { 
	$status_sql = "SELECT status FROM users WHERE email = '$id'";
	$rs = mysqli_query($con,$status_sql) or die(mysql_error());
	$status_now = $rs->fetch_object()->status; //echo $status_sql;
  ?>
	  <form class="" action="" method="POST">
		<div class="form-row">
			<div class="form-group col-lg-4">
				<label>Update Resident Name</label>
        <input type="text" name="owner" class="form-control"  value="<?php echo $owner; ?>" />
      </div>		
			<div class="form-group col-lg-4">
				<label>Update Resident's Phone No.</label>
        <input type="text" name="phone" class="form-control"  value="<?php echo $phone; ?>" />
      </div>
      <div class="form-group col-lg-4">
				<label>Update Flat/House No.</label>
				<input type="text" name="flat" value="<?php echo $flat; ?>" class="form-control" />
			</div>
		  <div class="form-group col-lg-4">
				<label>Update Block/Street No.</label>
				<input type="text" name="block" value="<?php echo $block; ?>" class="form-control" />
			</div>
			<div class="form-group col-lg-4">
				<label>New Passsword (If Applicable)</label>
				<input type="password" name="password" class="form-control" />
			</div>
			<div class="form-group col-lg-4">
				<label>Update Meter No.</label>
				<input type="text" name="meter" value="<?php echo $meter; ?>" class="form-control" />
			</div>
			<div class="form-group col-lg-12"><br>
        <?php if($status_now==0){echo "<b>Current Status: Not Active</b>"; } else{echo "<b>Current Status: Active</b>"; } ?>
		 		Activate <input type="radio" name="status" checked="checked" value="1"/> 
		    Deactivate <input type="radio" name="status" value="0"/> <br><br>
      </div>
      <div class="form-group">
        <button type="submit" name="update" class="btn btn-primary"> Update</button>
          <!--<button type="button" data-toggle="modal" data-original-title="More Notices" data-target="#modal-<?php echo $id; ?>" name="update" class="btn btn-success"> Credit Account</button>-->
        <button type="submit" name="cancel" class="btn btn-dark">Cancel</button>
      </div>
    </div>
    </form>
	</div>
	</section>
	<?php
   }
  }

?>
</body>
</html>