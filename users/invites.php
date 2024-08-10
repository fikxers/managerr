<?php require('auth.php'); $title ='All Invites'; 
include('mgr_sidebar.php'); require('../db.php');
$estate_code = $_SESSION['estate']; $_SESSION['msg'] =""; $msg = "";
$_SESSION['show']= 0; $v=""; $code=""; $comp=0; $regno="";
if (isset($_POST['signin'])){
  $id = $_REQUEST['id']; 
	$query = "UPDATE entrance_codes set status='signed-in' WHERE id = $id";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Guest signed in successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Sign In Error. Please try again.');</script>";
	  echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
	}
}
else if (isset($_POST['signout'])){
  $id = $_REQUEST['id']; 
	$query = "UPDATE entrance_codes set status='signed-out' WHERE id = $id";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Guest signed out successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Sign Out Error. Please try again.');</script>";
	  echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
	}
}
else if (isset($_POST['delete'])){
	$id = $_REQUEST['id'];
	$sql = "DELETE FROM entrance_codes WHERE id = $id"; 
	$res = $con->query($sql);
	if ($res) {
	  mysqli_close($con);
	  echo "<script>alert('Deleted Successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
	} else {
	  echo "<script>alert('Error deleting.');</script>";
	  echo "<script type='text/javascript'>window.top.location='invites.php';</script>";
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
	  echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating.');</script>";
	  //$error=mysqli_error($con);
	  //echo '<script type="text/javascript">alert("'.$error.'");</script>';
	  echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
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
	echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
  }
}
else{
?>
		<div class="row">
		  <div class="col-lg-12">
				<div class="card m-b-30">
          <div class="card-body">
          	<h4 class="mt-0 header-title">Pending Invites</h4>
						<div class="table-rep-plugin">
              <div class="table-responsive table-bordered">
                <?php include ('../db.php'); 
								$sql = "SELECT * FROM entrance_codes where estate='".$_SESSION['estate']."' AND status='invite' and block='0' and flat='0'";
								$result = $con->query($sql);
								if ($result->num_rows > 0) { ?>
								<table id="tech-companies-1" class="table table-bordered">
	                <thead><tr class="titles"><th>S/No</th><th>Guest</th><th>Vehicle No.</th><th>Companions</th><th>Duration</th><th>Arrival</th><th>Phone</th><th>Status</th><th>Action</th><th  style="display: none;">Code</th></tr></thead>
	                <tbody> <?php $i=1; while($row = $result->fetch_assoc()) { 
										$phpdate = strtotime( $row['arr_date'] ); $formatDateTime = date("d-M-Y g:i A", $phpdate);
										$formatDate = date("d-M-Y", $phpdate); $formatTime = date("g:i A", $phpdate);
										$txt_1 = 'Good day '. $row['visitor'].','."%0A"."%0D%0A";
										$txt_2 = 'You have been invited to '.$_SESSION['estate_name'].' by '.$_SESSION['owner'].'.'."%0D%0A"."%0D%0A";
										$txt_22 = 'Apartment details: House No. - '.$row['flat'].', Block No.: '.$row['block'].'.'."%0D%0A";
										$txt_23 = 'Your Expected Arrival: '.$formatDate.' by '.$formatTime.'.'."%0D%0A";
										$txt_24 = 'Expected companions: '.$row['comp'].'.'."%0D%0A"."%0D%0A";
										//$txt_23 = 'Your Expected Arrival: '.$row['arr_date']."%0D%0A"."%0D%0A";
										$txt_3 = 'Your access code: *'.strtoupper($row['code']).'*.'."%0D%0A";
										$txt_4 = 'When you arrive at the Estate gate, please show the code to the Security.'."%0D%0A";
										//if qr exists then send
										if($row['qr']==1){
										  $txt_0 = "%0D%0A".'View QR Code - https://HAIVEN.net/qrcode/images/'.$row['code'].'.png'."%0D%0A";
										}
										$txt_5 = "%0D%0A".'Powered By *HAIVEN* - https://HAIVEN.net';
										$msg= $txt_1.$txt_2.$txt_22.$txt_23.$txt_24.$txt_3.$txt_4.$txt_0.$txt_5;
	                	?>
									<tr><td><?php echo $i; ?></td><td><?php echo $row['visitor']; ?></td>
									<td><?php echo $row['reg_no']; ?></td><td><?php echo $row['comp']; ?></td>
									<td><?php echo $row['duration']." hours"; ?></td><td><?php echo $formatDateTime; ?></td>
									<td><?php echo $row['phone']; ?></td><td><?php echo 'Pending' ?></td>
							  	<?php 
							  			echo '<td><button type="button" class="btn btn-success btn-sm m-r-10" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#inmodal-'.$row['id'].'" data-original-title="Sign In" title="Sign In"><i class="fa fa-sign-in text-success"></i></button><button type="button" class="btn btn-warning btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-toggle="modal" data-target="#editmodal-'.$row['id'].'" data-original-title="Edit" title="Update Code"><i class="fa fa-pencil text-warning"></i></button>&emsp;<button type="button" class="btn btn-danger text-danger btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#delmodal-'.$row['id'].'" data-original-title="Delete" title="Delete"><i class="ti-eraser text-danger"></i></button>&emsp;&emsp;<button type="button" class="btn btn-dark btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#noshowmodal-' .$row['id'].'" data-original-title="No Show" title="Declare No-Show"><i class="fa fa-times-circle-o text-dark"></i></button>&emsp;&emsp;<a href="https://wa.me/?text=' .$msg. '" data-toggle="tooltip" data-original-title="Share on WhatsApp" target="_blank"><i class="fa fa-mail-forward text-success m-r-10"></i></a></td>'; 
											echo '<!-- Delete Modal -->
											<div class="modal fade" id="delmodal-'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['id'].'" aria-hidden="true">
											  <div class="modal-dialog" role="document">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="passmodal">Delete Entrance Code?</h5>
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
											<!-- /Delete Modal -->';
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
											<!-- Sign In Modal -->
											<div class="modal fade" id="inmodal-'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['id'].'" aria-hidden="true">
											  <div class="modal-dialog" role="document">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="outmodal">Sign guest in?</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												  </div>
												  <div class="modal-body">
													<form action="" method="POST">
													   <div class="form-row">
														<input type="hidden" name="id" value="'.$row['id'].'">
														<div class="form-group col-lg-12">
														  <input type="submit" name="signin" value="Yes. Sign In." class="btn btn-block btn-outline-info">
														</div>
													   </div>
													</form>
												  </div>
												</div>
											  </div>
											</div>
											<!-- /Sign Out Modal -->
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
										?>
										<td style="display: none;"><?php echo $row['code']; ?></td>
										</tr><?php $i++; } 
									      } else { echo "No Pending Invites.";}
											$con->close(); ?>                                  
									  </tbody>
                  </table>
                  </div>
			      		</div>
			  			</div>
            </div>
		  		</div>
		  		<div class="col-lg-12">
				<div class="card m-b-30">
          <div class="card-body">
          	<h4 class="mt-0 header-title">All Invites</h4>
						<div class="table-rep-plugin">
              <div class="table-responsive table-bordered">
                <?php include ('../db.php'); 
								$sql = "SELECT * FROM entrance_codes where estate='".$_SESSION['estate']."'";
								$result = $con->query($sql);
								if ($result->num_rows > 0) { ?>
								<!-- <button type='button' onclick="window.location.href = 'report.php?title=1';" class='btn btn-success btn-sm ml-1 mb-3' style='border-radius: 10px; float: right;'><b>Download CSV Report</b></button>
								<button type='button' onclick="window.location.href = 'reportpdf.php?title=1';" class='btn btn-danger btn-sm mb-3' style='border-radius: 10px; float: right;'><b>Download PDF Report</b></button> -->
								<table id="tech-companies-1" class="table table-bordered">
	                <thead><tr class="titles"><th>S/No</th><th>Guest</th><th>Vehicle No.</th><th>Companions</th><th>Duration</th><th>Arrival</th><th>Phone</th><!--<th>Action</th>--><th>Status</th><th  style="display: none;">Code</th></tr></thead>
	                <tbody> <?php $i=1; while($row = $result->fetch_assoc()) { 
										$phpdate = strtotime( $row['arr_date'] );
										$myFormatForView = date("d-M-Y g:i A", $phpdate);
	                	?>
									<tr><td><?php echo $i; ?></td><td><?php echo $row['visitor']; ?></td>
									<td><?php echo $row['reg_no']; ?></td><td><?php echo $row['comp']; ?></td>
									<td><?php echo $row['duration']; ?></td><td><?php echo $myFormatForView; ?></td>
									<td><?php echo $row['phone']; ?></td><td><?php echo $row['status']; ?></td>
									<td style="display: none;"><?php echo $row['code']; ?></td>
							  	<?php //echo "<td><a data-toggle='modal' data-target='#delmodal-" .$row['id']."' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>"; 
											echo '<!-- Delete Modal -->
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
											<!-- /Delete Modal -->';
										?></tr><?php $i++; } 
									      } else { echo "No Invites.";}
											$con->close(); ?>                                  
									  </tbody>
                  </table>
                  </div>
			      		</div>
			  			</div>
            </div>
		  		</div>
        </div><!-- end row -->
      </div><!-- container -->
    </div><!-- Page content Wrapper -->
  </div><!-- content -->
  <?php include('footer.php'); } ?>
</html>