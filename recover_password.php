<?php  $title='Recover Password'; include('header.php'); ?>

<section class="work-process-area pt-20 pb-20">
    <div class="m-auto col-lg-10">
        <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
                <a href="index.php"><img src="img/logo.png" height="40px" alt="" title="" /></a><br>
                <!--<small class="text-muted"><i>Ensuring exceptional service delivery for less</i></small>-->
            </div>
            <nav id="nav-menu-container">
              <ul class="nav-menu">
                <li class="login-btn menu-active "><a href="login.php">LOG IN</a></li>
                <li class="get-started-btn"><a href="signup.php">GET STARTED</a></li>
              </ul>
            </nav>
        </div>
    </div>
</section>

<!-- Start contact-page Area -->
<div class="body-wrapper-signup">
    <section class="pt-20 pb-20">

        <div class="m-auto col-lg-10 pad-0">
            <div class="">

            </div>
            <h1 class="login-title blue-color">Recover Password</h1>

            <div class="">
                <form method="POST" action="">
                    <label class="login-label">Enter your account details</label>
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <input type="email" name="email" class="form-control form-control-custom mb-5" placeholder="janedoe@mail.com" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <input type="submit" name="recover" class="btn btn-danger provide-btn" value="Recover Password">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php include('footer.php'); ?>