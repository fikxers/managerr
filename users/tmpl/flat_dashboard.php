<div class="row">
  <div class="col-md-4 col-xl-4">
    <a href="view_equipments.php" >
    <div class="mini-stat clearfix bg-white">
      <span class="mini-stat-icon"><i class="ti-shopping-cart"></i></span>
	  <div class="mini-stat-info text-right text-light">
        <span class="counter text-white"><?php echo $num_eqpm; ?></span> Assets
      </div>
    </div>
	</a>
  </div>
  <div class="col-md-4 col-xl-4">
    <a href="facility_service.php" >
    <div class="mini-stat clearfix bg-success">
      <span class="mini-stat-icon"><i class="ti-settings"></i></span>
      <div class="mini-stat-info text-right text-light">
        <span class="counter text-white"><?php echo $num_fac; ?></span> Issues
      </div>
    </div>
	</a>
  </div>
  <div class="col-md-6 col-xl-3">
	<a href="home_service.php" >
    <div class="mini-stat clearfix bg-orange">
      <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
      <div class="mini-stat-info text-right text-light">
        <span class="counter text-white"><?php echo $num_hom; ?></span> Errands
      </div>
    </div>
	</a>
  </div>
  <div class="col-md-4 col-xl-4">
	<a href="#" >
    <div class="mini-stat clearfix bg-info">
      <span class="mini-stat-icon"><i class="ti-credit-card"></i></span>--
      <div class="mini-stat-info text-right text-light">
        <span class="counter text-white"><?php echo acct_bal($amnt_paid,$total_debt);//$acct_bal; ?></span> Acct Balance
      </div>
    </div>
	</a>
  </div>
</div>