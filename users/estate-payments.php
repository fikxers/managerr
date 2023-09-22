		<?php
      include('auth.php'); $title='Estate Payments';
      include('flat_sidebar.php'); include ('../db.php');
		  $sql = "SELECT monthly_due FROM estates where estate_code='".$_SESSION['estate']."'";
      $result = $con->query($sql);
		  $row =mysqli_fetch_assoc($result);
		  $monthly_due = $row['monthly_due'];
		  //$query = "SELECT amount_paid FROM `flats` WHERE email='".$_SESSION['email']."'";
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
					$note = "Estate ".$levy;
					$pay_due_query = "INSERT INTO `dues`(`flat`,`estate`, `amount`, `date_paid`, `note`, `category`) VALUES ('".$_SESSION['email']."','".$_SESSION['estate']."',$amount,'".$pay_date."','".$note."','service_charge')";
					$result2 = mysqli_query($con,$pay_due_query); 
					if($result2){
					  $change_bal = "UPDATE flats set amount_paid=amount_paid-$amount WHERE id=".$_SESSION['id']; $result = mysqli_query($con,$change_bal); 
					  echo "<script>alert('".$levy." Paid Successfully.');</script>";
					  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
					}
					else{
					  echo "<script>alert('Error: ".mysqli_error($con)."');</script>";
					  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
					}
				  }
				  //monthly due payment
				  else if (isset($_POST['pay_due']) && ($_REQUEST['months']*$monthly_due)<=$acct_bal){
					$months = $_REQUEST['months']; 
					$total = $months*$monthly_due;
					$note = "Monthly due for $months months";
					$pay_due_query = "INSERT INTO `dues`(`flat`,`estate`, `amount`, `date_paid`, `note`, `category`) VALUES ('".$_SESSION['email']."','".$_SESSION['estate']."',$total,'".$pay_date."','".$note."','monthly_due')";
					$result2 = mysqli_query($con,$pay_due_query); 
					if($result2){
					  $change_bal = "UPDATE flats set amount_paid=amount_paid-$total WHERE id=".$_SESSION['id']; $result = mysqli_query($con,$change_bal); 
					  echo "<script>alert('Monthly Due Paid Successfully.');</script>";
					  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
					}
					else{
					  echo "<script>alert('Error: ".mysqli_error($con)."');</script>";
					  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; exit;
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
								  <?php include ('../db.php');
									$sql = "SELECT * FROM dues join flats on dues.flat=flats.email where flats.estate_code='".$_SESSION['estate']."' and dues.flat='".$_SESSION['email']."' ORDER BY dues.date_paid DESC"; $result = $con->query($sql); 
									if ($result->num_rows > 0) { ?>
									<table id="tech-companies-1" class="table  table-striped table-sm">
									  <thead><tr class="titles"><th>Payment Amount</th><!--<th>Payment Mode</th>--> <th>Date Paid</th><th>Note</th> </tr></thead>
									  <tbody> <?php while($row = $result->fetch_assoc()) { ?>
										<tr><td><?php echo "&#8358;".$row['amount']; ?></td><!--<td><?php echo $row['last_payment_type']; ?></td>--><td><?php echo $row['date_paid']; //$row['last_payment_date'] ?></td><td><?php echo $row['note']; ?></td></tr>
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
