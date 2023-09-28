<?php  session_start(); $title='Managerr Accounts'; 
	// Check if the user is logged in
  	// if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
	//     // Redirect the user to another page
	//     login();
	// }
	//checkRememberMeCookie();
	if(isset($_SESSION["username"]) || isset($_SESSION["email"])){
		$button_value = "<a href='logout.php' class='nav-link'>Logout</a>";
	}
	else{
	 echo "<script type='text/javascript'>window.top.location='login.php';</script>"; exit;
		//$button_value = "<a href='login.php' class='nav-link'>Login</a>";
	}
	include('db.php');
?>
<!DOCTYPE html>
<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/favicon.ico">
		<!-- Author Meta -->
		<meta name="Managerr" content="Managerr">
		<!-- Meta Description -->
		<meta name="description" content="Managerr is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead.">
		<!-- Meta Keyword -->
		<meta name="about" content="Managerr is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead.">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>Managerr | <?php echo $title; ?></title>
		<!-- Manifest for A2HS -->
		<!-- <link rel="manifest" href="manifest.webmanifest" /> -->
		<link rel="manifest" href="manifest.json" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="theme-color" content="#ffffff">
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="css/linearicons.css">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/bootstrap.css">
			<link rel="stylesheet" href="css/magnific-popup.css">
			<link rel="stylesheet" href="css/nice-select.css">							
			<link rel="stylesheet" href="css/animate.min.css">
			<link rel="stylesheet" href="css/owl.carousel.css">
			<link rel="stylesheet" href="css/main.css">
			<style>
			@media (max-width: 768px) {
			  .float-left-sm {
				float: left;
			  }
			}
			@media (min-width: 769px) {
			  .float-right {
				float: right;
			  }
			}
			.add-button {
			  position: absolute;
			  top: 1px;
			  left: 1px;
			}
			.hidden {
			  display: none !important;
			}

			#installContainer {
			  position: absolute;
			  bottom: 1em;
			  display: flex;
			  justify-content: center;
			  width: 100%;
			}

			#installContainer button {
			  background-color: inherit;
			  border: 1px solid white;
			  color: white;
			  font-size: 1em;
			  padding: 0.75em;
			}
			</style>
		</head>
		<body>	
			  <header id="header" id="home">
		  		<div class="header-top">
		  			<div class="container">
				  		<div class="row">
				  			<div class="col-lg-6 col-sm-6 col-4 header-top-left no-padding">
				  				<ul>
									<li><a href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter"></i></a></li>
									<!--<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
									<li><a href="#"><i class="fa fa-behance"></i></a></li>-->
				  				</ul>
				  			</div>
				  			<div class="col-lg-6 col-sm-6 col-8 header-top-right no-padding">
				  				<a href="tel:08037852881">08037852881 | 07026000053</a>
				  				<a href="mailto:support@managerr.net">support@Managerr.net</a>			
				  			</div>
				  		</div>			  					
		  			</div>
				</div>
			    <div class="container main-menu">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="index.php"><img src="img/logo.png" height="100px" alt="" title="" /></a><br>
						<!--<small class="text-muted"><i>Ensuring exceptional service delivery for less</i></small>-->
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <?php if($title=='Managerr Accounts'){ ?>		          
				          <!-- <li><a href="reset-password.php">Reset Password</a></li> -->
						  <li><a href="login.php"><?php echo $button_value ?></a></li>
						  <?php } else { ?>
						  <li class="menu-active"><a href="index.php">Home</a></li>
				          <li><a href="about.php">Overview</a></li>
				          <!--<li><a href="services.php">Services</a></li>
				          <li><a href="feedback.php">Feedback</a></li>
				          <li class="menu-has-children"><a href="">Blog</a>
				            <ul>
				              <li><a href="blog-home.php">Blog Home</a></li>
				              <li><a href="blog-single.php">Blog Single</a></li>
				            </ul>
				          </li>
						  <button type="button" class="btn btn-outline-primary btn-lg">REQUEST A SERVICE</button>-->							          
			              <li><a href="how-it-works.php">How it works</a></li>			          
				          <li><a href="contact.php">Contact Us</a></li>
						  <li><a href="login.php"><?php echo $button_value ?></a></li>
						  <li><a class="btn btn-large btn-outline-danger" href="login.php">REQUEST A SERVICE</a></li>
						  <?php } ?>
				        </ul>
				      </nav><!-- #nav-menu-container -->		
					  <!--<a href="login.php"><button class="genric-btn primary float-left-sm float-right" >REQUEST A SERVICE</button></a>	-->				  
			    	</div>
			    </div>
			  </header><!-- #header --><br><br><br>
			<!-- start banner Area -->
			<section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h2 class="text-white"><?php echo $title;  //echo "<br />".$_COOKIE['remember_me']. "<br />";?></h2>
							<!-- <p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="login.php"> <?php echo $title; ?></a></p> -->
						</div>	
					</div>
				</div>
			</section>
			<!-- End banner Area -->				  
			<br>
			<!-- Start contact-page Area -->
			<section class="contact-page-area">
			  <!--<div class="row m-1">
				<div class="col-lg-4">
				  <button type="submit" name="login" class="genric-btn btn-outline-primary btn-lg btn-block">Estate</button>
			    </div>
				<div class="col-lg-4">
				  <button type="submit" name="login" class="genric-btn btn-outline-success btn-lg btn-block">Hostel</button>
				</div>
				<div class="col-lg-4">
				  <button type="submit" name="login" class="genric-btn btn-outline-info btn-lg btn-block">Hotel</button>
				</div>
				<div class="col-lg-3">
				  <button type="submit" name="login" class="genric-btn btn-outline-danger btn-lg btn-block">Login</button>
				</div>
			  </div>-->
			  <div class="container">		
			    <div class="row">
			        <!-- <h4 class="mt-0 header-title">Your Managerr Accounts</h4> -->
			        <?php
			        //FM
			        $sql = "SELECT estate_name,address,estate_code,estate_manager.id as id FROM estates join estate_manager on (estates.estate_code = estate_manager.estate) where estate_manager.email='".$_SESSION['email']."'";
			        $result = $con->query($sql);
			        if ($result->num_rows > 0) { 
			        //while($row = $result->fetch_assoc()) { 
			        //foreach ($result->fetch_assoc() as $row) {
			        while($row = mysqli_fetch_assoc($result)) { ?>
			        <div class="col-sm-4 mb-3">
			            <div class="alert alert-primary" role="alert">
			              <h6 class="alert-heading text-muted"><?php echo $row['estate_name']; ?></h6>
			              <p class="text-muted"><b>Account Type:</b> Facility Manager</p>
			              <a class="btn btn-block btn-outline-success shadow" href="users/estate_mgr.php?id=<?php echo $row['id']; ?>&admin_type=mgr">Goto Profile</a>
			            </div>
			        </div>
			        <!-- <div class="col-sm-4 mb-3">
			            <a href="users/estate_mgr.php?id=<?php echo $row['id']; ?>&admin_type=mgr">
			              <div class="alert alert-primary" role="alert">
			                <h6 class="alert-heading text-muted"><?php echo $row['estate_name']; ?></h6>
			                <p class="text-muted"><b>Account Type:</b> Facility Manager</p>
			              </div>
			            </a>
			        </div> -->
			        <?php } } 
			        //Resident
			        $sql = "SELECT estate_name,address,flats.id as id FROM estates join flats using(estate_code) where flats.email='".$_SESSION['email']."'";
			        $result = $con->query($sql);
			        if ($result->num_rows > 0) { 
			        while($row = mysqli_fetch_assoc($result)) {  ?>
			        <div class="col-sm-4 mb-3">
			        	<div class="alert alert-info" role="alert">          
			              <h6 class="alert-heading text-muted"><?php echo $row['estate_name']; ?></h6>
			              <!-- <p class="text-muted">Estate Address: <?php echo $row['address']; ?></p> -->
			              <p class="text-muted"><b>Account Type:</b> Resident</p>
			              <a class="btn btn-block btn-outline-success" href="users/flat.php?id=<?php echo $row['id']; ?>&admin_type=flat">Goto Profile</a>
			            </div>
			        </div>
			        <!-- <div class="col-sm-4 mb-3">
			            <a href="users/flat.php?id=<?php echo $row['id']; ?>&admin_type=flat">
			              <div class="alert alert-info" role="alert">
			                <h6 class="alert-heading text-muted"><?php echo $row['estate_name']; ?></h6>
			                <!-- <p class="text-muted">Estate Address: <?php echo $row['address']; ?></p> 
			                <p class="text-muted"><b>Account Type:</b> Resident</p>
			              </div>
			            </a>
			        </div> -->
			        <?php } } 
			        //Admin
			        $sql = "SELECT admin_type FROM users where email='".$_SESSION['email']."' and admin_type='admin'";
			        $result = $con->query($sql);
			        if ($result->num_rows > 0) { 
			        while($row = mysqli_fetch_assoc($result)) {
			        ?>
			        <div class="col-sm-12 mb-3">
			            <div class="alert alert-info" role="alert">
			              <p class="text-muted"><b>Account Type:</b> Super Admin | <b>Email:</b> <?php echo $_SESSION['email']; ?></p>
			              <a class="btn btn-block btn-outline-success" href="users/index.php">Goto Profile</a>
			            </div>
			        </div>
			        <!-- <div class="col-sm-12 mb-3">
			            <a href="users/index.php">
			              <div class="alert alert-info" role="alert">
			                <p class="text-muted"><b>Account Type:</b> Super Admin</p>
			                <h6 class="alert-heading text-muted">Admin email: <?php echo $_SESSION['email']; ?></h6>
			              </div>
			            </a>
			        </div> -->
			    <?php } } ?>
			    </div>			
			  </div>	
			</section><br>
			<!-- End contact-page Area -->
			<?php include('footer.php'); ?>	
		</body>
	</html>