<?php session_start();
if(isset($_POST['submit'])){ 
	// Include the database configuration file 
	include_once '../db.php';
	$order_no = $_REQUEST['order_no'];
	$permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	function generate_string($input, $strength = 16) {
	    $input_length = strlen($input);
	    $random_string = '';
	    for($i = 0; $i < $strength; $i++) {
	        $random_character = $input[mt_rand(0, $input_length - 1)];
	        $random_string .= $random_character;
	    }
	    return $random_string;
	}
	$image_code = generate_string($permitted_chars, 7);
	$description = stripslashes($_REQUEST['description']);
	$skill = stripslashes($_REQUEST['skill']);
	$service_id = stripslashes($_REQUEST['service_id']);
	$query = "UPDATE orders SET required_skill = '$skill', order_status = 'quote_requested', mgr_description='$description' WHERE order_id=$service_id";

    // File upload configuration 
    $targetDir = "img/".$order_no."/"; 
	mkdir($targetDir);
    $allowTypes = array('jpg','png','jpeg','gif'); 
     
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
    $fileNames = array_filter($_FILES['files']['name']); 
    if(!empty($fileNames)){ 
        foreach($_FILES['files']['name'] as $key=>$val){ 
            // File upload path 
            $fileName = basename($_FILES['files']['name'][$key]); 
            $targetFilePath = $targetDir . $fileName; 
             
            // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
            if(in_array($fileType, $allowTypes)){ 
                // Upload file to server 
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){ 
                    // Image db insert sql  $image_code
                    $insertValuesSQL .= "('".$image_code."','".$targetFilePath."', NOW()),"; 
                }else{ 
                    $errorUpload .= $_FILES['files']['name'][$key].' | '; 
                } 
            }else{ 
                $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
            } 
        } 
         
        if(!empty($insertValuesSQL)){ 
            $insertValuesSQL = trim($insertValuesSQL, ','); 
            // Insert image file name into database 
            $insert = $con->query("INSERT INTO images (image_code,file_name, uploaded_on) VALUES $insertValuesSQL"); 
            if($insert){ 
                $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):''; 
                $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):''; 
                $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType; 
                $statusMsg = "Files are uploaded successfully.".$errorMsg; 
                $result = mysqli_query($con,$query);
                if($result){
				  echo "<script>alert('Quote requested.');</script>";
				  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
				}else{
				  echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
				  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
				}
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file."; 
            } 
        } 
    }else{ 
       // $statusMsg = 'Please select a file to upload.'; 
	   $query = "UPDATE orders SET required_skill = '$skill', order_status = 'quote_requested', mgr_description='$description' WHERE order_id=$service_id";
	   $result = mysqli_query($con,$query);
	   if($result){
		  echo "<script>alert('Quote requested.');</script>";
		  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
		}else{
		  echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
		  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
		}
    } 
     
    // Display status message 
    echo $statusMsg; 
} 
?>