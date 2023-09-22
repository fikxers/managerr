<?php include('auth.php'); $title ='Maintenance'; ?>
        <?php 
		  if($_SESSION['admin_type']=='admin'){
		   include('admin_sidebar.php'); 
		  }
	      else if($_SESSION['admin_type']=='mgr'){
		   include('mgr_sidebar.php');
		  }
		  else if($_SESSION['admin_type']=='flat'){
		   include('flat_sidebar.php');
		  }
		?>
		<?php
		  require('../db.php');
		  if (isset($_POST['name'])){
			$name = stripslashes($_REQUEST['name']);
			$date = stripslashes($_REQUEST['date']);
			$interval = stripslashes($_REQUEST['interval']);
			//$status = stripslashes($_REQUEST['status']);		  
			//b4 insert, check if exists
			if( ! ini_get('date.timezone') )
			{
			  date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT into `maintenance` (flat,estate, status, created_at,equipment, maint_date, mnt_interval) VALUES ('".$_SESSION['email']."', '".$_SESSION['estate']."', 'pending','$trn_date','$name', '$date', '$trn_date')";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Maintenance registered.');</script>";
			  echo "<script type='text/javascript'>window.top.location='maintenance.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Maintenance registration not successful.');</script>";
			  echo "<script type='text/javascript'>window.top.location='maintenance.php';</script>"; exit;
			}
		  }
		  else{
			//echo "<script>alert('Error');</script>";
		?>

            <div class="page-content-wrapper ">
                <div class="container-fluid">
				    <div class="row">       
						<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Maintenance</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM maintenance where flat='".$_SESSION['email']."'";
													if($_SESSION['admin_type']=='admin'){$sql = "SELECT * FROM maintenance";}
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Equipment</th>
															<th>Maintenance Date</th>
															<th>Monthly Interval</th>                                                                                                                                                                                 
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['equipment']; ?></td>
															<td><?php echo $row['maint_date']; ?></td>
															<td><?php echo $row['mnt_interval']; ?></td>
															</tr>
														<?php
														}
													} else {
														echo "No maintenance registered.";
													}
													$con->close();
													?>                                                       
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                        </div> <!-- end col -->
						<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Register Maintenance</h4>
                                        <p class="text-muted m-b-30 font-14">Add equipment for maintenance notifications.</p>
                                          <form class="" action="" required method="POST">
											<div class="form-group row">
											  <label for="example-text-input" class="col-sm-2 col-form-label">Select Equipment</label>
											  <div class="col-sm-10"><select class="form-control" required name="equipment" >
											    <!--<option value="">Select Equipment</option>-->
											    <?php include ('../db.php');
												$sql="select name,location from equipments where flat='".$_SESSION['email']."'"; 
											    $result = $con->query($sql);; 
											    while($row = $result->fetch_assoc()) { 
											    ?>
											    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']."-".$row['location']; ?></option><?php } ?>
											  </select></div>
											</div>
											<!--<div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Monthly Interval</label>
                                                <div class="col-sm-10">
                                                  <input type="number" name="interval" class="form-control" min="1" max="5" placeholder="0"/>
                                                </div>
                                            </div>-->
											<div class="form-group row">
											  <label for="example-text-input" class="col-sm-2 col-form-label">Maintenance Date</label>
                                              <div class="col-sm-10"><input type="date" name="date" class="form-control" required placeholder="Choose Date">
											  </div>
                                            </div>
											<div class="form-group row">
											  <label for="example-text-input" class="col-sm-2 col-form-label">Monthly Interval</label>
                                              <div class="col-sm-10"><input type="number" name="interval" class="form-control" min="1" max="12" placeholder="1"/>
											  </div>
                                            </div>
											
                                            <div class="form-group">
                                               <div>
                                                  <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                                  <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button>
                                               </div>
                                            </div>
                                          </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->   
                    </div>
                    <!-- container -->

                </div>
                <!-- Page content Wrapper -->

            </div>
            <!-- content -->

		  <?php include('footer.php'); } ?>
</html>