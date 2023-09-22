<?php require('auth.php'); $title ='Dues'; ?>
<?php 
/***
$date1=date_create("2013-03-15");
$date2=date_create("2013-12-12");
$diff=date_diff($date1,$date2);
echo $diff->format("%R%a days"); 
date_diff(datetime1, datetime2, absolute)
absolute	Optional. Specifies a Boolean value. TRUE indicates that the interval/difference MUST be positive. Default is FALSE

$date=date_create("2013-03-15");
echo date_format($date,"Y/m/d");

$date=date_create("2013-03-15");
echo date_format($date,"Y/m/d H:i:s");
***/
?>

	<?php
	  require('../db.php'); //require('functions.php');
	  if (isset($_POST['flat'])){
	    $flat = stripslashes($_REQUEST['flat']);
	    $amount = $_REQUEST['amount'];
	    $date_paid = $_REQUEST['date_paid'];
	    $note = $_REQUEST['note'];
		$category = $_REQUEST['category'];   
		$payment_type = $_REQUEST['payment_type'];
		$status = $_REQUEST['status'];
	    if($_SESSION['admin_type']=='admin'){
		  $estate_code = stripslashes($_REQUEST['estate']); 
		}
		else if($_SESSION['admin_type']=='mgr'){
		  $estate_code = $_SESSION['estate'];
		} 
	    $query = "INSERT into `dues` (flat,amount,date_paid,note,category) VALUES ('$flat',$amount,'$date_paid','$note','$category')";
		$query2 = "update flats set amount_paid = amount_paid + $amount,last_payment_date='$date_paid',last_payment_type='$payment_type',status='$status' where email='$flat'";
	    $result = mysqli_query($con,$query);$result2 = mysqli_query($con,$query2);
		if($result && $result2){
		   echo "<script>alert('Due Added.');</script>";
	       echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
	    }
		else{
		  $error=mysqli_error($con);
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
													  $sql = "SELECT * FROM dues join flats on dues.flat=flats.email where flats.estate_code='".$_SESSION['estate']."'";
													  //$sql = "SELECT * FROM dues join flats on dues.flat=flats.email where dues.estate='".$_SESSION['estate']."'";
													}
													$result = $con->query($sql);
													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr class="titles">
                                                            <th>Flat</th>
                                                            <th>Block</th>
                                                            <?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?>
                                                            <th>Resident</th> <th>Amount</th>
                                                            <th>Date paid</th> <th>Category</th><th>Note</th> 
															<!--<th>Status</th> <th>Expiry</th>--><th>Action</th> 
                                                        </tr> 
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['flat_no']; ?></td>
															<td><?php echo $row['block_no']; ?></td>
															<?php if($_SESSION['admin_type']=='admin'){echo "<td>".$row['estate_code']."</td>";} ?> 
															<td><?php echo $row['owner']; ?></td>
															<td><?php echo "&#8358;".$row['amount']; ?></td>
															<td><?php echo $row['date_paid']; ?></td>
															<td><?php echo $row['category']; ?></td>
															<td><?php echo $row['note']; ?></td>
															<?php //echo "<td>".$row['status']."</td>"; ?>
															<?php /*<td>
															  $stat = $row['status']; if($stat=='good'){echo '<span class="badge badge-success">'.$stat.'</span>';} 
															  else {echo '<span class="badge badge-danger">'.$stat.'</span>';} 
															</td>*/?>
															<!--<td><?php //echo deadline(5)." days"; ?></td>-->
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
											  <label for="name">Amount</label>
                                              <input data-parsley-type="number" type="number" name="amount" class="form-control" required value="0" min="0" step="100"/>
                                            </div>
											<div class="form-group">
											  <label for="name">Date paid</label>
                                              <input type="date" name="date_paid" class="form-control" required placeholder="Choose Date">
                                            </div>
											<div class="form-group">
											  <label for="name">Payment mode</label>
											  <select class="form-control" required name="payment_type" >
											    <option value="cash">Cash</option>
											    <option value="transfer">Transfer</option>
												<option value="online">Online</option>
											  </select>
											</div>
											<?php 
											  if($_SESSION['admin_type']=='admin'){
											   include('estate_div.php'); 
											  } 
											?>
											<input type="hidden" name="estate" value="<?php echo $row['estate']; ?>" />
											<div class="form-group">
											  <label for="name">Category</label>
											  <select class="form-control" required name="category" >
											    <option value="monthly_due">Monthly Due</option>
											    <option value="special_project">Special Project</option>
												<option value="donation">Donation</option>
												<option value="business">Business</option>
											  </select>
											</div>
											<div class="form-group">
											  <label for="name">Status</label>
											  <select class="form-control" required name="status" >
											    <option value="good">Good</option>
											    <option value="owing">Owing</option>
											  </select>
											</div>
											<div class="form-group">
											  <label for="name">Note</label>
											  <textarea name="note" class="form-control"  rows="3" cols="50"></textarea>
                                            </div>
                                            <div class="form-group">
                                               <div>
                                                  <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                            Add Due</button>
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