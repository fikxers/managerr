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
					<div class="row">
						<div class="col-lg-3">
							<a href="notifications.php?id=<?php echo $id; ?>">
								<button class="btn p-4 mb-3 border border-info shadow-sm btn-outline-info btn-block">
									<h6>Notifications</h6>
								</button>
							</a>
						</div>
						<div class="col-lg-3">
							<a href="validate_code.php?id=<?php echo $id; ?>">
								<button class="btn p-4 mb-3 border border-info shadow-sm btn-outline-info btn-block">
									<h6>Visitor Management</h6>
								</button>
							</a>
						</div>
						<div class="col-lg-3">
							<a href="electric-bill.php?id=<?php echo $id; ?>">
								<button class="btn p-4 mb-3 border border-info shadow-sm btn-outline-info btn-block">
									<h6>Electricity</h6>
								</button>
							</a>
						</div>
						<div class="col-lg-3">
							<a href="dues.php?id=<?php echo $id; ?>">
								<button class="btn p-4 mb-3 border border-info shadow-sm btn-outline-info btn-block">
									<h6>Estate Payments</h6>
								</button>
							</a>
						</div>

					</div>
				</div>
			</div>
			<div class="card m-b-30">
				<div class="card-body">
					<h4 class="mt-0 header-title">Manage Residents</h4>
					<div class="table-rep-plugin">
              <div class="table-responsive b-0" data-pattern="priority-columns">
                <?php include ('../db.php'); 
                $sql = "SELECT * FROM flats JOIN estates using(estate_code) where flats.estate_code='".$estate_code."' ORDER BY block_no, flat_no";
								if($_SESSION['admin_type']=='mgr'){
				  			$sql = "SELECT * FROM flats where estate_code='".$_SESSION['estate']."' ORDER BY block_no, flat_no"; }
							  $result = $con->query($sql);
							  if ($result->num_rows > 0) { ?>
				  			<table id="tech-companies-1" class="table table-bordered table-striped">
                  <thead><tr class="titles"><th>Flat</th><th>Block</th>
                    <th>Resident</th><th>Phone</th>
                    <th># of assets</th><th>Status</th><th>Acct Bal</th><th>Action</th></tr>
                  </thead>
                  <tbody> <?php while($row = $result->fetch_assoc()) { ?>
										<tr><td><?php echo $row['flat_no']; ?></td><td><?php echo $row['block_no']; ?></td>											
											<td><?php echo $row['owner']; ?></td><td><?php echo $row['phone']; ?></td>
											<?php $sql = "SELECT COUNT(*) AS cnt FROM equipments where flat='".$row['email']."'"; 
												$res = $con->query($sql); $values = mysqli_fetch_assoc($res); $num_eqpm = $values['cnt']; ?>
											<td><?php echo $num_eqpm; ?></td>
											<td><?php if($row['amount_paid']-$row['total_debt'] >= 0)	{echo '<span class="badge badge-success">Good</span>';}  
												else{echo '<span class="badge badge-danger">Owing</span>';}?></td>
											<td><?php echo acct_bal($row['amount_paid'],$row['total_debt']); ?></td>
											<?php echo "<td><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#editmodal-".$row['id']."' data-original-title='Update Resident'><i class='fa fa-pencil' aria-hidden='true'></i></button><button type='button' class='btn text-danger btn-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-".$row['id']."' data-original-title='Delete Resident'><i class='fa fa-trash' aria-hidden='true'></i></button>
											 <button type='button' class='btn btn-info text-info btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#creditmodal-" .$row['id']."' title='Update Resident Balance' data-original-title='Update Resident Balance'><i class='ti-wallet text-info'></i></button> <a href='history.php?flat_id=".$row['id']."' data-toggle='tooltip' data-original-title='Resident Payment History'><i class='fa fa-solid fa-eye'></i></a><a href='pay.php?flat_id=".$row['id']."' data-toggle='tooltip' data-original-title='Deposit to Wallet'><i class='ti-save-alt ml-3 text-primary'></i></a><a href='estate-payments.php?flat_id=".$row['id']."' data-toggle='tooltip' data-original-title='Estate Payments'><i class='ti-receipt ml-3 text-info'></i></a>
											 </td>"; ?>
										</tr>
										<!-- Delete Modal -->
										<div class="modal fade" id="delmodal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	                    <div class="modal-dialog modal-dialog-centered" role="document">
	                    	<div class="modal-content">
	                    		<div class="modal-header">
	                    			<h5 class="modal-title" id="exampleModalLongTitle">Delete <?php echo $row['owner']; ?>?</h5>
	                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    				<span aria-hidden="true">&times;</span>
	                    			</button>
	                    		</div>
	                    		<div class="modal-body">
	                    			<form action="" method="POST"> 
	                    				<input type="hidden" value="<?php echo $row['id']; ?>" name="delid">
	                    				<div class="form-group"><button type="submit" name="delete" class="btn btn-outline-primary btn-block">Yes. Delete</button></div>
	                    			 </form>   
	                    		</div>
	                    	</div>
	                    </div>
	                  </div>
	                  <!-- Delete Modal -->
										<!-- Edit Modal -->
										<div class="modal fade" id="editmodal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	                    <div class="modal-dialog modal-dialog-centered" role="document">
	                    	<div class="modal-content">
	                    		<div class="modal-header">
	                    			<h5 class="modal-title" id="exampleModalLongTitle">Update <?php echo $row['owner']; ?></h5>
	                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    				  <span aria-hidden="true">&times;</span>
	                    			</button>
	                    		</div>
	                    		<div class="modal-body">
	                    			<form class="" action="" method="POST">
															<div class="form-row">
																<div class="form-group col-lg-6">
																	<label>Update Resident Name</label>
													        <input type="text" name="owner" class="form-control"  value="<?php echo $row['owner']; ?>" />
													      </div>		
																<div class="form-group col-lg-6">
																	<label>Update Resident's Phone No.</label>
													        <input type="text" name="phone" class="form-control"  value="<?php echo $row['phone']; ?>" />
													      </div>
													      <div class="form-group col-lg-6">
																	<label>Update Flat/House No.</label>
																	<input type="text" name="flat" value="<?php echo $row['flat_no']; ?>" class="form-control" />
																</div>
															  <div class="form-group col-lg-6">
																	<label>Update Block/Street No.</label>
																	<input type="text" name="block" value="<?php echo $row['block_no']; ?>" class="form-control" />
																</div>
																<div class="form-group col-lg-6">
																	<label>New Passsword (If Applicable)</label>
																	<input type="password" name="password" class="form-control" />
																	<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
																	<input type="hidden" name="email" value="<?php echo $row['email']; ?>" />
																</div>
																<div class="form-group col-lg-6">
																	<label>Update Meter No.</label>
																	<input type="text" name="meter" value="<?php echo $row['meter_pan']; ?>" class="form-control" />
																</div>
																<!--<div class="form-group col-lg-12"><br>
													        <?php if($status_now==0){echo "<b>Current Status: Not Active</b>"; } else{echo "<b>Current Status: Active</b>"; } ?>
															 		Activate <input type="radio" name="status" checked="checked" value="1"/> 
															    Deactivate <input type="radio" name="status" value="0"/> <br><br>
													      </div>-->
													      <div class="form-group col-lg-12">
													        <button type="submit" name="update" class="btn btn-primary">Update Resident</button>
													      </div>
													    </div>
													  </form>  
	                    		</div>
	                    	</div>
	                    </div>
										</div>
										<!-- Edit Modal -->
							      <!-- Credit Modal -->
                    <div class="modal fade" id="creditmodal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                      		<div class="modal-header">
                      		  <!--<h6 class="modal-title" id="exampleModalLongTitle">Credit <?php echo $row['owner']."'s Account"; ?></h6>-->
                            <h6 class="modal-title" id="exampleModalLongTitle">Current Balance: <?php echo acct_bal($row['amount_paid'],$row['total_debt']); ?></h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form class="" action="" method="POST">
                              <div class="form-row">
                                <div class="form-group col-lg-12">
            										  <label>What do you want to do?</label><br>
            										  Credit Account <input class="" type="radio" name="bal" checked="checked" value="cred" /> 
            										  Add Debt <input class="" type="radio" name="bal" value="debt" /> <br>
                                  <input type="number" name="amount" step="500" min="1000" class="form-control" />
                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                                </div>		
                                <div class="form-group col-lg-12">
                                  <button type="submit" name="credit" class="btn btn-success"> Update Account</button> 
                                  <button type="reset" name="cancel" class="btn btn-dark">Reset</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /Credit Modal -->
											<?php } } else {echo "No resident in database.";}
											$con->close(); ?>
                    </tbody>
                  </table>
                </div>
			   			</div>
				</div>
			</div>
			<div class="card m-b-30">
				<div class="card-body">
					<h4 class="mt-0 header-title">Payment History</h4>
					<div class="table-rep-plugin">
						<div class="table-responsive b-0" data-pattern="priority-columns">
							<?php include ('../db.php'); 
								$sql = "SELECT flats.owner, note, amount, date_paid FROM dues JOIN flats ON flats.email=dues.flat WHERE estate='".$id."' UNION SELECT flats.owner,'Electricity Vend', amount, transaction_date FROM transactions JOIN flats ON transactions.flat=flats.flat_no AND transactions.block=flats.block_no WHERE estate='".$id."' UNION SELECT flats.owner, description, amount, pay_date FROM payments JOIN flats ON payments.flat=flats.flat_no AND payments.block=flats.block_no WHERE estate='".$id."' ORDER BY date_paid";
								$result = $con->query($sql); 
								if ($result->num_rows > 0) { ?>
								<table id="tech-companies-1" class="table table-bordered table-striped table-sm">
									<thead>
										<tr class="titles"><th>Resident</th><th>Transaction</th><th>Transaction Date</th><th>Amount</th></tr>
									</thead>
									<tbody> <?php while($row = $result->fetch_assoc()) { ?>
										<tr><td><?php echo $row['owner']; ?></td><td><?php echo $row['note']; ?></td>
											<td><?php echo format_date2($row['date_paid']); ?></td>
											<td><?php echo "&#8358;".currency_format($row['amount']); ?></td></tr>
										<?php } } else {echo "No Transaction Detected.";} $con->close(); ?>
									</tbody>
								</table>
						</div>
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