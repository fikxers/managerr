<?php require('auth.php'); $title ='Flats'; ?>

	<?php
	  require('../db.php');
	  if (isset($_POST['estate_code'])){
	    $flat_no = stripslashes($_REQUEST['flat_no']);
	    $block_no = stripslashes($_REQUEST['block_no']);
	    //$flat_id = stripslashes($_REQUEST['flat_id']);
	    //$no_of_equipments = stripslashes($_REQUEST['no_of_equipments']);
	    if($_SESSION['admin_type']=='admin'){
		  $estate_code = stripslashes($_REQUEST['estate_code']); 
		}
		else if($_SESSION['admin_type']=='mgr'){
		  $estate_code = $_SESSION['estate'];
		}
	    $owner = stripslashes($_REQUEST['owner']);
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
		  //check if flat_no && block_no && estate_code already in db
		  //alternatively, use email as pk
	      $query = "INSERT into `flats` (email,flat_no,block_no,estate_code,phone,owner,created_at) VALUES ('$email',$flat_no,$block_no, '$estate_code','$phone','$name','$trn_date')";
		  $query2 = "INSERT into `users` (email, password, admin_type) VALUES ('$email', '".md5($password)."', '$admin_type')";
	      $result = mysqli_query($con,$query);
		  if($result){
		  echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
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
                                      <h4 class="mt-0 header-title">All Flats</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM flats ORDER BY block_no, flat_no";
													if($_SESSION['admin_type']=='mgr'){
													  $sql = "SELECT * FROM flats where estate_code='".$_SESSION['estate']."' ORDER BY block_no, flat_no";
													}
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Flat number</th>
                                                            <th>Block number</th>
                                                            <?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?>
                                                            <th>Resident</th> <th>Phone</th>
                                                            <th># of equipments</th> 
															<th></th><th></th>
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['flat_no']; ?></td>
															<td><?php echo $row['block_no']; ?></td>
															<?php if($_SESSION['admin_type']=='admin'){echo "<td>".$row['estate_code']."</td>";} ?>
															<td><?php echo $row['owner']; ?></td>
															<td><?php echo $row['phone']; ?></td>
															<?php
															  $sql = "SELECT COUNT(*) AS cnt FROM equipments where flat='".$row['email']."'"; 								
														      $res = $con->query($sql);
															  $values = mysqli_fetch_assoc($res); 
															  $num_eqpm = $values['cnt']; 	
															?>
															<td><?php echo $num_eqpm;//$row['no_of_equipments']; ?></td>
															<?php
															echo "<td><a href='update_flat.php?id=" .$row['email']."&phone=" .$row['phone']."&owner=" .$row['owner']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> </td>";
															echo "<td><a href='delete_flat.php?id=" . $row['email'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>";
															echo "</tr>";
															?>
															</tr>
														<?php
														}
													} else {
														echo "No flat in database.";
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
                                      <h4 class="mt-0 header-title">Add Flat</h4>
                                        <p class="text-muted m-b-30 font-14">Enter details of a new flat.</p>
                                          <form class="" action="" method="POST">
                                            <div class="form-group">
                                              <input data-parsley-type="number" type="text" name="flat_no" class="form-control" required placeholder="Flat Number"/>
                                            </div>
											<div class="form-group">
                                              <input data-parsley-type="number" type="text" name="block_no" class="form-control" required placeholder="Block Number"/>
                                            </div>
                                            <!--<div class="form-group">
                                              <input type="text" name="flat_id" class="form-control" required placeholder="FLAT-N0_BLOCK-NO_ESTATE-CODE"/>
                                            </div>
											<div class="form-group">
                                              <input type="text" name="estate_code" class="form-control" required placeholder="Estate Code"/>
                                            </div>-->
											<?php 
											  if($_SESSION['admin_type']=='admin'){
											   include('estate_div.php'); 
											  }
											?>
											<!--<div class="form-group">
                                              <input data-parsley-type="number" type="text" name="no_of_equipments" class="form-control" required placeholder="Number of equipments"/>
                                            </div>-->
											<div class="form-group">
                                              <div>
                                                <input name="owner" type="text" class="form-control" required placeholder="Resident's name"/>
                                                </div>
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