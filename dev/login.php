<?php  $title='Login'; include('header.php'); 

include('menu.php');
?>

<!-- Start contact-page Area -->
<div class="body-wrapper-signup">
    <section class="pt-20 pb-20">

        <div class="m-auto col-lg-10 pad-0">
            <div class="">

            </div>
            <h1 class="login-title blue-color">Sign in</h1>

            <div class="">
                <form method="POST" action="">
                    <label class="login-label">Enter your account details</label>
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <input type="email" name="email" class="form-control form-control-custom" placeholder="janedoe@mail.com">
                        </div>
                    </div>
                    <div class="row mt-4 mb-4">
                        <div class="col-lg-6">
                            <input type="password" name="password" class="form-control form-control-custom" placeholder="Password">
                        </div>
                    </div>
                
                    <div class="row mb-4">
                        <div class="col-lg-6 mb-5">
                            <h4><span>Remember me&ensp;<input type="checkbox" name="remember" /> &emsp;&emsp;Forgot Password? </span><a id="linka" href="recover_password.php">Click here</a></h4>
                        </div>
                        <div class="col-lg-12">
                            <input type="submit" name="login" class="btn btn-danger provide-btn" value="Proceed to Dashboard">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>


</div>
<?php include('footer.php'); ?>