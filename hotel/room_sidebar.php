<?php 
  require('../db.php');
  $query = "SELECT * FROM `residents` WHERE email='".$_SESSION['email']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $name = mysqli_query($con,$query) or die(mysql_error());
  $hostel = mysqli_query($con,$query) or die(mysql_error());
  $_SESSION['room'] = $result->fetch_object()->room_no;
  $_SESSION['name'] = $name->fetch_object()->full_name;
  $_SESSION['hostel'] = $hostel->fetch_object()->hostel;
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
    <title>Fikxers - <?php echo $title; ?></title>
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
                    <a href="room.php" class="logo"><img src="assets/images/logo.png" height="33" alt="logo"></a>
                </div>
            </div>
            <div class="sidebar-inner slimscrollleft">
                <div class="user-details">
                    <div class="text-center">
                        <img src="assets/images/users/<?php echo $_SESSION['hostel'].'.png'; ?>" alt="" class="rounded-circle">
                    </div>
                    <div class="user-info">
                        <h4 class="font-16 text-white"><?php echo "Room ".$_SESSION['room']; ?></h4> 
                        <h4 class="font-14 text-white"><?php echo $_SESSION['hostel_name']; ?></h4><h6 class="font-14 text-warning"><?php echo $_SESSION['name']; ?></h6>
                        <span class="text-white"><i class="fa fa-dot-circle-o text-success"></i> Online</span>
                    </div>
                </div>
                <div id="sidebar-menu">
                    <ul>
                        <li>
                            <a href="room.php" class="waves-effect">
                                <i class="ti-home"></i>
                                <span> Notice Board </span>
                            </a>
                        </li>
                        <li>
                            <a href="my_requests.php" class="waves-effect"><i class="ti-settings"></i><span> My Requests </span> <span class="badge badge-success pull-right">
							  <?php
                                $r=$_SESSION['room'];
                                $sql = "SELECT COUNT(*) AS cnt FROM student_requests where hostel = '".$_SESSION['hostel']."' and room=$r";
								//include where clause for specific flat								
								$result = $con->query($sql);
								$values = mysqli_fetch_assoc($result); 
								$num_rep = $values['cnt']; 															
								echo $num_rep;								
							   ?>
							</span></a>
                        </li>
                        <li>
                            <a href="room_details.php" class="waves-effect"><i class="fa fa-desktop"></i><span> Room Details </span></a>
                        </li>
                        <!--<li>
                            <a href="profile.php" class="waves-effect"><i class="fa fa-user"></i><span> Profile </span></a>
                        </li>-->
                        <li>
                            <a href="book_service.php" class="waves-effect"><i class="ti-calendar"></i><span> Book Service </span></a>
                        </li>
                        <li>
                            <a href="hostelequipments.php" class="waves-effect"><i class="ti-calendar"></i><span> Room Assets </span></a>
                        </li>
						<!--<li>
                            <a href="hpay.php" class="waves-effect"><i class="ti-credit-card"></i><span> Payment </span></a>
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
                            <!--<div class="col-md-6 col-xl-3">
							    <a href="view_equipments.php" >
                                <div class="mini-stat clearfix bg-white">
                                    <span class="mini-stat-icon"><i class="ti-shopping-cart"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php echo "0"; ?></span> Equipments
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-6 col-xl-3">
								<a href="repairs.php" >
                                <div class="mini-stat clearfix bg-success">
                                    <span class="mini-stat-icon"><i class="ti-settings"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php echo "0"; ?></span> Repairs
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-6 col-xl-3">
								<a href="home_service.php" >
                                <div class="mini-stat clearfix bg-orange">
                                    <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php echo "0"; ?></span> Home Service
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
                            </div>-->
                        </div>