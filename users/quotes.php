<?php require('auth.php'); $title ='Dashboard'; ?>

    <?php include('mgr_sidebar.php'); ?>

                    <div class="row">
						<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Requested Quotes</h4>
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
															<td contenteditable="true"><?php echo $row['skill']; ?></td>															
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
                                      <h4 class="mt-0 header-title">Accepted Quotes</h4>
                                        <!--<p class="text-muted m-b-30 font-14">Enter details of a new fixer.</p>-->
                                          <form class="" action="" method="POST">
                                            <div class="table-rep-plugin">
                                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT *,flats.flat_no,flats.block_no FROM home_service join flats on flats.email=home_service.flat where home_service.status != 'completed'";
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Flat No</th> <th>Block No</th>
                                                            <th>Service</th>
															<th>Preferred Date</th>
                                                            <!--<th>Fikxer</th>--><th>Description</th>
                                                            <th></th>                                                            
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['flat_no']; ?></td>
															<td><?php echo $row['block_no']; ?></td>
															<td><?php echo $row['name']; ?></td>
															<td><?php echo $row['preferred_date']; ?></td>															
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
															 </td>-->
															 <td><input type="textarea" required name="description" class="form-control" placeholder="Add Description"/></td>
															 <td><button type="button" class="btn btn-primary btn-sm">Send for Quotes</button></td>
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
                                          </form>
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

            <?php include('footer.php'); ?>

</html>