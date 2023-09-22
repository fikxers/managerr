<?php require('auth.php'); 
	  $title ='Security Team'; 
	  require('../db.php');
	 // ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	if (isset($_POST['sec_name'])){
	  $sec_name = stripslashes($_REQUEST['sec_name']);
	  
	  if($_SESSION['admin_type']=='admin'){
		$estate_code = stripslashes($_REQUEST['estate_code']); 
	  }
	  else if($_SESSION['admin_type']=='mgr'){
		$estate_code = $_SESSION['estate'];
	  }
	  else if($_SESSION['admin_type']=='hmgr'){
		$estate_code = $_SESSION['hostel'];
	  }
	  $address = stripslashes($_REQUEST['address']);
	  $dob = stripslashes($_REQUEST['dob']);
	  //$status = stripslashes($_REQUEST['status']);
	  $phone = stripslashes($_REQUEST['phone']);
	  $email = stripslashes($_REQUEST['email']);
	  $password = stripslashes($_REQUEST['password']);
	  $password2 = stripslashes($_REQUEST['rpassword']);
	  if(trim($password)=='' || trim($password2)=='')
	  {
		echo('All fields are required!');
		header('Location: view_security.php');
	  }
	  else if($password != $password2)
	  {
		echo('Passwords do not match!');
		header('Location: view_security.php');
	  }
	  else{
		$password = mysqli_real_escape_string($con,$password);
		if( ! ini_get('date.timezone') )
		{
		  date_default_timezone_set('Africa/Lagos');
		}
		$trn_date = date("Y-m-d H:i:s");
		//b4 insert, check if exists
	    $query = "INSERT into `security_team` (name, phone, email, dob, address, estate, created_at) VALUES ('$sec_name', '$phone', '$email','$dob', '$address', '$estate_code', '$trn_date')";
		$query2 = "INSERT into `users` (email, password, admin_type) VALUES ('$email', '".md5($password)."', 'security')";
	    $result = mysqli_query($con,$query);
		$result2 = mysqli_query($con,$query2);
		if($result && $result2){
		  echo "<script>alert('Security member added successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_security.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Error adding security member.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_security.php';</script>"; exit;
		}
	  }
	}
	else if (isset($_POST['delete'])){
	  $id = $_REQUEST['id']; 
	  $query = "DELETE from security_team WHERE email = '$id'";
		$result2 = mysqli_query($con,$query); 
		if($result2){
		  echo "<script>alert('Deleted successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_security.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Delete Error. Please try again.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_security.php';</script>"; exit;
		}
	}
	else if (isset($_POST['update'])){
	    $id = $_REQUEST['id']; 
		if( ! ini_get('date.timezone') )
		{
		  date_default_timezone_set('Africa/Lagos');
		}
		$trn_date = date("Y-m-d H:i:s");
		$address = stripslashes($_REQUEST['address']);
	    $dob = stripslashes($_REQUEST['dob']);
	    $sec_name = stripslashes($_REQUEST['secname']);
	    $phone = stripslashes($_REQUEST['phone']);

		$query = "UPDATE security_team set name='".$sec_name."',phone='".$phone."',dob='".$dob."',address='".$address."',updated_at='".$trn_date."' WHERE email = '".$id."'";
		$result2 = mysqli_query($con,$query) or die(mysql_error()); 
		if($result2){
		  echo "<script>alert('Updated successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_security.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Update Error. Please try again.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_security.php';</script>"; exit;
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
		  else if($_SESSION['admin_type']=='hmgr'){
		   include('hmgr_sidebar.php');
		  }
		?>
		    <div class="row">       
			  <div class="col-lg-12">
                <div class="card m-b-30">
                  <div class="card-body">
                  <h4 class="mt-0 header-title">Security Team</h4>
				  <span style="float: right"><button type='button' class='btn btn-dark btn-sm text-dark' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#fikxermodal' data-original-title='Add Fikxer'><i class="fa fa-user-plus m-r-10 m-b-10"></i><b>Add Security Member</b></button></span>
                  <div class="table-rep-plugin">
                    <div class="table-responsive b-0" data-pattern="priority-columns">
                    <?php include ('../db.php');
					$sql = "SELECT * FROM security_team";
					if($_SESSION['admin_type']=='mgr'){
					  $sql = "SELECT * FROM security_team where estate='".$_SESSION['estate']."'";
					}$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
					<table id="tech-companies-1" class="table  table-striped">
                      <thead><tr class="titles"><th>Name</th><th>Phone</th><th>Email</th> <?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?> <th>DOB</th><th>Home Address</th>  <th colspan="2">Action</th></tr></thead>
					  <tbody> <?php while($row = $result->fetch_assoc()) { 
						echo "<tr><td>". $row['name']. "</td>"; echo "<td>". $row['phone']. "</td>"; echo "<td>". $row['email']. "</td>";
						if($_SESSION['admin_type']=='admin'){echo "<td>". $row['estate']. "</td>";}
						echo "<td>". $row['dob']. "</td>"; echo "<td>". $row['address']. "</td>";
						echo "<td><button type='button' class='btn btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#updatemodal-" .$row['email']."'><i class='fa fa-pencil text-success m-r-0'></i></button><button type='button' class='btn btn-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-" .$row['email']."'><i class='fa fa-trash text-danger m-r-0'></i></button></td> </tr>"; 
						echo '<!-- Delete Modal -->
						<div class="modal fade" id="delmodal-'.$row['email'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['email'].'" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="delmodal">Delete '.$row['name'].'?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<form action="" method="POST">
								   <div class="form-row">
									<input type="hidden" name="id" value="'.$row['email'].'">
									<div class="form-group col-lg-12">
									  <input type="submit" name="delete" value="Yes, Delete" class="btn btn-block btn-outline-info">
									</div>
								   </div>
								</form>
							  </div>
							</div>
						  </div>
						</div>
						<!-- /Delete Modal -->';
						echo '<!-- Update Modal -->
						<div class="modal fade" id="updatemodal-'.$row['email'].'" tabindex="-1" role="dialog" aria-labelledby="updatemodal-'.$row['email'].'" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="updatemodal">Update Info?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<form action="" method="POST">
								   <div class="form-row">
									<input type="hidden" name="id" value="'.$row['email'].'">
									<div class="form-group col-lg-12">
									  <input type="text" name="secname" class="form-control" placeholder="'.$row['name'].'" value="'.$row['name'].'"><input type="text" name="phone" class="form-control" placeholder="'.$row['phone'].'" value="'.$row['phone'].'"><input type="text" name="address" class="form-control" placeholder="'.$row['address'].'" value="'.$row['address'].'"><input type="date" name="dob" class="form-control" placeholder="'.$row['dob'].'" value="'.$row['dob'].'">
									</div>
									<div class="form-group col-lg-12">
									  <input type="submit" name="update" value="Yes. Update" class="btn btn-block btn-outline-info">
									</div>
								   </div>
								</form>
							  </div>
							</div>
						  </div>
						</div>
						<!-- /Update Modal -->';}
						}else { echo "No Security member in database."; } $con->close(); 
						?>
                       </tbody>
                    </table>
                    </div>
				  </div>
                 </div>
                </div>
              </div> <!-- end col -->
			 <!-- Modal -->
			 <div class="modal fade" id="fikxermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
				    <div class="modal-header">
					  <h5 class="modal-title" id="exampleModalLongTitle">Add Security Member</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					   <form class="" action="" method="POST">
						<div class="form-group">
						  <input type="text" name="sec_name" class="form-control" required placeholder="Full Name"/>
						</div>
						<div class="form-group">
						  <label>DOB</label><input type="date" name="dob" class="form-control" required />
						</div>
						<?php  if($_SESSION['admin_type']=='admin'){ include('estate_div.php'); } ?>
						<div class="form-group">
						  <input type="text" name="address" class="form-control" required placeholder="Home address"/> 
						</div>
						<div class="form-group">
						  <div><input name="phone" type="text" class="form-control" required placeholder="Phone"/></div>
						</div> 
						<div class="form-group">
						  <div><input name="email" type="text" class="form-control" required placeholder="Email"/></div>
						</div>
						<div class="form-group">
						  <div><input name="password" type="password" class="form-control" required placeholder="Password"/></div>
						</div> 
						<div class="form-group">
						  <div><input name="rpassword" type="password" class="form-control" required placeholder="Repeat password"/></div>
						</div>
						<!--<div class="form-group">
						  <select class="form-control" required name="status" >
							<option value="">Status</option>						
							<option value="available">Available</option> <option value="occupied">Occupied</option><option value="holiday">On holiday</option><option value="suspended">Suspended</option><option value="trial">On trial</option>
						  </select>
						</div>-->
						<div class="form-group">
						  <div><button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button><button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button></div>
						</div>
					  </form>
					</div>
				  </div>
				</div>
			  </div>	
            </div><!-- container -->
		  </div><!-- Page content Wrapper -->
		</div><!-- content -->
		<?php include('footer.php');  } ?>
</html>