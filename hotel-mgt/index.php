<?php $title='Hotel Management'; ?>
<!DOCTYPE html>
<html>
	<?php include('../script.php'); ?>
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="../img/favicon.ico">
		<!-- Author Meta -->
		<meta name="HAIVEN" content="HAIVEN">
		<!-- Meta Description -->
		<meta name="description" content="HAIVEN is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead.">
		<!-- Meta Keyword -->
		<!-- <meta name="about" content="HAIVEN is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead."> -->
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Open Graph Tags -->
		<meta name="og:title" property="og:title" content="HAIVEN">
		<!-- Twitter card -->
		<meta name="twitter:card" content="HAIVEN is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead.">
		<!-- Canonical Tage -->
		<link rel="canonical" href="https://HAIVEN.net/">
		<!-- Robots Tage -->
		<meta name="robots" content="noindex, nofollow">
		<!-- Site Title -->
		<title>HAIVEN | <?php echo $title; ?></title>
		<!-- Manifest for A2HS -->
		<!-- <link rel="manifest" href="manifest.webmanifest" /> -->
		<link rel="manifest" href="manifest.json" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="theme-color" content="#ffffff">


	    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,400,300,500,600,700" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Nunito Sans:100,200,400,300,500,600,700" rel="stylesheet">
		<!--CSS
		============================================= -->
		<link rel="stylesheet" href="../css/linearicons.css">
		<link rel="stylesheet" href="../css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../css/magnific-popup.css">
		<link rel="stylesheet" href="../css/nice-select.css">							
		<link rel="stylesheet" href="../css/animate.min. css">
		<link rel="stylesheet" href="../css/owl.carousel.css">
		<link rel="stylesheet" href="../css/main.css">
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
			.login-btn a{
				color:  background: #13247E;
			}
			.login-label{
				color: #1D2C4D;
				font-family: Montserrat;
				font-size: 36px;
				font-weight: 500;
				line-height: 44px;
				letter-spacing: 0em;
				text-align: left;
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
			img#family-img {
			    width: 500px;
			}
			img.this-for-col-img {
			    width: 90%;
			}
		</style>
	</head>
	<body>	
			<section class="banner-area" id="home">
				<div class="container">
                <header id="header" id="home">
			    <div class="main-menu">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="index.php"><img src="../img/logo.png" alt="" title="" /></a><br>
						<!--<small class="text-muted"><i>Ensuring exceptional service delivery for less</i></small>-->
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav">
						  <!-- <li class="nav-item login-btn"><a href="login.php">LOG IN</a></li> -->
						  <li class="nav-item menu-active get-started-btn"><a href="login.php">LOGIN</a></li>
						</ul>
				      </nav>			  
			    	</div>
			    </div>
			  </header><!-- #header --><br><br><br>
					<div class="fullscreen d-flex align-items-center wall-paper">
						<div class="banner-content col-lg-8 col-md-6 justify-content-center ">
							<!-- <h5 class="sub-title-o">WELCOME TO HAIVEN</h5> -->
							<h1>
								Hotel Management		
							</h1>
							<p class="description-o">
								Experience a harmonious living environment where convenience, security, and community converge seamlessly.
							</p>
						</div>	
					</div>
				</div>
			</section>
            <div class="body-wrapper">

			<!-- Start discount-section Area -->
			<section class="discount-section-area relative">
				<div class="row">
					<div class="row pt-5 pl-5">
						<div class="col-md-9 this-for">
							<h1>Book a room</h1>
							<p class="mt-5">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien.
							</p>
						</div>
					</div>
					<div class="row p-5">
						<?php $j=1; include ('db.php');  include ('functions.php');  
                          $sql = "SELECT *, h.Name hotel_name,t.Name type_name,t.price_per_night price FROM room JOIN hotel h using(hotel_id) JOIN room_type t using(type_id)"; $result = $con->query($sql);
                          if ($result->num_rows > 0) { 
                          	while($row = $result->fetch_assoc()) { ?>
						<div class="col-md-4 mb-5 pr-3 this-for-col">
							<img src="./../img/3970.png" class="this-for-col-img" />
							<h4 class="pt-4 pb-4 pr-4"><?php echo $row['type_name']; ?></h4>
							<!-- Deluxe Room -->
                            <p>Hotel: <?php echo $row['hotel_name']; ?></p>
                            <p>Description: <?php echo $row['Description']; ?></p>
                            <h5 class="pb-4 "><?php echo currency_format($row['price']); ?></h5>
                            <a class="text-white primary-btn add-btn btn btn-green btn-green-rd" href="book.php?room_no=<?php echo $row['room_id']; ?>&room_type=<?php echo $row['type_name']; ?>">Book Room</a>
						</div>
                        <?php } ?> 
						<div class="col-md-4 mb-5 pr-2 this-for-col">
							<img src="./../img/3969.png" class="this-for-col-img" />
							<h4 class="pt-4 pb-4 pr-4">Double Suite</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque.</p>
                            <h5 class="pb-4 ">N75,000</h5>
                            <button class="primary-btn add-btn btn btn-green btn-green-rd">Book Room</button>
						</div>
						<div class="col-md-4 mb-5 pr-2 this-for-col" >
							<img src="./../img/3968.png" class="this-for-col-img" />
							<h4 class="pt-4 pb-4 pr-4">Single Room</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris sceleri sque.</p>
                            <h5 class="pb-4 ">N5,000</h5>
                            <button class="primary-btn add-btn btn btn-green btn-green-rd">Book Room</button>
						</div>
						<?php } 
						  else { echo "<br><div class='alert alert-primary' role='alert'>Sorry, you cannot book a room now.</div>"; }
                        ?>
					</div>
				</div>	
			</section>
			<!-- End discount-section Area -->
			
			<!-- Start work-process Area -->
			<section class="work-process-area pt-20 pb-20">
			<div class="container main-menu">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="index.php"><img src="../img/logo.png" height="40px" alt="" title="" /></a><br>
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu footer">
						  <li class="menu-active"><a href="index.php">Home</a></li>
				          <li><a href="#">Terms and Conditions</a></li>						          
			              <li><a href="#">Privacy Policy</a></li>			          
				          <li><a href="#">FAQ</a></li>
				        </ul>
				      </nav>
					</div>
			    </div>
			</section>
            </div>
		<?php include('../footer.php'); ?>