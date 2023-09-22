<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team
-->
<?php session_start();
include 'atl_constants.php';
$transactionId = $_POST["transactionId"]; $value = $_POST["value"]; $meterPAN = $_POST["meterPAN"];
//$transactionId = $_GET["transactionId"]; $value = $_GET["value"]; $meterPAN = $_GET["meterPAN"];
if( ! ini_get('date.timezone') ){date_default_timezone_set('Africa/Lagos');}
$transactionDate = date("Y-m-d H:i:s");
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
	echo "Customer: ".$customerName;
	echo "<br>Merchant name: ".$description;
	echo "<br>Description: ".$description."<br><br>";
}else{
	die("Unable to pull meter details");
}

$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" . $meterPAN . "|" . $transactionId);
//echo $mac."<br>".$transactionId."<br>";

//Going ahead to vend after meter details were pulled
$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'","transactionId":"'. $transactionId .'",'.
			'"value":"' .$value. '"}';

$json_response = apiCall(VEND_CREDIT_TOKEN, $data);
$vendResponse = json_decode($json_response);
//$statusCode = $vendResponse->statusCode; 
$status = $vendResponse->status; 
echo "<br>VEND CREDIT TOKEN<br>";
if ($vendResponse->statusCode == "0"){
	$tokenDec = $vendResponse->vendingData->tokenDec; $unitsActual = $vendResponse->vendingData->unitsActual;
	$description = $vendResponse->vendingData->description; $vendTime = $vendResponse->vendingData->vendTime;
	$tariff = $vendResponse->vendingData->tariff; $unitName = $vendResponse->vendingData->unitName; 
	require('../../db.php'); $f = $_SESSION['flat_no'];$b = $_SESSION['block_no']; $e=$_SESSION['estate'];
	$query = "INSERT into `transactions` (meter_pan, transaction_id,transaction_date,amount,flat,block,estate,token,units) VALUES ('".$meterPAN."', '".$transactionId."','".$transactionDate."',$value,$f, $b,'".$e."','".$tokenDec."',$unitsActual)";
	$result = mysqli_query($con,$query);
	if($result){
		//echo "<script>alert('Your Token is ".$tokenDec."');</script>";
		//echo "<script type='text/javascript'>window.top.location='../electric-bill.php';</script>"; exit;
		//echo json_encode($vendResponse, JSON_PRETTY_PRINT);
		//echo "<br>Token is ".$tokenDec;
		$_SESSION['meterPAN'] = $meterPAN; $_SESSION['description'] = $description; $_SESSION['value'] = $value;
		$_SESSION['tariff'] = $tariff; $_SESSION['token'] = $formatted_token; $_SESSION['unitsActual'] = $unitsActual;
		$_SESSION['unitName'] = $unitName; $_SESSION['generated_by'] = 'FM'; $_SESSION['transactionDate'] = $transactionDate; $_SESSION['transactionId'] = $transactionId;
		echo "<script type='text/javascript'>window.top.location='electricity-token-receipt.php';</script>"; exit;
	}
	else{
		echo "Error: ".mysqli_error($con);
		echo "<br>". $query;
		//echo "<script>alert('Error: ".mysqli_error($con)."');</script>";
		//echo "<script type='text/javascript'>window.top.location='../electric-bill.php';</script>"; exit;
	}
	/*echo json_encode($vendResponse, JSON_PRETTY_PRINT);
	//$meterPAN = $vendResponse->meterPAN;
	$messageId = $vendResponse->messageId;
	$description = $vendResponse->description;
	$vendTime = $vendResponse->vendTime;
	$tariff = $vendResponse->tariff;
	$unitsActual = $vendResponse->unitsActual;
	$unitName = $vendResponse->unitName;
	$tokenHex = $vendResponse->tokenHex;
	$tokenDec = $vendResponse->tokenDec;*/

	//echo "Your Token is ".$tokenDec;
	//echo "Your Token is $tokenDec";
}
else{
	echo "Error occured: Status = ".$status;
}

?>
<br><br><button class="btn btn-primary" onclick="history.back()">Go Back</button>