<?php 
  /*
	Estate Configurations
    1. Street, Blocks and Flats
	2. Blocks and Flats
	3. Street and House
	4. Area, Street, House
	Deadline Options
	1. Last day of month 
	2. Days after month end 
	3. Days before month end
  */
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache'); 
  if(isset($_GET['id']) || isset($_GET['admin_type'])){
    $_SESSION['id'] = $_GET['id']; $_SESSION['admin_type'] = $_GET['admin_type'];
  }
  if($_SESSION['admin_type'] != 'mgr'){ session_destroy(); header("Location: ../login.php");}
  require('../db.php'); //require('functions.php');
  $query = "SELECT * FROM `estate_manager` WHERE id='".$_SESSION['id']."'";
  $result = mysqli_query($con,$query) or die(mysqli_error($con));
  $rows = mysqli_num_rows($result);
  $_SESSION['estate'] = $result->fetch_object()->estate;
  if (isset($_POST['updateduedate'])){
    $dueday = $_REQUEST['dueday'];
	$query = "UPDATE `estates` SET `due_date`=$dueday WHERE estate_code='".$_SESSION['estate']."'";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Due day updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating equipment.');</script>";
	  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
	}
  }
  else if (isset($_POST['updatedeadline'])){
    $deadline = $_REQUEST['deadline'];
	$query = "UPDATE `estates` SET `deadline_option`=$deadline WHERE estate_code='".$_SESSION['estate']."'";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Deadline option updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating deadline option.');</script>";
	  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
	}
  }
  else if (isset($_POST['updatelevy'])){
    $levy = $_REQUEST['levy']; $levysel = $_REQUEST['levysel'];
	$query = "UPDATE `estates` SET `building_levy`=$levy WHERE estate_code='".$_SESSION['estate']."'";
	if($levysel=='dev'){$query = "UPDATE `estates` SET `lev_levy`=$levy WHERE estate_code='".$_SESSION['estate']."'";}
	else if($levysel=='monthly'){$query = "UPDATE `estates` SET `monthly_due`=$levy WHERE estate_code='".$_SESSION['estate']."'";}
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Levy updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating equipment.');</script>";
	  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
	}
  }
  else if (isset($_POST['updatemaxelectric'])){
    $maxelectric = $_REQUEST['maxelectric']; 
    $query = "UPDATE `estates` SET `maxMonthlyPayment`=$maxelectric WHERE estate_code='".$_SESSION['estate']."'";
    $result2 = mysqli_query($con,$query); 
    if($result2){
      echo "<script>alert('Maximum Electricity Payment Updated Successfully.');</script>";
      echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
    }
    else{
      echo "<script>alert('Error Updating Maximum Electricity Payment.');</script>";
      echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
    }
  }
  $result = mysqli_query($con,$query) or die(mysqli_error($con));
  $_SESSION['name'] = $result->fetch_object()->name;
  $result = mysqli_query($con,$query) or die(mysqli_error($con));
  $_SESSION['updated_at'] = $result->fetch_object()->updated_at;
  $query = "SELECT due_date FROM `estates` WHERE estate_code='".$_SESSION['estate']."'";
  $result = mysqli_query($con,$query) or die(mysqli_error($con));
  $_SESSION['due_date'] = $result->fetch_object()->due_date;
  $query = "SELECT estate_name FROM `estates` WHERE estate_code='".$_SESSION['estate']."'";
  $result = mysqli_query($con,$query) or die(mysqli_error($con));
  $_SESSION['estate_name'] = $result->fetch_object()->estate_name;
  $query = "SELECT address FROM `estates` WHERE estate_code='".$_SESSION['estate']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $_SESSION['estate_address'] = $result->fetch_object()->address;
  $sql = "SELECT monthly_due FROM estates where estate_code='".$_SESSION['estate']."'";
  $result = $con->query($sql);
  $row =mysqli_fetch_assoc($result);
  $current_monthly_due = $row['monthly_due'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Estate Manager - <?php echo $_SESSION['estate_name']; ?></title>
    <?php include ('tmpl/header.html'); ?>
	
</head>
<body class="fixed-left">
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
          <div class="spinner"></div>
        </div>
    </div>
    <!-- Begin page -->
    <div id="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
              <i class="ion-close"></i>
            </button>
            <!-- LOGO -->
            <div class="topbar-left">
                <div class="text-center">
                  <!--<a href="index.html" class="logo">Admiry</a>-->
                  <a href="estate_mgr.php" class="logo"><img src="assets/images/logo.png" height="33" alt="logo"></a>
                </div>
            </div>
            <div class="sidebar-inner slimscrollleft">
                <div class="user-details">
                    <div class="text-center">
                      <img src="assets/images/users/avatar-6.jpg" alt="" class="rounded-circle">
                    </div>
                    <div class="user-info">
                      <h4 class="font-16 text-white"><?php echo "Estate: ".$_SESSION['estate_name'];//$_SESSION['email']; ?></h4> <h6 class="font-14 text-warning"><?php echo $_SESSION['name']; ?></h6>
                      <span class="text-white"><i class="fa fa-dot-circle-o text-success"></i> Online</span>
                    </div>
                </div>
				<div id="sidebar-menu">
                  <ul>
                    <li><a href="estate_mgr.php" class="waves-effect"><i class="ti-home"></i><span> Workbench</span></a></li>
					<li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-user"></i><span> Users </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                          <!-- <li><a href="view_fixers.php" class="waves-effect"><i class="ti-settings"></i><span> Fikxers</span></a></li> -->
						  <li><a href="view_security.php" class="waves-effect"><i class="ti-settings"></i><span> Security Team</span></a></li>
						  <li><a href="view_flats.php" class="waves-effect"><i class="ti-crown"></i><span> Residents </span></a></li>
                        </ul>
                    </li>
					<li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-calendar"></i><span> Management </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                          <!-- <li><a href="completed.php" class="waves-effect"><i class="ti-calendar"></i><span> Work Orders</span></a></li>
						  <li><a href="asset_types.php" class="waves-effect"><i class="ti-calendar"></i><span> Asset Types</span></a></li> -->
						  <li><a href="dues.php" class="waves-effect"><i class="ti-wallet"></i><span> Dues</span></a></li>
                        </ul>
                    </li>
					<li><a href="notifications.php" class="waves-effect"><i class="ti-comments"></i><span> Notifications </span></a></li>
                    <li><a href="validate_code.php" class="waves-effect"><i class="ti-id-badge"></i><span> Validate Code </span></a></li>
					<li><a href="electric-bill.php" class="waves-effect"><i class="ti-bolt-alt"></i><span> Electricity Bill </span></a></li>
					<!--<li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout"></i><span> Forum </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                          <li><a href="categories.php"><i class="fa fa-comment"></i>Categories</a></li>
                          <li><a href="topics.php"><i class="fa fa-reply"></i>Topics</a></li>
                          <li><a href="../forumn/tags.php"><i class="fa fa-tags"></i> Tags</a></li>
                        </ul>
                    </li>-->
                  </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <!-- Top Bar Start -->
                <div class="topbar">
                    <nav class="navbar-custom">
                        <ul class="list-inline float-right mb-0">
							<!--<li class="nav-link arrow-none waves-effect nav-user">
                              <a class="dropdown-item" href="../logout.php"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                            </li>-->
							<li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="assets/images/users/user-5.jpg" alt="user" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <a class="dropdown-item" href="reset_password.php"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Reset Password</a>
                                    <!--<a class="dropdown-item" href="#"><span class="badge badge-success pull-right">5</span><i class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a>
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5 text-muted"></i> Lock screen</a>-->
                                     <a class="dropdown-item" href="switch-account.php"><i class="mdi mdi-account-switch m-r-5 text-muted"></i> Switch Account</a>
                                    <a class="dropdown-item" href="../logout.php"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-inline menu-left mb-0">
                            <li class="list-inline-item">
                              <button type="button" class="button-menu-mobile open-left waves-effect">
							    <i class="ion-navicon"></i>
							  </button>
                            </li>
                            <li class="hide-phone list-inline-item app-search">
                              <h3 class="page-title"><?php echo $title; ?></h3>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </nav>
                </div>
                <!-- Top Bar End -->

                <div class="page-content-wrapper ">

                    <div class="container-fluid">

                        <div class="row">
                            <!-- <div class="col-md-6 col-xl-4">
								<a href="completed.php" >
                                <div class="mini-stat clearfix bg-white">
                                    <span class="mini-stat-icon"><i class="ti-shopping-cart"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM repairs where estate='".$_SESSION['estate']."' and status='pending'"; 
										$sql2 = "SELECT COUNT(*) AS cnt FROM home_service where estate='".$_SESSION['estate']."' and status='pending'";
										$result = $con->query($sql); $result2 = $con->query($sql2);
										$values = mysqli_fetch_assoc($result);  $values2 = mysqli_fetch_assoc($result2);
										$num = $values['cnt']; 	$num2 = $values2['cnt']; 					
										echo $num+$num2;
									   ?></span> Total Requests
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-6 col-xl-4">
								<a href="view_flats.php" >
                                <div class="mini-stat clearfix bg-success">
                                    <span class="mini-stat-icon"><i class="ti-user"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM flats where estate_code='".$_SESSION['estate']."'";					
										$result = $con->query($sql);
										$values = mysqli_fetch_assoc($result); 
										$num_fl = $values['cnt']; 
										echo $num_fl;
									   ?></span> Flats
                                    </div>
                                </div>
								</a>
                            </div> -->
                            <!--<div class="col-md-6 col-xl-3">
								<a href="view_fixers.php" >
                                <div class="mini-stat clearfix bg-orange">
                                    <span class="mini-stat-icon"><i class="ti-shopping-cart-full"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										/*include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM fixers where estate='".$_SESSION['estate']."' and status='available'";	
										$result = $con->query($sql);
										$values = mysqli_fetch_assoc($result); 
										$num_f = $values['cnt']; 
										echo $num_f;*/
									   ?></span> Managerr
                                    </div>
                                </div>
								</a>
                            </div>-->
                            <!-- <div class="col-md-6 col-xl-4">
								<a href="view_fixers.php" >
                                <div class="mini-stat clearfix bg-info">
                                    <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM fixers where estate='".$_SESSION['estate']."' "; 								
										$result = $con->query($sql);
										$values = mysqli_fetch_assoc($result); 
										$num_f = $values['cnt']; 
										echo $num_f;
									   ?></span> Fikxers
                                    </div>
                                </div>
								</a>
                            </div> -->
                        </div>
						<?php 
							$estate_code = $_SESSION['estate'];
							$btn = "<button type='button' class='btn btn-primary btn-sm' style='background-color: transparent; border-width: 0px;' title='Change Due Date' data-toggle='modal' data-target='#exampleModalCenter' data-original-title='Change Due Date'><i class='fa fa-pencil text-primary'></i></button>";
							$btnn = "<button type='button' class='btn btn-dark btn-sm' style='background-color: transparent; border-width: 0px;' title='Change Deadline Option' data-toggle='modal' data-target='#changedeadline' data-original-title='Change Deadline Option'><i class='fa fa-pencil text-dark'></i></button>";
							$btnm = "<button type='button' class='btn btn-warning btn-sm' style='background-color: transparent; border-width: 0px;' title='Change Estate Levy' data-toggle='modal' data-target='#levymodal' data-original-title='Change Due Date'><i class='ti-wallet text-dark'></i></button>";
                            $btnmax = "<button type='button' class='btn btn-warning btn-sm' style='background-color: transparent; border-width: 0px;' title='Change Max Monthly Electricity Payment' data-toggle='modal' data-target='#maxmodal' data-original-title='Change Max Monthly Electricity Payment'><i class='text-dark'>&#8358;</i></button>";
							//<button type='button' class='btn btn-dark btn-sm' style='background-color: transparent; border-width: 0px;' title='Change Devt Levy' data-toggle='modal' data-target='#exampleModalCenter' data-original-title='Change Due Date'><i class='ti-wallet text-dark'></i></button>";
							$textbox_msg = "";

							//DEADLINE OPTION
							$deadline_option = "select deadline_option from estates where estate_code='$estate_code'";
							$result = mysqli_query($con,$deadline_option) or die(mysqli_error($con));
							$deadline_option = $result->fetch_object()->deadline_option; $options = "";
                            //$last_day = last_day_of_the_month();
							if($deadline_option==1){ 
								echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: Last day of month <span style="float: right">'.$btnn.'</span></div>';
							}
							else if ($deadline_option==2){ 
								$textbox_msg = "# of days after month end"; 
								echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: '.$_SESSION['due_date'].' Days after month end <span style="float: right">'.$btnn.' '.$btn.'</span></div>';
							}
							else { 
								$textbox_msg = "# of days before month end";
								echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: '.$_SESSION['due_date'].' Days before month end <span style="float: right">'.$btnn.' '.$btn.'</span></div>';
							}
                            echo '<div class="row">';
                            //CURRENT MONTHLY DUE
							echo '<div class="col-lg-6"><div class="alert alert-warning text-dark" role="alert">Current Monthly Due:  '.number_format($current_monthly_due, 2, '.', ',').'<span style="float: right">'.$btnm.'</span></div></div>';
                            //MAX MONTHLY ELECTRIC PAYMENT FOR RESIDENTS
                            $maxMonthlyPayment = "select maxMonthlyPayment from estates where estate_code='$estate_code'";
                            $result = mysqli_query($con,$maxMonthlyPayment) or die(mysqli_error($con));
                            $maxMonthlyPayment = $result->fetch_object()->maxMonthlyPayment; 
                            $formattedNumber = number_format($maxMonthlyPayment, 2, '.', ',');
                            echo '<div class="col-lg-6"><div class="alert alert-warning text-dark" role="alert">Max Monthly Electricity Payment Allowed:  '.$formattedNumber.'<span style="float: right">'.$btnmax.'</span></div></div>';
                            echo '</div>';
							echo '
							<!-- Modal -->
							<div class="modal fade" id="changedeadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Change Deadline Option</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form action="" method="POST">
									   <div class="form-row">
										<div class="form-group col-lg-6">
										  <select class="form-control" name="deadline">
										  	<option value="1">Month End</option><option value="2">Days After Month End</option><option value="3">Days Before Month End</option>
										  </select>
										</div>
										<div class="form-group col-lg-6">
										  <input type="submit" name="updatedeadline" value="Update" class="btn btn-block btn-outline-info">
										</div>
									   </div>
									  </form>
								  </div>
								  <!--<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								  </div>-->
								</div>
							  </div>
							</div>';
							echo '
							<!-- Modal -->
							<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Grace Period for Payment of Dues</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form action="" method="POST">
									   <div class="form-row">
										<div class="form-group col-lg-6">
										  <input type="number" max="31" min="1" name="dueday" id="dueday" class="form-control" placeholder="'.$textbox_msg.'" required />
										</div>
										<div class="form-group col-lg-6">
										  <input type="submit" name="updateduedate" value="Update" class="btn btn-block btn-outline-info">
										</div>
									   </div>
									  </form>
								  </div>
								  <!--<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								  </div>-->
								</div>
							  </div>
							</div>';
							echo '
							<!-- Modal -->
							<div class="modal fade" id="levymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							  <div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Change Estate Levy</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form action="" method="POST">
									   <div class="form-row">
									    <div class="form-group col-lg-12">
										   <label>Which levy are you changing?</label><br>
										   Development Levy <input class="" type="radio" name="levysel" checked="checked" value="dev" /> 
										   Building Levy <input class="" type="radio" name="levysel" value="build" /> Monthly Due <input class="" type="radio" name="levysel" value="monthly" />
										</div>
										<div class="form-group col-lg-6">
										  <input type="number" max="1000000" min="10000" step="5000" name="levy" class="form-control" placeholder="New Levy" required />
										</div>
										<div class="form-group col-lg-6">
										  <input type="submit" name="updatelevy" value="Update Levy" class="btn btn-block btn-outline-info">
										</div>
									   </div>
									  </form>
								  </div>
								  <!--<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								  </div>-->
								</div>
							  </div>
							</div>';
                            echo '
                            <!-- Modal -->
                            <div class="modal fade" id="maxmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Change Max Monthly Electricity Payment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="" method="POST">
                                       <div class="form-row">
                                        <div class="form-group col-lg-6">
                                          <input type="number" max="1000000" min="10000" step="5000" name="maxelectric" class="form-control" placeholder="Current: '.$formattedNumber.'" required />
                                        </div>
                                        <div class="form-group col-lg-6">
                                          <input type="submit" name="updatemaxelectric" class="btn btn-block btn-outline-info">
                                        </div>
                                       </div>
                                      </form>
                                  </div>
                                  <!--<div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                  </div>-->
                                </div>
                              </div>
                            </div>';
							//DUE DEADLINE
							/*$due_date = $_SESSION['due_date'];//$d = date("d");
							$d = days2due($due_date);//$d = deadline(5);
							if ($due_date==0) $due_date = 5;
							$amount = 10000;
							$time = date('H:i:s'); $trn_date = date("Y-m-d H:i:s");
							//echo $_SESSION['updated_at'];
							$sql = "update flats set total_debt = total_debt + $amount,updated_at='$trn_date' where estate_code='$estate_code'";
							$sql2 = "update estate_manager set updated_at='$trn_date' where estate='$estate_code'";
							//if($_SESSION['updated_at']<$trn_date) echo $_SESSION['updated_at'];
														
							if($d==0){ //if (check_if_due($due_date, $amount, 0)==1){
							  $result = $con->query($sql); $result = $con->query($sql2);
							  echo '<div class="alert alert-success text-dark" role="alert">Due Updated Today!!! <span style="float: right">'.$btn.'</span></div>';
							}
							else if($d==1){
							  echo '<div class="alert text-dark alert-info" role="alert">Due will be updated Tomorrow! <span style="float: right">'.$btn.'</span></div>';
							}
							else {
							  $lastmonth = date('F',strtotime('first day of -1 month'));
							  $nextmonth = date('F',strtotime('first day of +1 month'));	
							  $thismonth = date('F',strtotime('first day of +0 month')); $today = date("d");
							  //echo '<div class="alert alert-warning text-dark" role="alert">Due will be updated in '.days2due($due_date).' days. <span style="float: right">'.$btn.'</span></div>';
							  
							  if($due_date > $today){
								echo '<div class="alert alert-warning text-dark" role="alert">'.$lastmonth.' Levy Deadline is '.$thismonth.' '.$due_date.', in '.$d.' day(s) time.<span style="float: right">'.$btn.'</span></div>';
							  }
							  else{
								echo '<div class="alert alert-warning text-dark" role="alert">'.$thismonth.' Levy Deadline is '.$nextmonth.' '.$due_date.', in '.$d.' day(s) time.<span style="float: right">'.$btn.'</span></div>';
							  }
							}*/
							//TRAFFIC CONTROL
							if( ! ini_get('date.timezone') ) { date_default_timezone_set('Africa/Lagos'); } $trn_date = date("Y-m-d"); //$trn_date = date("Y-m-d H:i:s");
							$trafficin = "SELECT COUNT(*) AS cnt FROM entrance_codes where status='signed-in' AND signin='".$trn_date."'"; //format the date from mysql
							$trafficout = "SELECT COUNT(*) AS cnt FROM entrance_codes where status='signed-out' AND signout='".$trn_date."'";
							$result = mysqli_query($con,$trafficin) or die(mysqli_error($con));
							$ins = $result->fetch_object()->cnt;
							$result = mysqli_query($con,$trafficout) or die(mysqli_error($con));
							$outs = $result->fetch_object()->cnt;
							echo '<div class="alert alert-info" role="alert">DAILY TRAFFIC CONTROL<br>Checkouts: '.$outs.' | Checkins: '.$ins.' | Total Visits: '.($ins+$outs).' </div>';
						?>
