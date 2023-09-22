		<?php
      include('auth.php'); $title='Fund Wallet';
      include('flat_sidebar.php');	  
		  if (isset($_POST['pay_now'])){	
			//include('paystack-initialize.php'); $_SESSION['email']
			//$purpose = $_REQUEST['answer'];
			//if($purpose = 'Others'){$purpose = $_REQUEST['otherAnswer'];}
			$_SESSION['amount'] = $_REQUEST['amount']; //$_SESSION['purpose'] = $purpose;
			echo "<script type='text/javascript'>window.top.location='proceed_pay.php';</script>";
		  }
		  else{
		?>
	    <div class="row">
		  <div class="col-lg-12">
	        <div class="card m-b-30">
	          <div class="card-body">
	      	    <h4 class="mt-0 header-title">Enter Amount</h4>
				<form action="" method="POST">
				  <div class="form-row">
					<div class="form-group col-lg-12">
					  <input type="number" name="amount" class="form-control" value="500" min="500" step="100" />
					</div>
					<!--<div class="form-group col-lg-12">
						<label>What is the payment for?</label><br>
						Estate Levy <input class="form-control form-control" type="radio" name="answer" checked="checked" value="Levy"/> <br><br>
                        Project Support <input class="form-control form-control" type="radio" name="answer" value="Project"/> <br><br>
						Others <input class="form-control form-control" type="radio" name="answer" value="Others"/><br>
						<input class="form-control form-control" style="display:none;" type="text" name="otherAnswer" id="otherAnswer"/>
					</div>-->
					<div class="form-group col-lg-12">
					  <button type="submit" name="pay_now" class="btn btn-sm btn-block btn-outline-success"> Proceed </button>
					</div>
				  </div>
				</form>
	          </div>
	        </div>
	      </div> 
	    </div>
	    <!-- end row -->
	  </div><!-- container -->
	</div><!-- Page content Wrapper -->
</div><!-- content -->
<?php include('footer.php'); } ?>
</html>
