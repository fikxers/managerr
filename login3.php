<!DOCTYPE html>
<?php  $title='Login'; include('header2.php'); ?>

<section class="work-process-area pt-20 pb-20">
    <div class="m-auto col-lg-10">
        <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
                <a href="index.php"><img src="img/logo.png" height="40px" alt="" title="" /></a><br>
                <!--<small class="text-muted"><i>Ensuring exceptional service delivery for less</i></small>-->
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">

                <li class="login-btn"><a href="login.php"></a>LOG IN</li>
                <li class="menu-active get-started-btn"><a href="index.php">GET STARTED</a></li>
            </nav>
        </div>
    </div>
</section>

<!-- Start contact-page Area -->
<section class="pt-20 pb-20">

    <div class="m-auto col-lg-10">
            <div class="">

            </div>
            <h1 class="login-title blue-color">LET'S GET STARTED</h1>

        <div class="">
            <div class="nav-section">
                <nav class="custom-nav">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Personal Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Resedential Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Login</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <h5 class="register-what">What would you like to register?</h5>

                            <div class="col-lg-4">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="cs-nav nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                        <span class="active">
                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="16" cy="16" r="16" fill="#1ED760"/>
                                            </svg>
                                        </span>
                                        <span class="img"><img src="./img/home-select.png" /></span>
                                        <span class="text">Resident</span>
                                    </a>
                                    <a class="cs-nav nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                        <span class="inactive">
                                            <svg width="32" height="32" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                              <circle cx="18" cy="18" r="17" stroke="#060C2C" stroke-width="2"/>
                                            </svg>
                                        </span>
                                        <span class="img"><img src="./img/more-houses.png" /></span>
                                        <span class="text">Estate/Community</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <button class="btn btn-danger provide-btn">Provide Personal Info</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                            <h5 class="register-what-2">Please enter the following information?</h5>

                            <form class="col-lg-10">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control form-control-custom" placeholder="First name">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control form-control-custom" placeholder="Last name">
                                    </div>
                                </div>
                                <div class="row mb-3 pad-33">
                                    <div class="col">
                                        <input type="text" class="form-control form-control-custom" placeholder="Phone Number">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control form-control-custom" placeholder="Email">
                                    </div>
                                </div>
                            </form>
                            <div class="col-lg-10">
                                <button class="btn btn-danger provide-btn">+ Join Community</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <form class="col-lg-5 search-residential">
                                <div class="col">
                                    <input type="text" class="form-control form-control-custom" placeholder="Type Estate Or Community Name">
                                </div>
                            </form>
                            <hr>
                            <div class="result-count-text">3 Results found</div>
                            <div class="row result-wrapper">
                                <div class="col-md-4">
                                    Pearl Nuga
                                </div>
                                <div class="col-md-5">
                                    25 Shobarinde off Lingali Bustop
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-reply">SELECT</button>
                                </div>
                            </div>
                            <div class="row result-wrapper">
                                <div class="col-md-4">
                                    Pearl Nuga
                                </div>
                                <div class="col-md-5">
                                    25 Shobarinde off Lingali Bustop
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-reply">SELECT</button>
                                </div>
                            </div>
                            <div class="row result-wrapper">
                                <div class="col-md-4">
                                    Pearl Nuga
                                </div>
                                <div class="col-md-5">
                                    25 Shobarinde off Lingali Bustop
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-reply">SELECT</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

                        </div>
                    </div>
                </nav>
               </div>
        </div>
    </div>
</section>



<script src="js/vendor/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="js/vendor/bootstrap.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
<script src="js/easing.min.js"></script>
<script src="js/hoverIntent.js"></script>
<script src="js/superfish.min.js"></script>
<script src="js/mn-accordion.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery.circlechart.js"></script>
<script src="js/mail-script.js"></script>
<script src="js/main.js"></script>
</body>
</html>