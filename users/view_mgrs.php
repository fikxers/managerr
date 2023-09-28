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
									  	<?php echo "<td><a href='update_mgr.php?id=" .$row['email']."&phone=" .$row['phone']."&name=" .$row['name']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> <a href='delete_mgr.php?id=" . $row['email'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>"; ?></tr><?php } 
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
					<div class="form-group">
					  <select class="form-control" required name="estate_code" >
						<option value="">Select Estate</option>
						<?php include ('../db.php');
						$sql="select estate_code,estate_name from estates"; 
						$result = $con->query($sql);
						while($row = $result->fetch_assoc()) { ?>
						<option value="<?php echo $row['estate_code']; ?>"><?php echo $row['estate_name']; ?></option><?php } ?>
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
                      <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button><button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button>
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