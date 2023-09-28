<?php require('auth.php'); $title ='Dashboard'; ?>

    <?php include('mgr_sidebar.php'); ?>
    <?php
		  if (isset($_POST['submit'])){
			//echo "Working...";
			//$flat = stripslashes($_REQUEST['flat']);
			$description = stripslashes($_REQUEST['description']);
			//$status = "pending";		
			$skill = stripslashes($_REQUEST['skill']);			
			//$pdate = stripslashes($_REQUEST['pdate']);
			//$service_type = stripslashes($_REQUEST['service_type']);
			$service_id = stripslashes($_REQUEST['service_id']);
			//b4 insert, check if exists
			//SERVICE TYPE COLUMN - 1: Repairs | 2: Home Service
			//$query = "INSERT INTO `request4quotes` (description,flat, estate,skill_required, status,date_sent,preferred_date,service_type,service_id) VALUES ('$description','$flat','".$_SESSION['estate']."','$skill', 'pending','$trn_date','$pdate','$service_type',$service_id)";
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
					<h4 class="mt-0 header-title">Recent Payments</h4>
					<div class="table-rep-plugin">
					  <div class="table-responsive b-0" data-pattern="priority-columns">
					  <?php include ('../db.php');
						//$sql = "SELECT * FROM payments where estate='".$_SESSION['estate']."' ORDER BY pay_date DESC"; 
						$sql = "SELECT * FROM `payments` join flats on payments.estate=flats.estate_code where payments.estate='".$_SESSION['estate']."'AND payments.flat = flats.flat_no AND payments.block = flats.block_no";
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
					</div>
				  </div>
				</div>
			  </div> 
						<!--<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Available Fikxers</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0 datatable " data-pattern="priority-columns">
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM fixers where status = 'available' AND estate='". $_SESSION['estate']."'";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="example" class="table table-bordered table-striped m-b-0">
                                                      <thead>
                                                        <tr class="titles">
                                                            <th>Name</th>
															<th>Email</th>
															<th>Phone</th>
                                                            <th>Skill</th> 
                                                            <th>Status</th>       
															<?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?>
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['name']; ?></td>
															<td><?php echo $row['email']; ?></td>
															<td><?php echo $row['phone']; ?></td>
															<td><?php echo $row['skill']; ?></td>	
															<td><?php echo $row['status']; ?></td>
															<?php if($_SESSION['admin_type']=='admin'){echo '<td>'.$row['estate'].'</td>';} ?>
															</tr>
														<?php
														}
													} else {
														echo "No available Fikxer.";
													}
													$con->close();
													?>                      
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
                                      <h4 class="mt-0 header-title">Work Requests</h4>
                                            <div class="table-rep-plugin">
                                                <div class="table-responsive b-0" data-pattern="priority-columns">
												
                                                    <table id="tech-companies-1" class="table  table-striped">
                                                      
												   <?php
												    include ('db.php');
													// mysql select query
													//$sql = "SELECT *,flats.flat_no,flats.block_no FROM home_service join flats on flats.email=home_service.flat where home_service.status != 'completed'";
													$sql = "SELECT *,flats.flat_no,flats.block_no FROM orders join flats on orders.flat=flats.email where order_status = 'pending'";
													$stmt = $con->prepare($sql);
													$stmt->execute();
													$results = $stmt->fetchAll();
													if ($stmt->rowCount() > 0) {
													echo "<thead>
                                                        <tr class='titles''>
                                                            <th>Order #</th><th>Flat #</th> <th>Block #</th>
                                                            <th>Asset/Service</th> <th>Info</th>
															<th>Pictures</th><th>Start Date</th>
                                                            <th>Description</th>
                                                            <th>Skill Required</th><th>Action</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>";
													foreach ($results as $result)
													{  
													    //echo $result['id'];
														//echo $result['flat_no'].' - '.$result['block_no'].' - '.$result['name'].' - '.$result['preferred_date'].'<br>'; ?>
													  
													  <tr>
														<td><?php echo $result['order_no']; ?></td>
														<td><?php echo $result['flat_no']; ?></td>
														<td><?php echo $result['block_no']; ?></td>
														<td><?php echo $result['order_name']; ?></td>
														<td><?php echo $result['description']; ?></td>
														<td><?php 
														  if($result['order_no'] != "" || $result['order_no'] != NULL){
														  $targetDir = "img/".$result['order_no']."/";
														  $images = glob($targetDir."*.{jpg,jpeg,svg,gif,png}",GLOB_BRACE);
														  foreach($images as $image) {
														   echo '<a href="'.$image.'" target=blank>'.$image.'</a><br />';
														  }
														  }
														?></td>
														<td><?php echo $result['preferred_date']; ?></td>
														<!--<input type="hidden" name="flat" value="<?php echo $result['email']; ?>">
														<input type="hidden" name="pdate" value="<?php echo $result['preferred_date']; ?>">
														<input type="hidden" name="service_type" value="2">	--
														<form class="" action="request_quote.php" method="POST" enctype="multipart/form-data">
														<input type="hidden" name="service_id" value="<?php echo $result['order_id']; ?>"><input type="hidden" name="order_no" value="<?php echo $result['order_no']; ?>">
														<td><textarea name="description" placeholder="Please describe in detail" required rows="3" cols="30"></textarea>
														<input type="file" class="form-control" name="files[]" multiple ></td>
														<td>
															  <select class="form-control" required name="skill" >
																<option value="Generator Repairs">Generator Repairs</option> <option value="Air Conditioner">Air Conditioner</option>
																<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
																<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option>
																<option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
															  </select>
															</td>
														<td><button name="submit" type="submit" class="btn btn-primary btn-sm">Request Quotes</button></td>
														</form>
													  </tr>
													  
														<?php 
														}
													} else {
														echo "0 Work Requests.";
													}
													//$con->close(); 
													?>                                                       
                                                        </tbody>
                                                    </table>
												
                                                </div>

                                            </div>
                                          
                                        </div>
                                    </div>
                        </div>-->
                    </div><!-- end row -->

                    </div>
                    <!-- container -->

                </div>
                <!-- Page content Wrapper -->

            </div>
            <!-- content -->
			
		  <?php include('footer.php'); } ?>

</html>