<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team
-->
<?php session_start();

$value = $_POST["value"];
$maxMonthlyPayment = $_POST["estate_max_electric"];
$electric_this_month = $_POST["electric_this_month"];
$last_electricity_payment = $_POST["last_electricity_payment"];
//echo $maxMonthlyPayment."<br>".$last_electricity_payment."<br>".$electric_this_month;
//CHECK MONTHLY MAX ELECTRICITY
include '../functions.php';
//MAX MONTHLY ELECTRIC PAYMENT FOR RESIDENTS
 
$check = check_electric_max($value, $maxMonthlyPayment, $electric_this_month, $last_electricity_payment);
if($check > 0){
	// echo 'Good Standing. You can vend: '.$check.' <br>'; require('../../db.php');
	// $query = "UPDATE flats set electric_this_month = electric_this_month + ".$check." WHERE estate_code='".$_SESSION['estate']."' AND flat_no='".$_SESSION['flat_no']."' AND block_no='".$_SESSION['block_no']."'";
	// $result2 = mysqli_query($con,$query); 

include 'atl_constants.php';
$transactionId = $_POST["transactionId"];
$meterPAN = $_POST["meterPAN"];
$generated_by = $_POST["generated_by"];
//$transactionDate = $_POST["transactionDate"];
//if( ! ini_get('date.timezone') ){date_default_timezone_set('Africa/Lagos');}
date_default_timezone_set('Africa/Lagos'); $transactionDate = date("Y-m-d H:i:s");
$responseurl = PATH . "/receipt.php";

//pull meter details first to verify meterPAN provided
$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" .$meterPAN);

$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'"}';
$verifyResponse = apiCall(VERIFY_METER, $data);
$verifyResponse = json_decode($verifyResponse);
if ($verifyResponse->statusCode == "0"){
	echo "METER VERIFICATION \r\n <br>";
	//$meterPAN = $verifyResponse->meterPAN;
	$merchantName = $verifyResponse->merchant;
	//$merchantId = $verifyResponse->merchantId;
	$customerName = $verifyResponse->customerName; $_SESSION['customerName'] = $customerName;
	$description = $verifyResponse->description;
	echo "<h2>Customer: ".$customerName;
	echo "<br>Merchant name: ".$description;
	echo "<br>Description: ".$description."</h2><br><br>";
}else{
	//echo "<h2>Unable to pull meter details</h2>";
	die("<h2>Unable to pull meter details</h2><br><br><button class='btn btn-primary' onclick='history.back()'>Go Back</button>");
}

$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" . $meterPAN . "|" . $transactionId);
//echo $mac."<br>".$transactionId."<br>".$value."<br>";

//Going ahead to vend after meter details were pulled
/*$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'","transactionId":"'. $transactionId .'",'.
			'"value":"' .$value. '"}';*/
$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'","transactionId":"'. $transactionId .'",'.
			'"value":' .$value. '}';

$json_response = apiCall(VEND_CREDIT_TOKEN, $data);
$vendResponse = json_decode($json_response);
//$statusCode = $vendResponse->statusCode; 
$status = $vendResponse->status; 
echo "<br>VEND CREDIT TOKEN<br>";
if ($vendResponse->statusCode == "0"){
	$tokenDec = $vendResponse->vendingData->tokenDec; $unitsActual = $vendResponse->vendingData->unitsActual;
	$description = $vendResponse->vendingData->description; $vendTime = $vendResponse->vendingData->vendTime;
	$tariff = $vendResponse->vendingData->tariff; $unitName = $vendResponse->vendingData->unitName;
	include('../functions.php');
	$arr_result = submystr_to_array($tokenDec, 4);
	$formatted_token = $arr_result[0]." ".$arr_result[1]." ".$arr_result[2]." ".$arr_result[3]." ".$arr_result[4];
	require('../../db.php'); $f = $_SESSION['flat_no'];$b = $_SESSION['block_no']; $e=$_SESSION['estate'];
	$query = "INSERT into `transactions` (meter_pan, transaction_id,transaction_date,amount,flat,block,estate,token,units,generated_by) VALUES ('".$meterPAN."', '".$transactionId."','".$transactionDate."',$value,'".$f."', '".$b."','".$e."','".$formatted_token."',$unitsActual,'".$generated_by."')";
	$result = mysqli_query($con,$query);
	if($result){
		//echo "<script>alert('Your Token is ".$tokenDec."');</script>";
		//echo "<script type='text/javascript'>window.top.location='../electric-bill.php';</script>"; exit;
		//echo json_encode($vendResponse, JSON_PRETTY_PRINT);	
		$change_bal = "UPDATE flats set amount_paid=amount_paid-$value WHERE id=".$_SESSION['id']; $result = mysqli_query($con,$change_bal); 
		//echo "<br><h2>Your Token is ".$formatted_token."</h2>";
		//include ("electricity-token-receipt.php");
		$_SESSION['meterPAN'] = $meterPAN; $_SESSION['description'] = $description; $_SESSION['value'] = $value;
		$_SESSION['tariff'] = $tariff; $_SESSION['token'] = $formatted_token; $_SESSION['unitsActual'] = $unitsActual;
		$_SESSION['unitName'] = $unitName; $_SESSION['generated_by'] = $generated_by; $_SESSION['transactionDate'] = $transactionDate; $_SESSION['transactionId'] = $transactionId;
		echo "<script type='text/javascript'>window.top.location='electricity-token-receipt.php';</script>"; exit;
	}
	else{
		echo "<h2>Error: ".mysqli_error($con);
		echo "<br>". $query."</h2>";
		//echo "<script>alert('Error: ".mysqli_error($con)."');</script>";
		//echo "<script type='text/javascript'>window.top.location='../electric-bill.php';</script>"; exit;
	}
	/*echo json_encode($vendResponse, JSON_PRETTY_PRINT);
	//$meterPAN = $vendResponse->meterPAN;
	$messageId = $vendResponse->messageId;
	$unitsActual = $vendResponse->unitsActual;
	
	$tokenHex = $vendResponse->tokenHex;
	$tokenDec = $vendResponse->tokenDec;*/

	//echo "Your Token is ".$tokenDec;
	//echo "Your Token is $tokenDec";
}
else{
	echo "<h2>Error occured: Status = ".$status."</h2>";
}

} //close big if
else{
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
	      <img src="../../img/logo.png" alt="Managerr" width="200" height="auto"><br>
	      <h2><span id="title">Vend Error</span></h2>
	      <h5 class="text-danger">You cannot vend more than &#8358;'.number_format($maxMonthlyPayment, 2, '.', ',').' in a month!</h5>
	      <h5 class="text-success">This month: &#8358;'.number_format($electric_this_month, 2, '.', ',').'.</h5>
	      
	    </div>
		<button id="back" class="btn btn-primary" onclick="history.back()">Go Back</button>
	  </body>
	</html>';
	echo $message;
}


?>
<!-- <br><br><button class="btn btn-primary" onclick="history.back()">Go Back</button> -->