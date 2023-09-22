<?php
  //OPTIONS -> 1-Set Meter
  require('../db.php');
  // Retrieve data from Query String
  //$meter_pan = $_GET['pan']; $estate = $_GET['estate'];$block = $_GET['block'];$flat = $_GET['flat'];
  $meter_pan = $_POST['meterPAN']; $estate = $_POST['estate'];$block = $_POST['block'];$flat = $_POST['flat'];
  $query = "UPDATE flats set meter_pan = '$meter_pan' WHERE flat_no = $flat AND block_no = $block AND estate_code = '$estate'";
  $result = mysqli_query($con,$query) or die(mysqli_error());; 
  echo "Meter PAN Set Successfully<br />";
?>