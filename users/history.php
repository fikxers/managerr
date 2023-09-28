		<?php
          include('auth.php'); $title='Resident Payment History';
          include ('../db.php');
		  $flat_no = $flat_email = $block = "";
		  //if( $_SESSION['admin_type']=='mgr' && isset($_GET['flat_email']) && isset($_GET['flat_no']) && isset($_GET['block'])){
		  if( ($_SESSION['admin_type']=='mgr' || $_SESSION['admin_type']=='admin') && isset($_GET['flat_id']) ){
		  	$id = $_GET['flat_id']; 
			$query = "SELECT * FROM `flats` WHERE id=$id";
		    $result = mysqli_query($con,$query) or die(mysql_error());
		    $flat = mysqli_query($con,$query) or die(mysql_error());
		    $block = mysqli_query($con,$query) or die(mysql_error());
		    $owner = mysqli_query($con,$query) or die(mysql_error());
		    $flat_email = mysqli_query($con,$query) or die(mysql_error());
		    $phone = mysqli_query($con,$query) or die(mysql_error());
			$flat_no = $flat->fetch_object()->flat_no;
			$block = $block->fetch_object()->block_no;
			$full_name = $owner->fetch_object()->owner;
			$flat_email = $flat_email->fetch_object()->email;
			$phone = $phone->fetch_object()->phone;
			if($_SESSION['admin_type']=='mgr'){ include('mgr_sidebar.php'); }
			else{ 
			  $estate = mysqli_query($con,$query) or die(mysql_error());
			  $_SESSION['estate'] = $estate->fetch_object()->estate_code;
			  include('admin_sidebar.php'); 
			}
		  }
		  else{
			include('flat_sidebar.php'); 
			$flat_no = $_SESSION['flat_no']; $flat_email = $_SESSION['email']; $block = $_SESSION['block_no'];
			$sql = "SELECT monthly_due FROM estates where estate_code='".$_SESSION['estate']."'";
		    $result = $con->query($sql);
		    $row =mysqli_fetch_assoc($result);
		    $monthly_due = $row['monthly_due'];
		    //$query = "SELECT amount_paid FROM `flats` WHERE email='".$_SESSION['email']."'";
		    $acct_bal = acct_bal2($amnt_paid,$total_debt);
		  }
		  
		?>			
					<div class="row">
						<div class="col-lg-12">
							<div class="card m-b-30">
							  <div class="card-body">
								<!--<h4 class="mt-0 header-title">Payment History for </h4>-->
								<?php if( $_SESSION['admin_type']=='mgr'){ ?>
								<h6>Payment History for <?php echo $full_name."<br><em>Flat $flat_no | Block $block</em>"; ?></h6><br>
								<?php } ?>
								<div class="table-rep-plugin">
								  <div class="table-responsive b-0" data-pattern="priority-columns">
								  <?php include ('../db.php'); //echo $_SESSION['estate'];
									//$sql = "SELECT * FROM dues join flats on dues.flat=flats.email where dues.estate='".$_SESSION['estate']."' and dues.flat='".$_SESSION['email']."' ORDER BY dues.date_paid DESC"; 
									//$sql = "SELECT note AS 'Transaction', amount AS 'Amount', date_paid AS 'Transaction Date' FROM dues where flat='ypolycarp@yahoo.com' UNION SELECT units, amount, transaction_date FROM transactions where flat='1A' AND block='33' AND estate='OBA' UNION SELECT description, amount, pay_date FROM payments where flat='1A' AND block='33' AND estate='OBA'";
									//$sql = "SELECT d.note, d.amount, d.date_paid' FROM dues d WHERE d.flat='ypolycarp@yahoo.com' AND d.estate='OBA' UNION SELECT t.units, t.amount, t.transaction_date FROM transactions t WHERE flat='1A' AND block='33' AND estate='OBA' UNION SELECT p.description, p.amount, p.pay_date FROM payments p WHERE flat='1A' AND block='33' AND estate='OBA'";
									$sql = "SELECT note, amount, date_paid FROM dues WHERE flat='".$flat_email."' AND estate='".$_SESSION['estate']."' UNION SELECT 'Electricity Vend', amount, transaction_date FROM transactions WHERE flat='".$flat_no."' AND block='".$block."' AND estate='".$_SESSION['estate']."' UNION SELECT description, amount, pay_date FROM payments WHERE flat='".$flat_no."' AND block='".$block."' AND estate='".$_SESSION['estate']."' ORDER BY date_paid";
									$result = $con->query($sql); 
									if ($result->num_rows > 0) { ?>
									<table id="tech-companies-1" class="table table-bordered table-striped table-sm">
									  <thead><tr class="titles"><th>Transaction</th><th>Transaction Date</th><th>Amount</th></tr></thead>
									  <tbody> <?php while($row = $result->fetch_assoc()) { ?>
										<tr><td><?php echo $row['note']; ?></td><td><?php echo format_date2($row['date_paid']); ?></td><td><?php echo "&#8358;".currency_format($row['amount']); ?></td></tr>
									<?php } } else {echo "No Transaction Detected.";} $con->close(); ?>
									   </tbody>
									</table>
								   </div>
								</div>
							  </div>
							</div>
						</div>
					</div> <!-- end row -->
				</div> <!-- container -->
			</div><!-- Page content Wrapper -->
		</div> <!-- content -->
		<?php include('footer.php'); ?>
</html>
