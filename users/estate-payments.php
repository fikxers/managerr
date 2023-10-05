		<?php
      include('auth.php'); $title='Estate Payments';
      include ('../db.php');
      if( ($_SESSION['admin_type']=='admin') && isset($_GET['flat_id']) ){
		  	$id = $_GET['flat_id']; 
				$query = "SELECT * FROM `flats` WHERE id=$id";
		    $result = mysqli_query($con,$query) or die(mysql_error());
		    $flat = mysqli_query($con,$query) or die(mysql_error());
		    $block = mysqli_query($con,$query) or die(mysql_error());
		    $owner = mysqli_query($con,$query) or die(mysql_error());
		    $flat_email = mysqli_query($con,$query) or die(mysql_error());
		    $phone = mysqli_query($con,$query) or die(mysql_error());
		    $amnt_paid = mysqli_query($con,$query) or die(mysql_error());
		    $total_debt = mysqli_query($con,$query) or die(mysql_error());
				$flat_no = $flat->fetch_object()->flat_no;
				$block = $block->fetch_object()->block_no;
				$full_name = $owner->fetch_object()->owner;
				$flat_email = $flat_email->fetch_object()->email;
				$phone = $phone->fetch_object()->phone;
				$amnt_paid = $amnt_paid->fetch_object()->amount_paid;
				$total_debt = $total_debt->fetch_object()->total_debt;
				$estate = mysqli_query($con,$query) or die(mysql_error());
				$estate_code = $estate->fetch_object()->estate_code;
				include('admin_sidebar.php'); 
		  }
			else if($_SESSION['admin_type']=='flat'){
				include('flat_sidebar.php'); $estate_code = $_SESSION['estate'];
				$id = $_SESSION['id']; $flat_email = $_SESSION['email'];
			}
			else{
				echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
			}

		  $sql = "SELECT monthly_due FROM estates where estate_code='".$estate_code."'";
		  $result = $con->query($sql);
		  $row =mysqli_fetch_assoc($result);
		  $monthly_due = $row['monthly_due'];
		  //$query = "SELECT amount_paid FROM `flats` WHERE email='".$flat_email."'";
		  $acct_bal = acct_bal2($amnt_paid,$total_debt);
		  //echo $acct_bal;
		  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
				//Make sure resident has money in wallet
				date_default_timezone_set('Africa/Lagos');
				$pay_date = date("Y-m-d H:i:s"); 
				if($acct_bal >= 0){ 
				  //service charge payment
				  if (isset($_POST['pay_service_charge']) && $_REQUEST['amount']<=$acct_bal){
					$amount = $_REQUEST['amount']; $levy = $_REQUEST['answer']; 
					$note = "Estate ".$levy; $new_bal = $acct_bal - $amount;
					$pay_due_query = "INSERT INTO `dues`(`flat`,`estate`, `amount`, `date_paid`, `note`, `category`,`new_bal`) VALUES ('".$flat_email."','".$estate_code."',$amount,'".$pay_date."','".$note."','service_charge',$new_bal)";
					$result2 = mysqli_query($con,$pay_due_query); 
					if($result2){
					  $change_bal = "UPDATE flats set amount_paid=amount_paid-$amount WHERE id=".$id; $result = mysqli_query($con,$change_bal); 
					  echo "<script>alert('".$levy." Paid Successfully.');</script>";
					  echo "<script type='text/javascript'>window.top.location='estate-payments.php';</script>"; exit;
					}
					else{
					  echo "<script>alert('Error: ".mysqli_error($con)."');</script>";
					  echo "<script type='text/javascript'>window.top.location='estate-payments.php';</script>"; exit;
					}
				  }
				  //monthly due payment
				  else if (isset($_POST['pay_due']) && ($_REQUEST['months']*$monthly_due)<=$acct_bal){
					$months = $_REQUEST['months']; $total = $months*$monthly_due;
					$note = "Monthly due for $months months"; $new_bal = $acct_bal - $total;
					$pay_due_query = "INSERT INTO `dues`(`flat`,`estate`, `amount`, `date_paid`, `note`, `category`,`new_bal`) VALUES ('".$flat_email."','".$estate_code."',$total,'".$pay_date."','".$note."','monthly_due',$new_bal)";
					$result2 = mysqli_query($con,$pay_due_query); 
					if($result2){
					  $change_bal = "UPDATE flats set amount_paid=amount_paid-$total WHERE id=".$id; $result = mysqli_query($con,$change_bal); 
					  echo "<script>alert('Monthly Due Paid Successfully.');</script>";
					  echo "<script type='text/javascript'>window.top.location='estate-payments.php';</script>"; exit;
					}
					else{
					  echo "<script>alert('Error: ".mysqli_error($con)."');</script>";
					  echo "<script type='text/javascript'>window.top.location='estate-payments.php';</script>"; exit;
					}
				  }
				  else{
					echo "<script>alert('You need to Fund your  Wallet.');</script>";
				    echo "<script type='text/javascript'>window.top.location='pay.php';</script>";
				  }
				}
			  else{
				  echo "<script>alert('Account Balance Low. Please Fund Wallet.');</script>";
				  echo "<script type='text/javascript'>window.top.location='pay.php';</script>";
				}
		  }
		  else{
		?>
					<div class="row">
						<div class="col-lg-12">
						  <div class="card m-b-30">
							<div class="card-body">
								<h4 class="mt-0 header-title">Estate Levies</h4>
								<p>Balance: <?php echo "&#8358;".currency_format($acct_bal); ?></p>
								<form action="" method="POST">
									<div class="form-row">
										<div class="form-group col-lg-12">
										  <label>Amount to Pay</label>
										  <input type="number" name="amount" class="form-control" min="500" step="100" required />
										</div>
										<div class="form-group col-lg-12">
										  <label>What is the payment for?</label><br>
										   Development Levy <input class="" type="radio" name="answer" checked="checked" value="Development Levy" /> 
										   Building Levy <input class="" type="radio" name="answer" value="Building Levy" />
										</div>
										<div class="form-group col-lg-12">
										  <button type="submit" name="pay_service_charge" class="btn btn-sm btn-block btn-outline-primary"> Pay Levy </button>
										</div>
									</div>
								</form>
							</div>
						  </div>
						</div> 
						<div class="col-lg-12">
							<div class="card m-b-30">
							  <div class="card-body">
								<h4 class="mt-0 header-title">Recent Transactions</h4>
								<div class="table-rep-plugin">
								  <div class="table-responsive b-0" data-pattern="priority-columns">
								  <?php include ('../db.php'); //echo $estate_code;
									$sql = "SELECT * FROM dues join flats on dues.flat=flats.email where dues.estate='".$estate_code."' and dues.flat='".$flat_email."' ORDER BY dues.date_paid DESC"; $result = $con->query($sql); 
									if ($result->num_rows > 0) { ?>
									<table id="tech-companies-1" class="table table-bordered table-striped table-sm">
									  <thead><tr class="titles"><th>Payment Amount</th><!--<th>Payment Mode</th>--> <th>Date Paid</th><th>Note</th><th>New Balance</th> </tr></thead>
									  <tbody> <?php while($row = $result->fetch_assoc()) { ?>
										<tr><td><?php echo "&#8358;".$row['amount']; ?></td><!--<td><?php echo $row['last_payment_type']; ?></td>--><td><?php echo format_date2($row['date_paid']); //$row['last_payment_date'] ?></td><td><?php echo $row['note']; ?></td><td><?php if($row['new_bal'] != NULL) echo "&#8358;".currency_format($row['new_bal']); else echo 'NA'; ?></td></tr>
									<?php } } else {echo "No Transaction Detected.";} $con->close(); ?>
									   </tbody>
									</table>
								   </div>
								</div>
							  </div>
							</div>
						</div>
						<!-- <div class="col-lg-6">
              <div class="card m-b-30">
                <div class="card-body">
                  <h4 class="mt-0 header-title">Monthly Estate Dues</h4>
								  <p>Balance: <?php echo "&#8358;".currency_format($acct_bal); ?></p>
								  <form action="" method="POST">
								   <div class="form-row">
									<!--<div class="form-group col-lg-6">
									  <label>Amount to Pay</label>
									  <input type="number" name="amount" class="form-control" value="500" min="500" step="100" />
									</div>--
									<div class="form-group col-lg-12">
									  <label>Number of Months [&#8358;<?php echo currency_format($monthly_due); ?> per month]</label>
									  <input type="number" name="months" class="form-control" value="1" min="1" required />
									</div>
									<div class="form-group col-lg-12">
									  <button type="submit" name="pay_due" class="btn btn-sm btn-block btn-outline-primary"> Pay </button>
									</div>
								   </div>
								  </form>
                </div>
              </div>
            </div> --> 
					</div> <!-- end row -->
				</div> <!-- container -->
			</div><!-- Page content Wrapper -->
		</div> <!-- content -->
		<?php include('footer.php'); } ?>
</html>
