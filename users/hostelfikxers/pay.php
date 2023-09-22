		<?php
          include('auth.php'); $title='Payment';
          include('flat_sidebar.php');	  
		  if (isset($_POST['paystackPay'])){	
		    $_SESSION['price'] = $_POST['amount'];
			include('initpay.php');
			//echo "<script>alert('".$_SESSION['price']."".$_SESSION['email']."');</script>";
			//echo "<script type='text/javascript'>window.top.location='pay.php';</script>"; exit;
		    //include('initialize.php');
		  }
		  else{
			//echo "<script>alert('Error');</script>";
		?>
                      <div class="row">
						<div class="col-lg-12">
                              <div class="card m-b-30">
                                  <div class="card-body">
                                      <h4 class="mt-0 header-title">Dues Info</h4>
                                        <div class="table-rep-plugin">
                                           <div class="table-responsive b-0" data-pattern="priority-columns">
                                               
												   <?php
													include ('../db.php');
													$sql = "SELECT * FROM dues where flat='".$_SESSION['email']."'";
													$sql2 = "SELECT sum(totalAmountOwed) AS cnt FROM dues where estate='".$_SESSION['estate']."'";
													$result = $con->query($sql); $result2 = $con->query($sql2);
													$values = mysqli_fetch_assoc($result2); 
								                    $total = $values['cnt']; 
													if ($result->num_rows > 0) { ?>
													<table id="tech-companies-1" class="table  table-striped">
                                                      <thead>
                                                        <tr>
														    <th>Due paid last month</th><th># of months owed</th> <th>My Debt this year</th><th>My Total Debts</th> <th>Status</th><th>All Flats debts till date</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody> <?php
														while($row = $result->fetch_assoc()) { ?>
															<tr>
															<td><?php echo $row['lstMntlyDuePaid']; ?></td>
															<td><?php echo $row['noMntsOwed']; ?></td>
															<td><?php echo $row['amntOwedThisYr']; ?></td>
															<td><?php echo $row['totalAmountOwed']; ?></td>
															<td>
															  <?php if($row['due_status']=='Good'){echo '<span class="badge badge-success">Good</span>';} 
															      else {echo '<span class="badge badge-danger">Bad</span>';} ?>
															</td>
															<td><?php echo $total; ?></td>
															</tr>
														<?php
														}
													} else {
														echo "Please contact Estate Manager.";
													}
													$con->close();
													?>                                                       
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                        </div> 
					    <div class="col-lg-12">
                          <div class="card m-b-30">
                            <div class="card-body">
                              <h4 class="mt-0 header-title">Make Payment</h4>
							  <form >
							   <div class="form-row">
								<div class="form-group col-lg-4 col-xs-12  col-md-12">
								  <input type="number" name="amount" id="amount" class="form-control" value="500" min="500" step="100" />
								</div>
								<div class="form-group col-lg-4">
								  <button type="button" class="btn btn-outline-success" onclick="payWithPaystack()"> Pay </button> 
								</div>
							   </div>
							  </form>

							  <form method="POST" action="">
                                <div class="form-row">
								  <div class="form-group col-lg-4 col-xs-12  col-md-12">
									<input type="number" name="amount" class="form-control" value="500" min="500" step="100" />
								  </div>
								  <div class="form-group col-lg-4">
									<button class="btn btn-outline-success" name="paystackPay">Pay</button>
									<input class="btn btn-primary" type="reset" id="gridCheck">
								  </div>
								</div>     
							  </form>
                            </div>
                          </div>
                        </div> 
                      </div>
                      <!-- end row -->

                    </div>
                    <!-- container -->

                </div>
                <!-- Page content Wrapper -->

            </div>
            <!-- content -->
			<script src="https://js.paystack.co/v1/inline.js"></script>
			<script>
			  function payWithPaystack(){
				//var eml = "<?php echo $_SESSION['email'] ?>";
				//var amnt = Integer.parseInt(document.getElementById("amount").value);
				//alert(eml); alert (amnt);
				var handler = PaystackPop.setup({
				  key: 'pk_test_95eb59aa97491928b10d0da6f53f346ba43a52b3',				  
				  email: 'ypolycarp@gmail.com',
				  amount: 10000,
				  currency: "NGN",
				  ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
				  metadata: {
					 custom_fields: [
						{
							display_name: "Mobile Number",
							variable_name: "mobile_number",
							value: "+2348012345678"
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