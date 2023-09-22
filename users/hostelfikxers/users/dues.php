<?php require('auth.php'); $title ='Dues'; ?>

	<?php
	  require('../db.php');
	  if (isset($_POST['flat'])){
	    $flat = stripslashes($_REQUEST['flat']);
	    $lstMntPaid = $_REQUEST['lstMntPaid'];
	    $amntOwedThisYr = $_REQUEST['amntOwedThisYr'];
	    $noMntsOwed = $_REQUEST['noMntsOwed'];
		$totalAmountOwed = $_REQUEST['totalAmountOwed'];
	    $amntOwedThisYr = $_REQUEST['amntOwedThisYr'];
	    $status = stripslashes($_REQUEST['status']);    
	    if($_SESSION['admin_type']=='admin'){
		  $estate_code = stripslashes($_REQUEST['estate']); 
		}
		else if($_SESSION['admin_type']=='mgr'){
		  $estate_code = $_SESSION['estate'];
		} 
	    $query = "INSERT into `dues` (flat,estate,lstMntlyDuePaid,noMntsOwed,totalAmountOwed,amntOwedThisYr,due_status) VALUES ('$flat','$estate_code',$lstMntPaid,$noMntsOwed,$totalAmountOwed,$amntOwedThisYr,'$status')";
	    $result = mysqli_query($con,$query);
		if($result){
		   echo "<script>alert('Due Added.');</script>";
	       echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
	    }
		else{
		  $error=mysqli_error($con);
	      //echo '<script type="text/javascript">alert("'.$order_id.'");</script>';
	      //echo '<script type="text/javascript">alert("'.$error.'");</script>';
		  echo "<script>alert('Due not Added.');</script>";
		  echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
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
                                      <h4 class="mt-0 header-title">Flat Dues</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM dues";
													if($_SESSION['admin_type']=='mgr'){
													  $sql = "SELECT * FROM dues join flats on dues.flat=flats.email where dues.estate='".$_SESSION['estate']."'";
													}
													$result = $con->query($sql);
													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
                                                            <th>Flat number</th>
                                                            <th>Block number</th>
                                                            <?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?>															
                                                            <th>Resident</th> <th>Due paid last month</th>
                                                            <th># of months owed</th> <th>Debt this year</th><th>Total Debts</th> <th>Status</th><!--<th># Flats paid till date</th><th>#Flats owing till date</th>--><th></th>
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['flat_no']; ?></td>
															<td><?php echo $row['block_no']; ?></td>
															<?php if($_SESSION['admin_type']=='admin'){echo "<td>".$row['estate']."</td>";} ?> 
															<td><?php echo $row['owner']; ?></td>
															<td><?php echo $row['lstMntlyDuePaid']; ?></td>
															<td><?php echo $row['noMntsOwed']; ?></td>
															<td><?php echo $row['amntOwedThisYr']; ?></td>
															<td><?php echo $row['totalAmountOwed']; ?></td>
															<td>
															  <?php if($row['due_status']=='Good'){echo '<span class="badge badge-success">Good</span>';} 
															      else {echo '<span class="badge badge-danger">Bad</span>';} ?>
															</td>
															<!--<td><a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-success m-r-10"></i> </a></td><td><a id="delete" href="#"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a></td>-->
															<?php echo "<td><a href='update_due.php?id=" .$row['due_id']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> </td>"; ?>
															</tr>
														<?php
														}
													} else {
														echo "Please add dues.";
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
                                      <h4 class="mt-0 header-title">Add Due</h4>
                                        <!--<p class="text-muted m-b-30 font-14">Enter details of a new flat.</p>-->
                                          <form class="" action="" method="POST">
										    <div class="form-group">
											  <label for="name">Select Flat</label>
											  <select class="form-control" required name="flat" >
											    <!--<option value="">Select Flat</option>-->
											    <?php include ('../db.php');
												$sql="select flat_no,block_no,email from flats where estate_code='".$_SESSION['estate']."'"; 
											    $result = $con->query($sql);; 
											    while($row = $result->fetch_assoc()) { 
												 $flat = "Flat ".$row['flat_no'].", Block ".$row['block_no'];
											    ?>
											    <option value="<?php echo $row['email']; ?>"><?php echo $flat; ?></option><?php } ?>
											  </select>
											</div>
                                            <div class="form-group">
											 <label for="name">Last monthly due paid</label>
                                              <input data-parsley-type="number" type="number" name="lstMntPaid" class="form-control" required value="0" min="0" step="100"/>
                                            </div>
											<div class="form-group">
											  <label for="name"># of Months owed to date</label>
                                              <input data-parsley-type="number" type="number" name="noMntsOwed" class="form-control" required value="0" min="0" step="1"/>
                                            </div>
											<?php 
											  if($_SESSION['admin_type']=='admin'){
											   include('estate_div.php'); 
											  } 
											?>
											<input type="hidden" name="estate" value="<?php echo $row['estate']; ?>" />
											<div class="form-group">
											  <label for="name">Total Dues owed</label> 
                                              <input data-parsley-type="number" type="number" name="totalAmountOwed" class="form-control" required value="0" min="0" step="100"/>
                                            </div>
											<div class="form-group">
											  <label for="name">Total Dues owed this year</label>
                                              <input data-parsley-type="number" type="number" name="amntOwedThisYr" class="form-control" required value="0" min="0" step="100"/>
                                            </div>
											<div class="form-group">
                                              <div>
											    <label for="name">Dues Status</label>
											    <select class="form-control" required name="status" >
											      <option value="Good">Good</option>
											      <option value="Bad">Bad</option>
											    </select>
                                                <!--<input name="status" type="text" class="form-control" required placeholder="Status"/>-->
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