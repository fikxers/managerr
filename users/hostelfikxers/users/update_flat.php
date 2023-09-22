<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Update Flat</title>
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
 <h1>Update Flat</h1>

<?php
  // connect to the database
  include ('../db.php');
  $id = $_GET['id'];
  $phone = $_GET['phone'];
  $owner = $_GET['owner'];
  
  $sql = "SELECT * FROM flats WHERE email = '$id'";
  $result = $con->query($sql);
  
  if (isset($_POST['update'])){
	if($_REQUEST['owner'] != ""){
	  $owner = stripslashes($_REQUEST['owner']);
	}
	if($_REQUEST['phone'] != ""){
	  $phone = stripslashes($_REQUEST['phone']);
	}
	

	$query = "UPDATE flats set owner='".$owner."',phone='".$phone."' WHERE email = '$id'";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Flat updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating flat.');</script>";
	  //echo "<script type='text/javascript'>window.top.location='view_equipments.php';</script>"; exit;
	}
  }
  else if (isset($_POST['cancel'])){
	 echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>";
  }
  else{

  // display records if there are records to display
  if ($result->num_rows > 0)
  { ?>
	<form class="" action="" method="POST">
		<div class="form-group">
          <input type="text" name="owner" class="form-control" placeholder="<?php echo "Name of Resident"; ?>"/>
        </div>		
		<div class="form-group">
          <input type="text" name="phone" class="form-control" placeholder="<?php echo "Resident's Phone"; ?>"/>
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
  }

?>
</body>
</html>