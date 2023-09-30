<?php
require('auth.php'); 
//session_start(); 
$title ='Dashboard';
//echo '<script type="text/javascript">alert("Email: '.$_SESSION['email'].'");</script>';
//echo '<script type="text/javascript">alert("Admn: '.$_SESSION['admin_type'].'");</script>';
?>
<?php include('admin_sidebar.php'); ?>
	<div class="row"> 
		<div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">All Quotes</h4>
                    <div class="table-rep-plugin">
                      <div class="table-responsive b-0" data-pattern="priority-columns">
						<?php include ('db.php');
							$sql = "SELECT * FROM quotes join flats on flats.email=quotes.flat";
							$stmt = $con->prepare($sql);
							$stmt->execute();
							$results = $stmt->fetchAll();
							if ($stmt->rowCount() > 0) { ?>
							<table class="table table-hover table-bordered mb-0">
                                <thead>
                                  <tr class="titles">
                                    <th>Description</th><th>Duration</th>
                                    <th>Cost Estimate</th><th>Date Sent</th><th>Status</th>
                                  </tr>
                                </thead>
                                <tbody>
								<?php foreach ($results as $result) {  ?>
                                <form action="" method="POST">
								  <tr>
									<td><?php echo $result['description']; ?></td>
									<td><?php echo $result['duration']; ?></td>
									<td><?php echo $result['cost']; ?></td>
									<td><?php echo $result['date_sent']; ?></td>
									<td><?php echo $result['status']; ?></td>
									<input type="hidden" name="id" value="<?php echo $result['id']; ?>">
									<input type="hidden" name="description" value="<?php echo $result['description']; ?>">
									<!--<td><input name="accept" type="submit" value="Accept" class="btn btn-primary"></td>
									<td><input name="reject" type="submit" value="Reject" class="btn btn-primary"></td>-->
								  </tr>
								</form>
                                <?php   }
									} else { echo "0 Quotes."; } ?>
                            </table>
                      </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->	  
      </div><!-- end row -->
     </div><!-- container -->
   </div><!-- Page content Wrapper -->
  </div><!-- content -->
  <?php include('footer.php'); ?>
</html>