		<?php
          include('auth.php'); $title='Dashboard';
          include('flat_sidebar.php');
		  require('../db.php');	require('functions.php');
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
													$sql = "SELECT * FROM dues join flats on dues.flat=flats.email where flats.estate_code='".$_SESSION['estate']."' and dues.flat='".$_SESSION['email']."'";
													$result = $con->query($sql); 
													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr class="titles">
														    <th>Last Payment</th><th>Payment Mode</th> <th>Date Paid</th><th>Note</th><th>Status</th><th>Expiry</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo "&#8358;".$row['amount']; ?></td>
															<td><?php echo $row['last_payment_type']; ?></td>
															<td><?php echo $row['last_payment_date']; ?></td>
															<td><?php echo $row['note']; ?></td>
															<td>
															  <?php $stat = $row['status']; if($stat=='good'){echo '<span class="badge badge-success">'.$stat.'</span>';} 
															      else {echo '<span class="badge badge-danger">'.$stat.'</span>';} ?>
															</td>
															<td><?php echo deadline(5)." days"; ?></td>
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
														<th>Status</th> <th colspan="2">Action</th>
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
												<td><?php echo "&#8358;".$result['cost']; ?></td>
												<td><?php echo $result['date_sent']; ?></td>
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