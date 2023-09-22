<?php
session_start();
$val = $_GET['val']; $code = $_GET['code'];
$data = "Resident: ".$_SESSION['owner']."\n";
$data .= "Flat: ".$_SESSION['flat_no'].", Block: ".$_SESSION['block_no']."\n";
$data .= "Visitor: ".$_GET['test']."\n";
$data .= "Entrance Code: ".$code."\n";
$data .= "Vehicle Reg No: ".$_GET['regno']."\n";
$data .= "No of companions: ".$_GET['comp']."\n";
$data .= "Time Generated: ".$_GET['t']."\n";
$data .= "Validation Period: ".$val." hour(s)\n";
$data .= "Arrival Date: ".$_GET['arr_date'].", Time: ".$_GET['arr_time']."\n";

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
if($_SESSION['secyes']==1)echo "<script type='text/javascript'>window.top.location='../security/index.php';</script>";

//echo '<a href="../users/qr-code.php" class="btn btn-lg btn-primary">Back</a>';
echo "<script type='text/javascript'>window.top.location='../users/qr-code.php';</script>";
?>