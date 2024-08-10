<?php 
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache'); //require('auth.php');
  if($_SESSION['admin_type'] != 'event-mgr'){ session_destroy(); header("Location: ../login.php");}
  require('../db.php'); require('../users/functions.php');
  $query = "SELECT * FROM `event_mgr` WHERE email='".$_SESSION['email']."'";
  $result = mysqli_query($con,$query) or die(mysql_error());
  $rows = mysqli_num_rows($result);
  $_SESSION['name'] = $result->fetch_object()->full_name;
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
	  //echo "<script type='text/javascript'>window.top.location='view_equipments.php';</script>"; exit;
	}
  }
  // $result = mysqli_query($con,$query) or die(mysql_error());
  // $_SESSION['name'] = $result->fetch_object()->name;
  // $result = mysqli_query($con,$query) or die(mysql_error());
  // $_SESSION['updated_at'] = $result->fetch_object()->updated_at;
  // $query = "SELECT due_date FROM `estates` WHERE estate_code='".$_SESSION['estate']."'";
  // $result = mysqli_query($con,$query) or die(mysql_error());
  // $_SESSION['due_date'] = $result->fetch_object()->due_date;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>HAIVEN - Event Management</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="../users/assets/images/favicon.ico">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="../users/assets/plugins/morris/morris.css">

    <link href="../users/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../users/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="../users/assets/css/style.css" rel="stylesheet" type="text/css">
	
	<script src="https://kit.fontawesome.com/1bc1b65193.js" crossorigin="anonymous"></script>
	
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>	
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
                    <a href="estate_mgr.php" class="logo"><img src="../users/assets/images/logo.png" height="33" alt="logo"></a>
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">

                <div class="user-details">
                    <div class="text-center">
                        <img src="../users/assets/images/users/avatar-6.jpg" alt="" class="rounded-circle">
                    </div>
                    <div class="user-info">
                        <h4 class="font-16 text-white"><?php echo "Welcome back, "; ?></h4> 
                        <h6 class="font-14 text-warning"><?php echo $_SESSION['name']; ?></h6>
                        <!-- <span class="text-white"><i class="fa fa-dot-circle-o text-success"></i> Online</span> -->
                    </div>
                </div>

				<div id="sidebar-menu">
                  <ul>
					<li><a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a></li>
					<li><a href="addevent.php" class="waves-effect"><i class="ti-calendar"></i><span> Add Event </span></a></li>
                    <li><a href="sendinvite.php" class="waves-effect"><i class="ti-agenda"></i><span> Send Invite </span></a></li>
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
							<li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="../users/assets/images/users/user-5.jpg" alt="user" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <a class="dropdown-item" href="reset_password.php"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Reset Password</a>
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
                            <li class="list-inline-item app-search"> <!--<li class="hide-phone list-inline-item app-search">-->
                                <h3 class="page-title"><?php echo $title; ?></h3>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </nav>

                </div>
                <!-- Top Bar End -->

                <div class="page-content-wrapper ">

                    <div class="container-fluid">
						<?php if ($title=='Dashboard' || $title=='My Events'){ ?>
                        <div class="row">
							<div class="col-md-3 col-xl-3">
								<a href="invites.php" >
                                <div class="mini-stat clearfix bg-info">
                                    <span class="mini-stat-icon"><i class="ti-agenda"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM entrance_codes where estate='".$_SESSION['estate']."'";					
										$result = $con->query($sql);
										$values = mysqli_fetch_assoc($result); 
										$num_fl = $values['cnt']; 
										echo $num_fl;
									   ?></span> Events
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-3 col-xl-3">
								<a href="visits.php" >
                                <div class="mini-stat clearfix bg-white">
                                    <span class="mini-stat-icon"><i class="ti-user"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM entrance_codes where estate='".$_SESSION['estate']."' and (status='signed-in' OR status='signed-out')"; 
										$result = $con->query($sql); 
										$values = mysqli_fetch_assoc($result);  
										$num = $values['cnt']; 				
										echo $num;
									   ?></span> Guests
                                    </div>
                                </div>
								</a>
                            </div>
                            <div class="col-md-3 col-xl-3">
								<a href="noshow.php" >
                                <div class="mini-stat clearfix bg-danger">
                                    <span class="mini-stat-icon"><i class="ti-heart-broken"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM entrance_codes where estate='".$_SESSION['estate']."' and status='no-show'"; 								
										$result = $con->query($sql);
										$values = mysqli_fetch_assoc($result); 
										$num_f = $values['cnt']; 
										echo $num_f;
									   ?></span> No Show
                                    </div>
                                </div>
								</a>
                            </div>
							<div class="col-md-3 col-xl-3">
								<a href="pending.php" >
                                <div class="mini-stat clearfix bg-warning">
                                    <span class="mini-stat-icon"><i class="ti-stats-up"></i></span>
                                    <div class="mini-stat-info text-right text-light">
                                        <span class="counter text-white"><?php
										include ('../db.php');
										$sql = "SELECT COUNT(*) AS cnt FROM entrance_codes where estate='".$_SESSION['estate']."' and status='invite'"; 								
										$result = $con->query($sql);
										$values = mysqli_fetch_assoc($result); 
										$num_f = $values['cnt']; 
										echo $num_f;
									   ?></span> Pending
                                    </div>
                                </div>
								</a>
                            </div>
                        </div>
						<?php } ?>
