<?php include('auth.php'); $title ='Work Orders'; 
if($_SESSION['admin_type']=='admin'){include('admin_sidebar.php'); }
else if($_SESSION['admin_type']=='mgr'){include('mgr_sidebar.php');}
else if($_SESSION['admin_type']=='flat'){include('flat_sidebar.php');}	
require('../db.php');

if (isset($_POST['equipment'])){
  $equipment = stripslashes($_REQUEST['equipment']);
  $description = stripslashes($_REQUEST['description']); $service = stripslashes($_REQUEST['service']);
  $date = stripslashes($_REQUEST['date']); $completion_date = stripslashes($_REQUEST['cdate']);
  //$status = stripslashes($_REQUEST['status']);		  
  //b4 insert, check if exists
  if( ! ini_get('date.timezone') ){date_default_timezone_set('Africa/Lagos');}
  $trn_date = date("Y-m-d H:i:s");
  //$query = "INSERT into `repairs` (flat,estate, status, created_at, equipment, description,preferred_date) VALUES ('".$_SESSION['email']."', '".$_SESSION['estate']."', 'pending','$trn_date', '$equipment', '$description','$date')";
  $query = "INSERT into `orders` (flat,estate,order_name,order_status, created_at, service description,preferred_date, completion_date, order_type) VALUES ('".$_SESSION['email']."', '".$_SESSION['estate']."','$equipment', 'pending','$trn_date','$service', '$description','$date','$completion_date','repairs')";
  //$query = "INSERT into `orders` (flat,estate,order_name,order_status, created_at, description,preferred_date, order_type) VALUES ('".$_SESSION['email']."', '".$_SESSION['estate']."','$equipment', 'pending','$trn_date', '$description','$date','repairs')";
  $result = mysqli_query($con,$query);
  if($result){
	echo "<script>alert('Work Request raised.');</script>";
	echo "<script type='text/javascript'>window.top.location='flat.php#work-requests';</script>"; exit;
  }
  else{
    echo "<script>alert('Work Request not raised successfully.');</script>";
    echo "<script type='text/javascript'>window.top.location='flat.php#work-requests';</script>"; exit;
  }
}
else if (isset($_POST['name'])){
  $page = 'repairs';
  include("tmpl/add_asset_script.php");
}
else{
//echo "<script>alert('Error');</script>";
?>
  <div class="row">       
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-body">
        <h4 class="mt-0 header-title">Work Orders</h4>
    		<!--<span style="float: right"><a data-toggle="modal" data-target="#ordermodal" data-original-title="Raise Work Request"><i class="fa fa-bullhorn text-success m-r-10 m-b-10"> <b>Raise Work Request</b></i></a></span>
    		 <span style="float: right"><a data-toggle="modal" data-target="#assetmodal" data-original-title="Add Asset"><i class="fa fa-plus text-info m-r-10 m-b-10"> <b>Add Asset</b></i></a></span><button type='button' class='btn btn-info btn-sm' style='background-color: transparent; border-width: 0px; float: right;' data-toggle='modal' data-target='#assetmodal' data-original-title='Add Asset'><i class='fa fa-plus text-info m-r-10 m-b-10'> <b>Add Asset</b></i></button>-->
    		 <button type='button' class='btn btn-danger btn-sm' style='border-radius: 10px; float: right;' data-toggle="modal" data-target="#ordermodal" data-original-title="Raise Work Request"><i class='fa fa-plus'></i> <b>Work Request</b></button><br><br>	
         <?php include ('tmpl/work_order.php'); ?>
        </div>
      </div>
    </div> <!-- end col -->  
  	<div class="col-lg-12">
        <div class="card m-b-30">
          <div class="card-body">
            <?php include("tmpl/work_request_list.php"); ?>    
          </div>
        </div>
    </div>
	   <!-- Modal --><?php include ('tmpl/work_request.php'); ?><!-- /Modal -->		
		 <!-- Modal -->
		 <div class="modal fade" style="border-color: red important; margin: 5px;" id="assetmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Add new Asset</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<?php include('tmpl/add_asset.php');	?>	
						</div>
					</div>
				</div>
			</div><!-- /Modal -->
  </div><!-- container -->
 </div><!-- Page content Wrapper -->
</div><!-- content -->
<?php include('footer.php'); } ?>
</html>