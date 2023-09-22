<?php include('auth.php'); $title ='Repairs & Inspection'; ?>
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
		  if (isset($_POST['equipment'])){
			$equipment = stripslashes($_REQUEST['equipment']);
			$description = stripslashes($_REQUEST['description']);
			$date = stripslashes($_REQUEST['date']);
			//$status = stripslashes($_REQUEST['status']);		  
			//b4 insert, check if exists
			if( ! ini_get('date.timezone') )
			{
			  date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			//$query = "INSERT into `repairs` (flat,estate, status, created_at, equipment, description,preferred_date) VALUES ('".$_SESSION['email']."', '".$_SESSION['estate']."', 'pending','$trn_date', '$equipment', '$description','$date')";
			$query = "INSERT into `orders` (flat,estate,order_name,order_status, created_at, description,preferred_date, order_type) VALUES ('".$_SESSION['email']."', '".$_SESSION['estate']."','$equipment', 'pending','$trn_date', '$description','$date','repairs')";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Repair request sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='repairs.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Request not successful.');</script>";
			  echo "<script type='text/javascript'>window.top.location='repairs.php';</script>"; exit;
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
                                      <h4 class="mt-0 header-title">All Repairs</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM orders where flat='".$_SESSION['email']."' and order_type = 'repairs'";
													//$sql = "SELECT * FROM repairs where flat='".$_SESSION['email']."'";
													if($_SESSION['admin_type']=='admin'){$sql = "SELECT * FROM orders where order_type = 'repairs'";}
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Equipment</th>
                                                            <th>Description</th>
                                                            <th>Status</th>                                                            
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['order_name']; ?></td>
															<td><?php echo $row['description']; ?></td>
															<td><?php echo $row['order_status']; ?></td>
															</tr>
														<?php
														}
													} else {
														echo "No ordered repair.";
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
                                      <h4 class="mt-0 header-title">Book Repair</h4>
                                        <p class="text-muted m-b-30 font-14">Book for repair and/or maintenance.</p>
                                          <form class="" action="" method="POST">
                                            <!--<div class="form-group">
											  <select class="form-control" name="name" >
											   <option value="">Select Equipment</option>
											   <option value="Generators">Generators</option>
											   <option value="Air Conditioner">Air Conditioner</option>
											   <option value="Inverter">Inverter</option>
											   <option value="Mobile Phone">Mobile Phone</option>
											   <option value="Computer & Laptop">Computer & Laptop</option>
											   <option value="CCTV">CCTV</option>
											   <option value="Gas Appliances">Gas Appliances</option>
											   <option value="Plumbing">Plumbing</option>
											   <option value="Refrigeration Repairs">Refrigeration Repairs</option>
											  </select>
											</div>-->
											<div class="form-group">
											  <select class="form-control" required name="equipment" >
											    <option value="">Select Equipment</option>
											    <?php include ('../db.php');
												$sql="select name,location from equipments where flat='".$_SESSION['email']."'"; 
											    $result = $con->query($sql);; 
											    while($row = $result->fetch_assoc()) { 
											    ?>
											    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']."-".$row['location']; ?></option><?php } ?>
											  </select>
											</div>
											<!--<div class="form-group">
                                                <select class="form-control" name="service_type" >
											      <option value="">Select Services</option>
											      <option value="Repair">Repair</option>
											      <option value="Maintenance">Maintenance</option>
											    </select>
                                            </div>-->
											<div class="form-group">
                                              <div>
                                                <input name="description" type="textarea" class="form-control" placeholder="Description e.g Generator does not start."/>
                                                </div>
                                            </div>
											<div class="form-group">
                                              <input type="date" name="date" class="form-control" required placeholder="Choose Date"><!--<input type="datetime-local">-->
                                            </div>
                                            <div class="form-group">
                                               <div>
                                                  <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                            Submit</button>
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