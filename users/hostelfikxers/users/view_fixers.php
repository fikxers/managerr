<?php require('auth.php'); $title ='Fikxers'; ?>

	<?php
	  require('../db.php');
	  if (isset($_POST['fixer_name'])){
	  $fixer_name = stripslashes($_REQUEST['fixer_name']);
	  
	  if($_SESSION['admin_type']=='admin'){
		$estate_code = stripslashes($_REQUEST['estate_code']); 
	  }
	  else if($_SESSION['admin_type']=='mgr'){
		$estate_code = $_SESSION['estate'];
	  }
	  $address = stripslashes($_REQUEST['address']);
	  $skill = stripslashes($_REQUEST['skill']);
	  $skill2 = stripslashes($_REQUEST['skill2']);
	  $skill3 = stripslashes($_REQUEST['skill3']);
	  $status = stripslashes($_REQUEST['status']);
	  $phone = stripslashes($_REQUEST['phone']);
	  $email = stripslashes($_REQUEST['email']);
	  $password = stripslashes($_REQUEST['password']);
	  $password2 = stripslashes($_REQUEST['rpassword']);
	  if(trim($password)=='' || trim($password2)=='')
	  {
		echo('All fields are required!');
		header('Location: view_fixers.php');
	  }
	  else if($password != $password2)
	  {
		echo('Passwords do not match!');
		header('Location: view_fixers.php');
	  }
	  else{
		$password = mysqli_real_escape_string($con,$password);
		if( ! ini_get('date.timezone') )
		{
		  date_default_timezone_set('Africa/Lagos');
		}
		$trn_date = date("Y-m-d H:i:s");
		//b4 insert, check if exists
	    $query = "INSERT into `fixers` (name, skill,skill2,skill3,status, phone, email, home_address, estate, created_at) VALUES ('$fixer_name', '$skill','$skill2','$skill3','$status', '$phone', '$email', '$address', '$estate_code', '$trn_date')";
		$query2 = "INSERT into `users` (email, password, admin_type) VALUES ('$email', '".md5($password)."', 'fixer')";
	    $result = mysqli_query($con,$query);
		$result2 = mysqli_query($con,$query2);
		if($result && $result2){
		  echo "<script>alert('Fikxer added successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_fixers.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Error adding Fikxer.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_fixers.php';</script>"; exit;
		}
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
		?>

            <div class="page-content-wrapper ">
                <div class="container-fluid">
				    <div class="row">       
						<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">All Fikxers</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM fixers";
													if($_SESSION['admin_type']=='mgr'){
													  $sql = "SELECT * FROM fixers where estate='".$_SESSION['estate']."'";
													}
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Skill</th><th>Skill #2</th><th>Skill #3</th>
                                                            <th>Phone</th>
                                                            <th>Status</th>         
															<?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?>  <th></th><th></th>
                                                        </tr>
                                                      </thead>
													  <tbody> <?php
														while($row = $result->fetch_assoc()) { 
															echo "<tr>";
															echo "<td>". $row['name']. "</td>";	
															echo "<td>". $row['skill']. "</td>";
															echo "<td>". $row['skill2']. "</td>";
															echo "<td>". $row['skill3']. "</td>";
															echo "<td>". $row['phone']. "</td>";
															echo "<td>". $row['status']. "</td>";
															if($_SESSION['admin_type']=='admin'){echo "<td>". $row['estate']. "</td>";}
															echo "<td><a href='update_fixer.php?id=" .$row['email']."&phone=" .$row['phone']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> </td>";
															echo "<td><a href='delete_fixer.php?id=" . $row['email'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>";
															echo "</tr>";														
														}
													} else {
														echo "No Fikxer in database.";
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
                                      <h4 class="mt-0 header-title">Add Fikxer</h4>
                                        <p class="text-muted m-b-30 font-14">Enter details of a new Fikxer.</p>
                                          <form class="" action="" method="POST">
                                            <div class="form-group">
                                              <input type="text" name="fixer_name" class="form-control" required placeholder="Name of Fikxer"/>
                                            </div>
                                            <!--<div class="form-group">
                                              <input type="text" name="estate_code" class="form-control" required placeholder="Estate CODE"/>
                                            </div>-->
											<?php 
											  if($_SESSION['admin_type']=='admin'){
											   include('estate_div.php'); 
											  }
											?>
											
											<div class="form-group">
                                              <input type="text" name="address" class="form-control" required placeholder="Home address"/>
                                            </div>
											<!--<div class="form-group">
                                              <div>
                                                <input name="skill" type="text" class="form-control" required placeholder="Skill"/>
                                                </div>
                                            </div>-->
											<div class="form-group">
											  <select class="form-control" required name="skill" >
											    <option value="">Choose Skill</option>						
												<option value="Generator Repairs">Generator Repairs</option> <option value="Air Conditioner">Air Conditioner</option>									
												<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
												<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option>
												<option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
											  </select>
											</div>
											<div class="form-group">
											  <select class="form-control" name="skill2" >
											    <option value="">2nd Skill (Optional)</option>						
												<option value="Generator Repairs">Generator Repairs</option> <option value="Air Conditioner">Air Conditioner</option>									
												<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
												<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option>
												<option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
											  </select>
											</div>
											<div class="form-group">
											  <select class="form-control" name="skill3" >
											    <option value="">3rd Skill (Optional)</option>						
												<option value="Generator Repairs">Generator Repairs</option> <option value="Air Conditioner">Air Conditioner</option>									
												<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
												<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option>
												<option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
											  </select>
											</div>
											<div class="form-group">
                                              <div>
                                                <input name="phone" type="text" class="form-control" required placeholder="Phone"/>
                                                </div>
                                            </div> 
											<div class="form-group">
                                              <div>
                                                <input name="email" type="text" class="form-control" required placeholder="Email"/>
                                                </div>
                                            </div>
											<div class="form-group">
                                              <div>
                                                <input name="password" type="password" class="form-control" required placeholder="Password"/>
                                                </div>
                                            </div> 
											<div class="form-group">
                                              <div>
                                                <input name="rpassword" type="password" class="form-control" required placeholder="Repeat password"/>
                                                </div>
                                            </div>
											<div class="form-group">
											  <select class="form-control" required name="status" >
											    <option value="">Status</option>						
												<option value="available">Available</option> <option value="occupied">Occupied</option><option value="holiday">On holiday</option><option value="suspended">Suspended</option><option value="trial">On trial</option>
											  </select>
											</div>
                                            <div class="form-group">
                                               <div>
                                                  <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                            Submit</button>
                                                  <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button>
                                               </div>
                                            </div>
                                          </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                    </div>
                    <!-- container -->

                </div>
                <!-- Page content Wrapper -->

            </div>
            <!-- content -->

            <?php include('footer.php'); ?>
			<?php } ?>
</html>