		<?php
          include('auth.php'); $title='Payment';
          include('room_sidebar.php');	  
		  if (isset($_POST['paystackPay'])){	
		    $_SESSION['price'] = $_POST['amount'];
			include('initpay.php');
		  }
		  else{
		?>
                  <div class="row">
					<div class="col-lg-12">
                      <div class="card m-b-30">
                        <div class="card-body">
                          <h4 class="mt-0 header-title">Make Payment</h4>
						  <form ><?php //echo $_SESSION['email'] ?>
						    <div class="form-row">
						      <div class="form-group col-lg-4 col-xs-12  col-md-12">
								<input type="number" name="amount" id="amount" class="form-control" value="500" min="500" step="100" />
							  </div>
							  <div class="form-group col-lg-4">
								<button type="button" class="btn btn-outline-success" onclick="payWithPaystack()"> Pay </button> 
							  </div>
						    </div>
						  </form>
                        </div>
                      </div>
                    </div> 
                  </div>
               </div>
              <!-- container -->
            </div>
            <!-- Page content Wrapper -->

            </div>
            <!-- content -->
			<script src="https://js.paystack.co/v1/inline.js"></script>
			<script>
			  function payWithPaystack(){
				var eml = "<?php echo $_SESSION['email'] ?>";
				var amnt = document.getElementById("amount").value;
				var nm = "<?php echo $_SESSION['owner'] ?>";
				var fn = "<?php echo $_SESSION['flat_no'] ?>";
				var bn = "<?php echo $_SESSION['block_no'] ?>"; 
				var estate = "<?php echo $_SESSION['estate'] ?>";
				//var amnt = Integer.parseInt(document.getElementById("amount").value);
				//var data = <?php echo json_encode("42", JSON_HEX_TAG); ?>;
				//alert(eml); alert (amnt);
				var handler = PaystackPop.setup({
				  //key: 'pk_test_95eb59aa97491928b10d0da6f53f346ba43a52b3',				
         key: 'pk_live_5b6b847567629e840f7e4fb67eb5e3b14b6199cf',
				  email: eml,//'ypolycarp@gmail.com',
				  amount: (amnt * 100),
				  //amount: 10000,
				  currency: "NGN",
				  ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
				  metadata: {
					 custom_fields: [
						{
							display_name: "Name",
							variable_name: "name",
							value: nm//"+2348012345678"
						}
						{
							display_name: "Flat #",
							variable_name: "flat_number",
							value: fn//"+2348012345678"
						}
						{
							display_name: "Block #",
							variable_name: "block_number",
							value: bn //"+2348012345678"
						}
						{
							display_name: "Estate",
							variable_name: "estate",
							value: estate //"+2348012345678"
						}
					 ]
				  },
				  callback: function(response){
					  alert('success. transaction ref is ' + response.reference);
				  },
				  onClose: function(){
					  alert('window closed');
				  }
				});
				handler.openIframe();
			  }
			</script>
		  <?php include('footer.php'); } ?>
</html>
