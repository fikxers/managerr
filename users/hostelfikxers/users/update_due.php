<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Update Due</title>
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
 <h1>Update Due</h1>

<?php
  // connect to the database
  include ('../db.php');
  $id = $_GET['id'];
  $sql = "SELECT * FROM dues WHERE due_id = $id";
  $result = $con->query($sql);
  
  if (isset($_POST['update'])){
	$lstMntlyDuePaid = $_REQUEST['lstMntlyDuePaid']; $noMntsOwed = $_REQUEST['noMntsOwed']; 
	$totalAmountOwed = $_REQUEST['totalAmountOwed']; 
	$amntOwedThisYr = $_REQUEST['amntOwedThisYr']; $due_status = $_REQUEST['due_status'];
	//$query = "UPDATE dues set name='".$name."',location='".$location."' WHERE due_id = $id";
	$query = "UPDATE `dues` SET `lstMntlyDuePaid`=$lstMntlyDuePaid,`noMntsOwed`=$noMntsOwed,`totalAmountOwed`=$totalAmountOwed,`amntOwedThisYr`=$amntOwedThisYr,`due_status`='$due_status' WHERE due_id=$id";
	$result2 = mysqli_query($con,$query); 
	if($result2){
	  echo "<script>alert('Due updated successfully.');</script>";
	  echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
	}
	else{
	  echo "<script>alert('Error updating due.');</script>";
	  //$error=mysqli_error($con);
	  //echo '<script type="text/javascript">alert("'.$error.'");</script>';
	  //echo '<script type="text/javascript">alert("'.$query.'");</script>';
	  echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
	}
  }
  else if (isset($_POST['cancel'])){
	 echo "<script type='text/javascript'>window.top.location='dues.php';</script>";
  }
  else{

  // display records if there are records to display
  if ($result->num_rows > 0)
  { 
	$values = mysqli_fetch_assoc($result); 
	//$num_f = $values['flat'];
	//echo $num_f;
  ?>
	<form class="" action="" method="POST">
		<div class="form-group">
			<label for="name">Last monthly due paid</label>
            <input data-parsley-type="number" type="number" name="lstMntlyDuePaid" class="form-control" value="<?php echo $values['lstMntlyDuePaid']; ?>" min="0" step="100"/>
        </div>
		<div class="form-group">
			<label for="name"># of Months owed to date</label>
            <input data-parsley-type="number" type="number" name="noMntsOwed" class="form-control" value="<?php echo $values['noMntsOwed']; ?>" min="0" step="1"/>
        </div>
		<?php 
		  //if($_SESSION['admin_type']=='admin'){include('estate_div.php'); } 
		?>
		<input type="hidden" name="estate" value="<?php echo $row['estate']; ?>" />
		<div class="form-group">
			<label for="name">Total Dues owed</label> 
            <input data-parsley-type="number" type="number" name="totalAmountOwed" class="form-control" value="<?php echo $values['totalAmountOwed']; ?>" min="0" step="100"/>
        </div>
		<div class="form-group">
			<label for="name">Total Dues owed this year</label>
            <input data-parsley-type="number" type="number" name="amntOwedThisYr" class="form-control" value="<?php echo $values['amntOwedThisYr']; ?>" min="0" step="100"/>
        </div>
		<div class="form-group">
			<label for="name">Due Status</label>
			<select class="form-control" name="due_status" >
				<option value="Good">Good</option>
				<option value="Bad">Bad</option>
			</select>
		</div> <!--Due paid last month	# of months owed	Debt this year	Total Debts-->
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
   else{
	  //echo 'Selected record not available';;
	  echo "<script>alert('Selected record not available.');</script>";
	  echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
   }
  }

?>
</body>
</html>