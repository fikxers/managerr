<?php include('auth.php'); $title ='Assets Register'; ?>

	<?php
	  require('../db.php');
	  if (isset($_POST['name'])){
	    $page = 'view_equipments';
		include("tmpl/add_asset_script.php");
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
				    <div class="row">       
						<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">All Assets</h4>
									  <!--<span style="float: right"><a data-toggle="modal" data-target="#ordermodal" data-original-title="Raise Work Request"><i class="fa fa-bullhorn text-success m-r-10 m-b-10"> <b>Raise Work Request</b></i></a></span>-->
									  <button type='button' class='btn btn-danger btn-sm' style='border-radius: 10px; float: right;' data-toggle='modal' data-target='#assetmodal' data-original-title='Add Asset'><i class='fa fa-plus'></i><b> Add Asset</b></button>
									  <!--<span style="float: right"><a data-toggle="modal" data-target="#assetmodal" data-original-title="Add Asset"><i class="fa fa-plus text-info m-r-10 m-b-10"> <b>Add Asset</b></i></a></span>--><br><br>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" style="overflow-y: scroll;" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM equipments where flat='".$_SESSION['email']."'";
													if($_SESSION['admin_type']=='admin'){$sql = "SELECT * FROM equipments join flats on equipments.flat=flats.email";}
													$result = $con->query($sql);

													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr class="titles">
                                                            <th>Name</th>
                                                            <!--<th>Status</th>-->
															<th>Brand</th><th>Model</th><th>Size</th>
                                                            <th>Location</th>
															<?php if($_SESSION['admin_type']=='admin'){
															echo '<th>Flat #</th><th>Block #</th>';
															} ?><th>Action</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { 
															$n = $row['name'];
															echo "<tr>";
															echo "<td>". $row['name']. "</td>";
															echo "<td>". $row['brand']. "</td>";echo "<td>". $row['model']. "</td>";echo "<td>". $row['size']. "</td>";
															echo "<td>". $row['location']. "</td>";
															if($_SESSION['admin_type']=='admin'){
															echo "<td>". $row['flat_no']. "</td>";
															echo "<td>". $row['block_no']. "</td>";
															}															
															echo "<td><a href='update.php?id=" .$row['id']."&name=".$row['name']."&brand=".$row['brand']."&model=".$row['model']."&size=".$row['size']."&location=".$row['location']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> <a href='delete.php?id=" . $row['id'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a><button type='button' class='btn btn-info btn-sm' style='background-color: transparent; padding-left: 0px; border-width: 0px;' data-toggle='modal' data-target='#ordermodal".$row["id"]."' data-toggle='tooltip' data-original-title='Raise Work Request'><i class='fa fa-calendar text-info'></i></button></td>";
															include('tmpl/work_request2.php');	
															echo "</tr>";
														
														}
													} else {
														echo "You don't have any Asset yet.";
													}
													$con->close();
													?>                                                       
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
										<!-- Modal -->
										<div class="modal fade" id="assetmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
											  <div class="modal-content">
												<div class="modal-header">
												  <h5 class="modal-title" id="exampleModalLongTitle">Add new Asset</h5>
												  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												  </button>
												</div>
												<div class="modal-body">
												    <?php include('tmpl/add_asset.php');	?>
												</div>
											  </div>
											</div>
										</div>
										<!-- Modal -->
                                    </div>
                        </div> <!-- end col -->   
                    </div>
                    <!-- container -->

                </div>
                <!-- Page content Wrapper -->

            </div>
            <!-- content -->

	  <?php include('footer.php'); } ?>

</html>