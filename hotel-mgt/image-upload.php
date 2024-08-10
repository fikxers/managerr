<!DOCTYPE html>
<?php 
 // Include the database configuration file 
 include_once 'db.php'; 
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Image Upload</title>
</head>
<body>
	<form action="upload.php" method="post" enctype="multipart/form-data">
      Select Image Files to Upload:
      <input type="file" name="files[]" multiple >
      <input type="submit" name="submit" value="UPLOAD">
	</form>
	<h3>Uploaded Images</h3>
	<?php
	// Include the database configuration file
	//include_once 'dbConfig.php';

	// Get images from the database
	$query = $con->query("SELECT * FROM images ORDER BY id DESC");

	if($query->num_rows > 0){
		echo '<div class="row">';
	    while($row = $query->fetch_assoc()){
	        $imageURL = 'uploads/'.$row["file_name"];
	        echo '<div class="col-md-3 col-lg-12"><img src="'.$imageURL.'" alt="" /></div>'
	?>
	    <!-- <img src="<?php echo $imageURL; ?>" alt="" /> -->
	<?php }
		echo '</div>';
	}else{ ?>
	    <p>No image(s) found...</p>
	<?php } ?> 
</body>
</html>