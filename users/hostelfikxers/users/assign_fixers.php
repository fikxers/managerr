<?php require('auth.php'); $title ='Assign Fixers'; ?>

    <?php include('admin_sidebar.php'); ?>
    <?php
		  require('../db.php');
		  if (isset($_POST['send4quotes'])){
			$flat = stripslashes($_REQUEST['flat']);
			$description = stripslashes($_REQUEST['description']);
			$status = "pending";		
			$skill = stripslashes($_REQUEST['skill']);			
			$pdate = stripslashes($_REQUEST['pdate']);
			$estate = stripslashes($_REQUEST['estate']);
			//b4 insert, check if exists
			if( ! ini_get('date.timezone') )
			{
			  date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT into `request4quotes` (description,flat, estate,skill_required, status,date_sent,preferred_date) VALUES ('$description','$flat','".$estate."','$skill', 'pending','$trn_date','$pdate')";
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
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM fixers where status = 'available'";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table editable-table table-bordered table-striped m-b-0">
                                                      <thead>
                                                        <tr>
                                                            <th>Name</th>
															<th>Emil</th>
															<th>Phone</th>
                                                            <th>Skill</th>
															<th>Skill 2</th>
															<th>Skill 3</th>
                                                            <th>Status</th>       
															<th><?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?></th>                                                    
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td contenteditable="true"><?php echo $row['name']; ?></td>
															<td contenteditable><?php echo $row['email']; ?></td>
															<td contenteditable><?php echo $row['phone']; ?></td>
															<td contenteditable="true"><?php echo $row['skill']; ?></td><td contenteditable="true"><?php echo $row['skill2']; ?></td><td contenteditable="true"><?php echo $row['skill3']; ?></td>
															<td><?php echo $row['status']; ?></td>
															<td><?php if($_SESSION['admin_type']=='admin'){echo $row['estate'];} ?></td>
															</tr>
														<?php
														}
													} else {
														echo "No available Fikxer.";
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
                                      <h4 class="mt-0 header-title">Assign Fikxer (Repairs)</h4>
                                        <!--<p class="text-muted m-b-30 font-14">Enter details of a new fixer.</p>-->
                                          
                                            <div class="table-rep-plugin">
                                                <div class="table-responsive b-0" data-pattern="priority-columns">
												    <table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Flat</th>
                                                            <th>Block</th>
                                                            <th>Equipment</th>
															<th>Problem</th>
															<th>Commencement Date</th>
															<th>Description</th>
															<th>Skill Required</th> 
															<!--<th>Upload Image(s)</th>-->
															<th></th>                                         
                                                        </tr>
                                                      </thead>
													  <tbody>
												   <?php
													include ('db.php');
													$sql = "SELECT *,flats.flat_no,flats.block_no FROM repairs join flats on flats.email=repairs.flat where repairs.status != 'completed'";
													$stmt = $con->prepare($sql);
													$stmt->execute();
													$results = $stmt->fetchAll();
													if ($stmt->rowCount() > 0) {
													foreach ($results as $result)
													{ ?>
														    <form class="" action="" method="POST">
															<tr>
															<td><?php echo $result['flat_no']; ?></td>
															<td><?php echo $result['block_no']; ?></td>
															<td><?php echo $result['equipment']; ?></td>
															<td><?php echo $result['description']; ?></td>
															<td><?php echo $result['preferred_date']; ?></td>
															<input type="hidden" id="flat" name="flat" value="<?php echo $result['email']; ?>">
															<input type="hidden" name="pdate" value="<?php echo $result['preferred_date']; ?>">
															<input type="hidden" name="estate" value="<?php echo $result['estate']; ?>">
															<!--<td><input type="textarea" required name="description" class="form-control" placeholder="Add Description"/></td>-->
															<td><textarea name="description" placeholder="Please describe in detail" required rows="3" cols="30"></textarea><input type="file" name="image"><input type="file" name="image"><input type="file" name="image"><input type="file" name="image"><input type="file" name="image"></td>
															<td>
															  <select class="form-control" required name="skill" >
																<!--<option value="">Skill Required</option>-->			
																<option value="Generator Repairs">Generator Repairs</option> <option value="Air Conditioner">Air Conditioner</option>									
																<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
																<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option>
																<option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option><option value="Carpenter">Carpenter</option><option value="Electronics">Electronics</option>					
															  </select>
															</td>
															<!--<td><input type="file" name="image"><input type="file" name="image"><input type="file" name="image"><input type="file" name="image"><input type="file" name="image"></td>-->
															<td><button name="send4quotes" type="submit" class="btn btn-primary btn-sm">Send for Quotes</button></td>
															</tr>
															</form>
													<?php } 
													} else {
														echo "0 Repair Requests.";
													}
													//$con->close(); ?>                                                       
                                                      </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                          
                                        </div>
                                    </div>
                        </div>
						<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Assign Fikxer (Home Service)</h4>
                                        <!--<p class="text-muted m-b-30 font-14">Enter details of a new fixer.</p>-->
                                          
                                            <div class="table-rep-plugin">
                                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                                    <table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Flat No</th> <th>Block No</th>
                                                            <th>Service</th> <th>Info</th>
															<th>Commencement Date</th>
                                                            <th>Description</th>
                                                            <th>Skill Required</th><th></th>                                                         
                                                        </tr>
                                                      </thead>
                                                      <tbody>
														
													  <!--</tbody>
                                                   </table>-->
												   <?php
												    include ('db.php');
													// mysql select query
													$sql = "SELECT *,flats.flat_no,flats.block_no FROM home_service join flats on flats.email=home_service.flat where home_service.status != 'completed'";
													$stmt = $con->prepare($sql);
													$stmt->execute();
													$results = $stmt->fetchAll();
													if ($stmt->rowCount() > 0) {
													foreach ($results as $result)
													{ 
														//echo $result['flat_no'].' - '.$result['block_no'].' - '.$result['name'].' - '.$result['preferred_date'].'<br>'; ?>
													  <form class="" action="" method="POST">
													  <tr>
														<td><?php echo $result['flat_no']; ?></td>
														<td><?php echo $result['block_no']; ?></td>
														<td><?php echo $result['name']; ?></td>
														<td><?php echo $result['description']; ?></td>
														<td><?php echo $result['preferred_date']; ?></td>
														<input type="hidden" name="flat" value="<?php echo $result['email']; ?>">
														<input type="hidden" name="pdate" value="<?php echo $result['preferred_date']; ?>">
														<td><textarea name="description" placeholder="Please describe in detail" required rows="3" cols="30"></textarea></td>
														<td>
															  <select class="form-control" required name="skill" >
																<!--<option value="">Skill Required</option>-->
																<option value="Generator Repairs">Generator Repairs</option> <option value="Air Conditioner">Air Conditioner</option>									
																<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
																<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option>
																<option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
															  </select>
															</td>
														<td><button name="send4quotes" type="submit" class="btn btn-primary btn-sm">Send for Quotes</button></td>
													  </tr>
													  </form>
													<?php
													
													/*include ('../db.php');
													$sql = "SELECT *,flats.flat_no,flats.block_no FROM home_service join flats on flats.email=home_service.flat where home_service.status != 'completed'";
													$result = $con->query($sql);

													if ($result->num_rows > 0) {*/ ?>
													<!--<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Flat No</th> <th>Block No</th>
                                                            <th>Service</th>
															<th>Preferred Date</th>
                                                            <!--<th>Fikxer</th><th>Description</th>
                                                            <th></th>                                                            
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php   //foreach($result->fetch_assoc() as $row){
														//while($row = $result->fetch_assoc()) { ?>
														    <form class="" action="" method="POST">
															<tr>
															<td><?php //echo $row['flat_no']; ?></td>
															<td><?php //echo $row['block_no']; ?></td>
															<td><?php //echo $row['name']; ?></td>
															<td><?php //echo $row['preferred_date']; ?></td>
															<input type="hidden" id="flat" name="flat" value="<?php //echo $row['email']; ?>">														
															<!--<td><div class="form-group">
															  <select class="form-control" required name="fixer" >
																<option value="">Select Fikxer</option>
																<?php /*include ('../db.php');
																$sql="select name,email from fixers where status='available'"; 
																$result = $con->query($sql);; 
																while($row = $result->fetch_assoc()) { 
																?>
																<option value="<?php echo $row['email']; ?>"><?php echo $row['name']; ?></option><?php } */?>
															  </select></div>
															 </td>
															 <td><input type="textarea" required name="description" class="form-control" placeholder="Add Description"/></td>
															 <td><button name="send4quotes" type="submit" class="btn btn-primary btn-sm">Send for Quotes</button></td>
															</tr>
															</form>-->
														<?php 
														}
													} else {
														echo "0 Home Service Requests.";
													}
													//$con->close(); 
													?>                                                       
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