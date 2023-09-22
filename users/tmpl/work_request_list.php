<h4 class="mt-0 header-title" id="work-requests">Work Requests</h4>
              <div class="table-rep-plugin">
                <div class="table-responsive b-0" >
                <?php include ('../db.php');
				$sql = "SELECT * FROM orders where flat='".$_SESSION['email']."' and order_status!='confirmed' and order_status!='completed' ORDER BY order_id DESC"; $result = $con->query($sql);
				//$sql = "SELECT * FROM orders where flat='".$_SESSION['email']."' and order_type = 'repairs'";
				if ($result->num_rows > 0) { ?>
				<table id="example" class="table  table-bordered">
                  <thead><tr class="titles"><th>Order #</th><th>Asset/Service</th> <th>Description</th> <th>Status</th></tr>
                    </thead><tbody> <?php while($row = $result->fetch_assoc()) { ?>
					<tr><td><?php echo $row['order_no']; ?></td><td><?php echo $row['order_name']; ?></td><td><?php echo $row['description']; ?></td><td><?php echo $row['order_status']; ?></td></tr>
					<?php } } else {echo "No ordered repair.";}$con->close();?></tbody></table>
                </div>
			  </div>