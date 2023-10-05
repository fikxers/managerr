<?php
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache'); 
  // if(isset($_GET['id']) || isset($_GET['admin_type'])){
  //   $_SESSION['id'] = $_GET['id']; $_SESSION['admin_type'] = $_GET['admin_type'];
  // }
  if($_SESSION['admin_type'] != 'admin'){ session_destroy(); header("Location: ../login.php");}
  require ('functions.php');
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
						<li>
                            <a href="#" class="waves-effect"><i class="ti-settings"></i><span> Settings </span></a>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-user"></i> <span> Users </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
								<li><a href="view_admins.php">Admins<span class="badge badge-success pull-right">
								  <?php
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM admins"; 
									//include where clause for specific flat
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$num_eqpm = $values['cnt'];
									echo $num_eqpm;								
								   ?>
								</span></a></li>
                                <li><a href="view_flats.php">Residents<span class="badge badge-success pull-right">
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
                                <li><a href="view_fixers.php">Fikxers<span class="badge badge-success pull-right">
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
                                <li><a href="view_residents.php">Hostel Residents<span class="badge badge-success pull-right">
                                  <?php
                                    include ('../db.php');
                                    $sql = "SELECT COUNT(*) AS cnt FROM residents"; 
                                    //include where clause for specific flat
                                    $result = $con->query($sql);
                                    $values = mysqli_fetch_assoc($result); 
                                    $num_eqpm = $values['cnt']; 
                                    echo $num_eqpm;                             
                                   ?>
                                </span></a></li>
                                <li><a href="#">Hostel Fikxers<span class="badge badge-success pull-right">
                                  <?php
                                    include ('../db.php');
                                    $sql = "SELECT COUNT(*) AS cnt FROM hostel_fikxers"; 
                                    //include where clause for specific flat
                                    $result = $con->query($sql);
                                    $values = mysqli_fetch_assoc($result); 
                                    $num_eqpm = $values['cnt'];
                                    echo $num_eqpm;                             
                                   ?>
                                </span></a></li>
                                <li><a href="view_hmgrs.php">Hostel Mgrs<span class="badge badge-success pull-right">
                                  <?php
                                    include ('../db.php');
                                    $sql = "SELECT COUNT(*) AS cnt FROM hostel_manager"; 
                                    //include where clause for specific flat
                                    $result = $con->query($sql);
                                    $values = mysqli_fetch_assoc($result); 
                                    $num_eqpm = $values['cnt']; 
                                    echo $num_eqpm;                             
                                   ?>
                                </span></a></li>
                                <li><a href="view_security.php" class="waves-effect">Security Team<span class="badge badge-success pull-right">
                                  <?php
                                    include ('../db.php');
                                    $sql = "SELECT COUNT(*) AS cnt FROM security_team"; 
                                    //include where clause for specific flat
                                    $result = $con->query($sql);
                                    $values = mysqli_fetch_assoc($result); 
                                    $num_eqpm = $values['cnt']; 
                                    echo $num_eqpm;                             
                                   ?>
                                </span></a></li>
                            </ul>
                        </li>
                        <!--<li>
                            <a href="view_hostels.php" class="waves-effect"><i class="ti-calendar"></i><span> Hostels </span></a>
                        </li>-->
						<li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-book"></i> <span> Estate Mgt </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="assign_fixers.php">Assign Fixers</a></li>
                                <li><a href="completed.php">Work Orders</a></li>
								<li><a href="view_estates.php">View Estates</a></li>
								<!-- <li><a href="#" class="waves-effect"><span> Visitor Mgt </span></a></li>
								<li><a href="#">Notifications</a></li> -->
                            </ul>
                        </li>
						<!-- <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-wallet"></i> <span> Transactions </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
								<li><a href="#" class="waves-effect"><span> Wallet Deposits </span></a></li>
								<li><a href="#">Electricity</a></li>
								<li><a href="#">Estate Payments</a></li> <li><a href="#">Deposits</a></li>
								<li><a href="#">History</a></li>
                            </ul>
                        </li> -->
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-id-badge"></i> <span> Hostel Mgt </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="#">Add Fikxer</a></li>
                                <li><a href="#">Add Asset</a></li>
								<li><a href="view_hostels.php">Hostels</a></li>
                            </ul>
                        </li>
						<li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="ti-id-badge"></i> <span> Resident Mgt </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="view_equipments.php">Assets<span class="badge badge-success pull-right">
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
                                <li><a href="repairs.php">Work Requests<span class="badge badge-success pull-right">
								  <?php
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM orders"; 
									//include where clause for specific flat
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$num_rep = $values['cnt']; 	
									echo $num_rep;								
								   ?>
								</span></a></li>
								<li><a href="asset_types.php" class="waves-effect"><i class="ti-calendar"></i><span> Asset Types</span></a></li>
                                <!--<li><a href="home_service.php">Errand Services<span class="badge badge-success pull-right">
								  <?php
									include ('../db.php');
									$sql = "SELECT COUNT(*) AS cnt FROM home_service"; 
									//include where clause for specific flat
									$result = $con->query($sql);
									$values = mysqli_fetch_assoc($result); 
									$num_hom = $values['cnt']; 
									echo $num_hom;								
								   ?>
								</span></a></li>-->
                            </ul>
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
							<li class="nav-link arrow-none waves-effect nav-user"><!--<span><?php echo $title; ?></span></li>-->
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
									   ?></span> Estate Residents
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
									   ?></span> Estate Fikxers
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
									   ?></span> Estate FMs
                                    </div>
                                </div>
								</a>
                            </div>
                        </div>