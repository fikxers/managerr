<?php require('../users/auth.php'); $title ='My Events'; 
include('sidebar.php'); require('../db.php');
$estate_code = $_SESSION['estate']; $_SESSION['msg'] =""; $msg = "";
$_SESSION['show']= 0; $v=""; $code=""; $comp=0; $regno="";

if (isset($_POST['vcode'])){ //if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $code = $_REQUEST['code'];
  $sql = "SELECT * FROM entrance_codes where code='".$code."'";
  $result = $con->query($sql); $resident = 'Flat ';
  if ($result->num_rows > 0) { 
    $_SESSION['show']=1; 
  	while($row = $result->fetch_assoc()) {
	  if ($row['status'] != 'invite'){
		echo "<script>alert('This code has expired.');</script>";
		echo "<script type='text/javascript'>window.top.location='index.php';</script>";
	  }
  	  $v=$row['visitor']; $comp=$row['comp']; $regno=$row['reg_no']; $arr_date=$row['arr_date']; $arr_time=$row['arr_time']; $resident .= $row['flat']. ', Block '.$row['flat']; $id = $row['id'];
  	}
  	if( ! ini_get('date.timezone') ) { date_default_timezone_set('Africa/Lagos'); } $trn_date = date("Y-m-d H:i:s");
   $query = "UPDATE entrance_codes set status='signed-in', signin='".$trn_date."', security='".$_SESSION['secname']."' WHERE id = $id";
   $result2 = mysqli_query($con,$query); 
   $r='Code: '.strtoupper($code).'\nVisitor: '.$v.'\nVehicle Reg No.: '.$regno.'\nNo. of companions: '.$comp.'\nArrival Date: '.$arr_date.'\nExpected Time: '.$arr_time.'\nResident to visit: '.$resident;
	
   //$_SESSION['msg'] = '<div class="row"><div class="col-lg-12"><div class="alert alert-success" role="alert">'.$r.'</div></div></div>';
   //$id = $_REQUEST['id']; 
   //echo '<script type="text/javascript">alert("'.$query.'");</script>';
   echo '<script type="text/javascript">alert("'.$r.'");</script>';
   echo "<script type='text/javascript'>window.top.location='index.php';</script>";
  }
  else{
	//$_SESSION['msg'] = "Invalid code.";//$msg	= '<div class="row"><div class="col-lg-12"><div class="alert alert-danger" role="alert">Invalid code.</div></div></div>';
	//$msg = "<h3 style='color: red'>Invalid code.</h3>";
  	//echo '<script type="text/javascript">alert("'.$msg.'");</script>';
	echo "<script>swal('Invalid code');</script>"; //<script>alert('Invalid code.');</script>
	echo "<script type='text/javascript'>window.top.location='index.php';</script>";
  }
}

else{
?>
				<div class="row">
				  <div class="col-md-12">
						<div class="card m-b-30">
		          <div class="card-body">
							  <h6>Upcoming Events</h6>
							  <?php 
								  include ('../db.php'); $i=1;
	                $sql = "SELECT * FROM events where created_by='".$_SESSION['email']."' and event_date >= CURDATE()";
									$result = $con->query($sql);
									if ($result->num_rows > 0) {
								?>
								<div class="table-responsive b-0" data-pattern="priority-columns">
								  <table class="table" style="width: 100%;">
									  <thead>
									    <tr>
									      <th scope="col">#</th>
									      <th scope="col">Title</th>
									      <th scope="col">Event Date</th>
									      <th scope="col">Event Address</th>
									      <th scope="col">Event Colour(s)</th>
									      <th scope="col">Action</th>
									    </tr>
									  </thead>
									  <tbody>
									  	<?php while($row = $result->fetch_assoc()) { ?>
									    <tr>
									      <th scope="row"><?php echo $i; ?></th>
									      <td><?php echo $row['title']; ?></td>
									      <td><?php echo $row['event_date']; ?></td>
									      <td><?php echo $row['address']; ?></td>
									      <td><?php echo $row['colours']; ?></td><?php echo "<td><a href='invites.php?event=".$row['id']."' data-toggle='tooltip' class='text-success'>Invited Guests</a></td>"; ?>
									    </tr>
									  	<?php $i++; } ?>
									    <!-- <tr>
									      <th scope="row">2</th>
									      <td>Retirement Party</td>
									      <td>2nd December, 2023</td>
									      <td>ECWA Church, Sauka</td>
									      <td>Gray</td><?php echo "<td><a href='update_flat.php?id=2' data-toggle='tooltip' class='text-success'>Send Invite</a></td>"; ?>
									    </tr> -->
									  </tbody>
									</table>
								</div>
								<?php 
									}else{
										echo '<div class="alert alert-danger" role="alert">No Upcoming Event.</div>';
									}
								?>
						  </div>
		        </div>
				  </div>
				  <!-- <div class="col-lg-6 col-md-6">
						<div class="card m-b-30">
		          <div class="card-body">
							  <h6>Staff Entry Validation</h6>  
							  <table class="table">
								  <thead>
								    <tr>
								      <th scope="col">#</th>
								      <th scope="col">First</th>
								      <th scope="col">Last</th>
								      <th scope="col">Handle</th>
								    </tr>
								  </thead>
								  <tbody>
								    <tr>
								      <th scope="row">1</th>
								      <td>Mark</td>
								      <td>Otto</td>
								      <td>@mdo</td>
								    </tr>
								    <tr>
								      <th scope="row">2</th>
								      <td>Jacob</td>
								      <td>Thornton</td>
								      <td>@fat</td>
								    </tr>
								    <tr>
								      <th scope="row">3</th>
								      <td colspan="2">Larry the Bird</td>
								      <td>@twitter</td>
								    </tr>
								  </tbody>
								</table>
						  </div>
		        </div>
				  </div> -->
        </div><!-- end row -->
      </div><!-- container -->
    </div><!-- Page content Wrapper -->
  </div><!-- content -->
  <?php include('footer.php'); } ?>
</html>