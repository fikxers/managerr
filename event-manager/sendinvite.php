<?php require('../users/auth.php'); $title ='Send Invite'; 
include('sidebar.php'); require('../db.php');
//$estate_code = $_SESSION['estate']; $_SESSION['msg'] =""; $msg = "";
//$_SESSION['show']= 0; $v=""; $code=""; $comp=0; $regno="";
$permitted_chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ'; //'0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
function generate_string($input, $strength = 16) {
  $input_length = strlen($input);
  $random_string = '';
  for($i = 0; $i < $strength; $i++) {
    $random_character = $input[mt_rand(0, $input_length - 1)];
    $random_string .= $random_character;
  }
  return $random_string;
}
if (isset($_POST['send'])){
  $title = $_REQUEST['title']; $full_name = $_REQUEST['full_name']; $companions = $_REQUEST['companions']; 
  $table = $_REQUEST['category']; $event = $_REQUEST['event']; $code = generate_string($permitted_chars, 5);
  $email = $_REQUEST['email']; $phone = $_REQUEST['phone'];
  //also insert code to db
	$query = "INSERT INTO `event_invites`(`title`, `full_name`,`phone`, `email`, `companions`, `designated_table`, `event`) VALUES ('$title','$full_name','$phone','$email',$companions,'$table',$event)";
	$r = mysqli_query($con,$query); 
	if($r){
	  echo "<script>alert('Invite sent successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='../qrcode/event.php?title=".$title."&name=".$full_name."&companions=".$companions."&table=".$table."&code=".$code."';</script>"; 
	  echo "<script type='text/javascript'>window.top.location='sendinvite.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error. Please try again.');</script>";
	  echo "<script type='text/javascript'>window.top.location='sendinvite.php';</script>"; exit;
	}
}
else{
?>
			<div class="row">
			  <div class="col-lg-12">
					<div class="card m-b-30">
	          <div class="card-body">
	          	<!-- <h4>Add Event</h4>
	          	1. Title
							2. Full Name
							3. Companion
							4. Designated Table (to be filled by the celebrant)

							CREATE TABLE `realeoki_fikxers`.`event_invites` ( `id` INT NOT NULL , `title` VARCHAR(50) NOT NULL , `full_name` VARCHAR(100) NOT NULL , `companions` INT NOT NULL , `designated_table` VARCHAR(50) NOT NULL , `event` INT NOT NULL ) ENGINE = InnoDB;
							ALTER TABLE `event_invites` ADD `phone` VARCHAR(20) NOT NULL AFTER `full_name`, ADD `email` VARCHAR(100) NOT NULL AFTER `phone`;
							-->
							<?php 
							  include ('../db.php'); 
                $sql = "SELECT id,title,event_date FROM events where created_by='".$_SESSION['email']."'";
								$result = $con->query($sql);
								if ($result->num_rows > 0) {
							?>
							<a href="import-csv/"><button type='button' class='btn btn-danger btn-sm mb-3' data-toggle='modal' data-target="#activatemodal" data-original-title="Activate Resident">Import CSV</button></a>
	          	<form method="POST" action="">
							  <div class="mb-3">
							    <label for="title" class="form-label">Title</label>
							    <input type="text" placeholder="HRH" class="form-control-sm form-control" name="title">
							  </div>
							  <div class="mb-3">
							    <label for="sub-title" class="form-label">Full Name</label>
							    <input type="text" placeholder="Jasper Oyelowo" class="form-control-sm form-control" name="full_name">
							  </div>
							  <div class="mb-3">
							    <label for="title" class="form-label">Phone</label>
							    <input type="text" placeholder="09019002213" class="form-control-sm form-control" name="phone" required>
							  </div>
							  <div class="mb-3">
							    <label for="sub-title" class="form-label">Email</label>
							    <input type="text" placeholder="jasperoyelowo@yahoo.com" class="form-control-sm form-control" name="email">
							  </div>
							  <div class="mb-3">
							    <label for="eventdate" class="form-label">Companions</label>
							    <input type="number" class="form-control-sm form-control" min="0" name="companions">
							  </div>
							  <div class="mb-0">
							    <label for="category" class="form-label">Guest Category</label>
							    <!-- <input type="text" class="form-control-sm form-control" name="table"> -->
								</div>
							  <div class="mb-3">
							    <div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="category" id="radio1" value="Special Guest">
									  <label class="form-check-label" for="radio1">Special Guest</label>
									</div>
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="category" id="radio2" value="Event Staff">
									  <label class="form-check-label" for="radio2">Event Staff</label>
									</div>
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="category" id="radio3" value="Table 1">
									  <label class="form-check-label" for="radio3">Table 1</label>
									</div>
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="category" id="radio4" value="Table 2">
									  <label class="form-check-label" for="radio4">Table 2</label>
									</div>
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="category" id="radio5" value="Table 3">
									  <label class="form-check-label" for="radio5">Table 3</label>
									</div>
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="category" id="radio6" value="Table 4">
									  <label class="form-check-label" for="radio6">Table 4</label>
									</div>
									<div class="form-check form-check-inline">
									  <input class="form-check-input" type="radio" name="category" value="Others" id="others" onclick="myFunction()">
									  <label class="form-check-label" for="others">Others</label>
									</div>
							  </div>
							  <div class="mb-3" style="display:none" id="text">
							  	<input type="text" class="form-control-sm form-control" name="category" placeholder="Category">
							  </div>
							  <div class="mb-3">
							    <select class="common-input mb-20 form-control form-control-sm" required name="event" >
										<option value="">Select Event</option>
										<?php $res = $con->query($sql);; 
										while($row = $res->fetch_assoc()) { ?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['title']."-".$row['event_date']; ?></option><?php } ?>
									</select>
							  </div>
							  <button type="submit" name="send" class="btn btn-primary btn-sm">Send Invite</button>
							</form>
							<?php 
								}else{
									echo '<div class="alert alert-danger" role="alert">Add an event to be able to send an invite.</div>';
								}
							?>
				  	</div>
	        </div>
			  </div>
      </div><!-- end row -->
      </div><!-- container -->
    </div><!-- Page content Wrapper -->
  </div><!-- content -->
  <?php include('footer.php'); } ?>
</html>