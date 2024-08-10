<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require('auth.php'); $title ='Resident Registration';  
include('hmgr_sidebar.php'); require('../db.php');
		  if (isset($_POST['register'])){
			$full_name = stripslashes($_REQUEST['name']);
			$email = stripslashes($_REQUEST['email']);			
			$phone = stripslashes($_REQUEST['phone']);
			$doe = stripslashes($_REQUEST['doe']);
			$room_no = stripslashes($_REQUEST['room_no']);			
			$fee = stripslashes($_REQUEST['fee']);
			$gender = stripslashes($_REQUEST['gender']);
			$hostel = $_SESSION['hostel'];
			//$address = stripslashes($_REQUEST['address']);
			$password = stripslashes($_REQUEST['password']);
			if( ! ini_get('date.timezone') )
			{
				date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT INTO `residents`(`room_no`, `hostel`, `fee`, `full_name`, `email`, `phone`, `gender`, `date_joined`) VALUES ($room_no,'".$hostel."',$fee,'".$full_name."','".$email."','".$phone."','".$gender."','".$doe."')";
			$query2 = "INSERT INTO `users`(`email`, `password`, `admin_type`) VALUES ('".$email."','".md5($password)."','student')";
			$result2 = mysqli_query($con,$query2);
			if($result2){
			  $result = mysqli_query($con,$query);
			  if($result){
			  	$message = '<html><body>';
			  $message .= '<img src="//fikxers.com/hostel/assets/images/users/DEX.png" alt="Kanchies Logo" />';
			  $message .= '<h2>Registration Successful</h2><br>';
			  $message .= '<h2>RESIDENT DETAILS</h2>';
			  $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			  $message .= "<tr style='background: #eee;'><td><strong>Room:</strong> </td><td>".$room_no."</td></tr>";
			  $message .= "<tr><td><strong>Name:</strong> </td><td>".$full_name."</td></tr>";
			  $message .= "<tr><td><strong>Phone:</strong> </td><td>".$phone."</td></tr>";
			  $message .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>".$email."</td></tr>";
			  $message .= "<tr><td><strong>Password:</strong> </td><td>".$password."</td></tr>";
			  $message .= "<tr><td>Login via </td><td><a href='https://fikxers.com/login.php' target='_blank'>Fikxers Login</a></td></tr>";
			  $message .= "</table>";
			  $message .= "</body></html>";
			  //Notify Student//Notify Manager
			  //$subject = "Service Booking Request";
			  $headers = "From: support@fikxers.com \r\n";
			  $headers .= "Reply-To: support@fikxers.com \r\n";
			  //$headers .= "CC: susan@example.com\r\n";
			  $headers .= "MIME-Version: 1.0\r\n";
			  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			  mail($_SESSION['email'], "Kanchies Hostels | Resident Registration", $message, $headers) or die("Error!");
			  mail($email, "Kanchies Hostels | Successful Registration", $message, $headers) or die("Error!");
			    echo "<script>alert('Resident Added.');</script>";
			    echo "<script type='text/javascript'>window.top.location='add_resident.php';</script>"; exit;
			  }
			  else{
			  	echo "<script>alert('Resident not added.');</script>";
			    echo "<script type='text/javascript'>window.top.location='add_resident.php';</script>"; exit;
			  }
			}
			else{
			  echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
			  //echo "<script>alert('Resident not added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='add_resident.php';</script>"; exit;
			}
		  }
		  else{
			//echo "<script>alert('Error');</script>";
		?>
        <div class="row">
		  <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <!--<h4 class="mt-0 header-title">Register Student</h4>-->
                <form class="row" action="" method="POST">
                  <div class="form-group col-md-4"><label>Resident's Name</label><input type="text" name="name" class="form-control form-control-sm" required /></div>
                  <div class="form-group col-md-4"><label>Resident's Email</label><input type="email" name="email" class="form-control form-control-sm" required /></div>
                  <div class="form-group col-md-4"><label>Resident's Phone Number</label><input type="text" name="phone" class="form-control form-control-sm" required /></div>
                  <div class="form-group col-md-4"><label>Gender</label>
                  	<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Male">
					  <label class="form-check-label" for="inlineRadio1">Male</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Female">
					  <label class="form-check-label" for="inlineRadio2">Female</label>
					</div>
				  </div>
                  <div class="form-group col-md-4"><label>Date of Entry</label><input type="date" name="doe" class="form-control form-control-sm" required /></div>
                  <!--<div class="form-group col-md-8"><label>Resident's Home Address</label><input type="text" name="address" class="form-control" required/></div>-->
                  <div class="form-group col-md-4"><label>Login Password</label><input type="password" name="password" class="form-control" required/></div>
                  <div class="form-group  col-md-4"><label>Room number</label><input type="number" name="room_no" class="form-control form-control-sm" required /></div>
                  <div class="form-group  col-md-4"><label>Price of Room</label><input type="number" name="fee" min="10000" step="1000" class="form-control form-control-sm" required /></div>
				  <div class="col-md-4 form-group"><br>
					<input type="submit" name="register" value="Register" class="btn btn-primary">
					<input type="reset" value="Reset" class="btn btn-info">
					<a href="import-csv/residents.php" class="btn btn-success" role="button">Upload CSV</a>
				  </div>
                </form>
              </div>
            </div>
          </div> <!-- end col -->
           </div>
           <!-- end row -->
        </div>
        <!-- container -->
     </div>
    <!-- Page content Wrapper -->
  </div>
  <!-- content -->

<?php include('footer.php'); } ?>
</html>