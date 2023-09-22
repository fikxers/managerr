<?php
// $target_dir = "img/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// // Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//   $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//   if($check !== false) {
//     echo "File is an image - " . $check["mime"] . ".";
//     $uploadOk = 1;
//   } else {
//     echo "File is not an image.";
//     $uploadOk = 0;
//   }
// }

// // Check if file already exists
// if (file_exists($target_file)) {
//   echo "Sorry, file already exists.";
//   $uploadOk = 0;
// }

// // Check file size
// if ($_FILES["fileToUpload"]["size"] > 500000) {
//   echo "Sorry, your file is too large.";
//   $uploadOk = 0;
// }

// // Allow certain file formats
// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
// && $imageFileType != "gif" ) {
//   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//   $uploadOk = 0;
// }

// // Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//   echo "Sorry, your file was not uploaded.";
// // if everything is ok, try to upload file
// } else {
//   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//     echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.\n";
//     echo "File path: ".$target_file;
//   } else {
//     echo "Sorry, there was an error uploading your file.";
//   }
// }
?>
<?php
// require_once  "db.php";

// $errors = array();
// $success = array();
// if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

//     $uploadDir = 'img/';
//     $allowTypes = array('jpg','png','jpeg','gif');

//     if(!empty(array_filter($_FILES['files']['name']))){
//         foreach($_FILES['files']['name'] as $key=>$val){
//             $filename = basename($_FILES['files']['name'][$key]);
//             $targetFile = $uploadDir.$filename;
//             if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFile)){
//                 $success[] = "Uploaded $filename";
//                 $insertQrySplit[] = "('$filename')";
//             }
//             else {
//                 $errors[] = "Something went wrong- File - $filename";
//             }
//         }

//         //Inserting to database
//         if(!empty($insertQrySplit)) {
//             $query = implode(",",$insertQrySplit);
//             $sql = "INSERT INTO upload_images (image) VALUES $query";
//             $stmt= $conn->prepare($sql);
//             $stmt->execute();
//         }
//     }
//     else {
//         $errors[] = "No File Selected";
//     }

// }
?>
<?php session_start();
if(isset($_POST['submit'])){ 
  // Include the database configuration file 
  include_once '../db.php';
  //$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
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
	function createDirectory($input) {
        //$add = $_POST["add"];
        mkdir("img/".$input);
        //echo "<script type = 'text/javascript'>alert('Done!');</script>";
    }
  $image_code = generate_string($permitted_chars, 7);
  $order_no = "WKRQ-".$image_code;
  $equipment = stripslashes($_REQUEST['equipment']);
  $description = mysqli_real_escape_string($con, $_REQUEST['description']); //$description = stripslashes($_REQUEST['description']);
  $date = stripslashes($_REQUEST['date']);
  if( ! ini_get('date.timezone') ){date_default_timezone_set('Africa/Lagos');}
  $trn_date = date("Y-m-d H:i:s");
  $query = "INSERT into `orders` (order_no,flat,estate,order_name,order_status, created_at, description,preferred_date, order_type,image_code) VALUES ('".$order_no."','".$_SESSION['email']."', '".$_SESSION['estate']."','$equipment', 'pending','$trn_date', '$description','$date','repairs','".$image_code."')";

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
				  $msg = 'You have submited the work request for '.$equipment.'. The FM will schedule a visit to assess the work. Look out for further updates.';
				  echo "<script>alert('".$msg."');</script>";
				  //echo "<script>alert('You have submited the work request.');</script>";
				  echo "<script type='text/javascript'>window.top.location='flat.php#work-requests';</script>"; exit;
				}else{
				  echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
				  echo "<script type='text/javascript'>window.top.location='flat.php#work-requests';</script>"; exit;
				}
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file."; 
            } 
        } 
    }else{ 
       // $statusMsg = 'Please select a file to upload.'; 
	   $query = "INSERT into `orders` (order_no,flat,estate,order_name,order_status, created_at, description,preferred_date, order_type) VALUES ('".$order_no."','".$_SESSION['email']."', '".$_SESSION['estate']."','$equipment', 'pending','$trn_date', '$description','$date','repairs')";
	   $result = mysqli_query($con,$query);
	   if($result){
		 $msg = 'You have submited the work request for '.$equipment.'. The FM will schedule a visit to assess the work. Look out for further updates.';
		 echo "<script>alert('".$msg."');</script>";
		 echo "<script type='text/javascript'>window.top.location='flat.php#work-requests';</script>"; exit;
		}else{
		  echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
		  echo "<script type='text/javascript'>window.top.location='flat.php#work-requests';</script>"; exit;
		}
    } 
     
    // Display status message 
    echo $statusMsg; 
} 
?>
<?php 
// if(isset($_POST['submit'])){ 
//     // Include the database configuration file 
//     include_once 'db.php'; 
//     $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// 	function generate_string($input, $strength = 16) {
// 	    $input_length = strlen($input);
// 	    $random_string = '';
// 	    for($i = 0; $i < $strength; $i++) {
// 	        $random_character = $input[mt_rand(0, $input_length - 1)];
// 	        $random_string .= $random_character;
// 	    }
// 	    return $random_string;
// 	}
//     $image_code = generate_string($permitted_chars, 7);
//     // File upload configuration 
//     $targetDir = "img/"; 
//     $allowTypes = array('jpg','png','jpeg','gif'); 
     
//     $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
//     $fileNames = array_filter($_FILES['files']['name']); 
//     if(!empty($fileNames)){ 
//         foreach($_FILES['files']['name'] as $key=>$val){ 
//             // File upload path 
//             $fileName = basename($_FILES['files']['name'][$key]); 
//             $targetFilePath = $targetDir . $fileName; 
             
//             // Check whether file type is valid 
//             $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
//             if(in_array($fileType, $allowTypes)){ 
//                 // Upload file to server 
//                 if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){ 
//                     // Image db insert sql  $image_code
//                     $insertValuesSQL .= "('".$image_code."','".$targetFilePath."', NOW()),"; 
//                 }else{ 
//                     $errorUpload .= $_FILES['files']['name'][$key].' | '; 
//                 } 
//             }else{ 
//                 $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
//             } 
//         } 
         
//         if(!empty($insertValuesSQL)){ 
//             $insertValuesSQL = trim($insertValuesSQL, ','); 
//             // Insert image file name into database 
//             $insert = $con->query("INSERT INTO images (image_code,file_name, uploaded_on) VALUES $insertValuesSQL"); 
//             if($insert){ 
//                 $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):''; 
//                 $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):''; 
//                 $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType; 
//                 $statusMsg = "Files are uploaded successfully.".$errorMsg; 
//             }else{ 
//                 $statusMsg = "Sorry, there was an error uploading your file."; 
//             } 
//         } 
//     }else{ 
//         $statusMsg = 'Please select a file to upload.'; 
//     } 
     
//     // Display status message 
//     echo $statusMsg; 
// } 
?>