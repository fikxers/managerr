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
						$sql="select name from hostel_equipments where room='".$_SESSION['room']."'"; 
						$result = $con->query($sql);; 
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