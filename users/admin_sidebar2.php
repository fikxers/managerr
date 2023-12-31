<?php 
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache');
  
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Managerr - Admin</title>
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
                    <a href="index.php" class="logo"><img src="assets/images/logo.png" height="33" alt="logo"></a>
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">

                <div class="user-details">
                    <div class="text-center">
                        <img src="assets/images/users/avatar-6.jpg" alt="" class="rounded-circle">
                    </div>
                    <div class="user-info">
                            <h4 class="font-16 text-white">Admin</h4>
                            <span class="text-white"><i class="fa fa-dot-circle-o text-success"></i> Online</span>
                    </div>
                </div>

            <div id="sidebar-menu">
                <ul>
                        <li>
                            <a href="index.php" class="waves-effect">
                                <i class="ti-home"></i>
                                <span> Home</span>
                            </a>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-light-bulb"></i> <span> Users </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="view_flats.php">Flats<span class="badge badge-success pull-right">
								  <?php
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM flats"; 
									//include where clause for specific flat								
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$num_eqpm = $values['cnt']; 																
									echo $num_eqpm;								
								   ?>
								</span></a></li>
                                <li><a href="view_fixers.php">Managerr<span class="badge badge-success pull-right">
								  <?php
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM fixers"; 
									//include where clause for specific flat								
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$num_eqpm = $values['cnt']; 																
									echo $num_eqpm;								
								   ?>
								</span></a></li>
                                <li><a href="view_mgrs.php">Estate Mgrs<span class="badge badge-success pull-right">
								  <?php
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM estate_manager"; 
									//include where clause for specific flat								
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$num_eqpm = $values['cnt']; 																
									echo $num_eqpm;								
								   ?>
								</span></a></li>
                            </ul>
                        </li>
						<li>
                            <a href="view_estates.php" class="waves-effect"><i class="ti-calendar"></i><span> Estates </span></a>
                        </li>
						<li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-shopping-cart"></i> <span> Estate Mgt </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="assign_fixers.php">Assign Fixers</a></li>
                                <li><a href="completed.php">History</a></li>
                                <!--<li><a href="view_mgrs.php">Estate Mgrs</a></li>-->
                            </ul>
                        </li>
						<li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-settings"></i> <span> Flat Mgt </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="view_equipments.php">Equipments<span class="badge badge-success pull-right">
								  <?php
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM equipments"; 
									//include where clause for specific flat								
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$num_eqpm = $values['cnt']; 																
									echo $num_eqpm;								
								   ?>
								</span></a></li>
                                <li><a href="repairs.php">Repairs<span class="badge badge-success pull-right">
								  <?php
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM repairs"; 
									//include where clause for specific flat								
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$num_rep = $values['cnt']; 																
									echo $num_rep;								
								   ?>
								</span></a></li>
                                <li><a href="home_service.php">Home Service<span class="badge badge-success pull-right">
								  <?php
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM home_service"; 
									//include where clause for specific flat								
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$num_hom = $values['cnt']; 																
									echo $num_hom;								
								   ?>
								</span></a></li>
								<!--<li><a href="maintenance.php">Maintenance<span class="badge badge-success pull-right">
								  <?php /*
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM maintenance"; 
									//include where clause for specific flat								
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$maint = $values['cnt']; 																
									echo $maint;*/								
								   ?>
								</span></a></li>-->
                            </ul>
                        </li>
						<!--<li>
                            <a href="dues.php" class="waves-effect"><i class="ti-calendar"></i><span> Dues</span></a>
                        </li>
						<li>
                            <a href="assign_fixers.php" class="waves-effect"><i class="ti-calendar"></i><span> Assign Fixers</span></a>
                        </li>
						<li>
                            <a href="completed.php" class="waves-effect"><i class="ti-calendar"></i><span> History</span></a>
                        </li>-->
                        <!--<li>
                            <a href="calendar.html" class="waves-effect"><i class="ti-calendar"></i><span> Calendar </span></a>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-files"></i><span> Pages </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="pages-timeline.html">Timeline</a></li>
                                <li><a href="pages-invoice.html">Invoice</a></li>
                                <li><a href="pages-directory.html">Directory</a></li>
                                <li><a href="pages-login.html">Login</a></li>
                                <li><a href="pages-register.html">Register</a></li>
                                <li><a href="pages-recoverpw.html">Recover Password</a></li>
                                <li><a href="pages-lock-screen.html">Lock Screen</a></li>
                                <li><a href="pages-blank.html">Blank Page</a></li>
                                <li><a href="pages-404.html">Error 404</a></li>
                                <li><a href="pages-500.html">Error 500</a></li>
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
                            <div class="col-md-6 col-sm-6 col-xs-6 col-xl-3">
                                <div class="mini-stat clearfix bg-white">
                                    <span class="mini-stat-icon"><i class="ti-user"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM users where admin_type !='admin' "; 																		
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$num = $values['cnt']; 															
										echo $num;								
									   ?></span> All Users
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 col-xl-3">
								<a href="view_flats.php" >
                                <div class="mini-stat clearfix bg-success">
                                    <span class="mini-stat-icon"><i class="ti-user"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM flats"; 																		
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$num = $values['cnt']; 															
										echo $num;								
									   ?></span> Total Flats
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 col-xl-3">
								<a href="view_fixers.php" >
                                <div class="mini-stat clearfix bg-orange">
                                    <span class="mini-stat-icon"><i class="ti-user"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM fixers "; 																		
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$num = $values['cnt']; 															
										echo $num;								
									   ?></span> Total Managerr
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6 col-xl-3">
								<a href="view_mgrs.php" >
                                <div class="mini-stat clearfix bg-info">
                                    <span class="mini-stat-icon"><i class="ti-user"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM estate_manager"; 																		
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$num = $values['cnt']; 															
										echo $num;								
									   ?></span> Total Managers
                                    </div>
                                </div>
								</a>
                            </div>
                        </div>