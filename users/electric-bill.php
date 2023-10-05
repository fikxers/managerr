<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include('auth.php'); $title="Electricity Bill Payment";
//if($_SESSION['admin_type'] == 'admin') { include('admin_sidebar.php'); }
if(isset($_GET['id']) && $_SESSION['admin_type']=='admin'){
	include('admin_sidebar.php'); $_SESSION['estate'] = $_GET['id'];
}
else if($_SESSION['admin_type'] == 'mgr') { include('mgr_sidebar.php'); }
else if($_SESSION['admin_type'] == 'flat') { include('flat_sidebar.php'); }
require('../db.php');
//Set FM Meter PAN
if (isset($_POST['fmmeterPAN'])){    
    $meter_pan = $_POST['fmmeterPAN']; 
	$query = "UPDATE estates set meter_pan = '".$meter_pan."' WHERE estate_code = '".$_SESSION['estate']."'";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('FM Meter PAN set successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='electric-bill.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error: ".mysqli_error()."');</script>";
	  echo "<script type='text/javascript'>window.top.location='electric-bill.php';</script>"; exit;
	}
}
//Set Resident Meter PAN
else if (isset($_POST['meterPAN'])){    
  $meter_pan = $_POST['meterPAN']; 
	$query = "UPDATE flats set meter_pan = '".$meter_pan."' WHERE flat_no = '".$_SESSION['flat_no']."' AND block_no = '".$_SESSION['block_no']."' AND estate_code = '".$_SESSION['estate']."'";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Meter PAN set successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='electric-bill.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error: ".mysqli_error()."');</script>";
	  echo "<script type='text/javascript'>window.top.location='electric-bill.php';</script>"; exit;
	}
}
//Update Resident Meter PAN
else if (isset($_POST['updatemeter'])){    
    $flat = $_POST['flat']; $block = $_POST['block']; $newpan = $_POST['newpan']; 
	$query = "UPDATE flats set meter_pan = '".$newpan."' WHERE flat_no = '".$flat."' AND block_no = '".$block."' AND estate_code = '".$_SESSION['estate']."'";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Meter PAN updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='electric-bill.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error: ".mysqli_error()."');</script>";
	  echo "<script type='text/javascript'>window.top.location='electric-bill.php';</script>"; exit;
	}
}

//Add External Transaction
else if (isset($_POST['addtransaction'])){ 
    $flat = $_POST['flat']; $block = $_POST['block']; $id = $_POST['id']; 
    $transaction = $_POST['transid']; $owner = $_POST['owner']; 
    
	echo "<script type='text/javascript'>window.top.location='electric/addtransaction.php?transaction=".$transaction."&flat=".$flat."&block=".$block."&owner=".$owner."&id=$id';</script>"; exit;
}

$permitted_chars = '0123456789';
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}
$final = generate_string($permitted_chars, 2);
$meterPAN="";
//$transactionID=$final.DATE("dmyHis");
$transactionId = "O" . DATE("dmyHis");
date_default_timezone_set('Africa/Lagos');
$transactionDate = date("Y-m-d H:i:s");

if($_SESSION['admin_type'] == 'flat') {  ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-body">
				<?php require('../db.php'); $meterPAN = "";
				$sql = "SELECT meter_pan FROM flats where estate_code='".$_SESSION['estate']."' AND flat_no='".$_SESSION['flat_no']."' AND block_no='".$_SESSION['block_no']."'";
				$result = $con->query($sql);
				$row =mysqli_fetch_assoc($result);
				$meterPAN = $row['meter_pan'];
				if ($meterPAN == NULL) {
				  $meterPAN = "Meter PAN not set";				  
				}  
				$acct_bal = acct_bal2($amnt_paid,$total_debt);	
				//Get estate max electric payment allowed		
				$maxMonthlyPayment = "select maxMonthlyPayment from estates where estate_code='".$_SESSION['estate']."'";
				$result = mysqli_query($con,$maxMonthlyPayment) or die(mysqli_error($con));
				$m = $result->fetch_object()->maxMonthlyPayment;
				//Get the electric resident has paid this month
				$electric_this_month = "select electric_this_month from flats where estate_code='".$_SESSION['estate']."' AND flat_no='".$_SESSION['flat_no']."' AND block_no='".$_SESSION['block_no']."'";
				$result = mysqli_query($con,$electric_this_month) or die(mysqli_error($con));
				$e = $result->fetch_object()->electric_this_month;
				//Get last date of electricity payment
				$l = 0; //initialize
				$last_electricity_payment = "select transaction_date from transactions where estate='".$_SESSION['estate']."' AND flat='".$_SESSION['flat_no']."' AND block='".$_SESSION['block_no']."'";
				$result=mysqli_query($con,$last_electricity_payment);
				if (mysqli_num_rows($result) > 0){
				    $l = $result->fetch_object()->transaction_date;
				}
			  ?>
			  <label>Meter PAN: <?php echo $meterPAN; ?></label><?php if ($meterPAN == "Meter PAN not set") { ?><span style="float: right"><button type='button' class='btn btn-dark btn-outline btn-sm' data-toggle='modal' data-target='#metermodal' data-original-title='Set Meter PAN'>Set Meter PAN</button></span><?php } ?>
			  <br><label>Your Account Balance: <?php echo "&#8358;".$acct_bal; ?></label>
			  <div id = 'ajaxDiv'></div>
			  <!-- Set Meter Modal -->
			  <div class="modal fade" id="metermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
				    <div class="modal-header">
					  <h5 class="modal-title" id="exampleModalLongTitle">Set Meter PAN?</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					  <form action="" method="POST">
					   <!--<form id="form" action="javascript:postData()">-->
					    <div class="form-group">
					      <input type="text" name="meterPAN" id="meterPAN" class="form-control inputs" placeholder="Meter PAN" required /><br>
						  <input type="submit" name="setmeterpan" value="Yes. Set" class="btn btn-block btn-outline-info" />
						</div>
					  </form>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- /Set Meter Modal -->
			  <?php if($acct_bal >= 0){ //make sure they set their meter ?> 
			  <form action="electric/post2.php" method="POST">
				<div class="form-row">
				  <div class="form-group col-lg-6">
					<input type="hidden" name="transactionId" value="<?php echo $transactionId ?>" />
					<input type="hidden" name="meterPAN" id="meterPAN" value="<?php echo $meterPAN ?>" />
					<input type="hidden" name="estate_max_electric" value="<?php echo $m ?>" />
					<input type="hidden" name="electric_this_month" value="<?php echo $e ?>" />
					<input type="hidden" name="last_electricity_payment" value="<?php echo $l ?>" />
					<input type="hidden" name="generated_by" value="Self" />
					<input type="number" title="NB: You cannot buy more than your account balance!" step="500" min="500" max="<?php echo $acct_bal; ?>" name="value" id="value" class="form-control" placeholder="Amount to recharge" required />
				  </div>
				  <div class="form-group col-lg-6">
					<input type="submit" name="vend" value="Vend Credit" class="btn btn-block btn-outline-info">
				  </div>
				</div>
			  </form>	
			  <?php }
			  // else if ($meterPAN == "Meter PAN not set" || $meterPAN == NULL){
			  // 	echo "Meter not Set.";
			  // } 
				else{
					echo "You cannot vend on negative balance.";
				}
			  ?>
	  </div>
	</div>
  </div>
</div><!-- end row -->

<?php } ?>
	<div class="row">
	  <div class="col-md-12">
		<div class="card m-b-30">
          <div class="card-body">
	        <?php  
			//echo last_day_of_the_month();
			include("tmpl/transactions.php");   ?>
		  </div>
		</div>
	  </div>
	</div>
	<?php	if($_SESSION['admin_type'] != 'flat') {  ?>	
	<div class="row">
	  <div class="col-md-12">
		<div class="card m-b-30">
          <div class="card-body">
			<?php require('../db.php'); $meterPAN = "";
				$sql = "SELECT meter_pan FROM estates where estate_code='".$_SESSION['estate']."'";
				$result = $con->query($sql);
				$row =mysqli_fetch_assoc($result);
				$meterPAN = $row['meter_pan'];
				if ($meterPAN == NULL) {
				  $meterPAN = "Not set";				  
				}
			  ?>
			  <label>FM Meter PAN: <?php echo $meterPAN; ?></label><?php if ($meterPAN == "Not set") { ?><span style="float: right"><button type='button' class='btn btn-dark btn-outline btn-sm' data-toggle='modal' data-target='#metermodalfm' data-original-title='Set Meter PAN'>Set Meter PAN</button></span><?php } else { ?>
			  <span style="float: right"><a type='button' href='mgr_vend.php?meterPAN=<?php echo $meterPAN; ?>'><button type='button' class='btn btn-danger btn-outline btn-sm' data-toggle='modal' data-target='#metermodal' data-original-title='Set Meter PAN'>Vend</button></a></span> <?php } 
			  //$_SESSION['flat_no'] = 0; $_SESSION['block_no'] = 0; ?>
			  <div id = 'ajaxDiv'></div>
			  <!-- Set Meter Modal -->
			  <div class="modal fade" id="metermodalfm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
				    <div class="modal-header">
					  <h5 class="modal-title" id="exampleModalLongTitle">Set FM Meter PAN?</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					  <form action="" method="POST">
					    <div class="form-group">
					      <input type="text" name="fmmeterPAN" class="form-control inputs" placeholder="FM Meter PAN" required /><br>
						  <input type="submit" name="fmsetmeter" value="Yes. Set" class="btn btn-block btn-outline-info" />
						</div>
					  </form>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- /Set Meter Modal -->
	        <?php  include("tmpl/meters.php");   ?>
		  </div>
		</div>
	  </div>
	</div>
	<?php	 }  ?>
	<!-- List Meters Modal 
			  <div class="modal fade" id="listmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
				    <div class="modal-header">
					  <h5 class="modal-title" id="exampleModalLongTitle">Set Meter PAN?</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					  <?php  //include("tmpl/meters.php"); ?>
					</div>
				  </div>
				</div>
			  </div>
	<!-- /List Meters Modal -->
</div><!-- container -->
</div><!-- Page content Wrapper -->
</div><!-- content -->
<?php include('footer.php'); ?>
</html>