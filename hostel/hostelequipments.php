<?php require('auth.php'); $title ='Equipments'; ?>

    <?php 
      if($_SESSION['admin_type']=='hmgr') {
      	include('hmgr_sidebar.php');
      	$sql = "SELECT * FROM hostel_equipments where hostel = '".$_SESSION['hostel']."'";
      } 
      else if($_SESSION['admin_type']=='student') {
      	include('room_sidebar.php');
      	//$sql = "SELECT * FROM hostel_equipments where room = '".$_SESSION['room']."'";
        $room_no = 'Room '.$_SESSION['room'];
        $sql = "SELECT * FROM hostel_assets where location = '".$room_no."' and hostel = '".$_SESSION['hostel']."'";
      } 
	  require('../db.php');
	?>
    <div class="row">
		  <div class="col-lg-12">
        <div class="card m-b-30">
          <div class="card-body">
            <!--<h4 class="mt-0 header-title">View Rooms</h4>-->
            <div class="table-rep-plugin">
              <div class="table-responsive b-0" data-pattern="priority-columns">
              <?php include ('../db.php');
					       $result = $con->query($sql);
					     if ($result->num_rows > 0) { ?>
					     <table id="tech-companies-1" class="table Stable-bordered table-striped m-b-0">
                  <thead><tr class="titles"><th>Name of Asset</th><th>Status</th><!--<th>Action</th>-->
							 <?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?> </tr>
                  </thead><tbody> <?php
      						while($row = $result->fetch_assoc()) { ?>
      						<tr><td><?php echo $row['name']; ?></td>
      							<td><?php echo $row['status']; ?></td>
      							<?php //echo "<td><a href='#' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a><a href='#' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>"; ?>
      							<?php if($_SESSION['admin_type']=='admin'){echo '<td>'.$row['estate'].'</td>';} ?>
      						</tr> <?php }
      								} else { echo "No asset recorded.";
      							} $con->close(); ?>
      						</tbody>
                </table>
              </div>
				    </div>
          </div>
        </div>
       </div> <!-- end col -->
      </div>
    </div>
  </div>
  <!-- Page content Wrapper -->
</div>
<!-- content -->

<?php include('footer.php'); ?>
</html>