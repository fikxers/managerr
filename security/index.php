<?php require('../users/auth.php'); $title ='Validate Code'; 
include('security_sidebar.php'); require('../db.php');
$estate_code = $_SESSION['estate']; $_SESSION['msg'] =""; $msg = "";
$_SESSION['show']= 0; $v=""; $code=""; $comp=0; $regno="";

if (isset($_POST['vcode'])){ //if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $code = $_REQUEST['code'];
  $sql = "SELECT * FROM entrance_codes where code='".$code."'";
  $result = $con->query($sql); $resident = 'Flat ';
  if ($result->num_rows > 0) { 
    $_SESSION['show']=1; 
  	while($row = $result->fetch_assoc()) {
	  if ($row['status'] != 'invite'){
		echo "<script>alert('This code has expired.');</script>";
		echo "<script type='text/javascript'>window.top.location='index.php';</script>";
	  }
  	  $v=$row['visitor']; $comp=$row['comp']; $regno=$row['reg_no']; $arr_date=$row['arr_date']; $arr_time=$row['arr_time']; $resident .= $row['flat']. ', Block '.$row['flat']; $id = $row['id'];
  	}
  	if( ! ini_get('date.timezone') ) { date_default_timezone_set('Africa/Lagos'); } $trn_date = date("Y-m-d H:i:s");
   $query = "UPDATE entrance_codes set status='signed-in', signin='".$trn_date."', security='".$_SESSION['secname']."' WHERE id = $id";
   $result2 = mysqli_query($con,$query); 
   $r='Code: '.strtoupper($code).'\nVisitor: '.$v.'\nVehicle Reg No.: '.$regno.'\nNo. of companions: '.$comp.'\nArrival Date: '.$arr_date.'\nExpected Time: '.$arr_time.'\nResident to visit: '.$resident;
	
   //$_SESSION['msg'] = '<div class="row"><div class="col-lg-12"><div class="alert alert-success" role="alert">'.$r.'</div></div></div>';
   //$id = $_REQUEST['id']; 
   //echo '<script type="text/javascript">alert("'.$query.'");</script>';
   echo '<script type="text/javascript">alert("'.$r.'");</script>';
   echo "<script type='text/javascript'>window.top.location='index.php';</script>";
  }
  else{
	//$_SESSION['msg'] = "Invalid code.";//$msg	= '<div class="row"><div class="col-lg-12"><div class="alert alert-danger" role="alert">Invalid code.</div></div></div>';
  	echo "<script>alert('Invalid code.');</script>";
	echo "<script type='text/javascript'>window.top.location='index.php';</script>";
  }
}

else{
?>
		<div class="row">
		  <div class="col-lg-12">
			<div class="card m-b-30">
              <div class="card-body">
			    
			  <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
			   <div class="form-row">
				<div class="form-group col-lg-6">
				  <input type="text" name="code" id="code" class="form-control" placeholder="Entrance Code" required />
				</div>
				<div class="form-group col-lg-6">
				  <input type="submit" name="vcode" value="Validate Code" class="btn btn-block btn-outline-info">
				</div>
			   </div>
			  </form>
			  <?php //echo '<div class="row"><div class="col-lg-12"><div class="alert alert-light text-dark" role="alert">'.$_SESSION['msg'].'</div></div></div>'; //if($_SESSION['show']===1){ }?>
			  </div>
            </div>
		  </div>
        </div><!-- end row -->
      </div><!-- container -->
    </div><!-- Page content Wrapper -->
  </div><!-- content -->
  <?php include('footer.php'); } ?>
</html>