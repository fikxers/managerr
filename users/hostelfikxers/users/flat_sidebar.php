<?php 
  require('../db.php');
  $query = "SELECT * FROM `flats` WHERE email='".$_SESSION['email']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $flat = mysqli_query($con,$query) or die(mysql_error());
  $block = mysqli_query($con,$query) or die(mysql_error());
  $owner = mysqli_query($con,$query) or die(mysql_error());
  //$rows = mysqli_num_rows($result);
  $_SESSION['estate'] = $result->fetch_object()->estate_code;
  $_SESSION['flat_no'] = $flat->fetch_object()->flat_no;
  $_SESSION['block_no'] = $block->fetch_object()->block_no;
  $_SESSION['owner'] = $owner->fetch_object()->owner;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Fikxers - Flat</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/faviicon.png">

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
                    <a href="index.html" class="logo"><img src="assets/images/logo.png" height="33" alt="logo"></a>
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">

                <div class="user-details">
                    <div class="text-center">
                        <img src="assets/images/users/avatar-6.jpg" alt="" class="rounded-circle">
                    </div>
                    <div class="user-info">
                        <h4 class="font-16 text-white"><?php echo "Room ".$_SESSION['flat_no']; ?></h4> <h6 class="font-14 text-warning"><?php echo $_SESSION['owner']; ?></h6>
                        <span class="text-white"><i class="fa fa-dot-circle-o text-success"></i> Online</span>
                    </div>
                </div>

            <div id="sidebar-menu">
                <ul>
                        <li>
                            <a href="flat.php" class="waves-effect">
                                <i class="ti-home"></i>
                                <span> Home </span>
                            </a>
                        </li>
						<li>
                            <a href="view_equipments.php" class="waves-effect"><i class="ti-shopping-cart"></i><span> Equipments </span> <span class="badge badge-success pull-right">
							  <?php
							    include ('../db.php');
								$sql = "SELECT COUNT(*) AS cnt FROM equipments where flat='".$_SESSION['email']."'"; 
								//include where clause for specific flat								
								$result = $con->query($sql);
								$values = mysqli_fetch_assoc($result); 
								$num_eqpm = $values['cnt']; 																
								echo $num_eqpm;								
							   ?>
							</span></a>
                        </li>
                        <li>
                            <a href="repairs.php" class="waves-effect"><i class="ti-settings"></i><span> Repairs </span> <span class="badge badge-success pull-right">
							  <?php
							    include ('../db.php');
								$sql = "SELECT COUNT(*) AS cnt FROM repairs where flat='".$_SESSION['email']."'"; 
								$sql = "SELECT COUNT(*) AS cnt FROM orders where flat='".$_SESSION['email']."' and order_type='repairs'"; 
								//include where clause for specific flat								
								$result = $con->query($sql);
								$values = mysqli_fetch_assoc($result); 
								$num_rep = $values['cnt']; 																
								echo $num_rep;								
							   ?>
							</span></a>
                        </li>
						<li>
                            <a href="home_service.php" class="waves-effect"><i class="ti-calendar"></i><span> Home Service </span> <span class="badge badge-success pull-right">
							  <?php
							    include ('../db.php');
								//$sql = "SELECT COUNT(*) AS cnt FROM home_service where flat='".$_SESSION['email']."'"; 
								$sql = "SELECT COUNT(*) AS cnt FROM orders where flat='".$_SESSION['email']."' and order_type='home_service'"; 
								//include where clause for specific flat								
								$result = $con->query($sql);
								$values = mysqli_fetch_assoc($result); 
								$num_hom = $values['cnt']; 																
								echo $num_hom;								
							   ?>
							</span></a>
                        </li>
						<li>
                            <a href="pay.php" class="waves-effect"><i class="ti-credit-card"></i><span> Payment </span></a>
                        </li>
						<!--<li>
                            <a href="maintenance.php" class="waves-effect"><i class="ti-calendar"></i><span> Maintenance </span> <span class="badge badge-success pull-right">
							  <?php /*
							    include ('../db.php');
								$sql = "SELECT COUNT(*) AS cnt FROM maintenance where flat='".$_SESSION['email']."'"; 
								//include where clause for specific flat								
								$result = $con->query($sql);
								$values = mysqli_fetch_assoc($result); 
								$maint = $values['cnt']; 																
								echo $maint; 							
							   ?>
							</span></a>
                        </li>
						<li>
                            <a href="completed.php" class="waves-effect"><i class="ti-calendar"></i><span> CONFIRM</span> <span class="badge badge-success pull-right">
							  <?php
							    include ('../db.php');
								$sql = "SELECT COUNT(*) AS cnt FROM repairs where flat='".$_SESSION['email']."' and status='completed'"; 
								$sql2 = "SELECT COUNT(*) AS cnt FROM home_service where flat='".$_SESSION['email']."' and status='completed'";
								//include where clause for specific flat								
								$result = $con->query($sql); $result2 = $con->query($sql2);
								$values = mysqli_fetch_assoc($result); $values2 = mysqli_fetch_assoc($result2);
								$comp = $values['cnt']+ $values2['cnt'];				
								echo $comp;		*/						
							   ?>
							</span></a>
                        </li>-->
                        <!--<li>
                            <a title="Click to PAY" onclick="payWithPaystack();return false;" class="waves-effect"><i class="ti-money"></i><span> Pay </span></a>
                        </li>
						<li>
                            <a href="pay.php" class="waves-effect"><i class="ti-calendar"></i><span> Pay </span></a>
                        </li>
						<li>
                            <a href="rate_fixer.php" class="waves-effect"><i class="ti-check-box"></i><span> Rate Fixer </span></a>
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
                            <!--<li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="mdi mdi-email-outline noti-icon"></i>
                                    <span class="badge badge-danger noti-icon-badge">5</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                                    <div class="dropdown-item noti-title">
                                        <h5><span class="badge badge-danger float-right">745</span>Messages</h5>
                                    </div>

                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon"><img src="assets/images/users/user-5.jpg" alt="user-img" class="img-fluid rounded-circle" /> </div>
                                        <p class="notify-details"><b>Charles M. Jones</b><small class="text-muted">Dummy text of the printing and typesetting industry.</small></p>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon"><img src="assets/images/users/avatar-3.jpg" alt="user-img" class="img-fluid rounded-circle" /> </div>
                                        <p class="notify-details"><b>Thomas J. Mimms</b><small class="text-muted">You have 87 unread messages</small></p>
                                    </a>

                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon"><img src="assets/images/users/avatar-4.jpg" alt="user-img" class="img-fluid rounded-circle" /> </div>
                                        <p class="notify-details"><b>Luis M. Konrad</b><small class="text-muted">It is a long established fact that a reader will</small></p>
                                    </a>

                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            View All
                                        </a>

                                </div>
                            </li>

                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="mdi mdi-bell-outline noti-icon"></i>
                                    <span class="badge badge-success noti-icon-badge">3</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                  
                                    <div class="dropdown-item noti-title">
                                        <h5><span class="badge badge-danger float-right">87</span>Notification</h5>
                                    </div>
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
                                        <p class="notify-details"><b>Your order is placed</b><small class="text-muted">Dummy text of the printing and typesetting industry.</small></p>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-success"><i class="mdi mdi-message"></i></div>
                                        <p class="notify-details"><b>New Message received</b><small class="text-muted">You have 87 unread messages</small></p>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-warning"><i class="mdi mdi-martini"></i></div>
                                        <p class="notify-details"><b>Your item is shipped</b><small class="text-muted">It is a long established fact that a reader will</small></p>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            View All
                                        </a>

                                </div>
                            </li>

                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="assets/images/users/user-5.jpg" alt="user" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                                    <a class="dropdown-item" href="#"><span class="badge badge-success pull-right">5</span><i class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a>
                                    <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5 text-muted"></i> Lock screen</a>
                                    <a class="dropdown-item" href="../logout.php"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                                </div>
                            </li>-->
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
                            <div class="col-md-6 col-xl-3">
							    <a href="view_equipments.php" >
                                <div class="mini-stat clearfix bg-white">
                                    <span class="mini-stat-icon"><i class="ti-shopping-cart"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php echo $num_eqpm; ?></span> Equipments
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-6 col-xl-3">
								<a href="repairs.php" >
                                <div class="mini-stat clearfix bg-success">
                                    <span class="mini-stat-icon"><i class="ti-settings"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php echo $num_rep; ?></span> Repairs
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-6 col-xl-3">
								<a href="home_service.php" >
                                <div class="mini-stat clearfix bg-orange">
                                    <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php echo $num_hom; ?></span> Home Service
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-6 col-xl-3">
								<a href="#" >
                                <div class="mini-stat clearfix bg-info">
                                    <span class="mini-stat-icon"><i class="ti-credit-card"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php echo "&#8358; " ?>0</span> Total Payments
                                    </div>
                                </div>
								</a>
                            </div>
                        </div>

                        