<?php require('auth.php'); require('../db.php');
	  if (isset($_GET['hotel_code']) && isset($_GET['hotel_name'])){
	  	$hotel_code = $_GET['hotel_code']; $title = $hotel_name = $_GET['hotel_name'];
	  }
	  else{ 
	  	switch ($_SESSION['admin_type']) {
				case "admin":
				  echo "<script type='text/javascript'>window.top.location='view_hotels.php';</script>"; exit;
				  break;
				default:
				  echo "<script type='text/javascript'>window.top.location='hotel_mgr.php';</script>"; exit;
			}
	  	
	  }
	  $msg = $query = "";
	  if (isset($_POST['task'])){
	  	if($_POST['task'] == 'addroom'){
			  $guest = stripslashes($_REQUEST['guest']);$room_no = stripslashes($_REQUEST['room_no']);
			  $fee = stripslashes($_REQUEST['fee']); $desc = stripslashes($_REQUEST['desc']);
			  //$from_date=stripslashes($_REQUEST['from']); $to_date=stripslashes($_REQUEST['to']);
			  $query = "INSERT into `hotel_rooms` (room_no,hotel,fee,description,guest) VALUES ('$room_no','$hotel_code',$fee,'$desc',$guest)";
			  $msg = "Room"; 
			}
			else{
				$name = stripslashes($_REQUEST['name']);$email = stripslashes($_REQUEST['email']);
			  $phone = stripslashes($_REQUEST['phone']); $sex = stripslashes($_REQUEST['sex']);
			  $dob=stripslashes($_REQUEST['dob']); $address=stripslashes($_REQUEST['address']);
			  $query = "INSERT into `guests` (guest,email,phone,gender,dob,address,hotel) VALUES ('$name','$email',$phone,'$sex','$dob','$address','$hotel_code')";
			  $msg = "Guest"; 
			}
		  $result = mysqli_query($con,$query);
			if($result){
				echo "<script>alert('".$msg." added successfully.');</script>";
			  echo "<script type='text/javascript'>window.top.location='hotel_room.php';</script>"; exit;
			}
			else {
			  echo "<script>alert('Error adding ".$msg.".');</script>";
			  echo "<script type='text/javascript'>window.top.location='hotel_room.php';</script>";
			}
	  }
	  else{
		  if($_SESSION['admin_type']=='admin'){
		    include('admin_sidebar.php'); 
		  }
	    else if($_SESSION['admin_type']=='hotelmgr'){
		    include('hmgr_sidebar.php');
		  }
		?>
    <div class="page-content-wrapper ">
      <div class="container-fluid">
				<div class="row">       
		  		<div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <h4 class="mt-0 header-title">Rooms in <?php echo $title; ?></h4>
                <button type='button' class='btn btn-success btn-sm' style='border-radius: 10px; float: right;' data-toggle='modal' data-target='#assetmodal' data-original-title='Add Room'><i class='fa fa-plus'></i><b> Add Room</b></button>
                <button type='button' class='btn btn-primary btn-sm mr-3' style='border-radius: 10px; float: right;' data-toggle='modal' data-target='#guestmodal' data-original-title='Add Guest'><i class='fa fa-user-plus'></i><b> Add Guest</b></button>
                <!-- Add Room Modal -->
								<div class="modal fade" id="assetmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
									  <div class="modal-content">
											<div class="modal-header">
											  <h5 class="modal-title" id="exampleModalLongTitle">Add new room</h5>
											  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
											  </button>
											</div>
											<div class="modal-body">
												<?php include ('../db.php');
												$sql = "SELECT * FROM guests where hotel='$hotel_code'"; $result = $con->query($sql);
		                    if ($result->num_rows > 0) { ?>
										    <form class="" action="" method="POST">
						              <div class="form-group">
						              	<label>Room # <span class="text-danger">*</span></label>
						                <input type="text" name="room_no" class="form-control" required placeholder="401"/>
						              </div>
									  			<div class="form-group">
									  				<label>Room Fee <span class="text-danger">*</span></label>
						                <input data-parsley-type="fee" name="fee" min="5000" step="1000" type="number" class="form-control" required placeholder="5000"/>
						              </div>
						              <div class="form-group">
									  				<label>Room Description</label>
						                <textarea class="form-control" name="desc" placeholder="Deluxe King Suite"></textarea>
						              </div>
						              <div class="form-group">
						              	<label>Select Guest</label>
						              	<div class="form-group">
														  <select class="form-control" required name="guest" >
														    <?php include ('../db.php');
																$sql="select * from guests where hotel = '".$hotel_code."'"; 
														    $result = $con->query($sql); 
														    while($row = $result->fetch_assoc()) { 
														    ?>
														    <option value="<?php echo $row['id']; ?>"><?php echo $row['guest']; ?></option><?php } ?>
														  </select>
														</div>
						              </div>
						              <div class="form-group">
						              	<input type="hidden" name="task" value="addroom" />
						                <button type="submit" name="addroom" class="btn btn-primary waves-effect waves-light">Add New Room</button>
						                <button type="reset" class="btn btn-secondary waves-effect m-l-5">Reset Form</button></div>
						            </form>
						            <?php } else { echo "Please add a guest first."; }
												$con->close(); ?>
											</div>
									  </div>
									</div>
								</div>
								<!-- /Add Room Modal -->
								<!-- Add Guest Modal -->
								<div class="modal fade" id="guestmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
									  <div class="modal-content">
											<div class="modal-header">
											  <h5 class="modal-title" id="exampleModalLongTitle">Add new guest</h5>
											  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
											  </button>
											</div>
											<div class="modal-body">
										    <form class="" action="" method="POST">
						              <div class="form-group">
						              	<label>Guest's name <span class="text-danger">*</span></label>
						                <input type="text" name="name" class="form-control" required placeholder="Michael Jackson"/>
						              </div>
									  			<div class="form-group">
									  				<label>Guest's Email </span></label>
						                <input type="email" name="email" class="form-control" placeholder="mjackson@yahoo.com"/>
						              </div>
						              <div class="form-group">
						              	<label>Guest's Phone number <span class="text-danger">*</label>
						                <input type="text" name="phone" class="form-control" required placeholder="09011223344"/>
						              </div>
						              <div class="form-group">
									  				<label>Guest's Sex <span class="text-danger">*</span></label>
						                <select name="sex" class="form-control" ><option value="Male">Male</option><option value="Female">Female</option></select>
						              </div>
						              <div class="form-group">
						              	<label>Guest's DOB</label>
						                <input type="date" name="dob" class="form-control" />
						              </div>
						              <div class="form-group">
									  				<label>Guest's Contact Address</label>
						                <textarea class="form-control" name="address" placeholder="H5, MJ Street,X Town"></textarea>
						              </div>
						              <div class="form-group">
						              	<input type="hidden" name="task" value="addguest" />
						                <button type="submit" name="addguest" class="btn btn-primary waves-effect waves-light">Add New Guest</button>
						                <button type="reset" class="btn btn-secondary waves-effect m-l-5">Reset Form</button></div>
						            </form>
											</div>
									  </div>
									</div>
								</div>
								<!-- /Add Guest Modal -->
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
										$sql = "SELECT * FROM hotel_rooms h JOIN guests g on h.guest=g.id where h.hotel='$hotel_code'"; 
										$result = $con->query($sql);
                    if ($result->num_rows > 0) { ?>
										<table id="tech-companies-1" class="table table-bordered">
                    	<thead class="titles"><tr><th>Room #</th><th>Fee</th>
                      <th>Guest</th><th>Check-in</th><th>Check-out</th><th>Action</th></tr></thead>
	                    <tbody> <?php while($row = $result->fetch_assoc()) { ?>
										  <tr><td><?php echo $row['room_no']; ?></td>
											<td><?php echo $row['fee']; ?></td>
											<td><?php echo $row['guest']; ?></td>
											<td><?php echo $row['from_date']; ?></td>
											<td><?php echo $row['to_date']; ?></td>
											<?php echo '<td><button type="button" class="btn btn-success btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-toggle="modal" data-target="#editmodal-'.$row['id'].'" data-original-title="Edit" title="Check-in Guest"><i class="fa fa-sign-in text-success"></i></button>&emsp;<button type="button" class="btn btn-danger text-danger btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#delmodal-'.$row['id'].'" data-original-title="Delete" title="Check-out Guest"><i class="fa fa-sign-out text-danger"></i></button></td>'; ?>
											</tr>
										  <?php } } else { echo "No room added in this hotel."; }
											$con->close(); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- end col -->
        </div><!-- container -->
      </div><!-- Page content Wrapper -->
    </div><!-- content -->
    <?php include('footer.php');  } ?>
</html>