<?php require('auth.php'); $title ='Hotels'; 
	  require('../db.php');
	  // ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);
	  if (isset($_POST['task'])){
	  	$task = stripslashes($_REQUEST['task']);
	  	$hotel_code = stripslashes($_REQUEST['hotel_code']);
	  	$msg = "deleting"; $msg2 = "Deleted"; 
	  	$query = "DELETE FROM hotels WHERE hotel_code = '".$hotel_code."'";
	  	if($task == 'edit' || $task == 'add'){
			  $hotel_name = stripslashes($_REQUEST['hotel_name']);
			  $address = stripslashes($_REQUEST['address']);
			  $no_of_rooms = stripslashes($_REQUEST['no_of_rooms']);
			  switch ($task) {
				  case "edit":
				    $query = "UPDATE hotels set address='".$address."',no_of_rooms=$no_of_rooms,hotel_name='".$hotel_name."' WHERE hotel_code = '".$hotel_code."'";
				    $msg = "updating"; $msg2 = "Updated";
				    break;
				  default:
				    $query = "INSERT into `hotels` (hotel_name, hotel_code,no_of_rooms, address) VALUES ('$hotel_name', '$hotel_code',$no_of_rooms,'$address')";
				    $msg = "adding"; $msg2 = "Added";
				}
			}
		  $result = mysqli_query($con,$query);
			if($result){
				echo "<script>alert('".$msg2." Successfully.');</script>";
			  echo "<script type='text/javascript'>window.top.location='view_hotels.php';</script>"; exit;
			}else {
			  echo "<script>alert('Error ".$msg.".');</script>";
			  echo "<script type='text/javascript'>window.top.location='view_hotels.php';</script>";
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
                <h4 class="mt-0 header-title">All Hotels</h4>
                <div class="table-rep-plugin">
                  <div class="table-responsive table-bordered b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
									$sql = "SELECT * FROM hotels"; $result = $con->query($sql);
                  if ($result->num_rows > 0) { ?>
									<table id="tech-companies-1" class="table  table-striped">
                    <thead class="titles"><tr><th>Name</th><th>Code</th>
                      <th>Address</th><th># of rooms</th><th>Action</th> </tr></thead>
                    <tbody> <?php while($row = $result->fetch_assoc()) { ?>
									  <tr><td><?php echo $row['hotel_name']; ?></td>
										<td><?php echo $row['hotel_code']; ?></td>
										<td><?php echo $row['address']; ?></td>
										<td><?php echo $row['no_of_rooms']; ?></td>

										<?php echo "<td><a href='hotel_room.php?hotel_code=" .$row['hotel_code']."&hotel_name=" .$row['hotel_name']."' data-toggle='tooltip' data-original-title='View Rooms'><i class='fa fa-building-o text-primary m-r-10'></i></a> "; 
											echo '<button type="button" class="btn btn-warning btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-toggle="modal" data-target="#editmodal-'.$row['hotel_code'].'" data-original-title="Edit" title="Update Hotel"><i class="fa fa-pencil text-warning"></i></button>&emsp;<button type="button" class="btn btn-danger text-danger btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#delmodal-'.$row['hotel_code'].'" data-original-title="Delete" title="Delete Hotel"><i class="fa fa-trash text-danger"></i></button></td>';
											//<button type="button" class="btn btn-primary btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-toggle="modal" data-target="#viewmodal-'.$row['hotel_code'].'" data-original-title="Edit" title="Hotel Rooms"><i class="fa fa-building-o text-primary"></i></button>&emsp;
										?>
									  </tr>
										<?php 
										  echo '<!-- Delete Modal -->
											<div class="modal fade" id="delmodal-'.$row['hotel_code'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['hotel_code'].'" aria-hidden="true">
											  <div class="modal-dialog" role="document">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="passmodal">Delete Hotel?</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												  </div>
												  <div class="modal-body">
													<form action="" method="POST">
													  <div class="form-row">
															<input type="hidden" name="hotel_code" value="'.$row['hotel_code'].'">
															<input type="hidden" name="task" value="delete">
														  <input type="submit" name="delete" value="Yes. Delete." class="btn btn-block btn-outline-info">
														</div>
													</form>
												  </div>
												</div>
											  </div>
											</div>
											<!-- /Delete Modal -->
											<!-- Hotel Rooms -->
											<div class="modal fade" id="viewmodal-'.$row['hotel_code'].'" tabindex="-1" role="dialog" aria-labelledby="viewmodal-'.$row['hotel_code'].'" aria-hidden="true">
											  <div class="modal-dialog" role="document">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="passmodal">View Hotel Rooms</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												  </div>
												  <div class="modal-body">
												  	<p class="text-muted m-b-30 font-14">Enter details of a new hotel.</p>
														<!--<table class="table table-striped">
                    					<thead class="titles"><tr><th>Name</th><th>Code</th></tr></thead>
                    					<tbody>
                    						<tr><td>1</td><td>2</td></tr>
                    					</tbody>
                    				</table>-->
												  </div>
												</div>
											  </div>
											</div>
											<!-- /Hotel Rooms -->
											<!-- Edit Modal -->
											<div class="modal fade" id="editmodal-'.$row['hotel_code'].'" tabindex="-1" role="dialog" aria-labelledby="editmodal-'.$row['hotel_code'].'" aria-hidden="true">
											  <div class="modal-dialog" role="document">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title">Update Hotel Details</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span>
													</button>
												  </div>
												  <div class="modal-body">
													<form action="" method="POST">
													  <div class="form-row">
													    <input type="hidden" name="hotel_code" value="'.$row['hotel_code'].'">
													    <input type="hidden" name="task" value="edit">
													    <div class="form-group col-lg-6">
															  <label for="arr_date">Name</label>
															  <input type="text" value="'.$row['hotel_name'].'" name="hotel_name" class="form-control" />
															</div>
															<div class="form-group col-lg-6">
															  <label for="arr_date">No. of rooms</label><input type="number" min="1" name="no_of_rooms" value="'.$row['no_of_rooms'].'" placeholder="1" class="form-control" />
															</div>
															<div class="form-group col-lg-12">
															  <label for="arr_date">Address</label>
															  <textarea class="form-control" name="address">'.$row['address'].'</textarea>
															</div>
														  <div class="form-group col-lg-12">
														    <input type="submit" value="Update" class="btn btn-block btn-outline-info">
														  </div>
													  </div>
													</form>
												  </div>
												</div>
											  </div>
											</div>
											<!-- /Edit Modal -->
											';
										} 
										  
										} else { echo "No hostel in database."; }
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
              <h4 class="mt-0 header-title">Add Hotel</h4>
              <p class="text-muted m-b-30 font-14">Enter details of a new hotel.</p>
              <form class="" action="" method="POST">
              <div class="form-group">
                <input type="text" name="hotel_name" class="form-control" required placeholder="Name of Hotel"/></div>
              <div class="form-group">
                <input type="text" name="hotel_code" class="form-control" required placeholder="Hotel Code"/></div>
			  			<div class="form-group">
                <input type="text" name="address" class="form-control" required placeholder="Full address"/></div>
			  			<div class="form-group">
                <input data-parsley-type="number" name="no_of_rooms" min="1" type="number" class="form-control" required placeholder="1"/></div>
              <div class="form-group">
              	<input type="hidden" name="task" value="add">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Add New Hotel</button>
                <button type="reset" class="btn btn-secondary waves-effect m-l-5">Reset Form</button></div>
              </form>
              </div>
            </div>
          </div> <!-- end col -->
        </div><!-- container -->
      </div><!-- Page content Wrapper -->
    </div><!-- content -->
    <?php include('footer.php');  } ?>
</html>