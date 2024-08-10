<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team
-->
<?php session_start();
include 'atl_constants.php';
$transactionId = $_GET["transaction"]; $id = $_GET["id"];
$flat = $_GET["flat"];$block = $_GET["block"];
$customerName = $_GET['owner']; $e = $_SESSION['estate'];
$responseurl = PATH . "/receipt.php"; $query=$msg=$msg2="";

$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" . $transactionId);

//Going ahead to vend after meter details were pulled
$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '","transactionId":"'. $transactionId .'"}';

$json_response = apiCall(VERIFY_STATUS, $data);
$vendResponse = json_decode($json_response);
//echo json_encode($vendResponse, JSON_PRETTY_PRINT);
//$statusCode = $vendResponse->statusCode; 
$status = $vendResponse->status; 
// echo "<br>TOKEN TRANSACTION STATUS<br>";
if ($vendResponse->statusCode == "0"){
	$meterPAN = $vendResponse->meterPAN;
	$value = $vendResponse->value;
	$vendTime = $vendResponse->vendTime;
	$tariff = $vendResponse->tariff;
	$unitsActual = $vendResponse->unitsActual;
	$unitName = $vendResponse->unitName;
	$tokenDec = $vendResponse->tokenDec;
	$description = $vendResponse->description;
	include_once("../functions.php");
	$arr_result = submystr_to_array($tokenDec, 4);
	$formatted_token = $arr_result[0]." ".$arr_result[1]." ".$arr_result[2]." ".$arr_result[3]." ".$arr_result[4];
	$estate=$_SESSION['estate_name']; $address= $_SESSION['estate_address']; 
	$amount = $value/0.99;
	
	//add transaction to db
	require('../../db.php'); 
	$query = "INSERT into `transactions` (meter_pan, transaction_id,transaction_date,amount,flat,block,estate,token,units,generated_by) VALUES ('".$meterPAN."', '".$transactionId."','".$vendTime."',$amount,'".$flat."', '".$block."','".$e."','".$formatted_token."',$unitsActual,'External Payment')"; 
	$sql = "UPDATE flats set amount_paid=amount_paid-$amount, last_payment_type='external_vend', last_payment_date='".$vendTime."' WHERE id = $id";
	$result = mysqli_query($con,$sql);
	if($result){
	   $msg2 = "Resident's account deducted successfully."; 
	}
	else{
	   //$msg2 = "Resident's account could not be deducted. Please try manual deduction."; 
	   $msg2 = "Error: ".mysqli_error($con);
	}
	$result = mysqli_query($con,$query);
	//echo "<br><h4>".$sql."<h4>";
	if($result){
	   $msg = "Transaction is valid and added successfully.";
	}
	else{
	   //$msg = "Transaction is valid but could not be added."; 
	   $msg = "Error: ".mysqli_error($con);
	}
}
else{
    // $query = "INSERT into `transactions` (meter_pan, transaction_id,transaction_date,amount,flat,block,estate,token,units,generated_by) VALUES ('".$meterPAN."', '".$transactionId."','".$vendTime."',$amount,'".$flat."', '".$block."','".$e."','Transaction Failed',0,'External Payment')"; 
	$msg = "Error. ".$status;
}
// echo "<h2>".$msg."<h2>"; echo "<br><h4>".$query."<h4>";
// echo "<br><br><button class='btn btn-primary' onclick='history.back()'>Go Back</button>";
$message = '
	<html lang="en">
	  <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta charset="utf-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	    <title>Vend Error</title>
	    <meta
	      name="viewport"
	      content="width=device-width, initial-scale=1"
	    />
	    <!-- html2pdf CDN link -->
	    <script
	      src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
	      integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
	      crossorigin="anonymous"
	      referrerpolicy="no-referrer"
	    ></script>
	    <style>
	      #download-button{
	        border-radius: 10px; margin-top: 20px !important;
	        background-color: green; font-size: 20px; padding: 10px 15px; color: #ffffff; margin: 30px 0px;
	        box-shadow: 0 4px 2px 0 rgba(0,0,0,0.2), 0 1px 10px 0 rgba(0,0,0,0.01);
	      }
	      #back{
	        border-radius: 10px; margin-top: 20px !important;
	        background-color: black; font-size: 20px; padding: 10px 15px; color: #ffffff; margin: 30px 0px;
	        box-shadow: 0 4px 2px 0 rgba(0,0,0,0.2), 0 1px 10px 0 rgba(0,0,0,0.01);
	      }
		  body{
		    padding: 20px; float: center;
		  }
	      div{
	        /*border: solid; padding: 20px; */
	        float: center; overflow-x:auto;
	        width: auto;
	      }
	      #title{
	        /*background-color: green;
	        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); */
	        color: green; padding: 5px 0px; 
	        font-weight: 800;        
	      }
	      img{ margin-bottom: 20px !important; }
	      table{
	        margin-top: 20px;
	        float: center; border: 2px solid;
	      }
	      @media (max-width: 414px) {
	        body{ padding: 10px; }
	      }
	    </style>
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	  </head>
	  <body>
	    <div id="receipt">
	      <img src="../../img/logo.png" alt="HAIVEN" width="200" height="auto"><br>
	      <!--<h2><span id="title">Transaction Added to the System</span></h2>-->
	      <h2>'.$msg.'</h2><br>
	      <h3><em>'.$msg2.'</em></h3>
	    </div>
		<button id="back" class="btn btn-primary" onclick="history.back()">Go Back</button>
	  </body>
	</html>';
echo $message;

?>