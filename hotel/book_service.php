		<?php
          include('auth.php'); $title='Book Service';
          include('room_sidebar.php');
		  require('../db.php');		  
		  if (isset($_POST['book'])){	
		    $id = $_REQUEST['id'];
			$service = $_REQUEST['service'];
			$service_date = $_REQUEST['service_date'];
			$moreinfo = $_REQUEST['moreinfo'];
			$equipment = $_REQUEST['equipment'];
			$query = "INSERT INTO `student_requests`(`service`, `equipment`, `service_date`,`info`,`hostel`,`room`,`status`) VALUES ('".$service."','".$equipment."','".$service_date."','".$moreinfo."','".$_SESSION['hostel']."',".$_SESSION['room'].",'Pending')";
			$result = mysqli_query($con,$query); 
			if($result){
			  //require('functions.php');
			  $q = "SELECT email FROM `hostel_manager` WHERE hostel='".$_SESSION['hostel']."'";
			  $r = mysqli_query($con,$q) or die(mysql_error());
			  $hemail = $r->fetch_object()->email; $r=$_SESSION['room'];
			  //echo $hemail;
			  //notify_admins($service,$service_date,$moreinfo,$equipment,$_SESSION['room'],$_SESSION['hostel']); 
			  $message = '<html><body>';
			  $message .= '<img src="//fikxers.com/hostel/assets/images/users/DEX.png" alt="Kanchies Logo" />';
			  $message .= '<h2>REQUEST SUMMARY</h2>';
			  $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			  $message .= "<tr style='background: #eee;'><td><strong>Room:</strong> </td><td>".$r."</td></tr>";
			  $message .= "<tr style='background: #eee;'><td><strong>Service:</strong> </td><td>".$service."</td></tr>";
			  $message .= "<tr><td><strong>Service Date:</strong> </td><td>".$service_date."</td></tr>";
			  $message .= "<tr><td><strong>Asset:</strong> </td><td>".$equipment."</td></tr>";
			  $message .= "<tr><td><strong>More Info:</strong> </td><td>".$moreinfo."</td></tr>";
			  $message .= "</table>";
			  $message .= "</body></html>";
			  //Notify Student//Notify Manager
			  $recipient = $admin_email;
			  //$subject = "Service Booking Request";
			  $headers = "From: support@fikxers.com \r\n";
			  $headers .= "Reply-To: support@fikxers.com \r\n";
			  //$headers .= "CC: susan@example.com\r\n";
			  $headers .= "MIME-Version: 1.0\r\n";
			  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			  mail($_SESSION['email'], "Kanchies Hostels | Your Booking Request", $message, $headers) or die("Error!");
			  mail($hemail, "Kanchies Hostels | Booking Request", $message, $headers) or die("Error!");
			  // notify_admin($_SESSION['email'], $message, "Kanchies Hostels | Your Booking Request");
			  // notify_admin($hemail, $message, "Kanchies Hostels | Booking Request");
			  echo "<script>alert('Booking received.');</script>";
			  echo "<script type='text/javascript'>window.top.location='book_service.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Booking was not received.');</script>";
			  echo "<script type='text/javascript'>window.top.location='book_service.php';</script>"; exit;
			}
		  }
		  else{
			//echo "<script>alert('Error');</script>";
		?>
        <div class="row">
		    <div class="col-lg-12">
              <div class="card m-b-30">
                <div class="card-body">
                  <!--<h4 class="mt-0 header-title">All Repairs</h4>-->
                  <form class="" action="" method="POST">
                    <div class="form-group">
                      <label>Select Equipment</label>

					  <select class="form-control" required name="equipment" >
						<?php 
						//$sql="select name from hostel_equipments where room='".$_SESSION['room']."'";
						$room_no = 'Room '.$_SESSION['room'];
        				$sql = "SELECT * FROM hostel_assets where location = '".$room_no."' and hostel = '".$_SESSION['hostel']."'";
						$result = $con->query($sql);
						while($row = $result->fetch_assoc()) { ?>
						<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option><?php } ?>
					  </select>
					</div>
					<div class="form-group">
                      <label>Select Service Category</label>
					  <select class="form-control" required name="service" >
						<?php 
						$sql="select service_name from hostelservices where hostel='".$_SESSION['hostel']."'"; 
						$result = $con->query($sql);; 
						while($row = $result->fetch_assoc()) { ?>
						<option value="<?php echo $row['service_name']; ?>"><?php echo $row['service_name']; ?></option><?php } ?>
					  </select>
					</div>
                    <div class="form-group">
                      <label>Preferred date</label>
                      <input data-parsley-type="number" type="date" name="service_date" class="form-control" required />
                    </div>
					<div class="form-group">
                      <label for="exampleFormControlTextarea1">More Info</label>
    				  <textarea class="form-control" name="moreinfo" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <div>
                        <button type="submit" name="book" class="btn btn-primary waves-effect waves-light">Book</button>
                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button>
                      </div>
                    </div>
                  </form>
                </div>
               </div>
            </div>
		</div>
        <!-- container -->
 	</div>
 	<!-- Page content Wrapper -->
</div>
<!-- content -->
<?php include('footer.php'); } ?>
</html>