<?php include('auth.php'); $title ='Estate Facility Services'; 
		  if($_SESSION['admin_type']=='admin'){
		   include('admin_sidebar.php'); 
		  }
	      else if($_SESSION['admin_type']=='mgr'){
		   include('mgr_sidebar.php');
		  }
		  else if($_SESSION['admin_type']=='flat'){
		   include('flat_sidebar.php');
		  }
		  require('../db.php');
		  if (isset($_POST['name'])){
			$name = stripslashes($_REQUEST['name']);
			$date = stripslashes($_REQUEST['date']);
			$description = stripslashes($_REQUEST['description']);
			if( ! ini_get('date.timezone') )
			{
			  date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT into `orders` (flat,estate,order_name,order_status, created_at, description,preferred_date, order_type) VALUES ('".$_SESSION['email']."', '".$_SESSION['estate']."','$name', 'pending','$trn_date', '$description','$date','facility_service')";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Facility Service requested.');</script>";
			  echo "<script type='text/javascript'>window.top.location='facility_service.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Facility Service request not successful.');</script>";
			  echo "<script type='text/javascript'>window.top.location='facility_service.php';</script>"; exit;
			}
		  }
		  else{
		?>
        <div class="page-content-wrapper ">
          <div class="container-fluid">
			<div class="row">       
			  <div class="col-lg-12">
                <div class="card m-b-30">
                  <div class="card-body">
                  <h4 class="mt-0 header-title">Estate Facility Services</h4>
                    <div class="table-rep-plugin">
                      <div class="table-responsive b-0" data-pattern="priority-columns">
                       <?php include ('../db.php');
						$sql = "SELECT * FROM orders where flat='".$_SESSION['email']."' and order_type='facility_service'";
						if($_SESSION['admin_type']=='admin'){$sql = "SELECT * FROM orders where order_type='facility_service'";}
						  $result = $con->query($sql);
						  if ($result->num_rows > 0) { ?>
							<table id="tech-companies-1" class="table  table-striped">
                              <thead><tr class="titles"><th>Name of Service</th>
								<th>Description</th><th>Preferred Date</th>
                                <th>Status</th> </tr></thead>
                              <tbody> <?php while($row = $result->fetch_assoc()) { ?>
								<tr><td><?php echo $row['order_name']; ?></td>
								<td><?php echo $row['description']; ?></td>
								<td><?php echo $row['preferred_date']; ?></td>
								<td><?php echo $row['order_status']; ?></td></tr>
								<?php } } else { echo "No facility service yet.";}
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
                  <h4 class="mt-0 header-title">Request Estate Facility Service</h4>
                  <form class="" action="" required method="POST">
					<div class="form-group">
					  <select class="form-control" name="name" >
						<!--<option value="">Select Service</option>
						<option value="Packers and Movers">Packers and Movers</option>
						<option value="Cleaning">Cleaning</option>
						<option value="Real Estate">Real Estate</option>
						<option value="Electrician">Electrician</option>
						<option value="Fumigation">Fumigation</option>
						<option value="Painter">Painter</option>
						<option value="Interior decoration">Interior decoration</option>
						<option value="Laundry & dry cleaning">Laundry & dry cleaning</option>-->
						<option value="Plumbing">Plumbing</option>
						<option value="Carpentry">Carpentry</option>
						<option value="Electrical Service">Electrical Service</option>
					  </select>
					</div>
					<div class="form-group">
                      <input type="date" name="date" class="form-control" required placeholder="Choose Date">
                    </div>
					<div class="form-group">
                      <input type="textarea" name="description" class="form-control" placeholder="Description e.g I want to move from Lekki to Ajah"/>
                    </div>
					<div class="form-group">
                      <div><button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button><button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button></div>
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