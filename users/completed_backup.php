<?php include('auth.php'); $title ='Repairs & Home Service'; ?>
		<?php
		  require('../db.php');
		  if (isset($_POST['confirm'])){
			$status = stripslashes($_REQUEST['status']);
			$table = stripslashes($_REQUEST['table']);
			$service_id = stripslashes($_REQUEST['service_id']);
			$query = "update $table set status = 'confirmed' where id = $service_id";
			$result = mysqli_query($con,$query); 
			if($result){
			  echo "<script>alert('Confirmation Complete.');</script>";
			  echo "<script type='text/javascript'>window.top.location='fixer.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Confirmation Error.');</script>";
			  echo "<script type='text/javascript'>window.top.location='fixer.php';</script>"; exit;
			}
		  }
		  else{
			//echo "<script>alert('Error');</script>";
		?>
        <?php 
		  if($_SESSION['admin_type']=='admin'){
		   include('admin_sidebar.php'); 
		  }
	      else if($_SESSION['admin_type']=='mgr'){
		   include('mgr_sidebar.php');
		  }
		  else if($_SESSION['admin_type']=='flat'){
		   include('flat_sidebar.php');
		  }
		?>

                <div class="page-content-wrapper ">
                <div class="container-fluid">
				    <div class="row">       
						<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Completed Repairs</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM orders join flats on flats.email=orders.flat join quotess using(order_id) join fixers on fixers.email=quotess.fixer where order_status='confirmed' and order_type='repairs'";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr class="titles">
                                                            <th>Flat</th> <th>Block</th>
                                                            <th>Fixer</th>
                                                            <th>Asset</th>
                                                            <th>Completion Date</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['flat_no']; ?></td>
															<td><?php echo $row['block_no']; ?></td>
															<td><?php echo $row['name']; ?></td>
															<td><?php echo $row['order_name']; ?></td>
															<td><?php echo $row['preferred_date']; ?></td>
															<input name="table" type="hidden" value="repairs">
															<input name="service_id" type="hidden" value="<?php echo $row['order_id']; ?>">
															<!--<td><div class="form-group">
															  <select class="form-control" name="status" >
															   <option value="satisfied">Satisfied</option>
															   <option value="unsatisfied">Unsatisfied</option>
															  </select>
															</div></td>
															<td><input name="confirm" type="submit" value="Confirm" class="btn btn-sm btn-outline-success"></td>-->
															</tr>
														<?php
														}
													} else {
														echo "0 Completed Repairs.";
													}
													$con->close();
													?>                                                       
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
                                      <h4 class="mt-0 header-title">Completed Home Service</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													//$sql = "SELECT * FROM orders join flats on flats.email=orders.flat join quotess using(order_id) where order_status='confirmed' and order_type='home_service'";
													$sql = "SELECT * FROM orders join flats on flats.email=orders.flat join quotess using(order_id) join fixers on fixers.email=quotess.fixer where order_status='confirmed' and order_type='home_service'";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr class="titles">
                                                            <th>Flat</th><th>Block</th>
                                                            <th>Fixer</th>
                                                            <th>Service</th>
                                                            <th>Completion Date</th>                                   
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['flat_no']; ?></td>
															<td><?php echo $row['block_no']; ?></td>
															<td><?php echo $row['name']; ?></td>
															<td><?php echo $row['order_name']; ?></td>
															<td><?php echo $row['preferred_date']; ?></td>
															<input name="table" type="hidden" value="home_service">
															<input name="service_id" type="hidden" value="<?php echo $row['order_id']; ?>">
															<!--<td><div class="form-group">
															  <select class="form-control" name="status" >
															   <option value="satisfied">Satisfied</option>
															   <option value="unsatisfied">Unsatisfied</option>
															  </select>
															</div></td>
															<td><input name="confirm" type="submit" value="Confirm" class="btn btn-sm btn-outline-success"></td>-->
															</tr>
														<?php
														}
													} else {
														echo "0 Completed Home Service.";
													}
													$con->close();
													?>                                                       
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                        </div>
                    </div>
                    <!-- container -->

                </div>
                <!-- Page content Wrapper -->

            </div>
            <!-- content -->

		  <?php include('footer.php'); } ?>

</html>