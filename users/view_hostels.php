<?php require('auth.php'); $title ='Hostels'; ?>

	<?php
	  require('../db.php');
	  if (isset($_POST['hostel_code'])){
	  $hostel_name = stripslashes($_REQUEST['hostel_name']);
	  $hostel_code = stripslashes($_REQUEST['hostel_code']);
	  $address = stripslashes($_REQUEST['address']);
	  $no_of_rooms = stripslashes($_REQUEST['no_of_room']);
	  $query = "INSERT into `hostels` (hostel_name, hostel_code,no_of_rooms, address) VALUES ('$hostel_name', '$hostel_code',$no_of_rooms,'$address')";
	  $result = mysqli_query($con,$query);
		if($result){
		  echo "<script type='text/javascript'>window.top.location='view_hostels.php';</script>"; exit;
		}
	  }
	  else{
		//echo "<script>alert('Error');</script>";
		  if($_SESSION['admin_type']=='admin'){
		   include('admin_sidebar.php'); 
		  }
	      else if($_SESSION['admin_type']=='mgr'){
		   include('mgr_sidebar.php');
		  }
		?>
    <div class="page-content-wrapper ">
      <div class="container-fluid">
		<div class="row">       
		  <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <h4 class="mt-0 header-title">All Hostels</h4>
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
					$sql = "SELECT * FROM hostels"; $result = $con->query($sql);
                    if ($result->num_rows > 0) { ?>
					<table id="tech-companies-1" class="table  table-striped">
                    <thead class="titles"><tr><th>Name</th><th>Code</th>
                      <th>Address</th><th># of rooms</th><th>Action</th> </tr></thead>
                    <tbody> <?php while($row = $result->fetch_assoc()) { ?>
					  <tr><td><?php echo $row['hostel_name']; ?></td>
						<td><?php echo $row['hostel_code']; ?></td>
						<td><?php echo $row['address']; ?></td>
						<td><?php echo $row['no_of_rooms']; ?></td>
						<?php echo "<td><a href='update_hostel.php?id=" .$row['hostel_code']."&rooms=" .$row['no_of_rooms']."&address=" .$row['address']."&name=" .$row['hostel_name']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> <a href='delete_hostel.php?id=" . $row['hostel_code'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>"; ?></tr>
						  <?php } } else { echo "No hostel in database."; }
							$con->close(); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- end col -->
		  <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
              <h4 class="mt-0 header-title">Add Hostel</h4>
              <p class="text-muted m-b-30 font-14">Enter details of a new hostel.</p><form class="" action="" method="POST">
              <div class="form-group">
                <input type="text" name="hostel_name" class="form-control" required placeholder="Name of Hostel"/></div>
              <div class="form-group">
                <input type="text" name="hostel_code" class="form-control" required placeholder="Hostel Code"/></div>
			  <div class="form-group">
                <input type="text" name="address" class="form-control" required placeholder="Full address"/></div>
			  <div class="form-group">
                <input data-parsley-type="number" name="no_of_rooms" type="text" class="form-control" required placeholder="No. of rooms"/></div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button><button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button></div>
              </form>
              </div>
            </div>
          </div> <!-- end col -->
        </div><!-- container -->
      </div><!-- Page content Wrapper -->
    </div><!-- content -->
    <?php include('footer.php');  } ?>
</html>