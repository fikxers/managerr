<!DOCTYPE html>
<?php  $title='Sign Up'; include('header.php'); 

include('menu.php');
?>

<!-- Start contact-page Area -->
<div class="body-wrapper-signup">
    <section class="pt-20 pb-20">
        <div class="m-auto col-lg-10 pad-0">
            <h1 class="login-title blue-color">LET'S GET STARTED</h1>
            <div class="">
                <div class="nav-section">
                    <nav class="custom-nav">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Category</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Manager Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Select Estate</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-password-tab" data-toggle="pill" href="#pills-password" role="tab" aria-controls="pills-password" aria-selected="false">Create Password</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <h5 class="register-what mb-4 mt-4">What would you like to register?</h5>
                                <div class="col-lg-4 pad-0">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="cs-nav nav-link" id="v-pills-home-tab" href="signup.php" role="tab" aria-controls="v-pills-home" aria-selected="false">
                                        <span class="active">
                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="16" cy="16" r="16"/>
                                            </svg>
                                        </span>
                                            <span class="img"><img src="./img/home-select2.png" /></span>
                                            <span class="text">Resident</span>
                                        </a>
                                        <a class="cs-nav nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="signup2.php" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                                        <span class="inactive">
                                            <svg width="32" height="32" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                              <circle cx="18" cy="18" r="17" fill="#1ED760" stroke="#060C2C" stroke-width="2"/>
                                            </svg>
                                        </span>
                                            <span class="img"><img src="./img/more-houses.png" /></span>
                                            <span class="text">Estate/Community</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-danger provide-btn nxt">Provide Manager Info</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"> <form method="POST" action="">
                                <h5 class="register-what-2">Please enter the following information?</h5>
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <input type="text" name="name" class="form-control form-control-custom" placeholder="Full name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="phone" class="form-control form-control-custom" placeholder="Phone Number" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" name="email" class="form-control form-control-custom" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-danger provide-btn nxt">Select Estate</button>
                                </div>
                            </div>
                            <div class="tab-pane fade body-wrapper-address" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <div class="row mt-4 mb-3">
                                  <div class="col-lg-12">
                                    <select class="common-input form-control form-control-custom" id="selest" data-style="btn-light" data-live-search="true" data-actions-box="true" required name="estate_code" >
                                        <option value="">Select Estate/Hostel</option>
                                        <?php include ('db.php');
                                        $sql="select estate_code,estate_name from estates"; 
                                        $result = $con->query($sql);; 
                                        while($row = $result->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['estate_code']; ?>">
                                        <?php echo $row['estate_name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-danger provide-btn nxt">Next</button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-password" role="tabpanel" aria-labelledby="pills-password">
                                <h5 class="register-what-2">Please Create Password</h5>
                                <div class="row mb-3">
                                    <div class="col-lg-6 mb-3">
                                        <input type="password" name="password" class="form-control form-control-custom" required placeholder="Password" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="password" name="rpassword" class="form-control form-control-custom" placeholder="Repeat Password" required data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                                        <input type="hidden" name="admin_type" value="mgr">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button name="signup" type="submit" class="btn mb-5 btn-danger provide-btn">Create Account</button>
                                </div>
                            </div>
                          </form>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('footer.php'); ?>