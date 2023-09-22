<?php require('auth.php'); $title ='Estates'; ?>

	<?php
	  require('../db.php');
	  if (isset($_POST['estate_code'])){
	  $estate_name = stripslashes($_REQUEST['estate_name']);
	  $estate_code = stripslashes($_REQUEST['estate_code']);
	  $address = stripslashes($_REQUEST['address']);
	  $no_of_blocks = stripslashes($_REQUEST['no_of_blocks']);
	  $no_of_flats = stripslashes($_REQUEST['no_of_flats']);
	  $query = "INSERT into `estates` (estate_name, estate_code, address, no_of_blocks, no_of_flats) VALUES ('$estate_name', '$estate_code', '$address', $no_of_blocks, $no_of_flats)";
	  $result = mysqli_query($con,$query);
		if($result){
		  echo "<script type='text/javascript'>window.top.location='view_estates.php';</script>"; exit;
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
                                      <h4 class="mt-0 header-title">All Estates</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM estates";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Code</th>
                                                            <th>Address</th>
                                                            <th># of blocks</th>
                                                            <th># of flats</th>  
															<th></th>  <th></th>                             
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['estate_name']; ?></td>
															<td><?php echo $row['estate_code']; ?></td>
															<td><?php echo $row['address']; ?></td>
															<td><?php echo $row['no_of_blocks']; ?></td>
															<td><?php echo $row['no_of_flats']; ?></td>
															<?php
															echo "<td><a href='update_estate.php?id=" .$row['estate_code']."&flats=" .$row['no_of_flats']."&blocks=" .$row['no_of_blocks']."&address=" .$row['address']."&name=" .$row['estate_name']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> </td>";
															echo "<td><a href='delete_estate.php?id=" . $row['estate_code'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>";
															echo "</tr>";
															?>
															</tr>
														<?php
														}
													} else {
														echo "No estate in database.";
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
                                      <h4 class="mt-0 header-title">Add Estate</h4>
                                        <p class="text-muted m-b-30 font-14">Enter details of a new estate.</p>
                                          <form class="" action="" method="POST">
                                            <div class="form-group">
                                              <input type="text" name="estate_name" class="form-control" required placeholder="Name of Estate"/>
                                            </div>
                                            <div class="form-group">
                                              <input type="text" name="estate_code" class="form-control" required placeholder="Estate Code"/>
                                            </div>
											<div class="form-group">
                                              <input type="text" name="address" class="form-control" required placeholder="Full address"/>
                                            </div>
											<div class="form-group">
                                              <div>
                                                <input data-parsley-type="number" name="no_of_blocks" type="text" class="form-control" required placeholder="No. of blocks"/>
                                                </div>
                                            </div>
											<div class="form-group">
                                              <div>
                                                <input data-parsley-type="number" name="no_of_flats" type="text" class="form-control" required placeholder="No. of flats"/>
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