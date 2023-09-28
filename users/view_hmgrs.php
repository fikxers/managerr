<?php require('auth.php'); $title ='Hostel Managers'; 
	  require('../db.php');
	  //Add Hostel Manager
	  if (isset($_POST['estate_code'])){
	  $mgr_name = stripslashes($_REQUEST['mgr_name']);
	  $estate_code = stripslashes($_REQUEST['estate_code']);
	  $phone = stripslashes($_REQUEST['phone']);
	  $email = stripslashes($_REQUEST['email']);
	  $password = stripslashes($_REQUEST['password']);
	  $password2 = stripslashes($_REQUEST['rpassword']);
	  if(trim($password)=='' || trim($password2)=='')
	  {
		echo('All fields are required!');
		header('Location: view_hmgrs.php');
	  }
	  else if($password != $password2)
	  {
		echo('Passwords do not match!');
		header('Location: view_hmgrs.php');
	  }
	  else{
		$password = mysqli_real_escape_string($con,$password);
		if( ! ini_get('date.timezone') )
		{
		  date_default_timezone_set('Africa/Lagos');
		}
		$trn_date = date("Y-m-d H:i:s");
		//b4 insert, check if exists
	    $query = "INSERT into `hostel_manager` (manager_name,hostel, phone, email, created_at) VALUES ('$mgr_name','$estate_code','$phone', '$email', '$trn_date')";
		$query2 = "INSERT into `users` (email, password, admin_type) VALUES ('$email', '".md5($password)."', 'hmgr')";
	    $result = mysqli_query($con,$query);
		$result2 = mysqli_query($con,$query2);
		if($result){
		  echo "<script>alert('Hostel manager added successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_hmgrs.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Error adding Hostel manager.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_hmgrs.php';</script>"; exit;
		}
	  }
	  }
	  else{
		//echo "<script>alert('Error');</script>";
		if($_SESSION['admin_type']=='admin'){
		   include('admin_sidebar.php'); 
		}
	    else if($_SESSION['admin_type']=='mgr'){
		   include('mgr_sidebar.php');
		}
	?>
	<div class="page-content-wrapper ">
      <div class="container-fluid">
		<div class="row">       
		  <div class="col-lg-12">
	        <div class="card m-b-30">
	          <div class="card-body">
	            <h4 class="mt-0 header-title">All Hostel Managers</h4>
		        <div class="table-rep-plugin">
		          <div class="table-responsive b-0" data-pattern="priority-columns">
		          <?php include ('../db.php');
					$sql = "SELECT * FROM hostel_manager";
					$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
					<table id="tech-companies-1" class="table table-bordered table-striped">
		              <thead><tr class="titles"><th>Name</th><th>Phone</th><th>Hostel</th><th>Action</th></tr></thead>
		              <tbody> <?php while($row = $result->fetch_assoc()) { ?>
						<tr><td><?php echo $row['manager_name']; ?></td>
							<td><?php echo $row['phone']; ?></td>
							<td><?php echo $row['hostel']; ?></td>
						  	<?php //echo "<td><a href='update_mgr.php?id=" .$row['email']."&phone=" .$row['phone']."&name=" .$row['manager_name']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> <a href='delete_mgr.php?id=" . $row['email'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>"; 
							echo "<td><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#editmodal-".$row['manager_id']."' data-original-title='Update Resident'><i class='fa fa-pencil' aria-hidden='true'></i></button> <button type='button' class='btn text-danger btn-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-".$row['manager_id']."' data-original-title='Delete Resident'><i class='fa fa-trash' aria-hidden='true'></i></button></td>";
							?></tr>
							<!-- Edit Modal -->
							<div class="modal fade" id="editmodal-<?php echo $row['manager_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    		  <div class="modal-dialog modal-dialog-centered" role="document">
                    		    <div class="modal-content">
                    			  <div class="modal-header">
                    			    <h5 class="modal-title" id="exampleModalLongTitle">Update Hostel Manager</h5>
                    			    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    				  <span aria-hidden="true">&times;</span>
                    			    </button>
                    			  </div>
                    			  <div class="modal-body">
                    			    <form class="" action="" method="POST">
										<div class="form-group col-lg-12">
											<label>Update Manager's Name</label>
											<input type="text" name="resident" class="form-control"  value="<?php echo $row['manager_name']; ?>" />
											<input type="hidden" name="id" value="<?php echo $row['manager_id']; ?>" />
										</div>		
										<div class="form-group col-lg-12">
											<label>Update Manager's Phone No.</label>
											<input type="text" name="phone" class="form-control"  value="<?php echo $row['phone']; ?>" />
										</div>
										<div class="form-group col-lg-12">
											<label>Update Manager's Email</label>
											<input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control" />
										</div>
										<div class="form-group col-lg-12">
											<label>New Passsword (If Applicable)</label>
											<input type="password" name="password" class="form-control" />
										</div>
										<div class="form-group col-lg-12">
											<button type="submit" name="update" class="btn btn-outline-primary btn-block"> Update Hostel Manager</button>
										</div>
									</form>  
                    			  </div>
                    		    </div>
                    		  </div>
							</div>
							<!-- Edit Modal -->
							<!-- Delete Modal -->
							<div class="modal fade" id="delmodal-<?php echo $row['manager_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    		  <div class="modal-dialog modal-dialog-centered" role="document">
                    		    <div class="modal-content">
                    				<div class="modal-header">
                    				  <h5 class="modal-title" id="exampleModalLongTitle">Delete <?php echo $row['manager_name']; ?>?</h5>
                    				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    					<span aria-hidden="true">&times;</span>
                    				  </button>
                    				</div>
                    				<div class="modal-body">
                    				  <form action="" method="POST"> 
                    						<input type="hidden" value="<?php echo $row['email']; ?>" name="id">
                    						<div class="form-group"><button type="submit" name="delete" class="btn btn-outline-primary btn-block">Yes. Delete</button></div>
                    				  </form>   
                    				</div>
                    			</div>
                    		  </div>
                    	    </div>
                    	    <!-- Delete Modal -->
							<?php } 
						    } else { echo "No hostel manager in database.";}
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
            	<h4 class="mt-0 header-title">Add Hostel Manager</h4>
                <p class="text-muted m-b-30 font-14">Enter details of a new hostel manager.</p>
                <form class="" action="" method="POST">
                  <div class="form-group">
                    <input type="text" name="mgr_name" class="form-control" required placeholder="Name of Hostel Manager"/>
                  </div>
				  <div class="form-group">
					<select class="form-control" required name="estate_code" >
					  <option value="">Select Hostel</option>
						<?php include ('../db.php');
						$sql="select hostel_code,hostel_name from hostels"; 
						$result = $con->query($sql);
						while($row = $result->fetch_assoc()) { ?>
					  <option value="<?php echo $row['hostel_code']; ?>"><?php echo $row['hostel_name']; ?></option><?php } ?>
					</select>
				  </div>
				  <div class="form-group">
				    <input type="text" name="phone" class="form-control" required placeholder="Phone"/>
				  </div>
				  <div class="form-group">
				    <input name="email" type="text" class="form-control" required placeholder="Email"/>
				  </div>
				  <div class="form-group">
				    <input name="password" type="password" class="form-control" required placeholder="Password"/>
				  </div> 
				  <div class="form-group">
                    <input name="rpassword" type="password" class="form-control" required placeholder="Repeat password"/>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add Hostel Manager</button>
					<button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div> <!-- end col -->
        </div><!-- container -->
      </div><!-- Page content Wrapper -->
    </div><!-- content -->            
	<?php include('footer.php'); } ?>
</html>