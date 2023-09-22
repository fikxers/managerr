<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 
include('auth.php'); $title="Special QRs";
include('flat_sidebar.php');	
require('../db.php');
//https://wa.me/?text=urlencodedtext'
if (isset($_POST['code'])){ 
  $name = stripslashes($_REQUEST['test']);
  $regno = stripslashes($_REQUEST['regno']);
  $comp = stripslashes($_REQUEST['comp']);
  $arr_date = stripslashes($_REQUEST['arr_date']);
  $phone = stripslashes($_REQUEST['phone']);
  $duration = stripslashes($_REQUEST['val']);
  
  $_SESSION['arr_date'] = $arr_date;
  $_SESSION['phone'] = $phone;
  $_SESSION['secyes'] = 1;
  
  //$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $permitted_chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ'; //'0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	function generate_string($input, $strength = 16) {
	    $input_length = strlen($input);
	    $random_string = '';
	    for($i = 0; $i < $strength; $i++) {
	        $random_character = $input[mt_rand(0, $input_length - 1)];
	        $random_string .= $random_character;
	    }
	    return $random_string;
	}
   $final = generate_string($permitted_chars, 5);
   if( ! ini_get('date.timezone') ) { date_default_timezone_set('Africa/Lagos'); } $trn_date = date("Y-m-d H:i:s");
   $query = "INSERT into `entrance_codes` (code,visitor,reg_no,comp,arr_date,phone,duration,estate,flat,block,created,status) VALUES ('$final','$name','$regno',$comp,'$arr_date','$phone',$duration,'".$_SESSION['estate']."','".$_SESSION['flat_no']."','".$_SESSION['block_no']."','".$trn_date."','invite')";
   $result = mysqli_query($con,$query);
   if($result){
	$code = $final;
	$final = 'Code: '.$final;
    echo '<script type="text/javascript">alert("'.$final.'");</script>';
	if (isset($_POST['addqr'])) {
	  $query = "UPDATE entrance_codes set qr=1 WHERE code = '".$code."'";
      $res = mysqli_query($con,$query); 
	  echo "<script type='text/javascript'>window.top.location='../qrcode/index.php?test=".$_REQUEST['test']."&regno=".$_REQUEST['regno']."&comp=".$_REQUEST['comp']."&val=".$_REQUEST['val']."&t=".date('d-m-y h:i:s')."&arr_date=".$_REQUEST['arr_date']."&arr_time=".$_REQUEST['arr_time']."&code=".$code."';</script>"; 
	}
    echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
   }else{
	$error=mysqli_error($con);
	echo '<script type="text/javascript">alert("'.$error.'");</script>';
	echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
   }
}
else if (isset($_POST['signout'])){
  $id = $_REQUEST['id']; 
  if( ! ini_get('date.timezone') ) { date_default_timezone_set('Africa/Lagos'); } $trn_date = date("Y-m-d H:i:s");
	$query = "UPDATE entrance_codes set status='signed-out', signout='".$trn_date."' WHERE id = $id";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Guest signed out successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Sign Out Error. Please try again.');</script>";
	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
	}
}
else if (isset($_POST['qrcode'])){ 
   echo "<script type='text/javascript'>window.top.location='../qrcode/index.php?test=".$_REQUEST['test']."&regno=".$_REQUEST['regno']."&comp=".$_REQUEST['comp']."&val=".$_REQUEST['val']."&t=".date('d-m-y h:i:s')."&arr_date=".$_REQUEST['arr_date']."&arr_time=".$_REQUEST['arr_time']."';</script>"; 
}
else if (isset($_POST['delete'])){
	$id = $_REQUEST['id'];
	$sql = "DELETE FROM entrance_codes WHERE id = $id"; 
	$res = $con->query($sql);
	if ($res) {
	  mysqli_close($con);
	  echo "<script>alert('Deleted Successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
	} else {
	  echo "<script>alert('Error deleting.');</script>";
	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>";
	}  
}
else if (isset($_POST['noshow'])){
  $id = $_REQUEST['id'];  $arr_date = $_REQUEST['arr_date']; 
  $atime = date("H:i:sa",strtotime($arr_date));
  $adate = date("d-m-Y",strtotime($arr_date));
  $nowtime = date('h:i:sa', strtotime("10:00:00 pm"));//date("h:i:sa");  
  $nowdate = date("d-m-Y");

  if ($nowdate >= $adate && $nowtime > $atime){
    $category = 'noshow'; 
    $query = "UPDATE entrance_codes set status='no-show' WHERE id = $id";
    $result2 = mysqli_query($con,$query); 
    if($result2){
	  echo "<script>alert('Guest signed in successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Sign In Error. Please try again.');</script>";
	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
	}
  }
  else{
	echo "<script>alert('Please be patient, the guest might still come.');</script>";
	echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
  }
}
else if (isset($_POST['update'])){
  $id = $_REQUEST['id']; $duration = $_REQUEST['val']; $name = stripslashes($_REQUEST['test']);
  $regno = stripslashes($_REQUEST['regno']); $comp = stripslashes($_REQUEST['comp']);
  $arr_date = stripslashes($_REQUEST['arr_date']); $phone = stripslashes($_REQUEST['phone']);
	$query = "UPDATE entrance_codes set visitor='".$name."',reg_no='".$regno."',comp=$comp,arr_date='".$arr_date."',phone='".$phone."',duration=$duration WHERE id = $id";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating.');</script>";
	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
	}
  }
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-body">
		<!--<h4 class="mt-0 header-title">Visitor Mgt</h4>
		<span style="float: right"><a data-toggle="modal" data-target="#passmodal" data-original-title="Add Asset"><i class="fa fa-plus text-info m-r-10 m-b-10"> <b>Visitor's Pass</b></i></a></span>-->
		<button type='button' class='btn btn-danger btn-sm' style='border-radius: 10px; float: right;' data-toggle="modal" data-target="#passmodal" data-original-title="Visitor's Pass"><i class="fa fa-plus"> </i> <b> New Pass</b></button><br><br>
		<!-- Modal -->
		<div class="modal fade" id="passmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="passmodal">New Pass</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<form action="" method="POST">
				   <div class="form-row">
					<div class="form-group col-lg-4">
					  <label for="arr_date">Full Name</label><input type="text" name="test" id="test" class="form-control" placeholder="John Doe" required />
					</div>
					<div class="form-group col-lg-4">
					  <label for="arr_date">Vehicle Reg No</label><input type="text" name="regno" id="regno" class="form-control" placeholder="ABJ1234" />
					</div>
					<div class="form-group col-lg-4">
					  <label for="arr_date">Companions</label><input type="number" min="0" name="comp" value="0" id="comp" class="form-control" />
					</div>
					<!--<div class="form-group col-lg-6">
					  <label for="arr_date">Duration (hours)</label><input type="number" min="0" name="val" id="val" class="form-control" />
					</div>
					<div class="form-group col-lg-6">
					  <label for="arr_date">Arrival date</label><input type="date" name="arr_date" id="arr_date" class="form-control" />
					</div>
					<div class="form-group col-lg-6">
					  <label for="arr_time">Arrival time</label><input type="time" name="arr_time" id="arr_time" class="form-control" />
					</div>-->
					<div class="form-group col-lg-6">
					  <div class="form-check">
					   <input type="checkbox" class="form-check-input" name="addqr" id="exampleCheck1">
					   <label class="form-check-label" for="exampleCheck1">Include QR Code</label>
					  </div>
					</div>
					<div class="form-group col-lg-12">
					  <input type="submit" name="code" value="Generate Code" class="btn btn-block btn-outline-info">
					</div>
				   </div>
				</form>
			  </div>										  
			</div>
		  </div>
		</div>
		<!-- /Modal -->
        <div class="table-rep-plugin">
            <div class="table-responsive b-0" data-pattern="priority-columns">
              <?php $txt_0 ='';//include ('../db.php');
				$sql = "SELECT * FROM entrance_codes where flat=".$_SESSION['flat_no']." and block=".$_SESSION['block_no'];
				if($_SESSION['admin_type']=='mgr'){
				  $sql = "SELECT * FROM fixers where estate='".$_SESSION['estate']."'";
				}$result = $con->query($sql);
				if ($result->num_rows > 0) { ?>
				  <?php while($row = $result->fetch_assoc()) { 
					$txt_1 = 'Good day '. $row['visitor'].','."%0A";
					$txt_2 = 'You have been invited to '.$_SESSION['estate_name'].'.'."%0D%0A";
					$txt_3 = 'Your access code: *'.strtoupper($row['code']).'*.'."%0D%0A";
					$txt_4 = 'When you arrive at the Estate gate, please show the code to the Security.'."%0D%0A";
					//if qr exists then send
					if($row['qr']==1){
					  $txt_0 = 'View QR Code - https://fikxers.com/qrcode/images/'.$row['code'].'.png'."%0D%0A";
					}
					$txt_5 = 'Powered By *Fikxers* - https://fikxers.com';
					$msg= $txt_1.$txt_2.$txt_3.$txt_4.$txt_0.$txt_5."%0A";
					if ($row['status']=='invite'){ 
					  echo '<div class="alert alert-dark alert-dismissible fade show" role="alert">
					  Entrance Code: <b>'.strtoupper($row['code']).'</b><hr>
					  Guest: <b>'.$row['visitor'].'</b> | Vehicle No.: '.$row['reg_no'].' <br>
					  Companions: '.$row['comp'].' | Duration: '.$row['duration'].' hours<br>
					  Expected Arrival: '.$row['arr_date'].' | Mobile Phone: '.$row['phone'].'<br>';
					  if($row['qr']==1){
					  //echo '<a href="../qrcode/images/'.$row['code'].'.png" target="blank">View QR</a><br>';
					  echo '<button type="button" class="btn text-primary btn-sm" style="background-color: transparent; border-width: 0px; padding: 0px;" data-toggle="modal" data-toggle="modal" data-target="#qrmodal-'.$row['id'].'" data-original-title="View QR">View QR</i></button>';}
					  echo '<br>
					  <button type="button" class="btn btn-warning btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-toggle="modal" data-target="#editmodal-'.$row['id'].'" data-original-title="Edit"><i class="fa fa-pencil text-warning m-r-10"></i></button>&emsp;<button type="button" class="btn btn-danger btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#delmodal-'.$row['id'].'" data-original-title="Delete"><i class="fa fa-trash text-danger m-r-10"></i></button>&emsp;<button type="button" class="btn btn-dark btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#noshowmodal-' .$row['id'].'" data-original-title="No Show"><i class="fa fa-times-circle-o text-dark m-r-10"></i></button>&emsp;<a href="https://wa.me/?text=' .$msg. '" data-toggle="tooltip" data-original-title="Share on WhatsApp" target="_blank"><i class="fa fa-mail-forward text-success m-r-10"></i></a>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
						</button>
					</div>'; 
					} else{
					  if ($row['status']!='signed-out'){
						echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
						  Entrance Code: <b>'.strtoupper($row['code']).'</b><hr>
						  Guest: <b>'.$row['visitor'].'</b> | Vehicle No.: '.$row['reg_no'].' <br>
						  Companions: '.$row['comp'].' | Duration: '.$row['duration'].' hours<br>
						  Expected Arrival: '.$row['arr_date'].' | Mobile Phone: '.$row['phone'].'<br>'.
						  'Signed in by: '.$row['security'].'<br>';
						  if($row['qr']==1){
						  echo '<button type="button" class="btn text-primary btn-sm" style="background-color: transparent; border-width: 0px; padding: 0px;" data-toggle="modal" data-toggle="modal" data-target="#qrmodal-'.$row['id'].'" data-original-title="View QR">View QR</i></button>';
						  }
						  echo '<br>
						  <button type="button" class="btn btn-warning btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-toggle="modal" data-target="#editmodal-'.$row['id'].'" data-original-title="Edit"><i class="fa fa-pencil text-warning m-r-10"></i></button>&emsp;<button type="button" class="btn btn-danger btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#delmodal-'.$row['id'].'" data-original-title="Delete"><i class="fa fa-trash text-danger m-r-10"></i></button>&emsp;&emsp;<button type="button" class="btn btn-dark btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#outmodal-'.$row['id'].'" data-original-title="Sign Out"><i class="fa fa-sign-out text-dark m-r-10"></i></button>&emsp;&emsp;<a href="https://wa.me/?text=' .$msg. '" data-toggle="tooltip" data-original-title="Share on WhatsApp" target="_blank"><i class="fa fa-mail-forward text-success m-r-10"></i></a>
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
							</button>
						</div>'; 
					  }
					}
					echo '<!-- Sign Out Modal -->
						<div class="modal fade" id="outmodal-'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['id'].'" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="outmodal">Sign guest out?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<form action="" method="POST">
								   <div class="form-row">
									<input type="hidden" name="id" value="'.$row['id'].'">
									<div class="form-group col-lg-12">
									  <input type="submit" name="signout" value="Yes. Sign Out." class="btn btn-block btn-outline-info">
									</div>
								   </div>
								</form>
							  </div>
							</div>
						  </div>
						</div>
						<!-- /Sign Out Modal -->';
					echo '<!-- No Show Modal -->
						<div class="modal fade" id="noshowmodal-'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['id'].'" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="outmodal">Are you sure this guest is not coming?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<form action="" method="POST">
								   <div class="form-row">
									<input type="hidden" name="id" value="'.$row['id'].'">
									<input type="hidden" name="arr_date" value="'.$row['arr_date'].'">
									<div class="form-group col-lg-12">
									  <input type="submit" name="noshow" value="Yes. Confirm No-Show" class="btn btn-block btn-outline-info">
									</div>
								   </div>
								</form>
							  </div>
							</div>
						  </div>
						</div>
						<!-- /No Show Modal -->
					<!-- Delete Modal -->
					<div class="modal fade" id="delmodal-'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['id'].'" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="passmodal">Delete</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<form action="" method="POST">
							   <div class="form-row">
								<input type="hidden" name="id" value="'.$row['id'].'">
								<div class="form-group col-lg-12">
								  <input type="submit" name="delete" value="Confirm Delete" class="btn btn-block btn-outline-info">
								</div>
							   </div>
							</form>
						  </div>
							
						</div>
					  </div>
					</div>
					<!-- /Delete Modal -->
					<!-- QR Modal -->
					<div class="modal fade" id="qrmodal-'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="qrmodal-'.$row['id'].'" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="qrmodal">QR Code</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<img src="../qrcode/images/'.$row['code'].'.png" />
						  </div>							
						</div>
					  </div>
					</div>
					<!-- /QR Modal -->
					<!-- Edit Modal -->
					<div class="modal fade" id="editmodal-'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="editmodal-'.$row['id'].'" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title">Edit Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<form action="" method="POST">
							   <div class="form-row">
							    <input type="hidden" name="id" value="'.$row['id'].'">
								<div class="form-group col-lg-6">
								  <label for="arr_date">Guest Name</label><input type="text" name="test" id="test" class="form-control" value="'.$row['visitor'].'" placeholder="'.$row['visitor'].'" required />
								</div>
								<div class="form-group col-lg-6">
								  <label for="arr_date">Vehicle Reg No</label><input type="text" name="regno" id="regno" class="form-control" value="'.$row['reg_no'].'" placeholder="'.$row['reg_no'].'" />
								</div>
								<div class="form-group col-lg-6">
								  <label for="arr_date">Companions</label><input type="number" min="0" name="comp" id="comp" value="'.$row['comp'].'" placeholder="'.$row['comp'].'" class="form-control" />
								</div>
								<div class="form-group col-lg-6">
								  <label for="arr_date">Duration (hours)</label><input type="number" min="0" name="val" id="val" value="'.$row['duration'].'" placeholder="'.$row['duration'].'" class="form-control" />
								</div>
								<div class="form-group col-lg-6">
								  <label for="arr_date">Arrival Date & Time</label><input type="datetime-local" name="arr_date" id="arr_date" class="form-control" value="'.$row['arr_date'].'" placeholder="'.$row['arr_date'].'" />
								</div>
								<div class="form-group col-lg-6">
								  <label for="arr_time">Mobile Phone</label><input type="text" name="phone" id="phone" class="form-control" value="'.$row['phone'].'" placeholder="'.$row['phone'].'" />
								</div>
								<div class="form-group col-lg-12">
								  <input type="submit" name="update" value="Update" class="btn btn-block btn-outline-info">
								</div>
							   </div>
							</form>
						  </div>
						</div>
					  </div>
					</div>
					<!-- /Edit Modal -->';
					}
					} else { echo "You've not invited any guest yet."; } $con->close(); ?>
            </div>
		</div>
	  </div>
	</div>
  </div>
</div><!-- end row -->
</div><!-- container -->
</div><!-- Page content Wrapper -->
</div><!-- content -->
<?php include('footer.php'); ?>
<script type="text/javascript">
  function ftest(){
  	const now = new Date();
  	var curr_time = now.toLocaleTimeString();
	window.location="../qr-code/barcode-script.php?test="+document.getElementById('test').value+"&regno="+document.getElementById('regno').value+"&comp="+document.getElementById('comp').value+"&val="+document.getElementById('val').value+"&t="+now;
  }
</script>
</html>
