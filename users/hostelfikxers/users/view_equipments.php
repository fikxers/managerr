<?php include('auth.php'); $title ='Equipments'; ?>

	<?php
	  require('../db.php');
	  if (isset($_POST['name'])){
	    $name = stripslashes($_REQUEST['name']);
	    $location = stripslashes($_REQUEST['location']);
	    //$status = stripslashes($_REQUEST['status']);

		if($_SESSION['admin_type']=='admin'){
		  $flat = stripslashes($_REQUEST['flat']);
		  $query = "INSERT into `equipments` (name, location, flat) VALUES ('$name', '$location', '".$flat."')";
		  $result = mysqli_query($con,$query); 
		  $sql = "SELECT COUNT(*) AS cnt FROM equipments where flat='".$flat."'";
		  $res = $con->query($sql);
		  $values = mysqli_fetch_assoc($res);
		  $num_eqpm = $values['cnt']; 
		  $query2 = "UPDATE flats SET no_of_equipments=".$num_eqpm." WHERE email = '".$flat."'";
		  $result2 = mysqli_query($con,$query2);
		}
		else{
		  $query = "INSERT into `equipments` (name, location, flat) VALUES ('$name', '$location', '".$_SESSION['email']."')";
		  $result = mysqli_query($con,$query); 
		  $sql = "SELECT COUNT(*) AS cnt FROM equipments where flat='".$_SESSION['email']."'";
		  $res = $con->query($sql);
		  $values = mysqli_fetch_assoc($res);
		  $num_eqpm = $values['cnt']; 				
		  $query2 = "UPDATE flats SET no_of_equipments=".$num_eqpm." WHERE email = '".$_SESSION['email']."'";
		  $result2 = mysqli_query($con,$query2);
		}
	    
	    if($result && $result2){
		  echo "<script>alert('Equipment added successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_equipments.php';</script>"; exit;
	    }
	    else{
		  echo "<script>alert('Error adding equipment.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_equipments.php';</script>"; exit;
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
                                      <h4 class="mt-0 header-title">All Equipments</h4>
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
                                                        <tr>
                                                            <th>Name</th>
                                                            <!--<th>Status</th>-->
                                                            <th>Location</th>
															<?php if($_SESSION['admin_type']=='admin'){
															echo '<th>Flat #</th><th>Block #</th>';
															} ?><th></th><th></th>
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { 
															echo "<tr>";
															echo "<td>". $row['name']. "</td>";
															echo "<td>". $row['location']. "</td>";
															if($_SESSION['admin_type']=='admin'){
															echo "<td>". $row['flat_no']. "</td>";
															echo "<td>". $row['block_no']. "</td>";
															}
															echo "<td><a href='update.php?id=" .$row['id']."&name=".$row['name']."&location=".$row['location']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> </td> <td><a href='delete.php?id=" . $row['id'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td>";
															echo "</tr>";
														
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
                                      <h4 class="mt-0 header-title">Add Equipment</h4>
                                        <p class="text-muted m-b-30 font-14">Enter new equipment.</p>
                                          <form class="" action="" method="POST">
                                            <!--<div class="form-group">
                                              <input type="text" name="name" class="form-control" required placeholder="Name of equipment"/>
                                            </div>-->
											<div class="form-group">
											  <select class="form-control" name="name" >
											   <option value="">Select Equipment</option>
											   <option value="Generator">Generator</option>
											   <option value="Air Conditioner">Air Conditioner</option>
											   <option value="Inverter">Inverter</option>
											   <option value="Mobile Phone">Mobile Phone</option>
											   <option value="Computer / Laptop">Computer / Laptop</option>
											   <option value="CCTV">CCTV</option>
											   <option value="Gas Appliances">Gas Appliances</option>
											   <option value="Plumbing">Plumbing</option>
											   <option value="Refrigerator">Refrigerator</option>
											  </select>
											</div>
											<!--<div class="form-group">
											  <select class="form-control" name="status" >
											   <option value="">Current state of equipment</option>
											   <option value="spoilt">Spoilt</option>
											   <option value="needs_servicer">Needs Service</option>
											   <option value="okay">Okay</option>
											  </select>
                                            </div>-->
											<?php 
											  if($_SESSION['admin_type']=='admin'){
											   include('flats_div.php'); 
											  }
											?>
											<div class="form-group">
                                              <input type="text" name="location" class="form-control" required placeholder="Location in the flat"/>
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

	  <?php include('footer.php'); } ?>

</html>