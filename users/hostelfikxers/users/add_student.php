<?php require('auth.php'); $title ='Resident Registration'; ?>

    <?php include('hmgr_sidebar.php'); ?>
    <?php
		  require('../db.php');
		  if (isset($_POST['register'])){
			$full_name = stripslashes($_REQUEST['name']);
			$email = stripslashes($_REQUEST['email']);			
			$phone = stripslashes($_REQUEST['phone']);
			$dob = stripslashes($_REQUEST['dob']);
			$room_no = stripslashes($_REQUEST['room_no']);			
			$fee = stripslashes($_REQUEST['fee']);
			$gender = stripslashes($_REQUEST['gender']);
			$hostel = $_SESSION['hostel'];
			$address = stripslashes($_REQUEST['address']);
			$password = stripslashes($_REQUEST['password']);
			if( ! ini_get('date.timezone') )
			{
				date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT INTO `residents`(`room_no`, `hostel`, `fee`, `full_name`, `email`, `phone`, `gender`, `dob`, `address`, `date_joined`) VALUES ($room_no,'".$hostel."',$fee,'".$full_name."','".$email."','".$phone."','".$gender."','".$dob."','".$address."','".$trn_date."')";
			$query2 = "INSERT INTO `users`(`email`, `password`, `admin_type`) VALUES ('".$email."','".md5($password)."','student')";
			$result = mysqli_query($con,$query);$result2 = mysqli_query($con,$query2);
			if($result && $result2){
			  echo "<script>alert('Resident Added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='add_student.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Resident not added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='add_student.php';</script>"; exit;
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
                  <div class="form-group col-md-4"><label>Resident's DOB</label><input type="date" name="dob" class="form-control form-control-sm" required /></div>
                  <div class="form-group col-md-4"><label>Resident's Home Address</label><input type="text" name="address" class="form-control" required/></div>
                  <div class="form-group col-md-4"><label>Login Password</label><input type="password" name="password" class="form-control" required/></div>
                  <div class="form-group  col-md-4"><label>Room number</label><input type="number" name="room_no" class="form-control form-control-sm" required /></div>
                  <div class="form-group  col-md-4"><label>Price of Room</label><input type="number" name="fee" min="10000" step="1000" class="form-control form-control-sm" required /></div>
				  <div class="col-md-12 form-group">
					<input type="submit" name="register" value="Register" class="btn btn-primary">
					<input type="reset" value="Reset" class="btn btn-info">
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