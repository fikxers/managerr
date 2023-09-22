<?php require('auth.php'); $title ='Asset Types'; 
	  require('../db.php'); //require('functions.php'); 
	  if (isset($_POST['add'])){
	    $type = stripslashes($_REQUEST['type']);
	    if($_SESSION['admin_type']=='admin'){
		  $estate_code = stripslashes($_REQUEST['estate_code']); 
		}
		else if($_SESSION['admin_type']=='mgr'){
		  $estate_code = $_SESSION['estate'];
		}
	    $query = "INSERT into `asset_type` (type,estate) VALUES ('$type','$estate_code')";
	    $result = mysqli_query($con,$query);
		if($result){
		  echo "<script>alert('Asset type added successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='asset_types.php';</script>"; exit;
		}
		else{
		  $error=mysqli_error($con);
		  echo '<script type="text/javascript">alert("Error: '.$error.'");</script>';
		  echo "<script type='text/javascript'>window.top.location='asset_types.php';</script>"; exit;
		}
	  }
	  else if (isset($_POST['delete'])){
	  $id = $_REQUEST['id']; 
	  $query = "DELETE from asset_type WHERE tid = '$id'";
		$result2 = mysqli_query($con,$query); 
		if($result2){
		  echo "<script>alert('Deleted successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='asset_types.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Delete Error. Please try again.');</script>";
		  echo "<script type='text/javascript'>window.top.location='asset_types.php';</script>"; exit;
		}
	  }
	  else if (isset($_POST['update'])){
	    $id = $_REQUEST['id']; 
	    $type = stripslashes($_REQUEST['type']);

		$query = "UPDATE asset_type set type='".$type."' WHERE tid = $id";
		$result2 = mysqli_query($con,$query) or die(mysql_error()); 
		if($result2){
		  echo "<script>alert('Updated successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='asset_types.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Update Error. Please try again.');</script>";
		  echo "<script type='text/javascript'>window.top.location='asset_types.php';</script>"; exit;
		}
	  }
	  else{
		  if($_SESSION['admin_type']=='admin'){
		   include('admin_sidebar.php'); 
		  }
	      else if($_SESSION['admin_type']=='mgr'){
		   include('mgr_sidebar.php');
		  }
		?>
	  <div class="row">       
			<div class="col-lg-12">
        <div class="card m-b-30">
          <div class="card-body">
            <!--<h4 class="mt-0 header-title">All Residents</h4>-->
			   		<span style="float: right"><button type='button' class='btn btn-dark text-dark btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target="#residentmodal" data-original-title="Add Asset Type"><i class="fa fa-plus m-r-10 m-b-10"></i><b>Add Asset Type</b></button></span>
            <div class="table-rep-plugin">
              <div class="table-responsive b-0">
               <?php include ('../db.php'); $sql = "SELECT * FROM asset_type join estates on asset_type.estate = estates.estate_code"; $i=1;
							 if($_SESSION['admin_type']=='mgr'){
							  $sql = "SELECT * FROM asset_type  join estates on asset_type.estate = estates.estate_code where estate='".$_SESSION['estate']."'"; }
							  $result = $con->query($sql); 
							  if ($result->num_rows > 0) { ?>
							  <table id="tech-companies-1" class="table  table-bordered">
			            <thead><tr class="titles"><th>S/No</th><th>Type</th>
			            <?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?><th>Action</th></tr></thead>
			            <tbody> <?php while($row = $result->fetch_assoc()) { ?>
								  <tr><td><?php echo $i; ?></td>
									<td><?php echo $row['type']; ?></td>
									<?php if($_SESSION['admin_type']=='admin'){echo "<td>".$row['estate_name']."</td>";} ?>
									<?php echo "<td><button type='button' class='btn btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#updatemodal-" .$row['tid']."'><i class='fa fa-pencil text-success m-r-0'></i></button><button type='button' class='btn btn-danger btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-" .$row['tid']."'><i class='fa fa-trash text-danger m-r-0'></i></button></td> ";  
									echo '<!-- Delete Modal -->
									<div class="modal fade" id="delmodal-'.$row['tid'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['tid'].'" aria-hidden="true">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<h5 class="modal-title" id="delmodal">Delete '.$row['type'].'?</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										  </div>
										  <div class="modal-body">
											<form action="" method="POST">
											   <div class="form-row">
												<input type="hidden" name="id" value="'.$row['tid'].'">
												<div class="form-group col-lg-12">
												  <input type="submit" name="delete" value="Yes, Delete" class="btn btn-block btn-outline-info">
												</div>
											   </div>
											</form>
										  </div>
										</div>
									  </div>
									</div>
									<!-- /Delete Modal -->';
									echo '<!-- Update Modal -->
									<div class="modal fade" id="updatemodal-'.$row['tid'].'" tabindex="-1" role="dialog" aria-labelledby="updatemodal-'.$row['tid'].'" aria-hidden="true">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<h5 class="modal-title" id="updatemodal">Update Type?</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										  </div>
										  <div class="modal-body">
											<form action="" method="POST">
											   <div class="form-row">
												<input type="hidden" name="id" value="'.$row['tid'].'">
												<div class="form-group col-lg-12">
												  <input type="text" name="type" class="form-control" placeholder="'.$row['type'].'" value="'.$row['type'].'">
												</div>
												<div class="form-group col-lg-12">
												  <input type="submit" name="update" value="Yes. Update" class="btn btn-block btn-outline-info">
												</div>
											   </div>
											</form>
										  </div>
										</div>
									  </div>
									</div>
									<!-- /Update Modal -->';
									?>
									</tr>
									<?php $i++; } } else {echo "No asset type in database.";}
									$con->close(); ?>
                    </tbody>
                  </table>
                  </div>
								</div>
                </div>
               </div>
             </div> <!-- end col -->
						 <!-- Modal -->
						 <div class="modal fade" id="residentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
							  <div class="modal-content">
							    <div class="modal-header">
								  <h5 class="modal-title" id="exampleModalLongTitle">Add Asset Type</h5>
								  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								  </button>
								</div>
								<div class="modal-body">
								  <form class="" action="asset_types.php" method="POST">
									  <div class="form-group">
									    <input type="text" name="type" class="form-control" required placeholder="Asset Type"/>
									  </div>
									  <?php if($_SESSION['admin_type']=='admin'){
										include('estate_div.php'); } ?>
									  <div class="form-group">
										<input type="submit" name="add" value="Add Asset" class="btn btn-primary">
										<!--<button type="submit" name="add" class="btn btn-primary waves-effect waves-light">Add Asset</button>--><button type="reset" class="btn btn-secondary waves-effect m-l-5">Clear Form</button>
									  </div>
									</form>
								</div>
							  </div>
							</div>
						  </div> 
            </div><!-- container -->
          </div><!-- Page content Wrapper -->
		</div><!-- content -->
	<?php include('footer.php'); } ?>
</html>