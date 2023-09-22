<?php
session_start();
if (isset($_GET['val'], $_GET['code'])){
	$val = $_GET['val']; $code = $_GET['code'];
	$data = "Resident: ".$_SESSION['owner']."\n";
	$data .= "Flat: ".$_SESSION['flat_no'].", Block: ".$_SESSION['block_no']."\n";
	$data .= "Visitor: ".$_GET['test']."\nEntrance Code: ".$code."\n";
	$data .= "Vehicle Reg No: ".$_GET['regno']."\n"."Phone: ".$_GET['phone']."\n";
	$data .= "No of companions: ".$_GET['comp']."\n";
	$data .= "Time Generated: ".$_GET['t']."\n";
	$data .= "Validation Period: ".$val." hour(s)\n";
	$data .= "Arrival: ".$_GET['arr_date']."\n";

	//https://www.codexworld.com/generate-qr-code-php-google-chart-api/
	// include QR_BarCode class 
	include "QR_BarCode.php";

	// QR_BarCode object 
	$qr = new QR_BarCode(); 

	// create text QR code 
	$qr->text($data); 
	//$qr->text('CodexWorld Save Demo'); 

	// save QR code image
	$img_path = 'images/'.$code.'.png';
	$qr->qrCode(350,$img_path);
	//$qr->qrCode(350,'images/cw-qr.png');

	// display QR code image
	//$qr->qrCode();
	// if($_SESSION['secyes']==1){
	// 	echo "<script type='text/javascript'>window.top.location='../security/index.php';</script>";
	// }
	// // echo '<a href="../users/qr-code.php" class="btn btn-lg btn-primary">Back</a>';
	// //echo "<script type='text/javascript'>window.top.location='../users/qr-code.php';</script>";
	// else {
	// 	echo "<script type='text/javascript'>window.top.location='../users/flat.php';</script>";
	// }
	header("Location: " . $_SERVER["HTTP_REFERER"]);
}
else {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}


?>