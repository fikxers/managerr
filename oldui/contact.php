	<!DOCTYPE html>
	<?php $title='Contact Us'; include('header.php'); 
	
	?>	

			<!-- start banner Area -->
			<section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">				
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								<?php echo $title; ?>				
							</h1>	
							<p class="text-white link-nav"><a href="index.php">Home </a>  <span class="lnr lnr-arrow-right"></span>  <a href="contact.php"> <?php echo $title; ?></a></p>
						</div>	
					</div>
				</div>
			</section>
			<!-- End banner Area -->				  

			<!-- Start contact-page Area -->
			<section class="contact-page-area"><br>
				<div class="container">
					<div class="row">
						<!--<div class="map-wrap" style="width:100%; height: 445px;" id="map"></div>-->
						<div class="col-lg-12 d-flex flex-column address-wrap">
						<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3964.533048206419!2d3.5545271!3d6.4539339!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf9e347d5c63d%3A0x5186ee18a81a762f!2sRealeng%20Integrated%20Limited!5e0!3m2!1sen!2sng!4v1596149124399!5m2!1sen!2sng" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe><br><br>
						</div>
						<div class="col-lg-4 d-flex flex-column address-wrap">
							<div class="single-contact-address d-flex flex-row">
								<div class="icon">
									<span class="lnr lnr-home"></span>
								</div>
								<div class="contact-details">
									<h5>Sugarland Estate</h5>
									<p>Km 22 Lekki - Epe Expy, beside Fidelity bank, Lekki Penninsula II, Lekki</p>
								</div>
							</div>
							<div class="single-contact-address d-flex flex-row">
								<div class="icon">
									<span class="lnr lnr-phone-handset"></span>
								</div>
								<div class="contact-details">
									<h5>08037852881, 07026000053</h5>
									<p>Mon to Fri 9am to 6 pm</p>
								</div>
							</div>
							<div class="single-contact-address d-flex flex-row">
								<div class="icon">
									<span class="lnr lnr-envelope"></span>
								</div>
								<div class="contact-details">
									<h5>support@HAIVEN.net</h5>
									<p>Send us your query anytime!</p>
								</div>
							</div>														
						</div>
						<div class="col-lg-8">
						  <div class="row">
							<div class="col-lg-12">
							<form action="mail.php" method="POST">
							  <div class="form-group"><label>Name</label> <input type="text" class="form-control" name="name"></div>
							  <div class="form-group"><label>Email</label> <input type="text"  class="form-control" name="email"></div>
							  <div class="form-group"><label>Message</label><textarea  class="form-control" name="message"></textarea></div>
							  <div class="form-group">
							    <input type="submit" class="btn btn-success" value="Send">
							    <input type="reset" class="btn btn-primary" value="Clear">
							  </div>
							</form>
							</div>
						  </div>
							<!--<form class="form-area " id="myForm" action="mail.php" method="POST" enctype="multipart/form-data" class="contact-form text-right">
								<div class="row">	
									<div class="col-lg-6 form-group">
										<input name="fullname" placeholder="Full name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" class="common-input mb-20 form-control" required="" type="text">
									
										<input name="email" placeholder="Email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">
										
										<input name="phone" placeholder="Phone" class="common-input mb-20 form-control" required type="text">

										<input name="subject" placeholder="Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your subject'" class="common-input mb-20 form-control" required="" type="text">
									</div>
									<div class="col-lg-6 form-group">
										<textarea class="common-textarea form-control" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
									</div>
									<div class="col-lg-12">
										<input type="submit" class="btn btn-success btn-send" value="Send message">
										<!--<div class="alert-msg" style="text-align: left;"></div>
										<button type="submit" class="genric-btn primary circle" style="float: right;">Send Message</button>									
									</div>
								</div>
							</form>	-->	
						</div>
					</div>
				</div><br><br>	
			</section>
			<!-- End contact-page Area -->

			<?php include('footer.php'); ?>	
		</body>
	</html>