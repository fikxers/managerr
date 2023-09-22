<?php
   //session_start();
	if(isset($_SESSION["username"]))
		$button_value = "<a href='logout.php' class='nav-link'>Logout</a>";
	else
		$button_value = "<a href='login.php' class='nav-link'>Login</a>";
?>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	
	<link rel="shortcut icon" href="users/assets/images/faviicon.png">

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
	
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
  </head>
  <body>
<header role="banner">
      <div class="top-bar">
        <div class="container">
          <div class="row">
            <div class="col-9 social">
              <a href="#"><span class="fa fa-twitter"></span></a>
              <a href="#"><span class="fa fa-facebook"></span></a>
              <a href="#"><span class="fa fa-instagram"></span></a>
              <a href="#"><span class="fa fa-youtube-play"></span></a>
              <a href="#"><span class="fa fa-vimeo"></span></a>
              <a href="#"><span class="fa fa-snapchat"></span></a>
            </div>
            <!--<div class="col-3 search-top">
              <form action="#" class="search-top-form">
                <span class="icon fa fa-search"></span>
                <input type="text" id="s" placeholder="Type keyword to search...">
              </form>
            </div>-->
          </div>
        </div>
      </div>

      <div class="container logo-wrap">
        <div class="row pt-5">
          <div class="col-12 text-center">
            <a class="absolute-toggle d-block d-md-none" data-toggle="collapse" href="#navbarMenu" role="button" aria-expanded="false" aria-controls="navbarMenu"><span class="burger-lines"></span></a>
            <h1 class="site-logo"><a href="index.php">Fikxers</a></h1>
          </div>
        </div>
      </div>
      
      <nav class="navbar navbar-expand-md  navbar-light bg-light">
        <div class="container">
		  <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>
			  <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
              </li>
			  <li class="nav-item">
                <a class="nav-link" href="services.php">Services</a>
              </li>
			  <!--<li class="nav-item">
                <a class="nav-link" href="about.php">Terms</a>
              </li> -->
			  <li class="nav-item">
                <?php echo $button_value ?><!--<a class="nav-link" href="account/login">Login</a>-->
              </li>
              <!--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="category.php" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="flat-login.php">Flat</a>
                  <a class="dropdown-item" href="#">Estate Mgr</a>
                  <a class="dropdown-item" href="#">Fixer</a>
                </div>
              </li>-->

              <!--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="category.php" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
                <div class="dropdown-menu" aria-labelledby="dropdown05">
                  <a class="dropdown-item" href="category.php">Lifestyle</a>
                  <a class="dropdown-item" href="category.php">Food</a>
                  <a class="dropdown-item" href="category.php">Adventure</a>
                  <a class="dropdown-item" href="category.php">Travel</a>
                  <a class="dropdown-item" href="category.php">Business</a>
                </div>

              </li>-->
			             
              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
              </li>
            </ul>
            
          </div>
        </div
      </nav>
    </header>