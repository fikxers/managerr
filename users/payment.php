		<?php
          include('auth.php'); $title='Payment';
          include('flat_sidebar.php');
		?>
                      <div class="row">
					    <div class="col-lg-12">
                          <div class="card m-b-30">
                            <div class="card-body">
                              <h4 class="mt-0 header-title">Make Payment</h4>
							  <form id="paymentForm">
							  <div class="form-group">
								<label for="email">Email Address</label>
								<input type="hidden" value="<?php echo $_SESSION['email']; ?>" id="email-address" />
							  </div>
							  <div class="form-group">
								<label for="amount">Amount</label>
								<input type="tel" id="amount" required />
							  </div>
							  <!--<div class="form-group">
								<label for="first-name">First Name</label>
								<input type="text" id="first-name" />
							  </div>
							  <div class="form-group">
								<label for="last-name">Last Name</label>
								<input type="text" id="last-name" />
							  </div>-->
							  <div class="form-submit">
								<button type="submit" onclick="payWithPaystack()"> Pay </button>
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
		  <?php include('footer.php'); ?>
</html>
