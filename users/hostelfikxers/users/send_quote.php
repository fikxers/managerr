	<?php include('fixer_sidebar.php');?>
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card card-sec m-b-30">
                                    <div class="card-body">
                                        <h4 class="mt-0 m-b-15 header-title">Quotations</h4>

                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr class="titles">
                                                        <th>Costumer Name</th>
                                                        <th>Company</th>
                                                        <th>Status</th>
                                                        <th>Invoice</th>
                                                        <th>Start date</th>
                                                        <th>Amount</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="c-table__cell">
                                                            <div class="user-wrapper">
                                                                <div class="img-user">
                                                                    <img src="assets/images/users/user-1.jpg" alt="user" class="rounded-circle">
                                                                </div>
                                                                <div class="text-user">
                                                                    <h6>Tiger Nixon</h6>
                                                                    <p>Web Designer</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="c-table__cell">Dribble</td>
                                                        <td class="c-table__cell"><span class="badge badge-warning">Due</span></td>
                                                        <td class="c-table__cell">INV-001001</td>
                                                        <td class="c-table__cell">2011/04/25</td>
                                                        <td class="c-table__cell">$320,800</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="c-table__cell">
                                                            <div class="user-wrapper">
                                                                <div class="img-user">
                                                                    <img src="assets/images/users/user-4.jpg" alt="user" class="rounded-circle">
                                                                </div>
                                                                <div class="text-user">
                                                                    <h6>Tiger Nixon</h6>
                                                                    <p>Web Designer</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                
                                                        <td>Senior Javascript Developer</td>
                                                        <td><span class="badge badge-warning">Due</span></td>
                                                        <td>22</td>
                                                        <td>2012/03/29</td>
                                                        <td>$433,060</td>
                                                    </tr>
                                
                                            

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-xl-12">
                                <div class="card card-sec m-b-30">
                                    <div class="card-body">
                                        <h4 class="mt-0 m-b-15 header-title">Send Quote</h4>
                                          <form action="#" method="post">
											<div class="row">
											  <div class="col-md-6 col-sm-6 col-xs-6 form-group">
												<label for="name">Estimated Duration</label>
												<input type="number" min="1" max="14" placeholder="1" name="duration" class="form-control ">
												<!--<select class="form-control" required name="fixer" >
												  <option value="1">1</option>
												  <option value="2">2</option>
												</select>-->				
											  </div>
											  <!--<div class="col-md-6 col-sm-6 col-xs-6  form-group">
												<label for="phone">Estimated Cost</label>
												<input type="number" data-type="currency"  placeholder="<?php //echo "&#8358;" ?>1,000" name="cost" class="form-control ">
											  </div>-->
											  <div class="col-md-6 col-sm-6 col-xs-6  form-group">
												<label for="phone">Estimated Cost(<?php echo "&#8358;" ?>)</label>											  
											    <!--<span class="input-group-addon"><?php //echo "&#8358;" ?></span>-->
												<input type="number" class="form-control" value="1000" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" />
											</div> 
											</div>
											<div class="row">
											  <div class="col-md-4 form-group">
												<input type="submit" value="Send Quote" class="btn btn-primary">
												<input type="reset" value="Reset" class="btn btn-primary">
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

            <?php include('footer.php'); ?>

</html>