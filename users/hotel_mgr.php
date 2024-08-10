<?php require('auth.php'); $title ='Hotel Manager'; 
      if($_SESSION['admin_type']=='hotelmgr') {
      	include('hmgr_sidebar.php');
      } 
      // else if($_SESSION['admin_type']=='student') {
      // 	include('room_sidebar.php');
      // 	$sql = "SELECT * FROM hostel_equipments where room = '".$_SESSION['room']."'";
      // } 
	  require('../db.php');

      if (isset($_POST['assign'])){
        $fikxer = stripslashes($_REQUEST['fikxer']);
        $id = $_REQUEST['id'];
        $query = "UPDATE student_requests SET status='Assigned',fikxer='".$fikxer."' WHERE id=$id";
        $result = mysqli_query($con,$query);
        echo '<script type="text/javascript">alert("'.$query.'");</script>';
        echo "<script type='text/javascript'>window.top.location='users/hostel_mgr.php';</script>"; exit;
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
                <h4 class="mt-0 header-title">Dashboard</h4>
                
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