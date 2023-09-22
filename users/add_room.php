<?php require('auth.php'); $title ='Add Room'; ?>

    <?php include('hmgr_sidebar.php'); ?>
    <?php
		  require('../db.php');
		  if (isset($_POST['send4quotes'])){
			$description = stripslashes($_REQUEST['description']);
			$skill = stripslashes($_REQUEST['skill']);			
			$service_id = stripslashes($_REQUEST['service_id']);
			$query = "UPDATE orders SET required_skill = '$skill', order_status = 'quote_requested', mgr_description='$description' WHERE order_id=$service_id";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Quote requested.');</script>";
			  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Quote Request not successful.');</script>";
			  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
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
                <!--INSERT INTO `rooms`(`id`, `room_no`, `no_of_students`, `hostel`, `fee`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])-->
                <form class="" action="" method="POST">
                  <div class="form-group"><input type="text" name="room_no" class="form-control" required placeholder="Room number"/></div>
                  <div class="form-group">
					<select class="form-control" name="status" >
					  <option value="">No. of students</option><option value="1">1</option>
					  <option value="2">2</option><option value="4">4</option>
					</select>
                  </div>
                  <div class="form-group"><input type="number" name="number" min="10000" step="1000" class="form-control" required placeholder="Fee"/></div>
                  <div class="row">
					<div class="col-md-4 form-group">
					  <input type="submit" value="Add Room" class="btn btn-primary">
					  <input type="reset" value="Reset" class="btn btn-info">
					</div>
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