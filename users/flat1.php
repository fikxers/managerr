		<?php
          include('auth.php'); $title='Dashboard';
          include('flat_sidebar.php');
		  require('../db.php');		  
		  if (isset($_POST['accept'])){	
		    //$('input[type="submit"]').attr('disabled', true);
		    $id = $_REQUEST['id'];
			$order_id = $_REQUEST['order_id'];
			$query = "UPDATE `quotess` SET quote_status = 'accepted' where quote_id = $id and order_id=$order_id";
			$query2 = "UPDATE `quotess` SET quote_status = 'rejected' where quote_id != $id and order_id=$order_id";
			$query3 = "UPDATE `orders` SET order_status = 'quote_accepted' where order_id=$order_id";
			$result3 = mysqli_query($con,$query3); $result2 = mysqli_query($con,$query2); $result = mysqli_query($con,$query); 
			if($result){
			  echo "<script>alert('Quote Accepted.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Quote could not be accepted.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
		  }
		  else if (isset($_POST['reject'])){
            $id = $_REQUEST['id'];	$order_id = $_REQUEST['order_id'];	  
			//$query = "UPDATE `quotes` SET status = 'rejected' where flat='".$_SESSION['email']."' and id=$id";
			$query = "UPDATE `quotess` SET quote_status = 'rejected' where quote_id = $id and order_id=$order_id";
			$query2 = "UPDATE `orders` SET order_status = 'quote_rejected' where order_id=$order_id";
			$result = mysqli_query($con,$query); $result2 = mysqli_query($con,$query2);
			if($result){
			  echo "<script>alert('Quote Rejected.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
			else{
			  $error=mysqli_error($con);
			  echo '<script type="text/javascript">alert("'.$error.'");</script>';
			  //echo "<script>alert('Quote could not be rejected.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
		  }
		  else if (isset($_POST['confirm'])){
			//echo "<script>alert('Confirmation.');</script>";
            $id = $_REQUEST['id'];	$order_id = $_REQUEST['order_id'];	  
			//$query = "UPDATE `quotes` SET status = 'rejected' where flat='".$_SESSION['email']."' and id=$id";
			$query = "UPDATE `quotess` SET quote_status = 'confirmed' where quote_id = $id and order_id=$order_id";
			$query2 = "UPDATE `orders` SET order_status = 'confirmed' where order_id=$order_id";
			$result = mysqli_query($con,$query); $result2 = mysqli_query($con,$query2);
			if($result){
			  echo "<script>alert('Confirmation Complete.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
			else{
			  //$error=mysqli_error($con);
			  //echo '<script type="text/javascript">alert("'.$error.'");</script>';
			  echo "<script>alert('Error in Confirmation.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
		  }
		  else{
			//echo "<script>alert('Error');</script>";
		?>
                    <div class="row">
					    <div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Dues Info</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM dues where flat='".$_SESSION['email']."'";
													$sql2 = "SELECT sum(totalAmountOwed) AS cnt FROM dues where estate='".$_SESSION['estate']."'";
													$result = $con->query($sql); $result2 = $con->query($sql2);
													$values = mysqli_fetch_assoc($result2); 
								                    $total = $values['cnt']; 
													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
														    <th>Due paid last month</th><th># of months owed</th> <th>My Debt this year</th><th>My Total Debts</th> <th>Status</th><th>All Flats debts</th><th>Last payment date</th><th>Next due date</th><th>Deadline</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['lstMntlyDuePaid']; ?></td>
															<td><?php echo $row['noMntsOwed']; ?></td>
															<td><?php echo $row['amntOwedThisYr']; ?></td>
															<td><?php echo $row['totalAmountOwed']; ?></td>
															<td>
															  <?php if($row['due_status']=='Good'){echo '<span class="badge badge-success">Good</span>';} 
															      else {echo '<span class="badge badge-danger">Bad</span>';} ?>
															</td>
															<td><?php echo $total; ?></td>
															<td><?php echo date('d/m/Y', strtotime('-7 day')); ?>
															<td><?php echo date('d/m/Y', strtotime('+7 day')); ?>
															<td>10</td>
															</td>
															</tr>
														<?php
														}
													} else {
														echo "Please contact Estate Manager.";
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
						<div class="col-xl-12">
                                <div class="card card-sec m-b-30">
                                    <div class="card-body">
                                        <h4 class="mt-0 m-b-15 header-title">Quotes</h4>
                                        <div class="table-responsive">
											
										    <?php
											include ('db.php');
											//$sql = "SELECT *,fixers.phone,fixers.name FROM quotess INNER JOIN flats on flats.email=quotes.flat   INNER JOIN fixers on fixers.email=quotes.fixer where quotes.flat='".$_SESSION['email']."'";
													
											$sql = "SELECT * FROM quotess join orders on orders.order_id=quotess.order_id where orders.flat='".$_SESSION['email']."'";
											//join orders on orders.order_id=quotess.order_id and orders.flat='".$_SESSION['email']."'";
											$stmt = $con->prepare($sql);
											$stmt->execute();
											$results = $stmt->fetchAll();
											if ($stmt->rowCount() > 0) { ?>
											<table class="table table-hover mb-0">
                                                <thead>
                                                    <tr class="titles">
                                                        <th>Description</th>
														<th>Duration</th>
                                                        <th>Cost Estimate</th>
                                                        <th>Date Sent</th>
														<!--<th>Fixer name</th><th>Fixer Phone</th><th>Fixer Email</th>-->
														<th>Status</th> <th></th> <th> </th>
                                                    </tr>

                                                </thead>
                                                <tbody>
											<?php
											foreach ($results as $result)
											{  ?>
                                                <form action="" method="POST">
												<tr>
												<td><?php echo $result['description']; ?></td>
												<td><?php echo $result['duration']; ?></td>
												<td><?php echo $result['cost']; ?></td>
												<td><?php echo $result['date_sent']; ?></td>
												<!--<td><?php /*echo $result['name']; ?></td>
												<td><?php echo $result['phone']; ?></td>
												<td><?php echo $result['fixer'];*/ ?></td>-->
												<td><?php echo $result['quote_status']; ?></td>
												<input type="hidden" name="id" value="<?php echo $result['quote_id']; ?>">
												<input type="hidden" name="order_id" value="<?php echo $result['order_id']; ?>">
												<?php 
												  if($result['quote_status']==='pending'){
													 echo '<td><input name="accept" type="submit" value="Accept" class="btn  btn-sm btn-outline-success"></td>
													<td><input name="reject" type="submit" value="Reject" class="btn btn-outline-danger btn-sm"></td>';
												  }
												  else if($result['quote_status']==='completed'){
													 echo '<td><input name="confirm" type="submit" value="Confirm" class="btn  btn-sm btn-outline-success"></td>';
												  }
												  else{
													 echo '<td><input name="accept" type="submit" value="Accept" class="btn  btn-sm btn-outline-success" disabled></td>
													<td><input name="reject" type="submit" value="Reject" class="btn btn-outline-danger btn-sm" disabled></td>';
												  }
												?>
												<!--<td><input name="accept" type="submit" value="Accept" class="btn  btn-sm btn-outline-success"></td>
												<td><input name="reject" type="submit" value="Reject" class="btn btn-outline-danger btn-sm"></td>-->
												</form>
                                                </tr>
											<?php   
											}
											} else {
												echo "0 Quotes.";
											}?>    
												</tbody>
                                            </table>
                                        </div>
									  
                                    </div>
                                </div>

                        </div>
						  <div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">All Repairs</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													//$sql = "SELECT * FROM repairs where flat='".$_SESSION['email']."'";
													$sql = "SELECT * FROM orders where flat='".$_SESSION['email']."' and order_type = 'repairs'";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr class="titles">
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
                        </div>
						<!--<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Maintenance</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php /*
													include ('../db.php'); 
													$sql = "SELECT * FROM maintenance where flat='".$_SESSION['email']."'";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr class="titles">
                                                            <th>Name of Service</th>
															<th>Description</th>
															<th>Preferred Date</th>
                                                            <th>Status</th>                                                                                                                       
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['name']; ?></td>
															<td><?php echo $row['description']; ?></td>
															<td><?php echo $row['preferred_date']; ?></td>
															<td><?php echo $row['status']; ?></td>
															</tr>
														<?php
														}
													} else {
														echo "No maintenance registered.";
													}
													$con->close(); */
													?>                                                       
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                        </div>-->
						<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Home Services</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													//$sql = "SELECT * FROM home_service where flat='".$_SESSION['email']."'";
													$sql = "SELECT * FROM orders where flat='".$_SESSION['email']."' and order_type = 'home_service'";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr class="titles">
                                                            <th>Name of Service</th>
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
														echo "No home service yet.";
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
                        <!-- end row -->

                    </div>
                    <!-- container -->

                </div>
                <!-- Page content Wrapper -->

            </div>
            <!-- content -->
		  <?php include('footer.php'); } ?>

</html>