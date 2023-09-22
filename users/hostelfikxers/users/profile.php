		<?php
          include('auth.php'); $title='My Profile';
          include('room_sidebar.php');
		  require('../db.php');		  
		  if (isset($_POST['accept'])){	
		    //$('input[type="submit"]').attr('disabled', true);
		    $id = $_REQUEST['id'];
			$order_id = $_REQUEST['order_id'];
			$query = "UPDATE `quotess` SET quote_status = 'accepted' where quote_id = $id and order_id=$order_id";
			$query2 = "UPDATE `quotess` SET quote_status = 'rejected' where quote_id != $id and order_id=$order_id";
			$query3 = "UPDATE `orders` SET order_status = 'quote_accepted' where order_id=$order_id";
			$result3 = mysqli_query($con,$query3); $result2 = mysqli_query($con,$query2); $result = mysqli_query($con,$query); 
			if($result){
			  echo "<script>alert('Quote Accepted.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Quote could not be accepted.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
		  }
		  else if (isset($_POST['reject'])){
            $id = $_REQUEST['id'];	$order_id = $_REQUEST['order_id'];	  
			//$query = "UPDATE `quotes` SET status = 'rejected' where flat='".$_SESSION['email']."' and id=$id";
			$query = "UPDATE `quotess` SET quote_status = 'rejected' where quote_id = $id and order_id=$order_id";
			$query2 = "UPDATE `orders` SET order_status = 'quote_rejected' where order_id=$order_id";
			$result = mysqli_query($con,$query); $result2 = mysqli_query($con,$query2);
			if($result){
			  echo "<script>alert('Quote Rejected.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
			else{
			  $error=mysqli_error($con);
			  echo '<script type="text/javascript">alert("'.$error.'");</script>';
			  //echo "<script>alert('Quote could not be rejected.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
		  }
		  else if (isset($_POST['confirm'])){
			//echo "<script>alert('Confirmation.');</script>";
            $id = $_REQUEST['id'];	$order_id = $_REQUEST['order_id'];	  
			//$query = "UPDATE `quotes` SET status = 'rejected' where flat='".$_SESSION['email']."' and id=$id";
			$query = "UPDATE `quotess` SET quote_status = 'confirmed' where quote_id = $id and order_id=$order_id";
			$query2 = "UPDATE `orders` SET order_status = 'confirmed' where order_id=$order_id";
			$result = mysqli_query($con,$query); $result2 = mysqli_query($con,$query2);
			if($result){
			  echo "<script>alert('Confirmation Complete.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
			}
			else{
			  //$error=mysqli_error($con);
			  //echo '<script type="text/javascript">alert("'.$error.'");</script>';
			  echo "<script>alert('Error in Confirmation.');</script>";
			  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
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
                  <?php $email = $_SESSION['email']; 
                    $query = "SELECT * FROM `residents` WHERE email ='$email'";
                    $result = $con->query($query);
					if ($result->num_rows > 0) { 
					  while($row = $result->fetch_assoc()) { ?>
                  <form class="" action="" method="POST">
                    <div class="form-group">
                      <label>Full name: </label>
                      <input data-parsley-type="number" type="text" name="fullname" class="form-control" required value="<?php echo $row['full_name']; ?>" />
                    </div>
					<div class="form-group">
					  <label>Gender:</label>
                      <select class="form-control" name="gender" >
					    <option value="Male">Male</option><option value="Female">Female</option>
					    </select>
                    </div>
					<div class="form-group">
                      <div>
                      	<label>Phone: </label>
                        <input name="phone" type="text" class="form-control" required value="<?php echo $row['phone']; ?>" />
                      </div>
                    </div>
					<div class="form-group">
                      <div>
                      	<label>Email: </label>
                        <input name="email" type="text" class="form-control" required value="<?php echo $row['email']; ?>" disabled/>
                      </div>
                    </div> 
                    <div class="form-group">
                      <div>
                        <button type="submit" class="btn btn-info waves-effect waves-light">Update Profile</button>
                        <!--<button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button>-->
                      </div>
                    </div>
                    <?php }    } $con->close();  ?>
                  </form><hr>
				  <form class="" action="" method="POST">
                    <div class="form-group">
                      <label>Old Password: </label>
                      <input data-parsley-type="number" type="password" name="old_password" class="form-control" required/>
                    </div>
					<div class="form-group">
					  <label>New Password:</label>
                      <input data-parsley-type="number" type="password" name="new_password" class="form-control" required />
                    </div>
					<div class="form-group">
                      <div>
                      	<label>Confirm Password: </label>
                        <input name="confirm_password" type="password" class="form-control" required/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div>
                        <button type="submit" class="btn btn-info waves-effect waves-light">Update Password</button>
                        <button type="reset" class="btn btn-success waves-effect m-l-5">Cancel</button>
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