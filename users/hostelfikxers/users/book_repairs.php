<?php include('auth.php'); $title ='Book Repair'; ?>
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
                                      <h4 class="mt-0 header-title">All Equipments</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM equipments";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Flat No.</th>
                                                            <th>Block No.</th>
                                                            <th>Estate Code</th>
                                                            <th>Owner</th> <th>Phone</th>
                                                            <th>No. of equipments</th>                                                            
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['flat_no']; ?></td>
															<td><?php echo $row['block_no']; ?></td>
															<td><?php echo $row['estate_code']; ?></td>
															<td><?php echo $row['owner']; ?></td>
															<td><?php echo $row['phone']; ?></td>
															<td><?php echo $row['no_of_equipments']; ?></td>
															</tr>
														<?php
														}
													} else {
														echo "You don't have any equipment yet.";
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
                                      <h4 class="mt-0 header-title">Add Equipments</h4>
                                        <p class="text-muted m-b-30 font-14">Enter new equipments.</p>
                                          <form class="" action="" method="POST">
                                            <div class="form-group">
                                              <input data-parsley-type="number" type="text" name="flat_no" class="form-control" required placeholder="Flat Number"/>
                                            </div>
											<div class="form-group">
                                              <input data-parsley-type="number" type="text" name="block_no" class="form-control" required placeholder="Block Number"/>
                                            </div>
                                            <!--<div class="form-group">
                                              <input type="text" name="flat_id" class="form-control" required placeholder="FLAT-N0_BLOCK-NO_ESTATE-CODE"/>
                                            </div>-->
											<div class="form-group">
                                              <input type="text" name="estate_code" class="form-control" required placeholder="Estate Code"/>
                                            </div>
											<div class="form-group">
                                              <input data-parsley-type="number" type="text" name="no_of_equipments" class="form-control" required placeholder="Number of equipments"/>
                                            </div>
											<div class="form-group">
                                              <div>
                                                <input name="owner" type="text" class="form-control" required placeholder="Owner name"/>
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
											<!--<div class="form-group">
                                              <div>
                                                <input name="password" type="text" class="form-control" required placeholder="Password"/>
                                                </div>
                                            </div> 
											<div class="form-group">
                                              <div>
                                                <input name="rpassword" type="text" class="form-control" required placeholder="Repeat password"/>
                                                </div>
                                            </div>-->
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

            <footer class="footer">
                © 2018 Agency - Crafted with <i class="mdi mdi-heart text-danger"></i> by Lamarena.
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <!--Morris Chart-->
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/plugins/raphael/raphael-min.js"></script>

    <script src="assets/pages/dashborad.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>