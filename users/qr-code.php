<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
include('auth.php'); $title="Visitor Management";
include('flat_sidebar.php');	
require('../db.php');
function notification($m) {
	  	$msg = ' 
          <html> 
            <head> 
              <title>Guest Successfully Invited</title> 
            </head> 
            <body>'.$m.' 
			  <hr><p>Thank you for choosing Managerr.</p> 
            </body> 
          </html>'; 
	  	  //Create a new PHPMailer instance
		  $mail = new PHPMailer();
			//Set PHPMailer to use the sendmail transport
			$mail->isSendmail();
			//Set who the message is to be sent from
			$mail->setFrom('support@managerr.net', 'Managerr Support');
			//Set an alternative reply-to address
			$mail->addReplyTo('info@managerr.net', 'Managerr Support');
			//Set who the message is to be sent to
			$mail->addAddress($_SESSION['email']);//$mail->addAddress('ypolycarp@gmail.com');
			//Set the subject line
			$mail->Subject = 'Guest Successfully Invited';
			$mail->msgHTML($msg);//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
			//Replace the plain text body with one created manually
			$mail->AltBody = 'Guest Successfully Invited.';
			$mail->send();
}
//https://wa.me/?text=urlencodedtext'
if (isset($_POST['code'])){ 
  $name = stripslashes($_REQUEST['test']);
  $regno = stripslashes($_REQUEST['regno']);
  $comp = stripslashes($_REQUEST['comp']);
  $arr_date = stripslashes($_REQUEST['arr_date']);
  $phone = stripslashes($_REQUEST['phone']);
  $duration = stripslashes($_REQUEST['val']);
  //$arr_time =stripslashes($_REQUEST['arr_time']);
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
    //send email notification
    $m = "Dear ".$_SESSION['owner']."<br><br>";
    $m .= "You have successfully invited ".$name." to your house in ".$_SESSION['estate_name']."<br>";
    $m .= 'Your house details: House No. - '.$_SESSION['flat_no'].', Block No.: '.$_SESSION['block_no'].'.'."<br><br>";
	  $m .= 'Their Expected Arrival: '.date("d-m-Y",strtotime($arr_date)).' by '.date("g:ia",strtotime($arr_date)).'.'."<br>";
	  $m .= 'Expected companions: '.$comp.'.'."<br><br>";
	  $m .= 'Entrance access code: <b>'.strtoupper($final).'</b>.'."<br>";
	  $m .= '<hr><p>Thank you for choosing Managerr.</p'> 
    notification($m);
    //create qr code
	$code = $final;
	$final = 'Code: '.$final;
    echo '<script type="text/javascript">alert("'.$final.'");</script>';
	if (isset($_POST['addqr'])) {
	  $query = "UPDATE entrance_codes set qr=1 WHERE code = '".$code."'";
	  $res = mysqli_query($con,$query); 
	  echo "<script type='text/javascript'>window.top.location='../qrcode/index.php?test=".$name."&regno=".$regno."&comp=".$comp."&val=".$duration."&t=".date('d-m-y h:i:s')."&arr_date=".$arr_date."&code=".$code."';</script>"; 
	  //echo "<script type='text/javascript'>window.top.location='../qrcode/index.php?test=".$name."&regno=".$regno."&comp=".$comp."&val=".$duration."&t=".date('d-m-y h:i:s')."&arr_date=".$arr_date."&arr_time=".$arr_time."&code=".$code."';</script>"; 
	  //echo "<script type='text/javascript'>window.top.location='../qr-code/barcode-script.php?test=".$_REQUEST['test']."&regno=".$_REQUEST['regno']."&comp=".$_REQUEST['comp']."&val=".$_REQUEST['val']."&t=".date('d-m-y h:i:s')."&arr_date=".$_REQUEST['arr_date']."&arr_time=".$_REQUEST['arr_time']."';</script>"; 
	}
    echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
  }else{
		//echo "<script>alert('Error generating code.');</script>";
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
   //$link = '../qr-code/barcode-script.php?test=" .$_REQUEST['test']."&regno=" .$_REQUEST['reg_no']."&email=" .$row['email']."' data-toggle='tooltip' data-original-title='Update'>
   echo "<script type='text/javascript'>window.top.location='../qrcode/index.php?test=".$_REQUEST['test']."&regno=".$_REQUEST['regno']."&comp=".$_REQUEST['comp']."&val=".$_REQUEST['val']."&t=".date('d-m-y h:i:s')."&arr_date=".$_REQUEST['arr_date']."&arr_time=".$_REQUEST['arr_time']."&phone=".$_REQUEST['phone']."';</script>"; 
   //echo "<script type='text/javascript'>window.top.location='../qr-code/barcode-script.php?test=".$_REQUEST['test']."&regno=".$_REQUEST['regno']."&comp=".$_REQUEST['comp']."&val=".$_REQUEST['val']."&t=".date('d-m-y h:i:s')."&arr_date=".$_REQUEST['arr_date']."&arr_time=".$_REQUEST['arr_time']."';</script>"; 
   //window.location="../qr-code/barcode-script.php?test="+document.getElementById('test').value+"&regno="+document.getElementById('regno').value+"&comp="+document.getElementById('comp').value+"&val="+document.getElementById('val').value+"&t="+now+"&arr_date="+document.getElementById('arr_date').value+"&arr_time="+document.getElementById('arr_time').value;
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
  $category = 'noshow'; 
  $query = "UPDATE entrance_codes set status='no-show' WHERE id = $id";
  $result2 = mysqli_query($con,$query); 
  if($result2){
	echo "<script>alert('You have successfully confirmed the guest will not show.');</script>";
	echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
  }

  else{
	echo "<script>alert('Error. Please try again later.');</script>";
	echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
  }
//   if ($nowdate >= $adate && $nowtime > $atime){
//     $category = 'noshow'; 
//     $query = "UPDATE entrance_codes set status='no-show' WHERE id = $id";
//     $result2 = mysqli_query($con,$query); 
//     if($result2){
// 	  echo "<script>alert('You have successfully confirmed the guest will not show.');</script>";
// 	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
// 	}
// 	else{
// 	  echo "<script>alert('Error. Please try again later.');</script>";
// 	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
// 	}
//   }
//   else{
// 	echo "<script>alert('Please be patient, the guest might still come.');</script>";
// 	echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
//   }
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
	  //$error=mysqli_error($con);
	  //echo '<script type="text/javascript">alert("'.$error.'");</script>';
	  echo "<script type='text/javascript'>window.top.location='qr-code.php';</script>"; exit;
	}
}
?>

<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-body">
      <?php $acct_bal = acct_bal2($amnt_paid,$total_debt);  if($acct_bal >= 0){ ?> 
			<!--<h4 class="mt-0 header-title">Visitor Mgt</h4>
			<span style="float: right"><a data-toggle="modal" data-target="#passmodal" data-original-title="Add Asset"><i class="fa fa-plus text-info m-r-10 m-b-10"> <b>Visitor's Pass</b></i></a></span>-->
			<?php 
				$query = "SELECT count(*) as visits FROM entrance_codes where estate='".$_SESSION['estate']."' and block='".$_SESSION['block_no']."' and flat='".$_SESSION['flat_no']."' and (status='signed-in' OR status='signed-out')";
				$result = mysqli_query($con,$query) or die(mysql_error()); $visits = $result->fetch_object()->visits;
				$query = "SELECT count(*) as pending FROM entrance_codes where estate='".$_SESSION['estate']."' and block='".$_SESSION['block_no']."' and flat='".$_SESSION['flat_no']."' and status='invite'";
				$result = mysqli_query($con,$query) or die(mysql_error()); $pending = $result->fetch_object()->pending;
				$query = "SELECT count(*) as noshows FROM entrance_codes where estate='".$_SESSION['estate']."' and block='".$_SESSION['block_no']."' and flat='".$_SESSION['flat_no']."' and status='no-show'";
				$query = "SELECT count(*) as noshows FROM entrance_codes where flat='1A' and block='33' and estate='OBA' and status='no-show'";
				$result = mysqli_query($con,$query) or die(mysql_error()); $noshow = $result->fetch_object()->noshows;
			?>
			<!-- Modal -->
			<div class="modal fade" id="passmodal-<?php echo 1; ?>" tabindex="1" role="dialog" aria-labelledby="passmodal-<?php echo 1; ?>" aria-hidden="true">
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
							<div class="form-group col-lg-6">
							  <label for="arr_date">Guest Name</label><input type="text" name="test" id="test" class="form-control" placeholder="John Doe" required />
							</div>
							<div class="form-group col-lg-6">
							  <label for="arr_date">Vehicle Reg No</label><input type="text" name="regno" id="regno" class="form-control" placeholder="ABJ1234" />
							</div>
							<div class="form-group col-lg-6">
							  <label for="arr_date">Companions</label><input type="number" min="0" name="comp" id="comp" class="form-control" />
							</div>

							<div class="form-group col-lg-6">
							  <label for="arr_date">Duration (hours)</label><input type="number" min="1" step="0.5" name="val" id="val" class="form-control" />
							</div>
							<div class="form-group col-lg-6">
							  <label for="arr_date">Arrival date & time</label>
							  <!-- <input type="date" name="arr_date" id="arr_date" class="form-control" /> -->
							  <!--<input type="datetime-local" name="arr_date" id="arr_date" class="form-control" />-->
							  <?php $today = date("Y-m-d"); //date("Y-m-d h:i:s"); 
							  	$min = $today." 05:00:00"; $max = $today." 21:00:00";
							  ?>
							  <input type="datetime-local" name="arr_date" min="<?php echo $min; ?>" max="<?php echo $max; ?>" id="arr_date" class="form-control" />
							</div>
							<!-- <div class="form-group col-lg-6">
							  <label for="arr_time">Arrival time</label><input type="time" name="arr_time" id="arr_time" class="form-control" />
							</div> -->
							<div class="form-group col-lg-6">
							  <label for="phone">Phone number</label><input type="text" name="phone" id="phone" class="form-control" />
							</div>
							<div class="form-group col-lg-6">
							  <div class="form-check"><br>
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
			<button type='button' class='btn btn-danger btn-sm' style='border-radius: 10px; float: right;' data-toggle="modal" data-target="#passmodal-<?php echo 1; ?>" data-original-title="Visitor's Pass"><i class="fa fa-plus"> </i> <b> Visitor's Pass</b></button><br>			
			<nav>
			  <div class="nav nav-tabs mt-2 mb-1 ent" id="nav-tab" role="tablist">
			  	<button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><span class="text-info"><?php echo $pending; ?> Pending</span></button>
			  	<button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><span class="text-success"><?php echo $visits; ?> Visits</span></button>
			  	<button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false"><span class="text-danger"><?php echo $noshow; ?> No-shows</span></button>
			  </div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
				<!-- TOTAL VISITS -->
			  <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
			  	<?php 
			  	$query = "SELECT * FROM entrance_codes where estate='".$_SESSION['estate']."' and block='".$_SESSION['block_no']."' and flat='".$_SESSION['flat_no']."' and (status='signed-in' OR status='signed-out')"; 
			  	$result = $con->query($query);
					if ($result !== false && $result->num_rows > 0) {
						echo '<br>
						<div class="list-group">';
						while($row = $result->fetch_assoc()) { $txt_0 ='';
							if($row['security'] == NULL || $row['security'] == '') $row['security'] = 'Security Post';
							$phpdate = strtotime( $row['arr_date'] ); $formatDateTime = date("d-M-Y g:i A", $phpdate);
							$formatSignout = date("d-M-Y g:i A", strtotime( $row['signout'] ));
							echo '<tr>
							<div class="list-group-item list-group-item-action">
								<div class="d-flex w-100 justify-content-between">
						      <h6 class="mb-1">Entrance Code: <b>'.strtoupper($row['code']).'</b> </h6>
						      <small>Expected Arrival: '.$formatDateTime.'</small>
						    </div>
						    <p class="mb-1">
								Guest: <b>'.$row['visitor'].'</b> | Vehicle No.: '.$row['reg_no'].' 
									   | Companions: '.$row['comp'].' | Duration: '.$row['duration'].' hours
									  | Mobile Phone: '.$row['phone'].
									  ' | Signed in by: '.$row['security'];
							if($row['qr']==1){
								echo ' | <button type="button" class="btn text-primary btn-sm" style="background-color: transparent; border-width: 0px; padding: 0px;" data-toggle="modal" data-toggle="modal" data-target="#qrmodal-'.$row['id'].'" data-original-title="View QR">View QR</i></button>';
							}
							echo '</p>';
							//show sign out if guest signed in
							if($row['status'] ==='signed-in'){
								echo '
								<small>
								<button type="button" class="btn btn-dark btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#outmodal-'.$row['id'].'" data-original-title="Sign Out"><i class="fa fa-sign-out text-dark"></i></button>
								</small>
								';
							}
							else{
								echo '
								<small>
								  <b>Signed Out On:</b> '.$formatSignout.'
								</small>
								';
							}
							echo '
							</div>
									<!-- Sign Out Modal -->
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
								echo '
								<!-- QR Modal -->
								<div class="modal fade text" id="qrmodal-'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="qrmodal-'.$row['id'].'" aria-hidden="true">
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
								';
						}
						echo '</div>
								</tr>
						  </tbody>
						</table> ';
					}
					else { echo "You've not invited any guest yet."; } 
			  	?>
			  </div>
			  <!-- PENDING VISITS -->
			  <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
			  	<?php 
			  	$query = "SELECT * FROM entrance_codes where estate='".$_SESSION['estate']."' and block='".$_SESSION['block_no']."' and flat='".$_SESSION['flat_no']."' and status='invite'";
			  	$result = $con->query($query);
					if ($result !== false && $result->num_rows > 0) {
						echo '<br>
						<div class="list-group">';
						while($row = $result->fetch_assoc()) { $txt_0 ='';
							if($row['security'] == NULL || $row['security'] == '') $row['security'] = 'Security Post';
							$phpdate = strtotime( $row['arr_date'] ); $formatDateTime = date("d-M-Y g:i A", $phpdate);
							$formatDate = date("d-M-Y", $phpdate); $formatTime = date("g:i A", $phpdate);
							$txt_1 = 'Good day '. $row['visitor'].','."%0A"."%0D%0A";
							$txt_2 = 'You have been invited to '.$_SESSION['estate_name'].' by '.$_SESSION['owner'].'.'."%0D%0A"."%0D%0A";
							$txt_22 = 'Apartment details: House No. - '.$_SESSION['flat_no'].', Block No.: '.$_SESSION['block_no'].'.'."%0D%0A";
							$txt_23 = 'Your Expected Arrival: '.$formatDate.' by '.$formatTime.'.'."%0D%0A";
							$txt_24 = 'Expected companions: '.$row['comp'].'.'."%0D%0A"."%0D%0A";
							//$txt_23 = 'Your Expected Arrival: '.$row['arr_date']."%0D%0A"."%0D%0A";
							$txt_3 = 'Your access code: *'.strtoupper($row['code']).'*.'."%0D%0A";
							$txt_4 = 'When you arrive at the Estate gate, please show the code to the Security.'."%0D%0A";
							//if qr exists then send
							if($row['qr']==1){
							  $txt_0 = "%0D%0A".'View QR Code - https://managerr.net/qrcode/images/'.$row['code'].'.png'."%0D%0A";
							}
							$txt_5 = "%0D%0A".'Powered By *Managerr* - https://managerr.net';
							$msg= $txt_1.$txt_2.$txt_22.$txt_23.$txt_24.$txt_3.$txt_4.$txt_0.$txt_5;
							echo '<tr>
							<div class="list-group-item list-group-item-action">
								<div class="d-flex w-100 justify-content-between">
						      <h6 class="mb-1">Entrance Code: <b>'.strtoupper($row['code']).'</b> </h6>
						      <small>Expected Arrival: '.$formatDateTime.'</small>
						    </div>
						    <p class="mb-1">
								Guest: <b>'.$row['visitor'].'</b> | Vehicle No.: '.$row['reg_no'].' 
									   | Companions: '.$row['comp'].' | Duration: '.$row['duration'].' hours
									  | Mobile Phone: '.$row['phone'].
									  ' | Signed in by: '.$row['security'];
							if($row['qr']==1){
								echo ' | <button type="button" class="btn text-primary btn-sm" style="background-color: transparent; border-width: 0px; padding: 0px;" data-toggle="modal" data-toggle="modal" data-target="#qrmodal-'.$row['id'].'" data-original-title="View QR">View QR</i></button>';
							}
							echo '</p>
							<small>
							<button type="button" class="btn btn-warning btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-toggle="modal" data-target="#editmodal-'.$row['id'].'" data-original-title="Edit"><i class="fa fa-pencil text-warning"></i></button>&emsp;<button type="button" class="btn btn-danger text-danger btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#delmodal-'.$row['id'].'" data-original-title="Delete"><i class="ti-eraser text-danger"></i></button>&emsp;&emsp;<button type="button" class="btn btn-dark btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#noshowmodal-' .$row['id'].'" data-original-title="No Show"><i class="fa fa-times-circle-o text-dark"></i></button>&emsp;&emsp;<a href="https://wa.me/?text=' .$msg. '" data-toggle="tooltip" data-original-title="Share on WhatsApp" target="_blank"><i class="fa fa-mail-forward text-success m-r-10"></i></a>
							</small>
							</div>';
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
						echo '</div>
								</tr>
						  </tbody>
						</table> ';
					}
					else { echo "No Pending Visits."; } 
			  	?>
			  </div>
			  <!-- NO-SHOWS -->
			  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
			  	<?php 
			  	$query = "SELECT * FROM entrance_codes where estate='".$_SESSION['estate']."' and block='".$_SESSION['block_no']."' and flat='".$_SESSION['flat_no']."' and status='no-show'";
			  	$result = $con->query($query);
					if ($result !== false && $result->num_rows > 0) {
						echo '<br>
						<div class="list-group">';
						while($row = $result->fetch_assoc()) { 
							$phpdate = strtotime( $row['arr_date'] ); $formatDateTime = date("d-M-Y g:i A", $phpdate);							
							echo '<tr>
							<div class="list-group-item list-group-item-action">
								<div class="d-flex w-100 justify-content-between">
						      <h6 class="mb-1">Entrance Code: <b>'.strtoupper($row['code']).'</b> </h6>
						      <small>Expected Arrival: '.$formatDateTime.'</small>
						    </div>
						    <p class="mb-1">
								Guest: <b>'.$row['visitor'].'</b>';
							if($row['qr']==1){
								echo ' | <button type="button" class="btn text-primary btn-sm" style="background-color: transparent; border-width: 0px; padding: 0px;" data-toggle="modal" data-toggle="modal" data-target="#qrmodal-'.$row['id'].'" data-original-title="View QR">View QR</i></button>';
							}
							echo '</p>
							</div>
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
								<!-- /QR Modal -->';
						}
						echo '</div>
								</tr>
						  </tbody>
						</table> ';
					}
					else { echo "No Pending Visits."; } 
			  	?>
			  </div>
			</div>
			<?php } else { 
				echo "You cannot invite a guest with a negative balance.<br><br>"; 
				echo '<a href="pay.php" class="btn btn-primary btn-sm">Fund Wallet</a>';
			} ?>
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
	//window.location="../qr-code/barcode-script.php?test="+document.getElementById('test').value+"&regno="+document.getElementById('regno').value+"&comp="+document.getElementById('comp').value+"&val="+document.getElementById('val').value+"&t="+now+"&arr_date="+document.getElementById('arr_date').value+"&arr_time="+document.getElementById('arr_time').value;
  }
</script>

</html>