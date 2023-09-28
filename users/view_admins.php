<?php require('auth.php'); $title ='View Admins'; 
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
	            <h4 class="mt-0 header-title">All Admins</h4>
		        <div class="table-rep-plugin">
		          <div class="table-responsive b-0" data-pattern="priority-columns">
		          <?php include ('../db.php');
					$sql = "SELECT * FROM admins";
					$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
					<table id="tech-companies-1" class="table table-bordered table-striped">
		              <thead><tr class="titles"><th>Username</th><th>Action</th></tr></thead>
		              <tbody> <?php while($row = $result->fetch_assoc()) { ?>
						<tr><td><?php echo $row['username']; ?></td>
						  	<?php 
							echo "<td><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#editmodal-".$row['username']."' data-original-title='Update Resident'><i class='fa fa-pencil' aria-hidden='true'></i></button> <button type='button' class='btn text-danger btn-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-".$row['username']."' data-original-title='Delete Resident'><i class='fa fa-trash' aria-hidden='true'></i></button></td>";
							?></tr>
							<!-- Edit Modal -->
							<div class="modal fade" id="editmodal-<?php echo $row['username']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    		  <div class="modal-dialog modal-dialog-centered" role="document">
                    		    <div class="modal-content">
                    			  <div class="modal-header">
                    			    <h5 class="modal-title" id="exampleModalLongTitle">Update <?php echo $row['username']; ?></h5>
                    			    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    				  <span aria-hidden="true">&times;</span>
                    			    </button>
                    			  </div>
                    			  <div class="modal-body">
                    			    <form class="" action="" method="POST">
										<div class="form-group col-lg-12">
											<label>Username</label>
											<input type="text" name="resident" class="form-control"  value="<?php echo $row['username']; ?>" />
											<input type="hidden" name="id" value="<?php echo $row['username']; ?>" />
										</div>
										<div class="form-group col-lg-12">
											<button type="submit" name="update" class="btn btn-outline-primary btn-block"> Update Admin</button>
										</div>
									</form>  
                    			  </div>
                    		    </div>
                    		  </div>
							</div>
							<!-- Edit Modal -->
							<!-- Delete Modal -->
							<div class="modal fade" id="delmodal-<?php echo $row['username']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    		  <div class="modal-dialog modal-dialog-centered" role="document">
                    		    <div class="modal-content">
                    				<div class="modal-header">
                    				  <h5 class="modal-title" id="exampleModalLongTitle">Delete <?php echo $row['username']; ?>?</h5>
                    				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    					<span aria-hidden="true">&times;</span>
                    				  </button>
                    				</div>
                    				<div class="modal-body">
                    				  <form action="" method="POST"> 
                    						<input type="hidden" value="<?php echo $row['username']; ?>" name="id">
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
            	<h4 class="mt-0 header-title">Add New Admin</h4>
                <p class="text-muted m-b-30 font-14">Enter details of a new admin.</p>
                <form class="" action="" method="POST">
                  <div class="form-group">
                    <input type="text" name="mgr_name" class="form-control" required placeholder="Admin Username"/>
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
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add New Admin</button>
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