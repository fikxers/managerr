<?php require('auth.php'); $title ='Hostel Locations'; ?>

    <?php include('hmgr_sidebar.php'); ?>
    <?php
		  require('../db.php');
		  if (isset($_POST['add'])){
			$service = stripslashes($_REQUEST['location']);
			$query = "INSERT INTO `hostel_locations`(`location`,`hostel`) VALUES ('".$service."','".$_SESSION['hostel']."')";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Location added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='hostel_locations.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Location not added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='hostel_locations.php';</script>"; exit;
			}
		  }
		  else{
			//echo "<script>alert('Error');</script>";

		?>
        <div class="row">
		  <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <!--<h4 class="mt-0 header-title">View Rooms</h4>-->
                <form class="" action="" method="POST">
                  <div class="row">
                  	<div class="col-md-8 form-group"><input type="text" name="location" class="form-control" required placeholder="Location"/></div>
					<div class="col-md-4 form-group">
					  <input type="submit" name="add" value="Add" class="btn btn-primary">
					  <input type="reset" value="Reset" class="btn btn-info">
					</div>
				  </div>
                </form>
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
					$sql = "SELECT * FROM hostel_locations where hostel = '".$_SESSION['hostel']."'";
					$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
					  <table id="tech-companies-1" class="table table-bordered table-striped m-b-0">
                        <thead>
                          <tr class="titles">
                          	<th>S/No</th><th>Location</th><th>Action</th>
							<?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?>
                          </tr>
                        </thead>
                        <tbody> <?php
						while($row = $result->fetch_assoc()) { ?>
						<tr><td><?php echo $row['id']; ?></td>
							<td><?php echo $row['location']; ?></td>
							<?php echo "<td><a href='#' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a><a href='#' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>"; ?>
							<?php if($_SESSION['admin_type']=='admin'){echo '<td>'.$row['hostel'].'</td>';} ?>
						</tr> <?php }
								} else { echo "Please add location.";
							} $con->close(); ?>
						</tbody>
                      </table>
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