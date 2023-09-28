<?php 
	require('auth.php'); $title ='Dues'; 
	require('../db.php'); //require('functions.php');
	//echo "<script>alert('Error');</script>";
	if($_SESSION['admin_type']=='admin'){
	   include('admin_sidebar.php'); 
	}
	else if($_SESSION['admin_type']=='mgr'){
	   include('mgr_sidebar.php');
	}
	/*else{
		echo "<script type='text/javascript'>window.top.location='login.php';</script>"; exit;
	}*/
	if (isset($_POST['flat'])){
	    $flat = stripslashes($_REQUEST['flat']);
		$flat = explode("|",$flat);
		$flat_email = $flat[0]; $flat_amnt = $flat[1]; $flat_debt = $flat[2];
	    $amount = $_REQUEST['amount'];
	    $date_paid = $_REQUEST['date_paid'];
	    //$note = $_REQUEST['note'];
		$category = $_REQUEST['category'];   
		$note = 'Building Levy'; if($category == 'devt_levy') $note = 'Development Levy';
		$payment_type = $_REQUEST['payment_type'];
		$status = $_REQUEST['status'];
		$acct_bal = acct_bal2($flat_amnt,$flat_debt);
		$new_bal = $acct_bal - $amount;
		if($acct_bal>=0){
			//echo "<script>alert('".acct_bal2($flat_amnt,$flat_debt)."');</script>";
			//echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
			if($_SESSION['admin_type']=='admin'){
			  $estate_code = stripslashes($_REQUEST['estate']); 
			}
			else if($_SESSION['admin_type']=='mgr'){
			  $estate_code = $_SESSION['estate'];
			} 
			$query = "INSERT into `dues` (flat,estate,amount,date_paid,note,category,new_bal) VALUES ('$flat_email','$estate_code',$amount,'$date_paid','$note','$category',$new_bal)";
			$query2 = "update flats set amount_paid = amount_paid - $amount,last_payment_date='$date_paid',last_payment_type='$payment_type',status='$status' where email='$flat_email'";
			$result = mysqli_query($con,$query);$result2 = mysqli_query($con,$query2);
			if($result && $result2){
			   echo "<script>alert('Estate Payment Added.');</script>";
			   echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
			}
			else{
			  $error=mysqli_error($con);
			  echo "<script>alert('Estate Payment not Added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
			}
		}
		else{
		  echo "<script>alert('The resident is owing. Cannot make Estate Payment for them.');</script>";
		  echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
		}
	}
	else{
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
										//$sql = "SELECT * FROM dues join flats on dues.flat=flats.email where flats.estate_code='".$_SESSION['estate']."'";
										$sql = "SELECT sum(amount) as total FROM dues where estate='".$_SESSION['estate']."'";
										$sql2 = "select sum(amount) as total from dues
											   where MONTH(date_paid) = MONTH(now())
											   and YEAR(date_paid) = YEAR(now()) and estate='".$_SESSION['estate']."'";
										$res = $con->query($sql); $values = mysqli_fetch_assoc($res); $total = $values['total'];
										$res = $con->query($sql2); $values = mysqli_fetch_assoc($res); $total2 = $values['total'];		
										echo '<div class="alert text-dark alert-info" role="alert">All Time Due Collected: <b>&#8358;'.currency_format($total).'</b>
										 | Due Collected This Month: <b>&#8358;'.currency_format($total2).'</b></div>';
										$sql = "SELECT * FROM dues join flats on dues.flat=flats.email where dues.estate='".$_SESSION['estate']."'";
										//$sql = "SELECT * FROM dues join flats on dues.flat=flats.email where dues.estate='".$_SESSION['estate']."'";
										}
										$result = $con->query($sql);
										if ($result->num_rows > 0) { ?>
										<table id="tech-companies-1" class="table  table-striped">
                                            <thead>
                                              <tr class="titles">
                                                <th>Flat</th><th>Block</th>
                                                <?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?>
                                                 <th>Resident</th> <th>Amount</th><th>Date paid</th> <th>Category</th><th>Note</th> <!--<th>Status</th> <th>Expiry</th>--><th>Action</th> 
                                              </tr> 
                                            </thead>
                                             <tbody> <?php while($row = $result->fetch_assoc()) { ?>
											  <tr>
												<td><?php echo $row['flat_no']; ?></td><td><?php echo $row['block_no']; ?></td><?php if($_SESSION['admin_type']=='admin'){echo "<td>".$row['estate_code']."</td>";} ?> 
										<td><?php echo $row['owner']; ?></td>
										<td><?php echo "&#8358;".$row['amount']; ?></td><td><?php echo format_date2($row['date_paid']); ?></td><td><?php echo $row['category']; ?></td><td><?php echo $row['note']; ?></td><?php //echo "<td>".$row['status']."</td>"; ?>
										<?php /*<td> $stat = $row['status']; if($stat=='good'){echo '<span class="badge badge-success">'.$stat.'</span>';} 
										else {echo '<span class="badge badge-danger">'.$stat.'</span>';} 
										</td>*/?><!--<td><?php //echo deadline(5)." days"; ?></td>-->
										<?php echo "<td><a href='update_due.php?id=" .$row['due_id']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a> </td>"; ?>
										     </tr>
										<?php
												}
											} else {
												echo "Please add dues.";
											} $con->close(); ?>                   </tbody>
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
												$sql="select flat_no,block_no,email,amount_paid,total_debt from flats where estate_code='".$_SESSION['estate']."'"; 
											    $result = $con->query($sql);; 
											    while($row = $result->fetch_assoc()) { 
												 $flat = "Flat ".$row['flat_no'].", Block ".$row['block_no'];
												 $flatt = $row['email']."|".$row['amount_paid']."|".$row['total_debt'];
											    ?>
											    <option value="<?php echo $flatt; ?>"><?php echo $flat; ?></option><?php } ?>
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
												<option value="devt_levy">Development Levy</option>
												<option value="building_levy">Building Levy</option>
											  </select>
											</div>
											<div class="form-group">
											  <label for="name">Status</label>
											  <select class="form-control" required name="status" >
											    <option value="good">Good</option>
											    <option value="owing">Owing</option>
											  </select>
											</div>
											<!--<div class="form-group">
											  <label for="name">Note</label>
											  <textarea name="note" class="form-control"  rows="3" cols="50"></textarea>
                                            </div>-->
                                            <div class="form-group">
                                               <button type="submit" class="btn btn-primary waves-effect waves-light">Add Due</button>
                                               <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button>
                                            </div>
                                          </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->   
                    </div><!-- container -->
                </div><!-- Page content Wrapper -->
            </div><!-- content -->
        <?php include('footer.php');  
		} ?>
</html>