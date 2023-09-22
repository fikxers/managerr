<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Update Fixer</title>
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
 <h1>Update Fixer</h1>

<?php
  // connect to the database
  include ('../db.php');
  $id = $_GET['id'];
  $phone = $_GET['phone'];
  
  $sql = "SELECT * FROM fixers WHERE email = '$id'";
  $result = $con->query($sql);
  
  if (isset($_POST['update'])){
	if($_REQUEST['phone'] != ""){
	  $phone = $_REQUEST['phone'];
	}
	$status = $_REQUEST['status'];

	$query = "UPDATE fixers set phone='".$phone."',status='".$status."' WHERE email = '$id'";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Fikxer updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='view_fixers.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating fikxer.');</script>";
	  echo "<script type='text/javascript'>window.top.location='view_fixers.php';</script>"; exit;
	}
  }
  else if (isset($_POST['cancel'])){
	 echo "<script type='text/javascript'>window.top.location='view_fixers.php';</script>";
  }
  else{

  // display records if there are records to display
  if ($result->num_rows > 0)
  { ?>
	<form class="" action="" method="POST">
		<!--<div class="form-group">
			<select class="form-control" name="skill" >
				<option value="">Choose Skill</option>						
				<option value="Generator Repairs">Generator Repairs</option> <option value="Air Conditioner">Air Conditioner</option>									
				<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
				<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option>
				<option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
			</select>
		</div>-->
		<div class="form-group">
          <input type="text" name="phone" class="form-control" placeholder="<?php echo $phone; ?>"/>
        </div>	
		<div class="form-group">
			<select class="form-control" name="status" >
				<option value="">Status</option><option value="available">Available</option> <option value="occupied">Occupied</option><option value="holiday">On holiday</option><option value="suspended">Suspended</option><option value="trial">On trial</option>
			</select>
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