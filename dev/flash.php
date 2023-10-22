<!DOCTYPE html>
<?php  $title='Managerr Accounts'; include('header.php'); 

include('menu.php');
?>

<!-- Start contact-page Area -->
<div class="body-wrapper-signup">
    <section class="pt-20 pb-20">

        <div class="m-auto col-lg-10 pad-0">
            <h1 class="login-title blue-color"><?php echo $title; ?></h1>
            <div class="row">
                    <?php
                    //FM
                    $sql = "SELECT estate_name,address,estate_code,estate_manager.id as id FROM estates join estate_manager on (estates.estate_code = estate_manager.estate) where estate_manager.email='".$_SESSION['email']."'";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) { 
                    while($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-sm-4 mb-3">
                        <div class="alert border-dark alert-light" role="alert">
                          <h6 class="alert-heading text-muted"><?php echo $row['estate_name']; ?></h6>
                          <p class="text-muted"><b>Account Type:</b> Facility Manager</p>
                          <a class="btn btn-block btn-outline-dark shadow" href="users/estate_mgr.php?id=<?php echo $row['id']; ?>&admin_type=mgr">Goto Profile</a>
                        </div>
                    </div>
                    <?php } } 
                    //Resident
                    $sql = "SELECT estate_name,address,flats.id as id FROM estates join flats using(estate_code) where flats.email='".$_SESSION['email']."'";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) { 
                    while($row = mysqli_fetch_assoc($result)) {  ?>
                    <div class="col-sm-4 mb-3">
                        <div class="alert border-dark alert-light" role="alert">          
                          <h6 class="alert-heading text-muted"><?php echo $row['estate_name']; ?></h6>
                          <!-- <p class="text-muted">Estate Address: <?php echo $row['address']; ?></p> -->
                          <p class="text-muted"><b>Account Type:</b> Resident</p>
                          <a class="btn btn-block btn-outline-dark" href="users/flat.php?id=<?php echo $row['id']; ?>&admin_type=flat">Goto Profile</a>
                        </div>
                    </div>
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
                <?php } } ?>
                </div>

        </div>
    </section>
</div>
<?php include('footer.php'); ?>