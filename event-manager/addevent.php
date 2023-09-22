<?php require('../users/auth.php'); $title ='Add Event'; 
include('sidebar.php'); require('../db.php');
// $estate_code = $_SESSION['estate']; $_SESSION['msg'] =""; $msg = "";
// $_SESSION['show']= 0; $v=""; $code=""; $comp=0; $regno="";
if (isset($_POST['add'])){
  $title = $_REQUEST['title']; $subtitle = $_REQUEST['subtitle']; $event_date = $_REQUEST['eventdate']; 
  $address = $_REQUEST['address']; $landmark = $_REQUEST['landmark']; $colour = $_REQUEST['colour']; $rsvp = $_REQUEST['rsvp'];
	$query = "INSERT INTO `events`(`title`, `subtitle`, `event_date`, `address`, `landmark`, `colours`, `rsvp`, `created_by`) VALUES ('$title','$subtitle','$event_date','$address','$landmark','$colour','$rsvp','".$_SESSION['email']."')";
	$r = mysqli_query($con,$query); 
	if($r){
	  echo "<script>alert('Event created successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='addevent.php';</script>"; exit;
	}
	else{
	  // echo "<script>alert('Error creating event. Please try again.');</script>";
	  $error=mysqli_error($con);
		echo '<script type="text/javascript">alert("Error: '.$error.'");</script>';
	  echo "<script type='text/javascript'>window.top.location='addevent.php';</script>"; exit;
	}
}
else{
?>
			<div class="row">
			  <div class="col-lg-12">
					<div class="card m-b-30">
	          <div class="card-body">
	          	<!-- <h4>Add Event</h4>
	          	1. Title of Party
							2. Any special sub-title
							3. Date and Time of event 
							4. Address of Event
							5. Landmark
							6. Color of the Day
							7. RSVP 

							CREATE TABLE `realeoki_fikxers`.`events` ( `id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(50) NOT NULL , `subtitle` VARCHAR(100) NOT NULL , `event_date` DATETIME NOT NULL , `address` VARCHAR(200) NOT NULL , `landmark` VARCHAR(50) NOT NULL , `colours` VARCHAR(100) NOT NULL , `rsvp` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
							ALTER TABLE `events` ADD `created_by` VARCHAR(50) NOT NULL AFTER `rsvp`;
							-->
	          	<form method="POST" action="">
							  <div class="mb-3">
							    <label for="title" class="form-label">Title of Event</label>
							    <input type="text" class="form-control-sm form-control" placeholder="My Golden Jubilee Party" name="title" aria-describedby="emailHelp">
							  </div>
							  <div class="mb-3">
							    <label for="subtitle" class="form-label">Any special sub-title</label>
							    <input type="text" placeholder="Celebration of 50 beautiful years" class="form-control-sm form-control" name="subtitle">
							  </div>
							  <div class="mb-3">
							    <label for="eventdate" class="form-label">Date and Time of event</label>
							    <input type="datetime-local" class="form-control-sm form-control" name="eventdate">
							  </div>
							  <div class="mb-3">
							    <label for="address" class="form-label">Address of Event</label>
							    <input type="text" class="form-control-sm form-control" placeholder="House 1, Peace Avenue, Ikota" name="address">
							  </div>
							  <div class="mb-3">
							    <label for="landmark" class="form-label">Landmark</label>
							    <input type="text" class="form-control-sm form-control" placeholder="Total Filling Station" name="landmark">
							  </div>
							  <div class="mb-3">
							    <label for="colour" class="form-label">Colour(s) of the Day</label>
							    <!-- <input type="color" class="form-control-sm form-control" name="colour"> -->
							    <input type="text" class="form-control-sm form-control" placeholder="Blue, Grey" name="colour">
							  </div>
							  <div class="mb-3">
							    <label for="rsvp" class="form-label">RSVP</label>
							    <input type="text" class="form-control-sm form-control" placeholder="07021990012, 09019220011" name="rsvp">
							  </div>
							  <!-- <div class="mb-3 form-check">
							    <input type="checkbox" class="form-check-input" id="exampleCheck1">
							    <label class="form-check-label" for="exampleCheck1">Check me out</label>
							  </div> -->
							  <button type="submit" name="add" class="btn btn-primary">Add Event</button>
							</form>
				  	</div>
	        </div>
			  </div>
      </div><!-- end row -->
      </div><!-- container -->
    </div><!-- Page content Wrapper -->
  </div><!-- content -->
  <?php include('footer.php'); } ?>
</html>