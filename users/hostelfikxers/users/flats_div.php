<div class="form-group">
											  <select class="form-control" required name="flat" >
											    <option value="">Select Flat</option>
											    <?php include ('../db.php');
												$sql="select * from flats"; 
											    $result = $con->query($sql);; 
											    while($row = $result->fetch_assoc()) { 
											    ?>
											    <option value="<?php echo $row['email']; ?>"><?php echo "Flat ".$row['flat_no'].", Block ".$row['block_no']; ?></option><?php } ?>
											  </select>
											</div>