	<!DOCTYPE html>
	<?php $title='Login'; include('header.php'); ?>	

			<!-- start banner Area -->
			<section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								<?php echo $title; ?>				
							</h1>	
							<p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="login.php"> <?php echo $title; ?></a></p>
						</div>	
					</div>
				</div>
			</section>
			<!-- End banner Area -->				  
			<br>
			<!-- Start contact-page Area -->
			<section class="contact-page-area">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<nav>
							  <div class="nav nav-tabs" id="nav-tab" role="tablist">
								<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Login</a>
								<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Sign Up</a>
							  </div>
							</nav>
							<div class="tab-content" id="nav-tabContent">
							  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
								<form class="form-area " id="myForm" action="mail.html" method="post" class="contact-form text-right"><br>
									<div class="row">	
										<div class="col-lg-4 form-group">
											<input name="email" placeholder="Enter Email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" class="common-input mb-20 form-control" required="" type="email">
										</div>
										<div class="col-lg-3 form-group">
											<input name="password" placeholder="Password" class="common-input mb-20 form-control" required="" type="password">
										</div>
										<div class="col-lg-3">
											<span>Forgot Password? </span><a id="linka" href="recover_password.php">Click here</a><br>
										</div>
										<div class="col-lg-2">
											<div class="alert-msg" style="text-align: left;"></div>
											<button class="genric-btn primary btn-lg circle" style="float: left;">Login</button>											
										</div>
									</div>
								</form>
							  </div>
							  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><br>
								<form class="form-area " id="myForm" action="mail.html" method="post" class="contact-form text-right">
									<div class="row">	
										<div class="col-lg-6 form-group">
											<input name="name" placeholder="Full name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Full name'" class="common-input mb-20 form-control" required="" type="text">
										
											<input name="email" placeholder="Email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">

											<input name="phone" placeholder="Phone" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your subject'" class="common-input mb-20 form-control" required="" type="text">
											
											<input name="flat_no" type="text"  class="common-input mb-20 form-control" placeholder="Flat No. (Flats only!)"/>
										</div>
										<div class="col-lg-6 form-group">
											<input name="block_no" type="text" class="common-input mb-20 form-control" placeholder="Block No. (Flats only!)"/>
											
											<select class="common-input mb-20 form-control" required name="estate_code" >
											<option value="">Select Estate Code</option>
											<?php include ('../db.php');
												$sql="select estate_code from estates"; 
												$result = $con->query($sql);; 
												while($row = $result->fetch_assoc()) { ?>
												  <option value="<?php echo $row['estate_code']; ?>"><?php echo $row['estate_code']; ?></option><?php } ?>
											</select>
											<input type="password" name="password" class="common-input mb-20 form-control" required placeholder="Password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
											<div class="validation"></div>
											
											<input name="rpassword" type="password" class="common-input mb-20 form-control" required placeholder="Repeat password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
											<div class="validation"></div>
											<div class="form-group">
											  <input type="radio" required name="admin_type" value="flat"> Flat
											  <input type="radio" required name="admin_type" value="mgr"> Estate Manager
											</div>
										</div>
										<div class="col-lg-12">
											<div class="alert-msg" style="text-align: left;"></div>
											<button class="genric-btn primary circle" style="float: right;">Send Message</button>											
										</div>
									</div>
								</form>
							  </div>
							</div>
						</div>
					</div>
				</div>	
			</section><br>
			<!-- End contact-page Area -->

			<?php include('footer.php'); ?>	
		</body>
	</html>