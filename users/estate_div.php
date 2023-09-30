<div class="form-group">
	<select class="form-control" required name="estate_code" >
		<option value="">Select Estate</option>
		<?php include ('../db.php');
		$sql="select estate_code,estate_name from estates"; 
		$result = $con->query($sql);; 
		while($row = $result->fetch_assoc()) { 
		?>
		<option value="<?php echo $row['estate_code']; ?>"><?php echo $row['estate_name']; ?></option><?php } ?>
	</select>
</div>