<?php 
$name = stripslashes($_REQUEST['name']);
	    $location = stripslashes($_REQUEST['location']);
	    //$status = stripslashes($_REQUEST['status']);
		$brand = stripslashes($_REQUEST['brand']);
	    $model = stripslashes($_REQUEST['model']);
	    $size = stripslashes($_REQUEST['size']);
		$description = stripslashes($_REQUEST['description']);

		if($_SESSION['admin_type']=='admin'){
		  $flat = stripslashes($_REQUEST['flat']);
		  //$query = "INSERT into `equipments` (name, location, flat) VALUES ('$name', '$location', '".$flat."')";
		  $query = "INSERT into `equipments` (name, location, description, flat, brand, model, size) VALUES ('$name', '$location', '".$description."', '".$flat."', '".$brand."', '".$model."', '".$size."')";
		  $result = mysqli_query($con,$query); 
		  $sql = "SELECT COUNT(*) AS cnt FROM equipments where flat='".$flat."'";
		  $res = $con->query($sql);
		  $values = mysqli_fetch_assoc($res);
		  $num_eqpm = $values['cnt']; 
		  $query2 = "UPDATE flats SET no_of_equipments=".$num_eqpm." WHERE email = '".$flat."'";
		  $result2 = mysqli_query($con,$query2);
		}
		else{
		  //$query = "INSERT into `equipments` (name, location, flat) VALUES ('$name', '$location', '".$_SESSION['email']."')";
		  $query = "INSERT into `equipments` (name, location, description, flat, brand, model, size) VALUES ('$name', '$location', '".$description."', '".$_SESSION['email']."', '".$brand."', '".$model."', '".$size."')";
		  $result = mysqli_query($con,$query); 
		  $sql = "SELECT COUNT(*) AS cnt FROM equipments where flat='".$_SESSION['email']."'";
		  $res = $con->query($sql);
		  $values = mysqli_fetch_assoc($res);
		  $num_eqpm = $values['cnt']; 				
		  $query2 = "UPDATE flats SET no_of_equipments=".$num_eqpm." WHERE email = '".$_SESSION['email']."'";
		  $result2 = mysqli_query($con,$query2);
		}
	    
	    if($result && $result2){
		  echo "<script>alert('Asset added successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='".$page.".php';</script>"; exit;
	    }
	    else{
		  echo "<script>alert('Error adding Asset.');</script>";
		  echo "<script type='text/javascript'>window.top.location='".$page.".php';</script>"; exit;
	    }
	  ?>