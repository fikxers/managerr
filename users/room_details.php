		<?php
          include('auth.php'); $title='Room Details';
          include('room_sidebar.php');
		  require('../db.php');		  
		  if (isset($_POST['update'])){	
		    $old_password = $_REQUEST['old_password'];
		    $new_password = $_REQUEST['new_password'];
			$confirm_password = $_REQUEST['confirm_password'];
			$query = "UPDATE `quotess` SET quote_status = 'accepted' where quote_id = $id and order_id=$order_id";
			if($result){
			  echo "<script>alert('Password changed successfully.');</script>";
			  echo "<script type='text/javascript'>window.top.location='room_details.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Password could not be changed.');</script>";
			  echo "<script type='text/javascript'>window.top.location='room_details.php';</script>"; exit;
			}
		  }
		  else{
			//echo "<script>alert('Error');</script>";
		?>
        <div class="row">
		    <div class="col-lg-12">
              <div class="card m-b-30">
                <div class="card-body">
                  <!--<h4 class="mt-0 header-title">All Repairs</h4>-->
                  <div class="table-rep-plugin">
                    <div class="table-responsive b-0">
						<table id="tech-companies-1" class="table table-bordered">
                          <thead>
                          	<tr class="titles">
                          		<th colspan="6">Room Info</th>      
                          	</tr>
                          </thead>
                          <?php $roomNo = $_SESSION['room']; 
                          	$query = "SELECT * FROM `residents` WHERE room_no =$roomNo";
                          	$result = $con->query($query);
					  		if ($result->num_rows > 0) { 
					  		  while($row = $result->fetch_assoc()) { ?>
                          <tbody> 
							<tr><td>Room No:</td><td><?php echo $row['room_no']; ?></td>
								<td>Fees: </td><td>&#8358;<?php echo number_format($row['fee'], 2); ?></td>
								<td>Entry Date:</td><td><?php echo $row['date_joined']; ?></td>
							</tr>
						  </tbody>
						  <thead>
                          	<tr class="titles">
                          		<th colspan="6">Personal Info</th>      
                          	</tr>
                          </thead>
					  		<tbody> 
							<tr><td>Name:</td><td><?php echo $row['full_name']; ?></td>
								<td>Gender:</td><td><?php echo $row['gender']; ?></td>
								<td>Phone: </td><td><?php echo $row['phone']; ?></td>
							</tr><tr>
								<td>Email:</td><td colspan="2"><?php echo $row['email']; ?></td>
								<td>Home Address: </td><td colspan="2"><?php echo $row['address']; ?></td>
							</tr>
							<?php }
							} ?>
						  </tbody>
                          
                        </table>
                    </div>
				  </div><hr>
				  <form class="" action="" method="POST">
                    <div class="form-group">
                      <label>Old Password: </label>
                      <input data-parsley-type="number" type="password" name="old_password" class="form-control" required/>
                    </div>
					<div class="form-group">
					  <label>New Password:</label>
                      <input data-parsley-type="number" type="password" name="new_password" class="form-control" required />
                    </div>
					<div class="form-group">
                      <div>
                      	<label>Confirm Password: </label>
                        <input name="confirm_password" type="password" class="form-control" required/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div>
                        <button name="update" type="submit" class="btn btn-info waves-effect waves-light">Update Password</button>
                        <button type="reset" class="btn btn-success waves-effect m-l-5">Cancel</button>
                      </div>
                    </div>
                  </form>
                </div>
               </div>
            </div>
		</div>
        <!-- container -->
 	</div>
 	<!-- Page content Wrapper -->
</div>
<!-- content -->
<?php include('footer.php'); } ?>
</html>