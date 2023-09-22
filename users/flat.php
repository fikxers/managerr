		<?php
          include('auth.php'); 
          $title='Dashboard';
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
		?>
						<div class="row">
						 <div class="col-lg-12">
						  <div class="card m-b-30">
                            <div class="card-body">
							  <h4 class="mt-0 header-title">Notice Board </h4>
								<div class="table-rep-plugin">
								  <div class="table-responsive b-0" data-pattern="priority-columns">
								  <?php
								   $sql = "SELECT * FROM broadcast where estate='".$_SESSION['estate']."' limit 3";
								   $result = $con->query($sql);
								   if ($result->num_rows > 0) { 
									while($row = $result->fetch_assoc()) { ?>
									  <div class="alert alert-info alert-dismissible fade show" role="alert">
										<?php echo '<b>'.$row['subject'].'</b> | '.$row['send_date'].'<br>'; 
										 echo $row['message']; ?>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
										</button>
									  </div>
								  <?php }
								  }else { echo "<div class='alert alert-primary' role='alert'> Notice board is empty!</div>"; } $con->close();  ?>
								  </div>
								  <span><a data-toggle="modal" class="text-primary" data-target="#noticemodal" data-original-title="More Notices">More &#8595;</a></span>
									<!-- Modal -->
									<div class="modal fade" id="noticemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									  <div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<h6 class="modal-title" id="exampleModalLongTitle">Notice Board</h6>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										  </div>
										  <div class="modal-body">
											<?php require('../db.php');
										   $sql = "SELECT * FROM broadcast where estate='".$_SESSION['estate']."'";
										   $result = $con->query($sql);
										   if ($result->num_rows > 0) { 
											while($row = $result->fetch_assoc()) { ?>
											  <div class="alert alert-info alert-dismissible fade show" role="alert">
												<?php echo '<b>'.$row['subject'].'</b> | '.$row['send_date'].'<br>'; 
												 echo $row['message']; ?>
												<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
												</button>
											  </div>
										  <?php }
										  }else { echo "<div class='alert alert-primary' role='alert'> Notice board is empty!</div>"; } $con->close();  ?>
										  </div>
										</div>
									   </div>
									</div>
								</div>
								<!-- /Modal -->
                            </div>
						   </div>
						 </div>
						</div>
						<!--</div>-->
        <div class="row">
		  		<div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <h4 class="mt-0 header-title">Recent Payments</h4>
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
								  <?php include ('../db.php');
									$sql = "SELECT * FROM payments where estate='".$_SESSION['estate']."' and flat='".$_SESSION['flat_no']."' and block='".$_SESSION['block_no']."' ORDER BY pay_date DESC"; $result = $con->query($sql); 
									if ($result !== false && $result->num_rows > 0) { ?>
										<table id="tech-companies-1" class="table  table-striped table-sm">
                      <thead><tr class="titles"><th>Payment Amount</th><!--<th>Payment Mode</th>--> <th>Date Paid</th><th>Description</th> </tr></thead>
										  <tbody> <?php while($row = $result->fetch_assoc()) { ?>
											<tr><td><?php echo "&#8358;".$row['amount']; ?></td><td><?php echo $row['pay_date']; //$row['last_payment_date'] ?></td><td><?php echo $row['description']; ?></td></tr>
									    <?php } } else {echo "No Payment Detected.";} $con->close(); ?>
                      </tbody>
                    </table>
                  </div>
								</div>
              </div>
            </div>
          </div> 
		  		<!--<div class="col-xl-12">
           <div class="card card-sec m-b-30">
            <div class="card-body">
            <h4 class="mt-0 header-title">Service Quotes (Bids)</h4>
              <div class="table--rep-plugin"> 
						  <?php include ('db.php');
							//$sql = "SELECT *,fixers.phone,fixers.name FROM quotess INNER JOIN flats on flats.email=quotes.flat   INNER JOIN fixers on fixers.email=quotes.fixer where quotes.flat='".$_SESSION['email']."'";
							$sql = "SELECT * FROM quotess join orders on orders.order_id=quotess.order_id where orders.flat='".$_SESSION['email']."' order by orders.order_id";
							//join orders on orders.order_id=quotess.order_id and orders.flat='".$_SESSION['email']."'";
							$stmt = $con->prepare($sql);$stmt->execute();$results = $stmt->fetchAll();
							if ($stmt->rowCount() > 0) { ?>
							<table class="table table-hover mb-0">
                <thead><tr class="titles"><th>Asset</th><th>Description</th>
								<th>Duration</th><th>Cost Estimate</th><th>Date Sent</th>
								<th>Status</th> <th colspan="2">Action</th></tr>
							  </thead><tbody>
								<?php foreach ($results as $result){  ?>
                  <form action="" method="POST">
										<tr><td><?php echo $result['order_name']; ?></td>
										 <td><?php echo $result['description']; ?></td>
										 <td><?php echo $result['duration']; ?></td>
										 <td><?php echo "&#8358;".$result['cost']; ?></td>
										 <td><?php echo $result['date_sent']; ?></td>
										 <td><?php echo $result['quote_status']; ?></td>
										 <input type="hidden" name="id" value="<?php echo $result['quote_id']; ?>">
										 <input type="hidden" name="order_id" value="<?php echo $result['order_id']; ?>">
									    <?php if($result['quote_status']==='pending'){
									    echo '<td><input name="accept" type="submit" value="Accept" class="btn  btn-sm btn-outline-success"></td><td><input name="reject" type="submit" value="Reject" class="btn btn-outline-danger btn-sm"></td>';}
										else if($result['quote_status']==='completed'){
										  echo '<td><input name="confirm" type="submit" value="Confirm" class="btn  btn-sm btn-outline-success"></td>';}
										 else{ echo '<td><input name="accept" type="submit" value="Accept" class="btn  btn-sm btn-outline-success" disabled></td><td><input name="reject" type="submit" value="Reject" class="btn btn-outline-danger btn-sm" disabled></td>'; } ?>
									  </form>
                    </tr>
								<?php } } else { echo "0 Quotes."; }?>    
								</tbody>
              </table>
              </div>			  
            </div>
          </div>
		  	</div>-->
		  <!--<div class="col-lg-12">
           <div class="card m-b-30">
            <div class="card-body">
               <?php include("tmpl/work_request_list.php"); ?>    
            </div>
           </div>
          </div>
		  <div class="col-lg-12">
            <div class="card m-b-30">
             <div class="card-body">
             <h4 class="mt-0 header-title">Errand Services</h4>
               <div class="table-rep-plugin">
                 <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
		          //$sql = "SELECT * FROM home_service where flat='".$_SESSION['email']."'";
				  $sql = "SELECT * FROM orders where flat='".$_SESSION['email']."' and order_type = 'home_service'";$result = $con->query($sql);
				  if ($result->num_rows > 0) { ?>
				  <table id="tech-companies-1" class="table  table-striped">
                   <thead><tr class="titles"> <th>Name of Service</th><th>Description</th> <th>Status</th> </tr></thead><tbody> <?php while($row = $result->fetch_assoc()) { ?>
					<tr><td><?php echo $row['order_name']; ?></td>
						<td><?php echo $row['description']; ?></td>
						<td><?php echo $row['order_status']; ?></td>
					</tr>
					<?php } } else { echo "No home service yet."; } $con->close();?>
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
             </div>
            </div>--><!-- end row -->
           </div> <!-- container -->
          </div><!-- Page content Wrapper -->
         </div><!-- content -->
		 
		<?php include('footer.php'); } ?>
</html>