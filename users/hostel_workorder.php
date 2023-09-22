<?php require('auth.php'); $title ='Work Orders'; 
      if($_SESSION['admin_type']=='hmgr') {
      	include('hmgr_sidebar.php');
      	$sql = "SELECT * FROM student_requests where hostel = '".$_SESSION['hostel']."'";
      } 
      else if($_SESSION['admin_type']=='student') {
      	include('room_sidebar.php');
      	$sql = "SELECT * FROM hostel_equipments where room = '".$_SESSION['room']."'";
      } 
	  require('../db.php');
	?>
  <?php
      
      if (isset($_POST['assign'])){
        $fikxer = stripslashes($_REQUEST['fikxer']);
        $id = $_REQUEST['id'];
        $query = "UPDATE student_requests SET status='Assigned',fikxer='".$fikxer."' WHERE id=$id";
        $result = mysqli_query($con,$query);
        echo '<script type="text/javascript">alert("'.$query.'");</script>';
          echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
        /*if($result){
          echo "<script>alert('Job Assigned.');</script>";
          echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
        }
        else{
          //echo "<script>alert('Error Assigning Job');</script>"; mysqli_error($con)
          echo '<script type="text/javascript">alert("'.$query.'");</script>';
          echo "<script type='text/javascript'>window.top.location='add_equipment.php';</script>"; exit;
        }*/
      }
      else{
    ?>
        <div class="row">
		      <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <!--<h4 class="mt-0 header-title">Residents Requests</h4>-->
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php 
          					$result = $con->query($sql);
          					if ($result->num_rows > 0) { ?>
          					  <table id="tech-companies-1" class="table table-bordered table-striped m-b-0">
                        <thead>
                          <tr class="titles">
                          	<th>Service</th><th>Equipment</th><th>Service Date</th><th>Info</th><th>Room</th><th>Status</th><th>Fikxer</th><th>Action</th>
							             <?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?>
                          </tr>
                        </thead>
                        <tbody> <?php
            						while($row = $result->fetch_assoc()) {  //$reqid=$row['id']; echo $reqid; ?>
            						<tr><td><?php echo $row['service']; ?></td>
                          <td><?php echo $row['equipment']; ?></td>
                          <td><?php echo $row['service_date']; ?></td>
                          <td><?php echo $row['info']; ?></td>
                          <td><?php echo $row['room']; ?></td>
            							<td><?php echo $row['status']; ?></td>
                          <td><?php echo $row['fikxer']; ?></td>
							           <?php 
                          echo "<td>"."<a href='hostel-update.php?id=" . $row['id'] . "&op=2' data-toggle='tooltip' data-original-title='Complete Job'><i class='fa fa-check-square text-success m-r-10'></i></a> "."<a href='hostel-update.php?id=" . $row['id'] . "&op=3' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a></td>";
                          //<a href='hostel-update.php?id=" . $row['id'] . "&op=1' data-toggle='tooltip' data-original-title='Assign Fikxer'><i class='fa fa-pencil text-info m-r-10'></i></a> 
                          ?>
            							<?php if($_SESSION['admin_type']=='admin'){echo '<td>'.$row['estate'].'</td>';} ?>
            						</tr> <?php }
            								} else { echo "0 Requests.";
            							} $con->close(); ?>
            						</tbody>
                      </table>
                      <!-- Button trigger modal 
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                        Launch demo modal
                      </button>-->
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalCenterTitle">Assign Fikxer</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="" method="POST">
                              <?php require('../db.php');
                                $query="select * from hostel_fikxers where hostel='".$_SESSION['hostel']."'"; 
                                $r = $con->query($query);
                                ?>
                              <select class="form-control" name="fikxer" >
                                <?php
                                
                                while($row = $r->fetch_assoc()) { 
                                  //$id = intval($row['id']);
                                echo '<option value="'.$row['email'].'">'.$row['name'].'</option>'; 
                                echo '<input type="hidden" name="id" value="'.$reqid.'">';
                                } ?>
                              </select>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" name="assign" class="btn btn-primary">Assign</button>
                            </form>
                            </div>
                          </div>
                        </div>
                      </div>
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