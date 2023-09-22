<?php 
  require('../db.php');
  $query = "SELECT * FROM `hostel_manager` WHERE email='".$_SESSION['email']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $rows = mysqli_num_rows($result);
  $_SESSION['hostel'] = $result->fetch_object()->hostel;
  $result = mysqli_query($con,$query) or die(mysql_error());
  $_SESSION['name'] = $result->fetch_object()->manager_name;
  $query = "SELECT hostel_name FROM `hostels` WHERE hostel_code='".$_SESSION['hostel']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $_SESSION['hostel_name'] = $result->fetch_object()->hostel_name;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php echo $_SESSION['hostel']; ?> - Hostel Manager</title>
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
                    <a href="hostel_mgr.php" class="logo"><img src="assets/images/logo.png" height="33" alt="logo"></a>
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">

                <div class="user-details">
                    <div class="text-center">
                        <img src="assets/images/users/avatar-6.jpg" alt="" class="rounded-circle">
                    </div>
                    <div class="user-info">
                            <h4 class="font-16 text-white"><?php echo $_SESSION['hostel_name'];?></h4> 
                            <h6 class="font-14 text-warning"><?php echo $_SESSION['name']; ?></h6>
                            <span class="text-white"><i class="fa fa-dot-circle-o text-success"></i> Online</span>
                    </div>
                </div>

            <div id="sidebar-menu">
                <ul>
                        <li>
                            <a href="hostel_mgr.php" class="waves-effect">
                                <i class="ti-home"></i>
                                <span> Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="hostel_workorder.php" class="waves-effect">
                                <i class="fa fa-calendar"></i>
                                <span> Work Orders</span>
                            </a>
                        </li>
						<li>
                            <a href="hostel_fixers.php" class="waves-effect">
                                <i class="fa fa-users"></i>
                                <span> Fikxers</span>
                            </a>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-user"></i> <span> Residents  </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                                <li><a href="add_student.php">Register Resident</a></li>  
                                <li><a href="residents.php">Manage Residents</a></li>                   
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-table"></i> <span> Asset Management  </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled"> 
                              <li><a href="add_equipment.php">Add Asset</a></li>  
                              <li><a href="hostelassets.php">Assets</a></li>
                              <li><a href="inventory.php">Inventory</a></li>
                            </ul>
                        </li>
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa fa-calendar"></i> <span> Management  </span> <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="list-unstyled">
                              <li><a href="hostel_locations.php">Locations</a></li>
                              <li><a href="hostelservices.php">Services</a></li>
                              <li><a href="notices.php">Notices</a></li>
                              <li><a href="hmessages.php">Messages</a></li>
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
                            <div class="col-md-3 col-xl-3">
								<a href="hostel_mgr.php" >
                                <div class="mini-stat clearfix bg-white">
                                    <span class="mini-stat-icon"><i class="ti-shopping-cart"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT count(*) as cnt FROM student_requests where status='Pending' and hostel = '".$_SESSION['hostel']."'";
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$num = $values['cnt']; 	
										echo $num;								
									   ?></span> Residents' Requests
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-3 col-xl-3">
								<a href="residents.php" >
                                <div class="mini-stat clearfix bg-success">
                                    <span class="mini-stat-icon"><i class="ti-user"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM residents where hostel='".$_SESSION['hostel']."'"; 
										$result = $con->query($sql);
										$values = mysqli_fetch_assoc($result); 
										$num_fl = $values['cnt']; 		
										echo $num_fl;								
									   ?></span> Total Residents
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-3 col-xl-3">
								<a href="hostel_workorder.php" >
                                <div class="mini-stat clearfix bg-orange">
                                    <span class="mini-stat-icon"><i class="ti-shopping-cart-full"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT count(*) as cnt FROM student_requests where status !='Pending' and hostel = '".$_SESSION['hostel']."'";
										$result = $con->query($sql);
										$values = mysqli_fetch_assoc($result); 
										$num_f = $values['cnt'];
										echo $num_f;								
									   ?></span> Total Workorders
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-3 col-xl-3">
								<a href="hmessages.php" >
                                <div class="mini-stat clearfix bg-info">
                                    <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM messages where receiver='".$_SESSION['hostel']."' "; 
										$result = $con->query($sql);
										$values = mysqli_fetch_assoc($result); 
										$num_f = $values['cnt']; 		
										echo $num_f;								
									   ?></span> Received Messages
                                    </div>
                                </div>
								</a>
                            </div>
                        </div>
