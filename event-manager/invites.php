<?php require('../users/auth.php'); $title ='Invited Guests'; 
include('sidebar.php'); require('../db.php'); $event=$_GET['event']; 
if (isset($_POST['send'])){
  $title = $_REQUEST['title']; $full_name = $_REQUEST['full_name']; $companions = $_REQUEST['companions']; 
  $table = $_REQUEST['table']; $event = $_REQUEST['event']; 
	$query = "INSERT INTO `event_invites`(`title`, `full_name`, `companions`, `designated_table`, `event`) VALUES ('$title','$full_name',$companions,'$table',$event)";
	$r = mysqli_query($con,$query); 
	if($r){
	  echo "<script>alert('Invite sent successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='sendinvite.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error. Please try again.');</script>";
	  echo "<script type='text/javascript'>window.top.location='sendinvite.php';</script>"; exit;
	}
}
else{
?>
			<div class="row">
			  <div class="col-lg-12">
					<div class="card m-b-30">
	          <div class="card-body">
							<?php 
								  include ('../db.php'); $i=1;
	                $sql = "SELECT *,event_invites.title as ttl FROM event_invites join events on (events.id = event_invites.event) where event_invites.event=$event";
									$result = $con->query($sql);
									if ($result->num_rows > 0) {
								?>
							  <table class="table">
								  <thead>
								    <tr>
								      <th scope="col">#</th>
								      <th scope="col">Title</th>
								      <th scope="col">Name</th>
								      <th scope="col">Companion(s)</th>
								      <th scope="col">Designated Table</th>
								      <!-- <th scope="col">Action</th> -->
								    </tr>
								  </thead>
								  <tbody>
								  	<?php while($row = $result->fetch_assoc()) { ?>
								    <tr>
								      <th scope="row"><?php echo $i; ?></th>
								      <td><?php echo $row['ttl']; ?></td>
								      <td><?php echo $row['full_name']; ?></td>
								      <td><?php echo $row['companions']; ?></td>
								      <td><?php echo $row['designated_table']; ?></td>
								      <!-- <?php echo "<td><a href='guests.php?event=".$row['id']."' data-toggle='tooltip' class='text-success'>Invited Guests</a></td>"; ?> -->
								    </tr>
								  	<?php $i++; } ?>
								  </tbody>
								</table>
								<?php 
									}else{
										echo '<div class="alert alert-danger" role="alert">You have not invited anyone.</div>';
									}
								?>
				  	</div>
	        </div>
			  </div>
      </div><!-- end row -->
      </div><!-- container -->
    </div><!-- Page content Wrapper -->
  </div><!-- content -->
  <?php include('footer.php'); } ?>
</html>