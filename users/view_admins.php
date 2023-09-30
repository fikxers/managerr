<?php require('auth.php'); $title ='View Admins'; 
	  require('../db.php');
	  //Delete admin
	  if (isset($_POST['delid'])){
		$id = $_REQUEST['delid'];
	    // sql to delete a record
	    $sql = "DELETE FROM admins WHERE id = $id"; 
	    $res = $con->query($sql);
	    if ($res) {
		  mysqli_close($con);
		  echo "<script>alert('Admin deleted.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_admins.php';</script>"; exit;
	    } 
		else {
		  echo "<script>alert('Error deleting admin.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_equipments.php';</script>";
	    }  
	  }
	  //Update admin
	  else if (isset($_POST['updateid'])){
		$name = stripslashes($_REQUEST['fullname']);
		$id = $_REQUEST['updateid'];
	    $query = "UPDATE admins set fullname='".$name."' WHERE id = $id";
	    $result = mysqli_query($con,$query); 
	    if($result){
	      echo "<script>alert('Admin updated successfully.');</script>";
	      echo "<script type='text/javascript'>window.top.location='view_admins.php';</script>"; exit;
	    }
	    else{
	      echo "<script>alert('Error updating admin.');</script>";
	      echo "<script type='text/javascript'>window.top.location='view_admins.php';</script>"; exit;
	    }
	  }
	  //Add Admin
	  else if (isset($_POST['rpassword'])){
		$email = stripslashes($_REQUEST['email']);
		$sql = "SELECT * FROM users where email = '".$email."'";
		$result = $con->query($sql);
		if ($result->num_rows > 0) {
		  echo "<script>alert('An account with this email already exists!');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_admins.php';</script>"; exit;
		}
	    $name = stripslashes($_REQUEST['fullname']);
	    $password = stripslashes($_REQUEST['password']);
	    $password2 = stripslashes($_REQUEST['rpassword']);
	    if(trim($password)=='' || trim($password2)=='')
	    {
		  echo "<script>alert('All fields are required!');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_admins.php';</script>"; exit;
	    }
	    else if($password != $password2)
	    {
		  echo "<script>alert('Passwords do not match!');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_admins.php';</script>"; exit;
	    }
	    else{
		  $password = mysqli_real_escape_string($con,$password);
		  if( ! ini_get('date.timezone') ){ date_default_timezone_set('Africa/Lagos'); }
		  $trn_date = date("Y-m-d H:i:s");
		  //b4 insert, check if exists
	      $query = "INSERT into `admins` (email,fullname,created_at) VALUES ('$email','$name','$trn_date')";
		  $query2 = "INSERT into `users` (email, password, admin_type) VALUES ('$email', '".md5($password)."', 'admin')";
	      $result = mysqli_query($con,$query); $result2 = mysqli_query($con,$query2);
		  if($result){
		  echo "<script>alert('Admin added successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_admins.php';</script>"; exit;
		  }
		  else{
		  echo "<script>alert('Error adding admin.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_admins.php';</script>"; exit;
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
		              <thead><tr class="titles"><th>Name</th><th>Email</th><th>Action</th></tr></thead>
		              <tbody> <?php while($row = $result->fetch_assoc()) { ?>
									<tr><td><?php echo $row['fullname']; ?></td><td><?php echo $row['email']; ?></td>
							  	<?php 
									echo "<td><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#editmodal-".$row['id']."' data-original-title='Update Resident'><i class='fa fa-pencil' aria-hidden='true'></i></button> <button type='button' class='btn text-danger btn-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-".$row['id']."' data-original-title='Delete Resident'><i class='fa fa-trash' aria-hidden='true'></i></button></td>";
									?></tr>
									<!-- Edit Modal -->
									<div class="modal fade" id="editmodal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    	<div class="modal-content">
                    		<div class="modal-header">
                    			<h5 class="modal-title" id="exampleModalLongTitle">Update <?php echo $row['fullname']; ?></h5>
                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    				  <span aria-hidden="true">&times;</span>
                    			</button>
                    		</div>
                    		<div class="modal-body">
                    			<form class="" action="" method="POST">
														<div class="form-group col-lg-12">
															<label>Full name</label>
															<input type="text" name="fullname" class="form-control"  value="<?php echo $row['fullname']; ?>" />
															<input type="hidden" name="updateid" value="<?php echo $row['id']; ?>" />
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
									<div class="modal fade" id="delmodal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    	<div class="modal-content">
                    		<div class="modal-header">
                    			<h5 class="modal-title" id="exampleModalLongTitle">Delete <?php echo $row['fullname']; ?>?</h5>
                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    					<span aria-hidden="true">&times;</span>
                    			</button>
                    		</div>
                    		<div class="modal-body">
                    			<form action="" method="POST"> 
                    				<input type="hidden" value="<?php echo $row['id']; ?>" name="delid">
                    				<div class="form-group"><button type="submit" name="delete" class="btn btn-outline-primary btn-block">Yes. Delete</button></div>
                    			 </form>   
                    		</div>
                    	</div>
                    </div>
                  </div>
                  <!-- Delete Modal -->
							<?php } 
						    } else { echo "No Admin in database.";}
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
                    <input type="text" name="fullname" class="form-control" required placeholder="Full name"/>
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