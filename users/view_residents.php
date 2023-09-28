<?php require('auth.php'); $title ='Residents'; //require('functions.php');
	require('../db.php'); include('admin_sidebar.php'); 

?>
	<div class="page-content-wrapper ">
	  <div class="container-fluid">
		<div class="row">       
		  <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
           	  <h4 class="mt-0 header-title">All Residents</h4>
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php'); 
                  $sql = "SELECT * FROM residents ORDER BY room_no, full_name";
				  if($_SESSION['admin_type']=='admin'){
					$sql = "SELECT * FROM residents ORDER BY room_no, full_name"; }
					$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
				  	<table id="tech-companies-1" class="table table-bordered table-striped">
                    <thead><tr class="titles"><th>Room</th><th>Full name</th><th>Email</th> <th>Phone</th>
                     <th>Gender</th><th>Address</th><th>DOB</th><th>Date Joined</th><th>Action</th></tr></thead>
                    <tbody> <?php while($row = $result->fetch_assoc()) { ?>
						<tr><td><?php echo $row['room_no']; ?></td>
							<td><?php echo $row['full_name']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><?php echo $row['phone']; ?></td><td><?php echo $row['gender']; ?></td>
							<td><?php echo $row['address']; ?></td><td><?php echo $row['dob']; ?></td>
							<td><?php echo $row['date_joined']; ?></td>
							<?php echo "<td><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#editmodal-".$row['id']."' data-original-title='Update Resident'><i class='fa fa-pencil' aria-hidden='true'></i></button> <button type='button' class='btn text-danger btn-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-".$row['id']."' data-original-title='Delete Resident'><i class='fa fa-trash' aria-hidden='true'></i></button></td>"; ?>
						</tr>
						<!-- Edit Modal -->
                    	<div class="modal fade" id="editmodal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    	  <div class="modal-dialog modal-dialog-centered" role="document">
                    		<div class="modal-content">
                    		  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Update Resident</h5>
                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    			  <span aria-hidden="true">&times;</span>
                    			</button>
                    		  </div>
                    		  <div class="modal-body">
								<form class="" action="" method="POST">
									<div class="form-group col-lg-12">
										<label>Update Resident Name</label>
										<input type="text" name="resident" class="form-control"  value="<?php echo $row['full_name']; ?>" />
										<input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
									</div>		
									<div class="form-group col-lg-12">
										<label>Update Resident's Phone No.</label>
										<input type="text" name="phone" class="form-control"  value="<?php echo $row['phone']; ?>" />
									</div>
									<div class="form-group col-lg-12">
										<label>Update Address</label>
										<input type="text" name="address" value="<?php echo $row['address']; ?>" class="form-control" />
									</div>
									<div class="form-group col-lg-12">
										<label>New Passsword (If Applicable)</label>
										<input type="password" name="password" class="form-control" />
									</div>
									<div class="form-group col-lg-12">
										<button type="submit" name="update" class="btn btn-outline-primary btn-block"> Update Resident</button>
									</div>
							   </div>
                    		</div>
                    	  </div>
                    	</div>
						<!-- Edit Modal -->
                    	<!-- Delete Modal -->
                    	<div class="modal fade" id="delmodal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    		<div class="modal-dialog modal-dialog-centered" role="document">
                    		  <div class="modal-content">
                    				<div class="modal-header">
                    				  <h5 class="modal-title" id="exampleModalLongTitle">Delete <?php echo $row['full_name']; ?>?</h5>
                    				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    					<span aria-hidden="true">&times;</span>
                    				  </button>
                    				</div>
                    				<div class="modal-body">
                    				  <form action="" method="POST"> 
                    						<input type="hidden" value="<?php echo $row['id']; ?>" name="id">
                    						<div class="form-group"><button type="submit" name="delete" class="btn btn-outline-primary btn-block">Yes. Delete</button></div>
                    				  </form>   
                    				</div>
                    			</div>
                    		</div>
                    	</div>
                    	<!-- Delete Modal -->
                      </div>
					  <?php } } else {echo "No resident in database.";}
						$con->close(); ?>
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
              <h4 class="mt-0 header-title">Add Resident</h4>
              <form class="" action="" method="POST">
                <div class="form-group">
                  <input data-parsley-type="number" type="text" name="flat_no" class="form-control" required placeholder="Room Number"/>
                </div>
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
					<select class="form-control" name="gender" id="gender">
						<option value="Male">Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</div>
				<div class="form-group">
                  <input name="address" type="text" class="form-control" required placeholder="Address"/>
                </div>
				<div class="form-group"> 
					<label for="dob">DOB</label>
					<input name="dob" type="date" class="form-control" required id="dob"/>
                </div>
				<div class="form-group">
					<input name="password" type="password" class="form-control" required placeholder="Password"/>
                </div> 
				<div class="form-group">
					<input name="rpassword" type="password" class="form-control" required placeholder="Repeat password"/>
                </div>
                <div class="form-group">
					<button type="submit" class="btn btn-primary waves-effect waves-light">Add Resident</button>
					<button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button>
                </div>
                </form>
                </div>
               </div>
              </div> <!-- end col -->   
        </div><!-- container -->
      </div><!-- Page content Wrapper -->
	</div><!-- content -->
	<?php include('footer.php'); ?>
</html>