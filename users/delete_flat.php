<?php 
  // connect to the database
  include ('../db.php');
  $id = $_GET['id'];
  
  if (isset($_POST['delete'])){
   include ('../db.php');
   $id = $_GET['id'];
   // sql to delete a record
   $sql = "DELETE FROM flats WHERE email = '$id'"; 
   $sql1 = "DELETE FROM users WHERE email = '$id'"; 
   $res = $con->query($sql); $res1 = $con->query($sql1);
   if ($res && res1) {
    echo "<script>alert('Resident deleted.');</script>";
    echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>";	//mysqli_close($con);
    //header('Location: view_equipments.php'); //If book.php is your main page where you list your all records
    exit;
   } else {
    echo "<script>alert('Error deleting resident.');</script>";
	echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>";
   }
  }
  else if (isset($_POST['cancel'])){
	 echo "<script type='text/javascript'>window.top.location='view_flats.php';</script>";
  }
  else{

 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Delete Resident</title>
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
 <h3>Delete Resident</h3><br><br>
	<form class="" action="" method="POST">
        <div class="form-group">
          <div>
            <button type="submit" name="delete" class="btn btn-primary">
              Delete</button> 
           <button type="submit" name="cancel" class="btn btn-primary">Cancel</button>
          </div>
        </div>
    </form>
	</div>
	</section>
	<?php

  }

?>
</body>
</html>