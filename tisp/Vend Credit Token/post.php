<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team
-->
<?php
include 'atl_constants.php';
$transactionId = $_POST["transactionId"]; //"O210220104709";
$value = $_POST["value"];
$meterPAN = $_POST["meterPAN"];
$responseurl = PATH . "/receipt.php";

//pull meter details first to verify meterPAN provided
$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" .$meterPAN);
//$mac = "9ca5d32e07763a488f6f9f21586d784dc8ec006cdf8c4f9db8fc6ef6ba7d02893a3c31e7b8368d377a0d3395e83c5f25082e1ba5ae27f585e72d1b5b3c4df9d6";

$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'"}';
$verifyResponse = apiCall(VERIFY_METER, $data);
$verifyResponse = json_decode($verifyResponse);
if ($verifyResponse->statusCode == "0"){
	echo "METER VERIFICATION \r\n <br>";
	//$meterPAN = $verifyResponse->meterPAN;
	$merchantName = $verifyResponse->merchant;
	//$merchantId = $verifyResponse->merchantId;
	$customerName = $verifyResponse->customerName;
	$description = $verifyResponse->description;
	echo "Customer: ".$customerName;
	echo "<br>Merchant name: ".$description;
	echo "<br>Description: ".$description."<br><br>";
}else{
	die("Unable to pull meter details");
}

$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" . $meterPAN . "|" . $transactionId);
echo $mac."<br>".$transactionId."<br>";

//Going ahead to vend after meter details were pulled
$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'","transactionId":"'. $transactionId .'",'.
			'"value":"' .$value. '"}';

$json_response = apiCall(VEND_CREDIT_TOKEN, $data);
$vendResponse = json_decode($json_response);
$statusCode = $vendResponse->statusCode; //$statusCode = $response->statusCode;
$status = $vendResponse->status; //$status = $response->status;
echo "<br>VEND CREDIT TOKEN<br>";
if ($statusCode == "0"){
	//echo json_encode($vendResponse, JSON_PRETTY_PRINT);
	//$meterPAN = $vendResponse->meterPAN;
	$messageId = $vendResponse->messageId;
	$description = $vendResponse->description;
	$vendTime = $vendResponse->vendTime;
	$tariff = $vendResponse->tariff;
	$unitsActual = $vendResponse->unitsActual;
	$unitName = $vendResponse->unitName;
	$tokenHex = $vendResponse->tokenHex;
	$tokenDec = $vendResponse->tokenDec;

	echo "Your Token is ".$tokenDec;
}
else{
	echo "Error occured: Status = ".$status;
}

//Verify Status
$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" . $meterPAN . "|" . $transactionId);

//Going ahead to vend after meter details were pulled
$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'","transactionId":"'. $transactionId .'",'.
			'"value":"' .$value. '"}';
			
$json_response = apiCall(VERIFY_STATUS, $data);
$vendResponse = json_decode($json_response);
$statusCode = $vendResponse->statusCode; 
$status = $vendResponse->status; 
echo "<br>VERIFY STATUS<br>";
if ($statusCode == "0"){
	echo json_encode($vendResponse, JSON_PRETTY_PRINT);
	//$meterPAN = $vendResponse->meterPAN;
	$messageId = $vendResponse->messageId;
	$idRecord = $vendResponse->idRecord;
	$tariff = $vendResponse->tariff;
	$value = $vendResponse->value;
	$description = $vendResponse->description;
	$vendTime = $vendResponse->vendTime;
	$unitsActual = $vendResponse->unitsActual;
	$unitName = $vendResponse->unitName;
	$tokenHex = $vendResponse->tokenHex;
	$tokenDec = $vendResponse->tokenDec;

	echo "Units: ".$unitsActual." ".$unitName;
	echo "<br>Token Hex: ".$tokenHex;
	echo "<br>Token Dec: ".$tokenDec;
}
else{
	echo "Error occured: Status = ".$status;
}