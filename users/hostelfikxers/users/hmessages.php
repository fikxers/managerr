<?php require('auth.php'); $title ='Messages'; ?>

    <?php include('hmgr_sidebar.php'); ?>
    <?php
		  require('../db.php');
		  if (isset($_POST['send_notice'])){
			$subject = stripslashes($_REQUEST['subject']);
			$message = stripslashes($_REQUEST['message']);			
			if( ! ini_get('date.timezone') )
			{
				date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT INTO `messages`(`sender`, `receiver`,`message`, `subject`, `date_received`) VALUES ('".$_SESSION['email']."','".$_SESSION['hostel']."','".$message."','".$subject."','".$trn_date."')";
	        $result = mysqli_query($con,$query);
	        if($result){
	          echo "<script>alert('Message sent.');</script>";
	          echo "<script type='text/javascript'>window.top.location='hmessages.php';</script>"; exit;
	        }
	        else{
	          echo "<script>alert('Message could not be sent.');</script>";
	          echo "<script type='text/javascript'>window.top.location='hmessages.php';</script>"; exit;
	        }
		  }
		  else{
		?>
        <div class="row">
		 <div class="col-lg-12">
           <div class="card m-b-30">
             <div class="card-body">
              <div class="row">
              	<div class="col-lg-3">
                <form class="" action="" method="POST">
                  <label for="exampleFormControlTextarea1">Subject</label>
                  <div class="form-group"><input type="text" name="subject" class="form-control" required /></div>
                  <div class="form-group">
                      <label for="exampleFormControlTextarea1">Message</label>
    				  <textarea class="form-control" name="message" rows="3"></textarea>
                  </div>
				  <div class="form-group">
					<input type="submit" name="send_notice" value="Send Notice" class="btn btn-primary">
					<input type="reset" value="Reset" class="btn btn-info">
				  </div>
                </form>
                </div>
                <div class="col-lg-9">
                  <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
                    $sql = "SELECT * FROM messages join residents on messages.sender=residents.email where receiver = '".$_SESSION['hostel']."'";
                    //$sql = "SELECT * FROM messages where receiver = '".$_SESSION['hostel']."'";
					$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
					  <table id="tech-companies-1" class="table editable-table table-bordered table-striped m-b-0">
                        <thead>
                          <tr class="titles">
                          	<th>Subject</th><th>Sender</th><th>Message</th><th>Date Sent</th><th>Action</th>
							<?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?>
                          </tr>
                        </thead>
                        <tbody> <?php
						while($row = $result->fetch_assoc()) { ?>
						<tr><td><?php echo $row['subject']; ?></td>
							<td><?php echo $row['full_name']; ?></td>
			              <td><?php echo $row['message']; ?></td>
			              <td><?php echo $row['date_received']; ?></td>
							<?php echo "<td><a href='#' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a><a href='#' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>"; ?>
							<?php if($_SESSION['admin_type']=='admin'){echo '<td>'.$row['estate'].'</td>';} ?>
						</tr> <?php }
								} else { echo "0 Messages.";
							} $con->close(); ?>
						</tbody>
                      </table>
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