<?php 
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache'); 
  //$isLoggedIn = $canLogIn = false;
  require('../db.php'); require('functions.php');
  if(isset($_GET['id']) || isset($_GET['admin_type'])){
    $_SESSION['id'] = $_GET['id']; $_SESSION['admin_type'] = $_GET['admin_type'];
  }
  // if (!empty($_SESSION["admin_type"]) && $_SESSION['admin_type'] == 'flat') {
  //   $isLoggedIn = true;
  // }
  // Check if loggedin session exists
  // else if (! empty($_COOKIE["admin_type"]) && ! empty($_COOKIE["password"]) && ! empty($_COOKIE["username"])) {
  //   $query = "SELECT * FROM `users` WHERE email='".$_COOKIE["username"]."' and remember_token='".$_COOKIE["password"]."'";
  //   $result = mysqli_query($con,$query) or die(mysql_error()); $rows = mysqli_num_rows($result);
  //   if($rows >= 1){
  //     $canLogIn = true;
  //   }
  // }

  if($_SESSION['admin_type'] != 'flat'){ session_destroy(); header("Location: ../login.php");}
  
  $query = "SELECT * FROM `flats` WHERE id='".$_SESSION['id']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $flat = mysqli_query($con,$query) or die(mysql_error());
  $block = mysqli_query($con,$query) or die(mysql_error());
  $owner = mysqli_query($con,$query) or die(mysql_error());
  $amnt = mysqli_query($con,$query) or die(mysql_error());
  $debt = mysqli_query($con,$query) or die(mysql_error());
  $stat = mysqli_query($con,$query) or die(mysql_error());
  $phone = mysqli_query($con,$query) or die(mysql_error());
  $_SESSION['estate'] = $result->fetch_object()->estate_code;
  $_SESSION['flat_no'] = $flat->fetch_object()->flat_no;
  $_SESSION['block_no'] = $block->fetch_object()->block_no;
  $_SESSION['owner'] = $owner->fetch_object()->owner;
  $_SESSION['phone'] = $phone->fetch_object()->phone;
  $amnt_paid = $amnt->fetch_object()->amount_paid;
  $total_debt = $debt->fetch_object()->total_debt;
  $duestatus = $stat->fetch_object()->status;
  $query = "SELECT due_date FROM `estates` WHERE estate_code='".$_SESSION['estate']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $_SESSION['due_date'] = $result->fetch_object()->due_date;
  $query = "SELECT estate_name FROM `estates` WHERE estate_code='".$_SESSION['estate']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $_SESSION['estate_name'] = $result->fetch_object()->estate_name;
  $query = "SELECT address FROM `estates` WHERE estate_code='".$_SESSION['estate']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $_SESSION['estate_address'] = $result->fetch_object()->address;
  $sql = "SELECT split_code FROM estates where estate_code='".$_SESSION['estate']."'";
  $code = mysqli_query($con,$sql) or die(mysql_error());
  $_SESSION['split_code'] = $code->fetch_object()->split_code;
  $acct_bal = acct_bal2($amnt_paid,$total_debt);
  $_SESSION['acct_bal'] = $acct_bal;
?>

<!DOCTYPE html>
<html>

<head>
    <title>HAIVEN - Flat</title>
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
                    <a href="flat.php" class="logo"><img src="assets/images/logo.png" height="33" alt="logo"></a>
                </div>
            </div>
            <div class="sidebar-inner slimscrollleft">
                <div class="user-details">
                    <div class="text-center">
                        <img src="assets/images/users/avatar-6.jpg" alt="" class="rounded-circle">
                    </div>
                    <div class="user-info">
                        <h4 class="font-16 text-white"><?php echo "Flat ".$_SESSION['flat_no']." - Block ".$_SESSION['block_no']; ?></h4> <h6 class="font-14 text-white"><?php echo $_SESSION['estate_name']; ?></h6><h6 class="font-14 text-warning"><?php echo $_SESSION['owner']; ?></h6>
                        <span class="text-white"><i class="fa fa-dot-circle-o text-success"></i> Online</span><br>
						<span class="counter text-white">Status: </span>
						<?php /*if($duestatus=='good' || $duestatus=='Good'){echo '<span class="badge badge-success">'.$duestatus.'</span>';} 

						else {echo '<span class="badge badge-danger">'.$duestatus.'</span>';}*/
						if($amnt_paid-$total_debt >= 0)	{echo '<span class="badge badge-success">Good</span>';}  
						else{echo '<span class="badge badge-danger">Owing</span>';}
						?>
						<?php //echo deadline(5)." days"; ?>
                    </div>
                </div>
				<div id="sidebar-menu">
                <ul>
                    <li>
                     <a href="flat.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                    </li>
					<!-- <li>
                      <a href="view_equipments.php" class="waves-effect"><i class="ti-check-box"></i><span> Assets Register</span> <span class="badge badge-success pull-right">
					  <?php include ('../db.php'); 
					    $sql = "SELECT COUNT(*) AS cnt FROM equipments where flat='".$_SESSION['email']."'"; 
						//include where clause for specific flat					
						$result = $con->query($sql); $values = mysqli_fetch_assoc($result); $num_eqpm = $values['cnt'];
						echo $num_eqpm;								
					  ?></span></a>

                    </li> -->

                    <!--<li>

                        <a href="facility_service.php" class="waves-effect"><i class="ti-bookmark-alt"></i><span> Facility Service </span> <span class="badge badge-success pull-right">

                        <?php include ('../db.php');
                            //$sql = "SELECT COUNT(*) AS cnt FROM home_service where flat='".$_SESSION['email']."'"; 
                            $sql = "SELECT COUNT(*) AS cnt FROM orders where flat='".$_SESSION['email']."' and order_type='facility_service'"; 
                            //include where clause for specific flat                                
                            $result = $con->query($sql); $values = mysqli_fetch_assoc($result); $num_fac = $values['cnt'];  
							echo $num_fac;                         
                        ?>
                            </span></a>
                    </li>-->
                    <!-- <li>
                       <a href="repairs.php" class="waves-effect"><i class="ti-settings"></i><span> Work Order </span> <span class="badge badge-success pull-right">
							  <?php
							    include ('../db.php');
								$sql = "SELECT COUNT(*) AS cnt FROM repairs where flat='".$_SESSION['email']."'"; 
								$sql = "SELECT COUNT(*) AS cnt FROM orders where flat='".$_SESSION['email']."' and (order_status='confirmed' or order_status='completed')"; 
								//include where clause for specific flat								
								$result = $con->query($sql);
								$values = mysqli_fetch_assoc($result); 
								$num_rep = $values['cnt']; 																
								echo $num_rep;								
							   ?>
							</span></a>
                    </li> -->
					<!--<li>
                            <a href="home_service.php" class="waves-effect"><i class="ti-calendar"></i><span> Errand Service </span> <span class="badge badge-success pull-right">
							  <?php
							    /* include ('../db.php');
								$sql = "SELECT COUNT(*) AS cnt FROM orders where flat='".$_SESSION['email']."' and order_type='home_service'"; 							
								$result = $con->query($sql);
								$values = mysqli_fetch_assoc($result); 
								$num_hom = $values['cnt']; 																
								echo $num_hom;	*/						
							   ?>
							</span></a>
                        </li><li><a href="electric-bill.php"><i class="ti-bolt-alt"></i><span> Electricity Bill </span></a></li>
					<li><a href="#" class="waves-effect"><i class="ti-cloud"></i><span> Chat Forum </span></a></li>-->
					<li><a href="messages.php" class="waves-effect"><i class="ti-comments"></i><span> Contact FM </span></a></li>
					<li class="has_sub">
						<a href="pay.php" class="waves-effect"><i class="ti-credit-card"></i><span> Payments </span><span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                          <li><a href="pay.php">Fund Wallet</a></li>
						  <li><a href="electric-bill.php">Electricity Bill </span></a></li>
                          <li><a href="estate-payments.php">Estate Payments</a></li>
                          <li><a href="history.php">History</a></li>
                        </ul>
                    </li>
                    <li><a href="qr-code.php" class="waves-effect"><i class="ti-stamp"></i><span> Visitor Management</span></a></li>
					<!--<li><a href="special-qrs.php" class="waves-effect"><i class="ti-id-badge"></i><span> Special QRs</span></a></li>
					<li><a class="waves-effect" href="reset_password.php"><i class="fa fa-thin fa-user-lock m-r-5 "></i> Reset Password</a></li>-->
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
                            <!-- <li class="list-inline-item dropdown notification-list"><h6>Wallet Balance: <span class="badge badge-danger"><?php echo "&#8358;".currency_format($acct_bal); ?></span></h6></li> -->
                            <li class="list-inline-item dropdown notification-list"><h6>Wallet Balance: <b class="text-info"><?php echo "&#8358;".currency_format($acct_bal); ?></b></h6></li>
							<li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="assets/images/users/user-5.jpg" alt="user" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <a class="dropdown-item" href="profile.php"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                                    <a class="dropdown-item" href="reset_password.php"><i class="mdi mdi-settings m-r-5 text-muted"></i> Reset Password</a>
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
					  <?php 
					  if ($title=='Dashboard'){ 
                        //include ('tmpl/flat_dashboard.php');
					  }
                            //DEADLINE OPTION
                            $thismonth = date('F',strtotime('first day of +0 month'));
                            $deadline_option = "select deadline_option from estates where estate_code='".$_SESSION['estate']."'";
                            $result = mysqli_query($con,$deadline_option) or die(mysqli_error($con));
                            $deadline_option = $result->fetch_object()->deadline_option; $options = "";
                            if($deadline_option==1){ 
                                echo '<div class="alert alert-primary text-dark" role="alert">Estate Levy Payment Day: '.$thismonth.' '.last_day_of_the_month().'. </div>'; 
                            }
                            else if ($deadline_option==2){ 
                                $textbox_msg = "# of days after month end"; 
                                echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: '.$_SESSION['due_date'].' Days after month end.</div>';
                            }
                            else { 
                                $textbox_msg = "# of days before month end";
                                echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: '.$_SESSION['due_date'].' Days before month end.</div>';
                            }
                            // else if ($deadline_option==2){ 
                            //     $textbox_msg = "# of days after month end"; 
                            //     echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: 5 Days after month end</div>';
                            // }
                            // else { 
                            //     $textbox_msg = "# of days before month end";
                            //     echo '<div class="alert alert-primary text-dark" role="alert">Estate Deadline Option: Days before month end</div>';
                            // }
                            //Flag Visitors not signed out
                            $query = "SELECT count(*) as cnt FROM entrance_codes where estate='".$_SESSION['estate']."' and block='".$_SESSION['block_no']."' and flat='".$_SESSION['flat_no']."' and (status='signed-in' )";
                            $result = mysqli_query($con,$query) or die(mysqli_error($con));
                            $signedin = $result->fetch_object()->cnt;
					        if ($signedin > 0) {
					            echo '<div class="alert text-dark alert-info" role="alert">You have <b>'.$signedin.'</b> visitors signed in. Please make sure they sign out on time.</div>';
					        }
                            //DUE DEADLINE
							/*$due_date = $_SESSION['due_date'];
							if ($due_date==0) $due_date = 5; $today = date("d"); $month = date('m');
							$d = days2due($due_date);//$d = deadline(5);
							$lastmonth = date('F',strtotime('first day of -1 month'));
							if($d==0){
							  echo '<div class="alert text-dark alert-danger" role="alert">Estate Levy Payment Day: Today!</div>';
							}
							else if($d==1){
							  echo '<div class="alert text-dark alert-info" role="alert">Next Estate Levy Payment For All: Tomorrow!</div>';
							}
							else{
							  $nextmonth = date('F',strtotime('first day of +1 month'));
							  $thismonth = date('F',strtotime('first day of +0 month'));
							  if($due_date > $today){
								echo '<div class="alert alert-warning text-dark" role="alert">'.$lastmonth.' Levy Deadline is '.$thismonth.' '.$due_date.', in '.$d.' day(s) time.</div>';
							  }
							  else{
								echo '<div class="alert alert-warning text-dark" role="alert">'.$thismonth.' Levy Deadline is '.$nextmonth.' '.$due_date.', in '.$d.' day(s) time.</div>';
							    //echo '<div class="alert alert-warning text-dark" role="alert">Next Estate Levy Payment For All on '.$lastmonth.' '.$due_date.'. '.$d.' days left.</div>'; 
							  }							  
							} */
							//$last_day = last_day_of_the_month(); $dd = days2due($last_day);
							// $dd = days2due(31); $msg = service_charge($dd, $acct_bal);  
							// if ($msg == 0){
							//   echo '<div class="alert text-dark alert-info" role="alert">Service charge will be deducted in '.$dd.' days!</div>';
							// }
							// if ($msg == 1){
							//   echo '<div class="alert text-dark alert-info" role="alert">Service Charge Paid Successfully, today - '.$_SESSION['pay_date'].'</div>';
							// }
							// else if ($msg == 2){
							//   echo '<div class="alert text-dark alert-info" role="alert">Error making payment. Please try pay manually.</div>';
							// }
							// else if ($msg == 3){
							//   echo '<div class="alert text-dark alert-info" role="alert">Service Charge could not be paid. You need to Fund your  Wallet.</div>';
							// }
							
						?>