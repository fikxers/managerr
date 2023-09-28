<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 
session_start();
include 'barcode.php';
$val = $_GET['val'];/*no of hour*/ $t = $_GET['t']; /*current time*/
/*$timeToAdd = ($val * 60 * 60);
$timeToExpire = $t + $timeToAdd;*/
//$t->add(new DateInterval("PT{$val}H"));
//$exp_date = $t->format('d/m/Y H:i');//date('d/m/Y H:i',$timeToExpire);
//$timestamp = strtotime('+4 hour',$_GET['t']);
// $now=date("Y/sm/d H:i:s");
// $diff=date_diff($t,$now)s;

$data = "Resident: ".$_SESSION['owner']."\n";
$data .= "Flat: ".$_SESSION['flat_no'].", Block: ".$_SESSION['block_no']."\n";
$data .= "Visitor: ".$_GET['test']."\n";
$data .= "Vehicle Reg No: ".$_GET['regno']."\n";
$data .= "No of companions: ".$_GET['comp']."\n";
$data .= "Time Generated: ".$t."\n";
$data .= "Validation Period: ".$val." hour(s)\n";
//$data .= "Arrival Date: ".$_GET['arr_date']."\n";
//$data .= "Expected Time: ".$_GET['arr_time']."\n";
$data .= "Arrival Date: ".$_GET['arr_date'].", Time: ".$_GET['arr_time']."\n";
//s$data .= "Expiry time: ".$exp_date."\n";
//$url = "barcode.php?f=svg&s=qr&d=".$data;
$generator = new barcode_generator();

$format = "png";
$symbology = "qr";
// $data = "Resident: Polycarp Yakoi\n";
// $data .= "Visitor: Sylvia Akpos\n";
//https://github.com/kreativekorp/barcode

$options = NULL;
/* Output directly to standard output. */
//$generator->output_image($format, $symbology, $data);
$generator->output_image($format, $symbology, $data, $options);
//barcode.php?f=svg&s=qr&d=HELLO%20WORLD&sf=8&ms=r&md=0.8

/* Create bitmap image. */
// $image = $generator->render_image($symbology, $data, $options);
// imagepng($image);
// imagedestroy($image);

/* Generate SVG markup. */
// $svg = $generator->render_svg($symbology, $data, $options);
// echo $svg;

?>