<?php require('auth.php'); $title ='Manage Estate';  
	include('admin_sidebar.php');
	if (isset($_GET['id'])){ 
		$id = $_GET['id']; 
		$sql = "SELECT * FROM estates where estate_code = '".$id."'"; 
		$result = mysqli_query($con,$sql) or die(mysqli_error($con));
    $estate_name = $result->fetch_object()->estate_name;
    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
    $due_date = $result->fetch_object()->due_date;
    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
    $current_monthly_due = $result->fetch_object()->monthly_due;
    
	}
	else{
		echo "<script type='text/javascript'>window.top.location='view_estates.php';</script>"; exit;
	}
	
	if (isset($_POST['submit'])){
		$description = stripslashes($_REQUEST['description']);
		$skill = stripslashes($_REQUEST['skill']);			
		$query = "UPDATE orders SET required_skill = '$skill', order_status = 'quote_requested', mgr_description='$description' WHERE order_id=$service_id";
		$result = mysqli_query($con,$query);
		if($result){
			echo "<script>alert('Quote requested.');</script>";
			echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
		}
		else{
			  echo "<script>alert('Quote Request not successful.');</script>";
			  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
		}
	}
	else{
?>
  <div class="row">
		<div class="col-lg-12">
			<div class="card m-b-30">
				<div class="card-body">
					<h4 class="mt-0 header-title"><?php echo $estate_name; ?></h4>
					<?php
						$estate_code = $id;
						$btn = "<button type='button' class='btn btn-primary btn-sm' style='background-color: transparent; border-width: 0px;' title='Change Due Date' data-toggle='modal' data-target='#exampleModalCenter' data-original-title='Change Due Date'><i class='fa fa-pencil text-primary'></i></button>";
						$btnn = "<button type='button' class='btn btn-dark btn-sm' style='background-color: transparent; border-width: 0px;' title='Change Deadline Option' data-toggle='modal' data-target='#changedeadline' data-original-title='Change Deadline Option'><i class='fa fa-pencil text-dark'></i></button>";
						$btnm = "<button type='button' class='btn btn-warning btn-sm' style='background-color: transparent; border-width: 0px;' title='Change Estate Levy' data-toggle='modal' data-target='#levymodal' data-original-title='Change Due Date'><i class='ti-wallet text-dark'></i></button>";
            $btnmax = "<button type='button' class='btn btn-warning btn-sm' style='background-color: transparent; border-width: 0px;' title='Change Max Monthly Electricity Payment' data-toggle='modal' data-target='#maxmodal' data-original-title='Change Max Monthly Electricity Payment'><i class='text-dark'>&#8358;</i></button>";
						$textbox_msg = "";
						//DEADLINE OPTION
						$deadline_option = "select deadline_option from estates where estate_code='$estate_code'";
						$result = mysqli_query($con,$deadline_option) or die(mysqli_error($con));
						$deadline_option = $result->fetch_object()->deadline_option; $options = "";
            
						if($deadline_option==1){ 
							echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: Last day of month <span style="float: right">'.$btnn.'</span></div>';
						}
						else if ($deadline_option==2){ 
							$textbox_msg = "# of days after month end"; 
							echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: '.$due_date.' Days after month end <span style="float: right">'.$btnn.' '.$btn.'</span></div>';
						}
						else { 
							$textbox_msg = "# of days before month end";
							echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: '.$due_date.' Days before month end <span style="float: right">'.$btnn.' '.$btn.'</span></div>';
						}
            echo '<div class="row">';
            //CURRENT MONTHLY DUE
						echo '<div class="col-lg-6"><div class="alert alert-warning text-dark" role="alert">Current Monthly Due:  '.number_format($current_monthly_due, 2, '.', ',').'<span style="float: right">'.$btnm.'</span></div></div>';
            //MAX MONTHLY ELECTRIC PAYMENT FOR RESIDENTS
            $maxMonthlyPayment = "select maxMonthlyPayment from estates where estate_code='$estate_code'";
            $result = mysqli_query($con,$maxMonthlyPayment) or die(mysqli_error($con));
            $maxMonthlyPayment = $result->fetch_object()->maxMonthlyPayment; 
            $formattedNumber = number_format($maxMonthlyPayment, 2, '.', ',');
            echo '<div class="col-lg-6"><div class="alert alert-warning text-dark" role="alert">Max Monthly Electricity Payment Allowed:  '.$formattedNumber.'<span style="float: right">'.$btnmax.'</span></div></div>';
            echo '</div>';
						echo '
							<!-- Modal -->
							<div class="modal fade" id="changedeadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Change Deadline Option</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form action="" method="POST">
									   <div class="form-row">
										<div class="form-group col-lg-6">
										  <select class="form-control" name="deadline">
										  	<option value="1">Month End</option><option value="2">Days After Month End</option><option value="3">Days Before Month End</option>
										  </select>
										</div>
										<div class="form-group col-lg-6">
										  <input type="submit" name="updatedeadline" value="Update" class="btn btn-block btn-outline-info">
										</div>
									   </div>
									  </form>
								  </div>
								  <!--<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								  </div>-->
								</div>
							  </div>
							</div>';
						echo '
							<!-- Modal -->
							<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Grace Period for Payment of Dues</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form action="" method="POST">
									   <div class="form-row">
										<div class="form-group col-lg-6">
										  <input type="number" max="31" min="1" name="dueday" id="dueday" class="form-control" placeholder="'.$textbox_msg.'" required />
										</div>
										<div class="form-group col-lg-6">
										  <input type="submit" name="updateduedate" value="Update" class="btn btn-block btn-outline-info">
										</div>
									   </div>
									  </form>
								  </div>
								  <!--<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								  </div>-->
								</div>
							  </div>
							</div>';
						echo '
							<!-- Modal -->
							<div class="modal fade" id="levymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Change Estate Levy</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form action="" method="POST">
									   <div class="form-row">
									    <div class="form-group col-lg-12">
										   <label>Which levy are you changing?</label><br>
										   Development Levy <input class="" type="radio" name="levysel" checked="checked" value="dev" /> 
										   Building Levy <input class="" type="radio" name="levysel" value="build" /> Monthly Due <input class="" type="radio" name="levysel" value="monthly" />
										</div>
										<div class="form-group col-lg-6">
										  <input type="number" max="1000000" min="10000" step="5000" name="levy" class="form-control" placeholder="New Levy" required />
										</div>
										<div class="form-group col-lg-6">
										  <input type="submit" name="updatelevy" value="Update Levy" class="btn btn-block btn-outline-info">
										</div>
									   </div>
									  </form>
								  </div>
								  <!--<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								  </div>-->
								</div>
							  </div>
							</div>';
            echo '
                            <!-- Modal -->
                            <div class="modal fade" id="maxmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Change Max Monthly Electricity Payment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="" method="POST">
                                       <div class="form-row">
                                        <div class="form-group col-lg-6">
                                          <input type="number" max="1000000" min="10000" step="5000" name="maxelectric" class="form-control" placeholder="Current: '.$formattedNumber.'" required />
                                        </div>
                                        <div class="form-group col-lg-6">
                                          <input type="submit" name="updatemaxelectric" class="btn btn-block btn-outline-info">
                                        </div>
                                       </div>
                                      </form>
                                  </div>
                                  <!--<div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                  </div>-->
                                </div>
                              </div>
                            </div>';
              //TRAFFIC CONTROL
							if( ! ini_get('date.timezone') ) { date_default_timezone_set('Africa/Lagos'); } $trn_date = date("Y-m-d"); //$trn_date = date("Y-m-d H:i:s");
							$trafficin = "SELECT COUNT(*) AS cnt FROM entrance_codes where status='signed-in' AND signin='".$trn_date."'"; //format the date from mysql
							$trafficout = "SELECT COUNT(*) AS cnt FROM entrance_codes where status='signed-out' AND signout='".$trn_date."'";
							$result = mysqli_query($con,$trafficin) or die(mysqli_error($con));
							$ins = $result->fetch_object()->cnt;
							$result = mysqli_query($con,$trafficout) or die(mysqli_error($con));
							$outs = $result->fetch_object()->cnt;
							echo '<div class="alert alert-info" role="alert">DAILY TRAFFIC CONTROL<br>Checkouts: '.$outs.' | Checkins: '.$ins.' | Total Visits: '.($ins+$outs).' </div>';
					?>
					<!--<div class="table-rep-plugin">
					  <div class="table-responsive b-0" data-pattern="priority-columns">
					  <?php include ('../db.php');
						$sql = "SELECT * FROM `payments` join flats on payments.estate=flats.estate_code where payments.estate='".$id."'AND payments.flat = flats.flat_no AND payments.block = flats.block_no";
						$result = $con->query($sql); 
						if ($result->num_rows > 0) { ?>
						<table id="tech-companies-1" class="table table-bordered table-striped table-sm">
						  <thead><tr class="titles"><th>Payment Amount</th><th>Resident</th><th>Block</th><th>Flat</th><th>Date Paid</th><th>Description</th> </tr></thead>
						  <tbody> <?php while($row = $result->fetch_assoc()) { ?>
							<tr><td><?php echo "&#8358;".$row['amount']; ?></td><td><?php echo $row['owner']; ?><td><?php echo $row['block']; ?></td><td><?php echo $row['flat']; ?></td><td><?php echo format_date($row['pay_date']); ?></td><td><?php echo $row['description']; ?></td></tr>
						<?php } } else {echo "No Payment Detected.";} $con->close(); ?>
						   </tbody>
						</table>
					   </div>
					</div>-->
					<div class="row">
						<div class="col-lg-3">
							<div class="alert alert-info text-center p-4 border border-info" role="alert">Transactions</div>
						</div>
						<div class="col-lg-3">
							<div class="alert alert-info text-center p-4 border border-info" role="alert">Visitor Management</div>
						</div>
						<div class="col-lg-3">
							<div class="alert alert-info text-center p-4 border border-info" role="alert">Electricity</div>
						</div>
						<div class="col-lg-3">
							<div class="alert alert-info text-center p-4 border border-info" role="alert">Notifications</div>
						</div>

					</div>
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					  <li class="nav-item" role="presentation">
					    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Home</button>
					  </li>
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</button>
					  </li>
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</button>
					  </li>
					</ul>
					<div class="tab-content" id="pills-tabContent">
					  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">...</div>
					  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
					  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
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