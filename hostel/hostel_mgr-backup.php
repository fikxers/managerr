<?php require('auth.php'); $title ='Dashboard'; ?>

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
                <h4 class="mt-0 header-title">Available Fikxers</h4>
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
					$sql = "SELECT * FROM fixers where status = 'available'";
					$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
					  <table id="tech-companies-1" class="table editable-table table-bordered table-striped m-b-0">
                        <thead>
                          <tr class="titles">
                          	<th>Name</th><th>Email</th><th>Phone</th><th>Skill</th><th>Status</th>       
							<?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?>
                          </tr>
                        </thead>
                        <tbody> <?php
						while($row = $result->fetch_assoc()) { ?>
						<tr><td contenteditable="true"><?php echo $row['name']; ?></td>
							<td contenteditable><?php echo $row['email']; ?></td>
							<td contenteditable><?php echo $row['phone']; ?></td>
							<td contenteditable="true"><?php echo $row['skill']; ?></td>	
							<td><?php echo $row['status']; ?></td>
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
		  <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <h4 class="mt-0 header-title">Assign Fikxer (Home Service)</h4>
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                    <table id="tech-companies-1" class="table  table-striped">
                    <?php  include ('db.php');
					  $sql = "SELECT *,flats.flat_no,flats.block_no FROM orders join flats on flats.email=orders.flat where order_status = 'pending' and order_type='home_service'";
					  $stmt = $con->prepare($sql);
					  $stmt->execute(); $results = $stmt->fetchAll();
					  if ($stmt->rowCount() > 0) {
						echo "<thead><tr class='titles''><th>Room</th> <th>Service</th> <th>Info</th><th>Start Date</th><th>Description</th><th>Skill Required</th><th>Action</th></tr></thead><tbody>";
						foreach ($results as $result){   ?>
						  <form class="" action="" method="POST">
							<tr><td><?php echo $result['flat_no']; ?></td>
								<td><?php echo $result['order_name']; ?></td>
								<td><?php echo $result['description']; ?></td>
								<td><?php echo $result['preferred_date']; ?></td>
								<input type="hidden" name="service_id" value="<?php echo $result['order_id']; ?>">
								<td><textarea name="description" placeholder="Please describe in detail" required rows="3" cols="30"></textarea></td>
								<td><select class="form-control" required name="skill" >
									<option value="Generator Repairs">Generator Repairs</option> <option value="Air Conditioner">Air Conditioner</option><option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option><option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option><option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option></select>
								</td><td><button name="send4quotes" type="submit" class="btn btn-primary btn-sm">Assign Fikxer</button></td>
							</tr>
						  </form>
						  <?php }
							} else { echo "0 Home Service Requests."; }	?>      
                        </tbody>
                    </table>
                         </div>
                       </div>
                    </div>
                 </div>
              </div>
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