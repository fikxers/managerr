<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Update Resident</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700" rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">

    <link rel="stylesheet" href="../fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
   <!-- Theme Style -->
   <link rel="stylesheet" href="../css/style.css"><link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
</head>
<body>

<section class="site-section">
 <div class="container">
   <?php
    session_start();
    // connect to the database
    include ('../db.php');
    $id = $_GET['id']; $n = $_GET['n']; $doe = $_GET['doe']; 
    $p = $_GET['p']; $r = $_GET['r'];$g = $_GET['g']; $ren = $_GET['ren'];
    if (isset($_POST['assign'])){
    	$name = stripslashes($_REQUEST['name']);
      $phone = stripslashes($_REQUEST['phone']);
      $room = $_REQUEST['room']; $renewal = $_REQUEST['renewal'];
      $entrydate = stripslashes($_REQUEST['doe']);
      if($name=="" || $name==$n){$name=$n;}
      if($phone=="" || $phone==$p){$phone=$p;}
      if($room=="" || $room==$r){$room=$r;}
      if(strtotime($entrydate)==false){$entrydate=$doe;}
	  if(strtotime($renewal)==false){$renewal=$ren;}
      if (isset($_POST["gender"])) {$gender = $_POST['gender'];}
      else {$gender = $g;}
      $query = "UPDATE residents SET full_name='".$name."',phone='".$phone."',gender='".$gender."',date_joined='".$entrydate."',renewal_date='".$renewal."',room_no=$room WHERE id=$id";
      //$query = "UPDATE residents SET full_name='".$name."',email='".$email."' WHERE id=$id";
      $result = mysqli_query($con,$query);
      // echo '<script type="text/javascript">alert("'.$query.'");</script>';
      // echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      if($result){
        echo "<script>alert('Update Successful.');</script>";
        echo "<script type='text/javascript'>window.top.location='residents.php';</script>"; exit;
      }
      else{
        //echo "<script>alert('Error Assigning Job');</script>"; 
        echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        echo "<script type='text/javascript'>window.top.location='residents.php';</script>"; exit;
      }
    }
    else if (isset($_POST['cancel'])){
  	 echo "<script type='text/javascript'>window.top.location='residents.php';</script>";
    }
    else{
      echo "<h1>Update Resident</h1>"; ?>
      <form class="" action="" method="POST">
        <div class="form-group"><label>Resident's Name</label><input type="text" name="name" placeholder="<?php echo $n; ?>" class="form-control form-control-sm" /></div>
        <!--<div class="form-group"><label>Resident's Email</label><input type="text" name="email" placeholder="<?php echo $e; ?>" class="form-control form-control-sm" /></div>-->
        <div class="form-group"><label>Resident's Phone</label><input type="text" name="phone" placeholder="<?php echo $p; ?>" class="form-control form-control-sm" /></div>
        <div class="form-group"><label>Room number</label><input type="number" name="room" class="form-control form-control-sm" placeholder="<?php echo $r; ?>" min="1" /></div>
        <div class="form-group"><label>Entry Date</label><input type="date" name="doe" placeholder="<?php echo $doe; ?>" class="form-control form-control-sm" /></div>
		<div class="form-group"><label>Renewal Date</label><input type="date" name="renewal" placeholder="<?php echo $ren; ?>" class="form-control form-control-sm" /></div>
        <!--<div class="form-group">
          <select class="form-control" name="location" >
            <option value="">Gender</option>
          </select>
        </div>-->
        <div class="form-group"><label>Gender</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Male">
            <label class="form-check-label" for="inlineRadio1">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Female">
            <label class="form-check-label" for="inlineRadio2">Female</label>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" name="assign" class="btn btn-primary">Update</button> 
          <button type="submit" name="cancel" class="btn btn-primary">Cancel</button>
        </div>
      </form> <?php 
      }
    ?>
    </div>
  </section>
</body>
</html>