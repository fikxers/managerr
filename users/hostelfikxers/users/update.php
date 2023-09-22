<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Update Equipment</title>
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
 <h1>Update Equipment</h1>

<?php
  // connect to the database
  include ('../db.php');
  $id = $_GET['id'];
  $location = $_GET['location'];
  $name = $_GET['name'];
  $sql = "SELECT * FROM equipments WHERE id = $id";
  $result = $con->query($sql);
  
  if (isset($_POST['update'])){
	if($_REQUEST['name'] != ""){
	  $name = stripslashes($_REQUEST['name']);
	}
	$location = stripslashes($_REQUEST['location']);

	$query = "UPDATE equipments set name='".$name."',location='".$location."' WHERE id = $id";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Equipment updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='view_equipments.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating equipment.');</script>";
	  //echo "<script type='text/javascript'>window.top.location='view_equipments.php';</script>"; exit;
	}
  }
  else if (isset($_POST['cancel'])){
	 echo "<script type='text/javascript'>window.top.location='view_equipments.php';</script>";
  }
  else{

  // display records if there are records to display
  if ($result->num_rows > 0)
  { ?>
	<form class="" action="" method="POST">
		<div class="form-group">
			<select class="form-control" name="name" >
				<option value="">Select Equipment</option>
				<option value="Generator">Generator</option>
				<option value="Air Conditioner">Air Conditioner</option>
				<option value="Inverter">Inverter</option>
				<option value="Mobile Phone">Mobile Phone</option>
				<option value="Computer / Laptop">Computer / Laptop</option>
				<option value="CCTV">CCTV</option>
				<option value="Gas Appliances">Gas Appliances</option>
				<option value="Plumbing">Plumbing</option>
				<option value="Refrigerator">Refrigerator</option>
			</select>
		</div>
		<div class="form-group">
          <input type="text" name="location" class="form-control" placeholder="<?php echo $location; ?>"/>
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