<?php
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache');
  require('auth.php'); 
  if($_SESSION['admin_type'] != 'fixer'){ session_destroy(); header("Location: ../login.php");}
  require('../db.php');
  $query = "SELECT * FROM `fixers` WHERE email='".$_SESSION['email']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $r1 = mysqli_query($con,$query) or die(mysql_error());
  $r2 = mysqli_query($con,$query) or die(mysql_error());
  $r3 = mysqli_query($con,$query) or die(mysql_error());
  $r4 = mysqli_query($con,$query) or die(mysql_error());
  //$rows = mysqli_num_rows($result);
  $_SESSION['name'] = $r4->fetch_object()->name;
  $_SESSION['estate'] = $result->fetch_object()->estate;
  $_SESSION['skill'] = $r1->fetch_object()->skill;
  $_SESSION['skill2'] = $r2->fetch_object()->skill2;
  $_SESSION['skill3'] = $r3->fetch_object()->skill3;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Fikxers - Fikxer</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

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
                    <a href="fixer.php" class="logo"><img src="assets/images/logo.png" height="33" alt="logo"></a>
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">

                <div class="user-details">
                    <div class="text-center">
                        <img src="assets/images/users/avatar-6.jpg" alt="" class="rounded-circle">
                    </div>
                    <div class="user-info">
                            <h4 class="font-16 text-white"><?php echo $_SESSION['name']; ?></h4>
                            <span class="text-white"><i class="fa fa-dot-circle-o text-success"></i> Online</span>
                    </div>
                </div>

            <div id="sidebar-menu">
                <ul>
                        <li>
                            <a href="fixer.php" class="waves-effect">
                                <i class="ti-home"></i>
                                <span> Home </span>
                            </a>
                        </li>
                        <!--<li>
                          <a href="send_quote.php" class="waves-effect"><i class="ti-calendar"></i><span>Send Quote </span></a>
                        </li>-->
						<li>
                            <a href="#" class="waves-effect"><i class="ti-calendar"></i><span>Payments</span></a>
                        </li>
						<li>
                            <a href="#" class="waves-effect"><i class="ti-calendar"></i><span>Invoice</span></a>
                        </li>
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
							<li class="nav-link arrow-none waves-effect nav-user">
                               <a class="dropdown-item" href="../logout.php"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                            </li>
                        </ul>

                        <ul class="list-inline menu-left mb-0">
                            <li class="list-inline-item">
                                <button type="button" class="button-menu-mobile open-left waves-effect">
                                    <i class="ion-navicon"></i>
                                </button>
                            </li>
                            <li class="hide-phone list-inline-item app-search">
                                <h3 class="page-title">Dashboard</h3>
                            </li>
                        </ul>

                        <div class="clearfix"></div>

                    </nav>

                </div>
                <!-- Top Bar End -->

                <div class="page-content-wrapper ">

                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="mini-stat clearfix bg-white">
                                    <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										//$sql = "SELECT COUNT(*) AS cnt FROM quotes where fixer='".$_SESSION['email']."' and status='pending'"; 
										$sql = "SELECT COUNT(*) AS cnt FROM quotess where fixer='".$_SESSION['email']."' and quote_status='pending'"; 
										//include where clause for specific flat								
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$pend = $values['cnt']; 															
										echo $pend;								
									   ?></span> Pending Quotes
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="mini-stat clearfix bg-success">
                                    <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										//$sql = "SELECT COUNT(*) AS cnt FROM quotes where fixer='".$_SESSION['email']."' and status='rejected'"; 
										$sql = "SELECT COUNT(*) AS cnt FROM quotess where fixer='".$_SESSION['email']."' and quote_status='rejected'"; 
										//include where clause for specific flat								
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$rej = $values['cnt']; 															
										echo $rej;								
									   ?></span> Rejected Quotes
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="mini-stat clearfix bg-orange">
                                    <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										//$sql = "SELECT COUNT(*) AS cnt FROM quotes where fixer='".$_SESSION['email']."' and status='accepted'"; 
										$sql = "SELECT COUNT(*) AS cnt FROM quotess where fixer='".$_SESSION['email']."' and quote_status='accepted'"; 
										//include where clause for specific flat								
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$acpt = $values['cnt']; 															
										echo $acpt;								
									   ?></span> Accepted Quotes
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="mini-stat clearfix bg-info">
                                    <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										//$sql = "SELECT COUNT(*) AS cnt FROM quotes where fixer='".$_SESSION['email']."' and status='completed' OR status='satisfied' OR status='unsatisfied'"; 		
										$sql = "SELECT COUNT(*) AS cnt FROM quotess where fixer='".$_SESSION['email']."' and quote_status='confirmed'"; 
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$acpt = $values['cnt']; 															
										echo $acpt;								
									   ?></span> Completed Jobs
                                    </div>
                                </div>
                            </div>
                        </div>