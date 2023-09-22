<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include('auth.php'); $title="FM Vend Electricity Token";
$meterPAN = $_GET["meterPAN"];

if($_SESSION['admin_type'] == 'admin') { include('admin_sidebar.php'); }
else if($_SESSION['admin_type'] == 'mgr') { include('mgr_sidebar.php'); }
else if($_SESSION['admin_type'] == 'flat') { include('flat_sidebar.php'); }
require('../db.php');

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
	$transactionId = "O" . DATE("dmyHis");
	if( ! ini_get('date.timezone') ){date_default_timezone_set('Africa/Lagos');}
    $transactionDate = date("Y-m-d H:i:s");
	
 ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-body">
		<form action="electric/post2.php" method="POST">
		  <div class="form-row">
			<div class="form-group col-lg-6">
			  <input type="hidden" name="transactionId" value="<?php echo $transactionId ?>" />
			  <!--<label>Meter: <?php echo $meterPAN; ?></label>-->
			  <input type="hidden" name="generated_by" value="FM" />
			  <input type="hidden" name="meterPAN" id="meterPAN" value="<?php echo $meterPAN ?>" />
			  <input type="number" min="1000" max="100000" name="value" id="value" class="form-control" placeholder="Amount to recharge" required />
			</div>
			<div class="form-group col-lg-6">
			  <input type="submit" name="vend" value="Vend Credit" class="btn btn-block btn-outline-info">
			</div>
		  </div>
		</form>
	  </div>
	</div>
  </div>
</div><!-- end row -->

</div><!-- container -->
</div><!-- Page content Wrapper -->
</div><!-- content -->
<?php include('footer.php'); ?>
</html>
