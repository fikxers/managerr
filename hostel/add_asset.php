<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
      require('auth.php'); $title ='Add Asset';  
      include('hmgr_sidebar.php'); 
		  require('../db.php');
		  if (isset($_POST['add'])){
			$name = stripslashes($_REQUEST['name']);
			$status = stripslashes($_REQUEST['status']);			
			$location = stripslashes($_REQUEST['location']);
			$query = "INSERT INTO `hostel_assets`(`name`, `status`, `location`, `hostel`) VALUES ('".$name."','".$status."','".$location."','".$_SESSION['hostel']."')";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Equipment added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='add_equipment.php';</script>"; exit;
			}
			else{
			  //echo "<script>alert('".mysqli_error($con)."');</script>";
        echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        //echo "<script>alert('Equipment not added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='add_equipment.php';</script>"; exit;
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
               <div class="row">
                <div class="col-lg-12">
                <form action="" method="POST">
                  <label>Add Asset</label>
                  <div class="form-group"><input type="text" name="name" class="form-control" required placeholder="Name of asset"/></div>
                  <div class="form-group"><input type="text" name="status" class="form-control" required placeholder="State of asset"/></div>
                  <div class="form-group">
          					<select class="form-control" name="location" >
                      <option value="">Location</option>
                      <?php 
                      $sql = "SELECT * FROM hostel_locations where hostel = '".$_SESSION['hostel']."'"; 
                      $result = $con->query($sql); 
                      while($row = $result->fetch_assoc()) { ?>
                      <option value="<?php echo $row['location']; ?>"><?php echo $row['location']; ?></option><?php }  
                      $sql="select room_no from residents where hostel='".$_SESSION['hostel']."'"; 
                      $result = $con->query($sql); 
                      while($row = $result->fetch_assoc()) { ?>
                      <option value="<?php echo 'Room '.$row['room_no']; ?>"><?php echo 'Room '.$row['room_no']; ?></option><?php } ?>
          					</select>
                  </div>
        				  <div class="form-group">
        					  <input type="submit" name="add" value="Add Asset" class="btn btn-primary">
        					  <input type="reset" value="Reset" class="btn btn-info">
                    <a href="import-csv/index.php" class="btn btn-success" role="button">Upload CSV</a>
        				  </div>
                </form>
                </div>
               </div>
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