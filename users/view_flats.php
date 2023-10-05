<?php require('auth.php'); $title ='Residents'; include ('../db.php');
	  if (isset($_POST['flat_no'])){
	    $flat_no = stripslashes($_REQUEST['flat_no']);
	    $block_no = stripslashes($_REQUEST['block_no']);
	    //$flat_id = stripslashes($_REQUEST['flat_id']);
	    //$no_of_equipments = stripslashes($_REQUEST['no_of_equipments']);
	    if( isset($_SESSION['admin_type']) && $_SESSION['admin_type']=='admin'){
		  	$estate_code = stripslashes($_REQUEST['estate_code']); 
			}
			else if( isset($_SESSION['admin_type']) && $_SESSION['admin_type']=='mgr'){
				$estate_code = $_SESSION['estate'];
			}
	    $owner = stripslashes($_REQUEST['owner']);
	    $phone = stripslashes($_REQUEST['phone']);
	    $email = stripslashes($_REQUEST['email']);
	    $password = stripslashes($_REQUEST['password']);
	    $password2 = stripslashes($_REQUEST['rpassword']);
	    if(trim($password)=='' || trim($password2)=='')
	    {
		  echo('All fields are required!');
		  header('Location: view_fixers.php');
	    }
	    else if($password != $password2)
	    {
		  echo('Passwords do not match!');
		  header('Location: view_fixers.php');
	    }
	    else{ 
		  $password = mysqli_real_escape_string($con,$password);
		  if( ! ini_get('date.timezone') )
		  {
		  date_default_timezone_set('Africa/Lagos');
		  }
		  $trn_date = date("Y-m-d H:i:s");
		  //b4 insert, check if exists 
		  //check if flat_no && block_no && estate_code already in db
		  //alternatively, use email as pk
	    $query = "INSERT into `flats` (email,flat_no,block_no,estate_code,phone,owner,created_at) VALUES ('".$email."','$flat_no','$block_no', '$estate_code','$phone','$owner','$trn_date')";
		  $query2 = "INSERT into `users` (email, password, admin_type) VALUES ('".$email."', '".md5($password)."', '$admin_type')";
	    $result = mysqli_query($con,$query);
		  if($result){
		  $result2 = mysqli_query($con,$query2);
			// the message
			$msg = "Dear ".$name."\n\nYou have successfully registered on Managerr.com\n\nYou are welcome.";
			// use wordwrap() if lines are longer than 70 characters
			$msg = wordwrap($msg,70);
			// send email
			mail($email,"Successful Registration on Managerr.com",$msg);
			echo "<script>alert('Resident added successfully.');</script>";
		    echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
		  }
		  else{
			$error=mysqli_error($con);
			echo '<script type="text/javascript">alert("Error: '.$error.'");</script>';
			//echo "<script>alert('Error adding resident.');</script>";
			echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
		  }
	    }
	  }
	  //Delete
	  if (isset($_POST['delid'])){
		$id = $_REQUEST['delid'];
	    // sql to delete a record
	    $sql = "DELETE FROM flats WHERE id = $id"; 
	    $res = $con->query($sql);
	    if ($res) {
		  mysqli_close($con);
		  echo "<script>alert('Resident deleted.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
	    } 
		else {
		  echo "<script>alert('Error deleting resident.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>";
	    }  
	  }
	  //update
	  else if (isset($_POST['update'])){
	  	$id = $_REQUEST['id']; $email = $_REQUEST['email'];
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
			// $status = $_REQUEST['status'];
			// $change_status = "UPDATE users set status=$status WHERE email = '$id'";
			if( isset($_REQUEST['password']) ){
			  $password = stripslashes($_REQUEST['password']);
			  $change_status = "UPDATE users set password='".md5($password)."' WHERE email = '".$email."'";
			  $result3 = mysqli_query($con,$change_status);
			}
			$query = "UPDATE flats set owner='".$owner."',phone='".$phone."',flat_no = '".$flat."',block_no = '".$block."',meter_pan='".$meter."' WHERE id = $id";
			$result2 = mysqli_query($con,$query); 
			if($result2){
			  echo "<script>alert('Resident updated successfully.');</script>";
			  echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Error updating resident.');</script>";
			  echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
			}
	  }
	  else if (isset($_POST['activate'])){
		//$id = $_REQUEST['id']; 
		$query = "UPDATE users set status=1 WHERE email = '".$_REQUEST['email']."'";
		$result2 = mysqli_query($con,$query); 
		if($result2){
			echo "<script>alert('Resident activated successfully.');</script>";
			echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
		}
		else{
			echo "<script>alert('Activation Error. Please try again.');</script>";
			echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
		}
	  }
	  else if (isset($_POST['credit'])){
		$amount = $_REQUEST['amount']; $id = $_REQUEST['id']; $action = $_REQUEST['bal'];
		$query = "UPDATE flats set amount_paid=amount_paid+$amount, last_payment_type='fm_credit', last_payment_date='".date("Y-m-d")."' WHERE id = $id";
		if($action=='debt'){$query = "UPDATE flats set total_debt=total_debt+$amount, updated_at='".date("Y-m-d H:i:s")."' WHERE id = $id";}
		$result2 = mysqli_query($con,$query); 
		if($result2){
			echo "<script>alert('Resident Account updated successfully.');</script>";
			echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;

		}
		else{
			echo "<script>alert('Account update Unsuccessful. Please try again.');</script>";
			echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
		}  
	  }
	  else{
		//echo "<script>alert('Error');</script>";
		if( isset($_SESSION['admin_type']) && $_SESSION['admin_type']=='admin'){
		   include('admin_sidebar.php'); 
		}
	    else if( isset($_SESSION['admin_type']) && $_SESSION['admin_type']=='mgr'){
		   include('mgr_sidebar.php');
		}
		?>
	  <div class="row">       
			<div class="col-lg-12">
        <div class="card m-b-30">
          <div class="card-body">
            <h4 class="mt-0 header-title">All Residents</h4>
			      <span style="float: right">
					    <a type='button' href="./import-csv" class='btn text-primary btn-primary btn-sm' style='background-color: transparent; border-width: 0px;'><i class="fa fa-file m-r-10 m-b-10"></i>Import CSV</a>
							<button type='button' class='btn text-dark btn-dark btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target="#residentmodal" data-original-title="Add Resident"><i class="fa fa-user-plus m-r-10 m-b-10"></i><b>Add Resident</b>
							</button>
							<button type='button' class='btn btn-danger text-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target="#activatemodal" data-original-title="Activate Resident"><i class="fa fa-check m-r-10 m-b-10"></i><b>Activate Resident</b>
							</button>
					  </span>
            <div class="table-rep-plugin">
              <div class="table-responsive b-0" data-pattern="priority-columns">
                <?php include ('../db.php'); 
                $sql = "SELECT * FROM flats JOIN estates using(estate_code) ORDER BY block_no, flat_no";
								if($_SESSION['admin_type']=='mgr'){
				  			$sql = "SELECT * FROM flats where estate_code='".$_SESSION['estate']."' ORDER BY block_no, flat_no"; }
							  $result = $con->query($sql);
							  if ($result->num_rows > 0) { ?>
				  			<table id="tech-companies-1" class="table table-bordered table-striped">
                  <thead><tr class="titles"><th>Flat</th><th>Block</th>
                    <?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?>
                    <th>Resident</th><!--<th>Ownership</th>--> <th>Phone</th>
                    <th># of assets</th><th>Due Status</th><th>Acct Bal</th><th>Action</th></tr>
                  </thead>
                  <tbody> <?php while($row = $result->fetch_assoc()) { ?>
										<tr><td><?php echo $row['flat_no']; ?></td>
											<td><?php echo $row['block_no']; ?></td>
											<?php if($_SESSION['admin_type']=='admin'){echo "<td>".$row['estate_name']."</td>";} ?>
											<td><?php echo $row['owner']; ?></td><!--<td><?php echo $row['ownership']; ?></td>-->
											<td><?php echo $row['phone']; ?></td>
											<?php $sql = "SELECT COUNT(*) AS cnt FROM equipments where flat='".$row['email']."'"; 
												$res = $con->query($sql);
												$values = mysqli_fetch_assoc($res); 
												$num_eqpm = $values['cnt']; ?>
											<td><?php echo $num_eqpm; ?></td>
											<!--<td><?php //$stat = $row['status']; if($stat=='good' || $stat=='Good'){echo '<span class="badge badge-success">'.$stat.'</span>';} else {echo '<span class="badge badge-danger">'.$stat.'</span>';} ?></td>-->
											<td><?php if($row['amount_paid']-$row['total_debt'] >= 0)	{echo '<span class="badge badge-success">Good</span>';}  
												else{echo '<span class="badge badge-danger">Owing</span>';}?></td>
											<td><?php echo acct_bal($row['amount_paid'],$row['total_debt']); ?></td>
											<?php echo "<td><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#editmodal-".$row['id']."' data-original-title='Update Resident'><i class='fa fa-pencil' aria-hidden='true'></i></button><button type='button' class='btn text-danger btn-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-".$row['id']."' data-original-title='Delete Resident'><i class='fa fa-trash' aria-hidden='true'></i></button>
											 <button type='button' class='btn btn-info text-info btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#creditmodal-" .$row['id']."' title='Update Resident Balance' data-original-title='Update Resident Balance'><i class='ti-wallet text-info'></i></button>
											 <a href='history.php?flat_id=".$row['id']."' data-toggle='tooltip' data-original-title='View Resident History'><i class='fa fa-solid fa-eye'></i></a></td>"; ?>
											 <!--<a href='update_flat.php?id=" .$row['email']."&phone=" .$row['phone']."&owner=" .$row['owner']."&flat=" .$row['flat_no']."&block=" .$row['block_no']."&meter=" .$row['meter_pan']."' data-toggle='tooltip' data-original-title='Update Resident Info'><i class='fa fa-pencil text-success'></i></a><a href='history.php?flat_email=" .$row['email']."&flat_no=" .$row['flat_no']."&block=" .$row['block_no']."' data-toggle='tooltip' data-original-title='View Resident History'><i class='fa fa-solid fa-eye'></i></a><a href='delete_flat.php?id=" . $row['email'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> -->
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
        </div> <!-- end col -->
			 <!-- Activate Resident Modal -->
			 <div class="modal fade" id="activatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
				    <div class="modal-header">
					  <h5 class="modal-title" id="exampleModalLongTitle">Activate Resident</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					  <div class="table-rep-plugin">
						<form action="" method="POST">
						 <div class="table-responsive b-0" data-pattern="priority-columns">
						 <?php include ('../db.php'); 
						 $sql = "SELECT * FROM flats ORDER BY block_no, flat_no";
						 if($_SESSION['admin_type']=='mgr'){
						  $sql = "SELECT * FROM flats natural join users where estate_code='".$_SESSION['estate']."' and users.status=0 ORDER BY block_no, flat_no"; }
						  $result = $con->query($sql);
						  if ($result->num_rows > 0) { ?>
						  <table id="tech-companies-1" class="table  table-striped">
							<thead><tr class="titles"><th>Flat</th><th>Block</th>
							<?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?><th>Resident</th><th>Action</th></tr></thead>
							<tbody> <?php while($row = $result->fetch_assoc()) { ?>
							  <tr><td><?php echo $row['flat_no']; ?></td>
								<td><?php echo $row['block_no']; ?></td>
								<?php if($_SESSION['admin_type']=='admin'){echo "<td>".$row['estate_code']."</td>";} ?>
								<td><?php echo $row['owner']; ?></td>
								<input type="hidden" name="email" value="<?php echo $row['email']; ?>">
								<td><input type='submit' name='activate' value='Activate' class='btn btn-block btn-outline-info'> </td>
								</tr>
								<?php } } else {echo "No resident in database.";}
								$con->close(); ?>
							</tbody>
						  </table>
						 </div>
						</form>
					  </div>
				    </div>
				</div>
			  </div>
			  <!-- /Activate Resident Modal -->
			 
			  <!-- Add Resident Modal -->
			 <div class="modal fade" id="residentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
				    <div class="modal-header">
					  <h5 class="modal-title" id="exampleModalLongTitle">Add Resident</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					    <form class="" action="view_flats.php" method="POST">
						  <div class="form-group">
						    <input data-parsley-type="number" type="text" name="flat_no" class="form-control" required placeholder="Flat Number"/>
						  </div>
						  <div class="form-group">
						    <input data-parsley-type="number" type="text" name="block_no" class="form-control" required placeholder="Block Number"/>
						  </div>
						  <?php if($_SESSION['admin_type']=='admin'){
							include('estate_div.php'); } ?>
						  <div class="form-group">
							<input name="owner" type="text" class="form-control" required placeholder="Resident's name"/>
						  </div>
						  <div class="form-group">
							<input name="phone" type="text" class="form-control" required placeholder="Phone"/>
						  </div>
						  <div class="form-group">
							<input name="email" type="text" class="form-control" required placeholder="Email"/>
						  </div> 
						  <div class="form-group">
							<input name="password" type="password" class="form-control" required placeholder="Password"/>
						  </div> 
						  <div class="form-group">
							<input name="rpassword" type="password" class="form-control" required placeholder="Repeat password"/>
						  </div>
						  <div class="form-group">
							<button type="submit"  class="btn btn-primary waves-effect waves-light">Add New Resident</button>
							<button type="reset" class="btn btn-secondary waves-effect m-l-5">Reset Form</button>
						  </div>
						</form>
					</div>
				  </div>
				</div>
			</div>
			<!-- /Add Resident Modal -->
        </div><!-- container -->
      </div><!-- Page content Wrapper -->
	</div><!-- content -->
	<?php include('footer.php'); } ?>
</html>