<?php require('auth.php'); $title ='Manage Students'; ?>

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
                <!--<h4 class="mt-0 header-title">All Students</h4>-->
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
					$sql = "SELECT * FROM students";//where status = 'available'";
					$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
					  <table id="tech-companies-1" class="table editable-table table-bordered table-striped m-b-0">
                        <thead>
                          <tr class="titles">
                          	<th>Name</th><th>Email</th><th>Phone</th><th>Room No.</th><th>Home Address</th> <th>Moved in</th>    <th>Action</th>
							<?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?>
                          </tr>
                        </thead>
                        <tbody> <?php
						while($row = $result->fetch_assoc()) { ?>
						<tr><td contenteditable="true"><?php echo $row['student_name']; ?></td>
							<td contenteditable><?php echo $row['email']; ?></td>
							<td contenteditable><?php echo $row['phone']; ?></td>
							<td contenteditable="true"><?php echo $row['room_no']; ?></td>	
							<td><?php echo $row['address']; ?></td>
							<td><?php echo $row['date_joined']; ?></td>
							<?php echo "<td><a href='#' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a><a href='#' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>"; ?>
							<?php if($_SESSION['admin_type']=='admin'){echo '<td>'.$row['estate'].'</td>';} ?>
						</tr> <?php }
								} else { echo "No available Fikxer.";
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