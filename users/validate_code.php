<?php require('auth.php'); $title ='Visitor Management'; 
require('../db.php');
if(isset($_GET['id']) && $_SESSION['admin_type']=='admin'){
	include('admin_sidebar.php'); $estate_code = $_GET['id'];
}
else if($_SESSION['admin_type']=='mgr'){
	include('mgr_sidebar.php');$estate_code = $_SESSION['estate'];
}
else{
	echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
}

$_SESSION['show']= 0; $v=""; $code=""; $comp=0; $regno="";
if (isset($_POST['gencode'])){ 
  $name = stripslashes($_REQUEST['test']);
  $regno = stripslashes($_REQUEST['regno']);
  $comp = stripslashes($_REQUEST['comp']);
  $arr_date = stripslashes($_REQUEST['arr_date']);
  $phone = stripslashes($_REQUEST['phone']);
  $duration = stripslashes($_REQUEST['val']);
  $flat = strtoupper(stripslashes($_REQUEST['flat']));
  $block = strtoupper(stripslashes($_REQUEST['block']));  
  $_SESSION['arr_date'] = $arr_date;
  $_SESSION['phone'] = $phone;
  
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
  $query = "INSERT into `entrance_codes` (code,visitor,reg_no,comp,arr_date,phone,duration,estate,flat,block,created,status) VALUES ('$final','$name','$regno',$comp,'$arr_date','$phone',$duration,'".$_SESSION['estate']."',$flat,$block,'".$trn_date."','invite')";
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
    echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
  }
  else{
		$error=mysqli_error($con);
		echo '<script type="text/javascript">alert("'.$error.'");</script>';
		echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
  }
}
else if (isset($_POST['vcode'])){
  $code = $_REQUEST['code'];
  $sql = "SELECT * FROM entrance_codes where code='".$code."' ";
  $result = $con->query($sql);
  if ($result->num_rows > 0) { $_SESSION['show']=1; 
  	while($row = $result->fetch_assoc()) {
  	  $v=$row['visitor']; $comp=$row['comp']; $regno=$row['reg_no']; $arr_date=$row['arr_date']; $arr_time=$row['arr_time']; 
  	}
  	$r='Code: '.$code.'\nVisitor: '.$v.'\nVehicle Reg No.: '.$regno.'\nNo. of companions: '.$comp.'\nArrival Date: '.format_date2($arr_date).'\nExpected Time: '.$arr_time;
   $_SESSION['msg'] = '<div class="row"><div class="col-lg-12"><div class="alert alert-success" role="alert">'.$r.'</div></div></div>';
   echo '<script type="text/javascript">alert("'.$r.'");</script>';
   echo "<script type='text/javascript'>window.top.location='validate_code.php';</script>";
  }
  else{
	$_SESSION['msg'] = '<div class="row"><div class="col-lg-12"><div class="alert alert-danger" role="alert">Invalid code.</div></div></div>';
  	echo "<script>alert('Invalid code.');</script>";
	echo "<script type='text/javascript'>window.top.location='validate_code.php';</script>";
  }
}
else{
	//if ($_SESSION['show']===1){echo $_SESSION['msg'];}
?>
		<div class="row">
		  <div class="col-lg-12">
				<div class="card m-b-30">
	        <div class="card-body">
				  <button type='button' class='btn btn-danger btn-sm' style='border-radius: 10px; float: right;' data-toggle="modal" data-target="#passmodal" data-original-title="Visitor's Pass"><i class="fa fa-plus"> </i> <b>Visitor's Pass</b></button><br><br>
					<!-- Modal -->
					<div class="modal fade" id="passmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="passmodal">Visitor's Pass</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<form action="" method="POST">
							  <div class="form-row">
									<!-- <div class="form-group col-lg-6">
									  <label for="arr_date">Flat</label><input type="text" name="flat" class="form-control" placeholder="Flat #" required />
									</div>
									<div class="form-group col-lg-6">
									  <label for="arr_date">Block</label><input type="text" name="block" class="form-control" placeholder="Block #" required />
									</div> -->
									<input type="hidden" name="block" value="0" /><input type="hidden" name="flat" value="0" />
									<div class="form-group col-lg-12">
									  <label for="arr_date">Guest Name</label><input type="text" name="test" id="test" class="form-control" placeholder="John Doe" required />
									</div>
									<div class="form-group col-lg-6">
									  <label for="arr_date">Phone</label><input type="text" name="phone" id="phone" class="form-control" placeholder="0801234567890" required />
									</div>
									<div class="form-group col-lg-6">
									  <label for="arr_date">Vehicle Reg No</label><input type="text" name="regno" id="regno" class="form-control" placeholder="ABJ1234" />
									</div>
									<div class="form-group col-lg-6">
									  <label for="arr_date">Companions</label><input type="number" value="0" min="0" name="comp" id="comp" class="form-control" />
									</div>
									<div class="form-group col-lg-6">
									  <label for="arr_date">Duration (hours)</label><input type="number" value="1" min="1" name="val" id="val" class="form-control" />
									</div>
									<div class="form-group col-lg-6">
									  <label for="arr_date">Arrival date</label><input type="date" name="arr_date" id="arr_date" class="form-control" />
									</div>
									<div class="form-group col-lg-6">
									  <label for="arr_time">Arrival time</label><input type="time" name="arr_time" id="arr_time" class="form-control" />
									</div>
									<div class="form-group col-lg-12">
									  <div class="form-check">
									   <input type="checkbox" class="form-check-input" name="addqr" id="exampleCheck1">
									   <label class="form-check-label" for="exampleCheck1">Include QR Code</label>
									  </div>
									</div>
									<div class="form-group col-lg-12">
									  <input type="submit" name="gencode" value="Generate Code" class="btn btn-block btn-outline-info">
									</div>
							  </div>
							</form>
						  </div>										  
						</div>
					  </div>
					</div>
					<!-- /Modal -->
				  <form action="" method="POST">
				   <div class="form-row">
						<div class="form-group col-lg-6">
						  <input type="text" name="code" id="code" class="form-control" placeholder="Entrance Code" required />
						</div>
						<div class="form-group col-lg-6">
						  <input type="submit" name="vcode" value="Validate Code" class="btn btn-block btn-outline-info">
						</div>
				   </div>
				  </form>
				  <?php if($_SESSION['show']===1){
				  /*echo '<div class="table-responsive b-0" data-pattern="priority-columns">
					<table id="tech-companies-1" class="table  table-striped">
	                  <thead><tr class="titles"><th>Code</th><th>Visitor</th><th>Vehicle Reg No.</th><th>No. of Companions</th> </tr></thead>
	                  <tbody>
						<tr><td>$code</td>
							<td>$v</td>
							<td>$regno</td>
							<td>$comp</td></tr>
	                  </tbody>
	                </table>
				  </div>';*/
				  }
				  ?>
			  	</div>
        </div>
		  </div>
    </div><!-- end row -->
    </div><!-- container -->
    </div><!-- Page content Wrapper -->
  </div><!-- content -->
  <?php include('footer.php'); } ?>
</html>