	<?php
    include('auth.php'); $title='Fund Wallet';
    include('flat_sidebar.php');	require('../db.php');  
    // $sql = "SELECT split_code FROM estates where estate_code='".$_SESSION['estate']."'";
    // $code = mysqli_query($con,$sql) or die(mysql_error());
  	// $_SESSION['split_code'] = $code->fetch_object()->split_code;
    $split_code = $_SESSION['split_code'];
	if (isset($_POST['pay_now'])){	
		//include('paystack-initialize.php'); $_SESSION['email']
		//$purpose = $_REQUEST['answer'];
		//if($purpose = 'Others'){$purpose = $_REQUEST['otherAnswer'];}
		//$_SESSION['amount'] = $_REQUEST['amount']; //$_SESSION['purpose'] = $purpose;
		//echo "<script>alert('Split: ".$split_code."');</script>";
		echo "<script type='text/javascript'>window.top.location='paystack-initialize.php';</script>";
	}
	else{ //echo "Split: ".$_SESSION['split_code'];
	?>
            <div class="row">
		      <div class="col-lg-12">
                <div class="card m-b-30">
                  <div class="card-body">
                    <h4 class="mt-0 header-title">Select Payment Option</h4>
					<form action="" method="POST">
						<div class="form-row">
							<div class="form-group col-lg-12">
								<label>Amount: <?php echo $_SESSION['amount']; ?></label>
								<input type="hidden" name="amount" value="<?php echo $_SESSION['amount']; ?>" />
							</div>
							<?php include ('../db.php'); 
								$sql = "SELECT authorization_code,last4,email FROM authorization where estate='".$_SESSION['estate']."' and email='".$_SESSION['email']."' ORDER BY signature"; 
								$result = $con->query($sql); //echo $sql; 
								if ($result->num_rows > 0) { 
								  while($row = $result->fetch_assoc()) { ?>
									<div class="form-group col-lg-12">
									  <a href="charge_authorization.php?amount=<?php echo $_SESSION['amount']; ?>&email=<?php echo $row['email']; ?>&authorization_code=<?php echo $row['authorization_code']; ?>"><button type="button" class="btn btn-sm btn-block btn-outline-info">Pay with card ending with <?php echo $row['last4']; ?></button></a>
									</div>
								<?php } 
									} 
									$con->close(); ?>
							<div class="form-group col-lg-12">
								<button type="submit" name="pay_now" class="btn btn-sm btn-block btn-outline-danger"> Pay with new card / bank transfer </button>
								<!--<button onclick="window.history.go(-1)">Back</button>-->
							</div>
						</div>
					</form>
					<button class="btn btn-sm btn-block btn-outline-dark" onclick="history.back()">Go Back</button>
                  </div>
                </div>
              </div> 
            </div><!-- end row -->
          </div><!-- container -->
        </div><!-- Page content Wrapper -->
      </div><!-- content -->
	<?php include('footer.php'); } ?>
</html>