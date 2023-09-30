<?php require('auth.php'); $title ='Estate Managers'; ?>

	<?php
	  require('../db.php');
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
			header('Location: view_mgrs.php');
		  }
		  else if($password != $password2)
		  {
			echo('Passwords do not match!');
			header('Location: view_mgrs.php');
		  }
		  else{
				$password = mysqli_real_escape_string($con,$password);
				if( ! ini_get('date.timezone') )
				{
				  date_default_timezone_set('Africa/Lagos');
				}
				$trn_date = date("Y-m-d H:i:s");
				//b4 insert, check if exists
			  $query = "INSERT into `estate_manager` (name,estate, phone, email, created_at) VALUES ('$mgr_name','$estate_code','$phone', '$email', '$trn_date')";
				$query2 = "INSERT into `users` (email, password, admin_type) VALUES ('$email', '".md5($password)."', 'mgr')";
			  $result = mysqli_query($con,$query);
				$result2 = mysqli_query($con,$query2);
				if($result){
				  echo "<script>alert('Estate manager added successfully.');</script>";
				  echo "<script type='text/javascript'>window.top.location='view_mgrs.php';</script>"; exit;
				}
				else{
				  echo "<script>alert('Error adding Estate manager.');</script>";
				  echo "<script type='text/javascript'>window.top.location='view_mgrs.php';</script>"; exit;
				}
		  }
	  }
	  //Delete
	  if (isset($_POST['delete'])){
	   $id = $_REQUEST['delid'];
	   // sql to delete a record
	   $sql = "DELETE FROM estate_manager WHERE id = '$id'"; 
	   //$sql1 = "DELETE FROM users WHERE email = '$id'"; 
	   $res = $con->query($sql); //$res1 = $con->query($sql1);
	   if ($res) {
	    mysqli_close($con);
	    echo "<script>alert('FM deleted.');</script>";
	    echo "<script type='text/javascript'>window.top.location='view_mgrs.php';</script>"; exit;
	   } else {
	    echo "<script>alert('Error deleting FM.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_mgrs.php';</script>"; exit;
	   }
	  }
	  //update 
	  else if (isset($_POST['updateid'])){
	  	$id = $_REQUEST['updateid'];
			$fullname = stripslashes($_REQUEST['fullname']);
			$phone = stripslashes($_REQUEST['phone']);
			$query = "UPDATE estate_manager set name='".$fullname."',phone='".$phone."' WHERE id = $id";
			$result2 = mysqli_query($con,$query); 
			if($result2){
			  echo "<script>alert('FM updated successfully.');</script>";
			  echo "<script type='text/javascript'>window.top.location='view_mgrs.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Error updating FM.');</script>";
			  echo "<script type='text/javascript'>window.top.location='view_mgrs.php';</script>"; exit;
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
                <h4 class="mt-0 header-title">All Estate Managers</h4>
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
									$sql = "SELECT * FROM estate_manager";
									$result = $con->query($sql);
									if ($result->num_rows > 0) { ?>
									<table id="tech-companies-1" class="table table-bordered table-striped">
                    <thead><tr class="titles"><th>Name</th><th>Phone</th><th>Estate</th><th>Action</th></tr></thead>
                    <tbody> <?php while($row = $result->fetch_assoc()) { ?>
										<tr><td><?php echo $row['name']; ?></td>
										<td><?php echo $row['phone']; ?></td>
										<td><?php echo $row['estate']; ?></td>
									  	<?php echo "<td><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#editmodal-".$row['id']."' data-original-title='Update Resident'><i class='fa fa-pencil' aria-hidden='true'></i></button> <button type='button' class='btn text-danger btn-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-".$row['id']."' data-original-title='Delete Resident'><i class='fa fa-trash' aria-hidden='true'></i></button></td> </td>"; ?></tr>
									  	<!-- Edit Modal -->
											<div class="modal fade" id="editmodal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		                    <div class="modal-dialog modal-dialog-centered" role="document">
		                    	<div class="modal-content">
		                    		<div class="modal-header">
		                    			<h5 class="modal-title" id="exampleModalLongTitle">Update <?php echo $row['name']; ?></h5>
		                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                    				  <span aria-hidden="true">&times;</span>
		                    			</button>
		                    		</div>
		                    		<div class="modal-body">
		                    			<form class="" action="" method="POST">
																<div class="form-group col-lg-12">
																	<label>Full name</label>
																	<input type="text" name="fullname" class="form-control"  value="<?php echo $row['name']; ?>" />
																</div>
																<div class="form-group col-lg-12">
																	<label>Phone</label>
																	<input type="text" name="phone" class="form-control"  value="<?php echo $row['phone']; ?>" />
																	<input type="hidden" name="updateid" value="<?php echo $row['id']; ?>" />
																</div>
																<div class="form-group col-lg-12">
																	<button type="submit" name="update" class="btn btn-outline-primary btn-block"> Update FM</button>
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
		                    			<h5 class="modal-title" id="exampleModalLongTitle">Delete <?php echo $row['name']; ?>?</h5>
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
									      } else { echo "No estate manager in database.";}
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
                <h4 class="mt-0 header-title">Add Estate Manager</h4>
                <p class="text-muted m-b-30 font-14">Enter details of a new estate manager.</p>
                <form class="" action="" method="POST">
                  <div class="form-group">
                    <input type="text" name="mgr_name" class="form-control" required placeholder="Name of Estate Manager"/></div>
                    <!--<div class="form-group"><input type="text" name="estate_code" class="form-control" required placeholder="Estate CODE"/></div>-->
										<?php include ('estate_div.php'); ?>
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
                      <button type="submit" class="btn btn-primary waves-effect waves-light">Add New FM</button>
                      <button type="reset" class="btn btn-secondary waves-effect m-l-5">Reset Form</button>
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