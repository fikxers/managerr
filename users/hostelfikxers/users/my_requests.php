<?php require('auth.php'); $title ='My Requests'; ?>

    <?php include('room_sidebar.php'); 	  require('../db.php');  ?>
        <div class="row">
		  <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <!--<h4 class="mt-0 header-title">View Rooms</h4>-->
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php'); $r=$_SESSION['room'];
					$sql = "SELECT * FROM student_requests where hostel = '".$_SESSION['hostel']."' and room=$r";
					$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
					  <table id="tech-companies-1" class="table table-bordered table-striped m-b-0">
                        <thead>
                          <tr class="titles">
                          	<th>Service</th><th>Equipment</th><th>Service Date</th><th>Info</th><th>Status</th><th>Action</th>
							<?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?>
                          </tr>
                        </thead>
                        <tbody> <?php
						while($row = $result->fetch_assoc()) { ?>
						<tr><td><?php echo $row['service']; ?></td>
							<td><?php echo $row['equipment']; ?></td>
							<td><?php echo $row['service_date']; ?></td>
							<td><?php echo $row['info']; ?></td>
							<td><?php echo $row['status']; ?></td>
							<?php echo "<td><a href='hostel-update.php?id=" . $row['id'] . "&op=2' data-toggle='tooltip' data-original-title='Confirm'><i class='fa fa-pencil text-success m-r-10'></i></a>";//<a href='#' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>"; ?>
							<?php if($_SESSION['admin_type']=='admin'){echo '<td>'.$row['estate'].'</td>';} ?>
						</tr> <?php }
								} else { echo "0 Requests.";
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

<?php include('footer.php'); ?>
</html>