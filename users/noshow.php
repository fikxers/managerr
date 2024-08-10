<?php require('auth.php'); $title ='No-Shows'; 
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
else{
?>
		<div class="row">
		  <div class="col-lg-12">
				<div class="card m-b-30">
          <div class="card-body">
						<div class="table-rep-plugin">
              <div class="table-responsive b-0" data-pattern="priority-columns">
              	<!-- <button type='button' onclick="window.location.href = 'report.php?title=3';" class='btn btn-success btn-sm ml-1 mb-3' style='border-radius: 10px; float: right;'><b>Download CSV Report</b></button>
								<button type='button' onclick="window.location.href = 'reportpdf.php?title=3';" class='btn btn-danger btn-sm mb-3' style='border-radius: 10px; float: right;'><b>Download PDF Report</b></button> -->
                <?php include ('../db.php');
								$sql = "SELECT * FROM entrance_codes where estate='".$_SESSION['estate']."' and status='no-show' and block='0' and flat='0'";
								$result = $con->query($sql);
								if ($result->num_rows > 0) { ?>
								<table id="tech-companies-1" class="table  table-bordered">
                  <thead><tr class="titles"><th>Guest</th><th>Vehicle No.</th><th>Companions</th><th>Duration</th><th>Arrival</th><th>Phone</th><!--<th>Action</th--><th style="display:none">Code</th></tr></thead>
                  <tbody> <?php while($row = $result->fetch_assoc()) { 
										$phpdate = strtotime( $row['arr_date'] );
										$myFormatForView = date("d-M-Y g:i A", $phpdate);
                  	?>
									<tr><td><?php echo $row['visitor']; ?></td>
									<td><?php echo $row['reg_no']; ?></td><td><?php echo $row['comp']; ?></td>
									<td><?php echo $row['duration']; ?></td><td><?php echo $myFormatForView; ?></td>
									<td><?php echo $row['phone']; ?></td>
							  	<?php //echo "<td><a data-toggle='modal' data-target='#inmodal-" .$row['id']."' data-original-title='Sign In'><i class='fa fa-sign-in text-success m-r-10'></i></a> <a data-toggle='modal' data-target='#outmodal-" .$row['id']."' data-original-title='Sign Out'><i class='fa fa-sign-out text-info m-r-10'></i></a> </td><td style='display:none'>".$row['code']."</td>"; 
										echo '<!-- Sign In Modal -->
										<div class="modal fade" id="inmodal-'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['id'].'" aria-hidden="true">
										  <div class="modal-dialog" role="document">
											<div class="modal-content">
											  <div class="modal-header">
												<h5 class="modal-title" id="inmodal">Sign in guest?</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span>
												</button>
											  </div>
											  <div class="modal-body">
												<form action="" method="POST">
												   <div class="form-row">
													<input type="hidden" name="id" value="'.$row['id'].'">
													<div class="form-group col-lg-12">
													  <input type="submit" name="signin" value="Yes. Sign In" class="btn btn-block btn-outline-info">
													</div>
												   </div>
												</form>
											  </div>
											</div>
										  </div>
										</div>
										<!-- /Sign In Modal -->';
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
										?></tr><?php } 
									      } else { echo "0 No-Shows.";}
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