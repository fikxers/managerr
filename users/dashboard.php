		<?php
      include('auth.php'); 
      $title='HAIVEN Dashboard';
      include('dashboard-sidebar.php');
		  require('../db.php');	
		?>
						<div class="row">
						 <div class="col-lg-12">
						  <div class="card m-b-30">
                <div class="card-body">
								  <h4 class="mt-0 header-title">Your HAIVEN Accounts</h4>
								  
								  <div class="row">
								  	<?php
								  	//FM
									  $sql = "SELECT estate_name,address,estate_code FROM estates join estate_manager on (estates.estate_code = estate_manager.estate) where estate_manager.email='".$_SESSION['email']."'";
									  $result = $con->query($sql);
									  if ($result->num_rows > 0) { 
									  $_SESSION['admin_type'] = 'mgr';
										while($row = $result->fetch_assoc()) { ?>
									  <div class="col-sm-4 mb-3 mb-sm-0">
									  	<a href="./estate_mgr.php">
									    <div class="alert alert-primary" role="alert">
												<h6 class="alert-heading text-muted"><?php echo $row['estate_name']; ?></h6>
												<p class="text-muted"><b>Estate Address:</b> <?php echo $row['address']; ?></p>
												<p class="text-muted"><b>Account Type:</b> Facility Manager</p>
												</a>
											</div>
									  </div>
										<?php } } 
										//Resident
									  $sql = "SELECT estate_name,address FROM estates join flats using(estate_code) where flats.email='".$_SESSION['email']."'";
									  $result = $con->query($sql);
									  if ($result->num_rows > 0) { 
									  $_SESSION['admin_type'] = 'flat';
										while($row = $result->fetch_assoc()) { ?>
									  <div class="col-sm-4 mb-3 mb-sm-0">
									  	<a href="./flat.php">
									    <div class="alert alert-info" role="alert">
												<h6 class="alert-heading text-muted"><?php echo $row['estate_name']; ?></h6>
												<p class="text-muted">Estate Address: <?php echo $row['address']; ?></p>
												<p class="text-muted"><b>Account Type:</b> Resident</p>
											</div>
											</a>
									  </div>
									  <?php } } ?>
									</div>
						    </div>
						 </div>
						</div>
          </div>
          <!-- Page content Wrapper -->
         </div><!-- content -->
		<?php include('footer.php'); ?>
</html>