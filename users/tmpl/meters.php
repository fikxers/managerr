<h4 class="mt-0 header-title" id="work-requests">Meters</h4>
<div class="table-rep-plugin">
    <div class="table-responsive b-0" >
        <?php include ('../db.php');
			$sql = "SELECT flat_no, block_no, meter_pan,owner FROM flats where estate_code='".$_SESSION['estate']."' AND meter_pan != 'NULL'";
			$result = $con->query($sql);
			if ($result->num_rows > 0) { ?>
			<table id="example" class="table  table-bordered">
			<thead><tr class="titles"><th>Flat</th><th>Block</th><th>Resident</th><th>Meter PAN</th></th><th>Action</th></tr></thead>
			  <tbody> <?php while($row = $result->fetch_assoc()) { ?>
					<tr><td><?php echo $row['flat_no']; ?></td><td><?php echo $row['block_no']; ?></td><td><?php echo $row['owner']; ?></td><td><?php echo $row['meter_pan']; ?></td><?php echo "<td><a type='button' class='btn btn-success btn-sm' title='Verify Meter' style='background-color: transparent; border-width: 0px;' href='electric/verifymeter.php?meterPAN=".$row['meter_pan']."'><i class='fa fa-check text-success m-r-0'></i></a><a type='button' title='Vend' href='mgr_vend.php?meterPAN=".$row['meter_pan']."' style='background-color: transparent; border-width: 0px;' class='btn btn-danger' title'Vend Credit'><b><i class='ti-bolt-alt text-danger m-r-0'></i></b></a><button type='button' class='btn btn-info btn-sm' title='Edit Meter' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#updatemodal-" .$row['meter_pan']."'><i class='fa fa-pencil text-info m-r-0'></i></button></td>"; 
					$_SESSION['flat_no'] = $row['flat_no']; $_SESSION['block_no'] = $row['block_no'];
					echo '<!-- Update Meter Modal -->
						<div class="modal fade" id="updatemodal-'.$row['meter_pan'].'" tabindex="-1" role="dialog" aria-labelledby="delmodal-'.$row['meter_pan'].'" aria-hidden="true">
						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="inmodal">Are you sure you want to change this meter number?</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<form action="./electric-bill.php" method="POST">
								   <div class="form-row">
									<input type="hidden" name="flat" value="'.$row['flat_no'].'">
									<input type="hidden" name="block" value="'.$row['block_no'].'">
									<div class="form-group col-lg-12">
									  <label>Enter new meter number</label>
									  <input type="text" class="form-control inputs"  name="newpan" placeholder="Current: '.$row['meter_pan'].'">
									</div>
									<div class="form-group col-lg-12">
									  <input type="submit" name="updatemeter" value="Change Meter Number" class="btn btn-block btn-outline-info">
									</div>
								   </div>
								</form>
							  </div>
							</div>
						  </div>
						</div>
						<!-- /Update Meter Modal -->'; ?></tr>
		<?php } } else {echo "Please set meter PANs.<br><br>";}
		
		 
						
						$con->close();
		?>
		      </tbody>
			</table>
    </div>
</div>

<!--<a type='button' class='btn btn-success btn-sm' title='Verify Meter' style='background-color: transparent; border-width: 0px;' href='electric/verifymeter.php?pan=.$row['meter_pan']."'><i class='fa fa-check text-success m-r-0'></i></a>
<button type='button' class='btn btn-success btn-sm' title='Verify Meter' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#updatemodal-" .$row['meter_pan']."'><i class='fa fa-check text-success m-r-0'></i></button>
<a type='button' class='btn btn-danger btn-sm' title='Vend Credit Token' style='background-color: transparent; border-width: 0px;' href='electric/mgrvend.php?meterPAN=".$row['meter_pan']."'><i class='ti-bolt-alt text-danger m-r-0'></i></a>-->