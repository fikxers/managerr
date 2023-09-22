	<?php include('fixer_sidebar.php');?>
    <?php
		  require('../db.php');
		  if (isset($_POST['sendQuote'])){
			//$flat = stripslashes($_REQUEST['flat']);
			//$duration = stripslashes($_REQUEST['duration']); $cost = stripslashes($_REQUEST['cost']);
			$duration = $_REQUEST['duration']; $cost = $_REQUEST['cost'];
			//$description = stripslashes($_REQUEST['description']);
			$order_id = $_REQUEST['order_id'];
			$status = "pending";		  
			//b4 insert, check if exists
			if( ! ini_get('date.timezone') )
			{
			  date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			//$query = "INSERT into `quotes` (flat,estate,description,duration,cost,fixer,date_sent,status,request_id) VALUES ('$flat','".$_SESSION['estate']."','$description', $duration,$cost,'".$_SESSION['email']."','$trn_date','$status',$request_id)";
			$query = "INSERT into `quotess` (order_id,duration,cost,fixer,quote_status,date_sent) VALUES ($order_id,$duration,$cost,'".$_SESSION['email']."','$status','$trn_date')";
			$result = mysqli_query($con,$query);// or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error(), E_USER_ERROR);
			/*if (!mysqli_query($con,$query))
			{
			  echo("Error description: " . mysqli_error($con));
			}*/
			if($result){
			  echo "<script>alert('Quote sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='fixer.php';</script>"; exit;
			}
			else{
			  $error=mysqli_error($con);
			  //echo '<script type="text/javascript">alert("'.$order_id.'");</script>';
			  //echo '<script type="text/javascript">alert("'.$error.'");</script>';
			  echo "<script>alert('Quote not sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='fixer.php';</script>"; exit;
			}
		  }
		  else if (isset($_POST['complete_job'])){
			$quote_id = $_REQUEST['quote_id'];
			$order_id = $_REQUEST['order_id'];
			$email = $_SESSION['email'];
			$query = "UPDATE `quotess` SET quote_status = 'completed' where quote_id = $quote_id";
			$query2 = "UPDATE `orders` SET fixer = '".$email."' where order_id = $order_id";
			//$query = "update quotes set status = 'completed' where id = $quote_id";
			$result = mysqli_query($con,$query); $result2 = mysqli_query($con,$query2);
			if($result2){
			  echo "<script>alert('Job Completed.');</script>";
			  echo "<script type='text/javascript'>window.top.location='fixer.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Error Completing Job.');</script>";
			  echo "<script type='text/javascript'>window.top.location='fixer.php';</script>"; exit;
			}
		  }
		  else{
			  //echo "INSERT into `quotess` (order_id,duration,cost,fixer,quote_status,date_sent) VALUES ($order_id,$duration,$cost,'".$_SESSION['email']."','$status','$trn_date')";
			//echo "<script>alert('Error');</script>";
		?>
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card card-sec m-b-30">
                                    <div class="card-body">
									  
                                        <h4 class="mt-0 m-b-15 header-title">Quote Requests</h4>
                                        <div class="table-rep-plugin table-responsive">
										    <?php
											include ('db.php');
											/*$typeArray = array(); //$number_list =  array('16.10', '22.0', '33.45', '45.45');
											$query = "select * from quotess ";
											$result = mysql_query($query);
											if ($result) {
											  while( $row = mysql_fetch_assoc( $result)){
													$typeArray[] = $row['order_id']; // Inside while loop
												}
											} Print_r($typeArray);*/
											$query = "select * from quotess ";
											$stmt = $con->prepare($query);
											$stmt->execute();
											$results = $stmt->fetchAll();
											if ($stmt->rowCount() > 0) {
											  foreach ($results as $result){ 
											    $typeArray[] = $result['order_id'];
											  }
											}//Print_r($typeArray);
											//$sql = "SELECT *,flats.flat_no,flats.block_no FROM request4quotes join flats on flats.email=request4quotes.flat where required_skill='".$_SESSION['skill']."' OR required_skill='".$_SESSION['skill2']."' OR required_skill='".$_SESSION['skill3']."'";
											$sql = "SELECT *,flats.flat_no,flats.block_no FROM orders join flats on flats.email=orders.flat where required_skill='".$_SESSION['skill']."' OR required_skill='".$_SESSION['skill2']."' OR required_skill='".$_SESSION['skill3']."' and order_status='quote_requested'";
											$stmt = $con->prepare($sql);
											$stmt->execute();
											$results = $stmt->fetchAll();
											if ($stmt->rowCount() > 0) { ?>
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr class="titles">
													    <th>Flat No</th>
                                                        <th>Block No</th>
                                                        <th>Description(Flat)</th>
                                                        <th>Description(Mgr)</th>
                                                        <th>Date Received</th>
														<th>Cost Estimate (<?php echo "&#8358;" ?>)</th>
														<th>Duration(Days)</th>
														<th>Action</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
												<?php   foreach ($results as $result){  
												          if (!in_array($result['order_id'], $typeArray))
															{ 
												 ?>
												  <form action="" method="POST">
                                                    <tr>
													  <td><?php echo $result['flat_no']; ?></td>
													  <td><?php echo $result['block_no']; ?></td>
													  <td><?php echo $result['description']; ?></td>
													  <td><?php echo $result['mgr_description']; ?></td>
													  <!--<input type="hidden" name="description" value="<?php /*echo $desc; ?>">
													  <input type="hidden" id="flat" name="flat" value="<?php echo $result['flat']; */?>">-->
													  <input type="hidden" name="order_id" value="<?php echo $result['order_id']; ?>">
													  <td><?php echo $result['created_at']; ?></td>
													  <td><input type="number" name="cost" class="form-control" placeholder="1000" min="1000" step="100" data-number-to-fixed="2" data-number-stepfactor="100" required></td>
													  <td><input type="number" min="1" max="14" placeholder="1" name="duration" class="form-control" required></td>
													  <td><input name="sendQuote" type="submit" value="Send Quote" class="btn btn-outline-info"></td>
                                                    </tr>
												   </form>
													<?php
														}
											          }
													} else {
														echo "No Requested Quote.";
													}
													//$con->close();
													?>    
                                                </tbody>
                                            </table>
                                        </div>
									  
                                    </div>
                                </div>
                            </div>
							<!--<div class="row" style="height:100px;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">
							  <div class="col-xl-12">
								<p style="height:200px;">
								  Scroll box automatic set in scroll in vertical scrollbar....<br /><br />
								  Scroll box automatic set in scroll in vertical scrollbar....<br /><br />
								  Scroll box automatic set in scroll in vertical scrollbar....<br /><br />
								  Scroll box automatic set in scroll in vertical scrollbar....
								</p>
							  </div>
							</div>-->
							<div class="col-xl-12">
                                <div class="card card-sec m-b-30">
                                    <div class="card-body">
                                        <h4 class="mt-0 m-b-15 header-title">My Quotes</h4>
										
                                        <div class="table-responsive"  style="height:350px;overflow:scroll;overflow:auto;">
										    <?php  //echo $_SESSION['email'];
											//include ('db.php'); 
											include ('../db.php');
											//$sql = "SELECT * FROM quotess where fixer='".$_SESSION['email']."'";
											//$sql = "SELECT * FROM quotess join orders join flats on quotess.flat=flats.email on quotess.order_id=orders.order_id where  quotess.fixer='".$_SESSION['email']."'";
											$sql = "SELECT * FROM quotess join orders on quotess.order_id=orders.order_id where quotess.fixer='".$_SESSION['email']."'";
											$result = $con->query($sql);
											if ($result->num_rows > 0) { 
											/*$stmt = $con->prepare($sql);
											$stmt->execute();
											$results = $stmt->fetchAll();
											if ($stmt->rowCount() > 0) { */ ?>
											
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr class="titles">
                                                        <!--<th>Flat No</th>
                                                        <th>Block No</th>-->
                                                        <th>Manager Description</th>
														<th>Duration</th>
                                                        <th>Cost Estimate</th>
                                                        <th>Date Sent</th>
														<th>Status</th><th>Action</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
												<?php  //foreach ($results as $row){ 
   												while($row = $result->fetch_assoc()) { ?>
												     <form method="POST" action="">
                                                      <!--<td><?php //echo $row['flat_no']; ?></td>
													  <td><?php //echo $row['block_no']; ?></td>-->
													  <td><?php echo $row['mgr_description']; ?></td>
													  <td><?php echo $row['duration']; ?></td>
													  <td><?php echo $row['cost']; ?></td>
													  <td><?php echo $row['date_sent']; ?></td>
													  <td><?php echo $row['quote_status']; ?></td>
													  <input type="hidden" name="quote_id" value="<?php echo $row['quote_id']; ?>">
													  <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
													  <?php if($row['quote_status'] === 'accepted') {
													  echo '<td><input name="complete_job" type="submit" value="Complete Job" class="btn btn-sm btn-outline-success"></td>';}
													  else{
													  echo '<td><input name="complete_job" type="submit" value="Complete Job" class="btn btn-sm btn-outline-success" disabled></td>';}
													  ?>
													  <!--<td><input name="complete_job" type="submit" value="Complete Job" class="btn btn-sm btn-outline-success"></td>-->
													 </form>
                                                    </tr>
													<?php
														}
													} else {
														echo "0 Quotes.";
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