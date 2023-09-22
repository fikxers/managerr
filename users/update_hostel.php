<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Update Hostel</title>
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
 <h1>Update Hostel</h1>

<?php
  // connect to the database
  include ('../db.php');
  $id = $_GET['id'];	$address = $_GET['address'];	$rooms = $_GET['rooms'];	
  	$name = $_GET['name'];
  
  if (isset($_POST['update'])){
	if($_REQUEST['name'] != ""){
	  $name = stripslashes($_REQUEST['name']);
	}
	if($_REQUEST['location'] != ""){
	  $address = stripslashes($_REQUEST['location']);
	}
	if($_REQUEST['blocks'] != ""){
	  $blocks = $_REQUEST['blocks'];
	}
	if($_REQUEST['flats'] != ""){
	  $flats = $_REQUEST['flats'];
	}
	//$blocks = stripslashes($_REQUEST['blocks']);	$flats = stripslashes($_REQUEST['flats']);
	$query = "UPDATE hostels set hostel_name='".$name."',address='".$address."',no_of_rooms=$rooms WHERE hostel_code = '".$id."'";
	$result2 = mysqli_query($con,$query); 
	//echo "<script>alert('".$query."');</script>";
	if($result2){
	  echo "<script>alert('Hostel updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='view_hostels.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating hostel.');</script>";
	  echo "<script type='text/javascript'>window.top.location='view_hostels.php';</script>"; exit;
	}
  }
  else if (isset($_POST['cancel'])){
	 echo "<script type='text/javascript'>window.top.location='view_hostels.php';</script>";
  }
  else{
  ?>
	<form class="" action="" method="POST">
		<div class="row"> 
		  <div class="form-group col-md-6">
			<label>Name</label>
		    <input type="text" name="name" class="form-control" placeholder="<?php echo $name; ?>"/>
		  </div> 
		  <div class="form-group col-md-6">
		    <label>Address</label>
            <input type="text" name="location" class="form-control" placeholder="<?php echo $address; ?>"/>
          </div>
		  <div class="form-group col-md-6">
			<label># of blocks</label>
		    <input type="text" name="blocks" class="form-control" placeholder="<?php echo $blocks; ?>"/>
		  </div>
		  <div class="form-group col-md-6">
			<label># of flats</label>
            <input type="text" name="flats" class="form-control" placeholder="<?php echo $flats; ?>"/>
          </div>
		</div>
				
        <div class="form-group">
          <div>
            <button type="submit" name="update" class="btn btn-primary">
              Update</button> </form>
           <button type="submit" name="cancel" class="btn btn-primary">Cancel</button>
          </div>
        </div>
    
	</div>
	</section>
	<?php
  }

?>
</body>
</html>