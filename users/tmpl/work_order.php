<div class="table-rep-plugin">
          <div class="table-responsive b-0" data-pattern="priority-columns">
          <?php include ('../db.php');
    			$sql = "SELECT * FROM orders where flat='".$_SESSION['email']."' and (order_status='confirmed' or order_status='completed')";
    			//$sql = "SELECT * FROM repairs where flat='".$_SESSION['email']."'";
				//$sql = "SELECT * FROM orders where flat='".$_SESSION['email']."' and order_type = 'repairs'";
    			if($_SESSION['admin_type']=='admin'){$sql = "SELECT * FROM orders";}
    			$result = $con->query($sql);
    			if ($result->num_rows > 0) { ?>
   			  <table id="tech-companies-1" class="table  table-striped">
                <thead>
                  <tr class="titles"><th>Order #</th><th>Asset</th><th>Service</th><th>Description</th><th>Start Date</th><th>Completion Date</th><th>Status</th></tr>
                </thead>
                <tbody> <?php while($row = $result->fetch_assoc()) { ?>
				  <tr><td><?php echo $row['order_no']; ?></td><td><?php echo $row['order_name']; ?></td><td><?php echo $row['service']; ?></td>
				  	<td><?php echo $row['description']; ?></td><td><?php echo $row['preferred_date']; ?></td>
					<td><?php echo $row['completion_date']; ?></td><td><?php echo $row['order_status']; ?></td></tr>
					<?php }
					  } else { echo "No Work Order."; }
					  $con->close(); ?>                                                       
                </tbody>
              </table>
          </div>
		</div>