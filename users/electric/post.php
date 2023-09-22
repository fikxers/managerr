<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team
-->
<?php
include 'atl_constants.php';
$transactionId = $_POST["transactionId"];
$value = $_POST["value"];
$meterPAN = $_POST["meterPAN"];
$responseurl = PATH . "/receipt.php";

//pull meter details first to verify meterPAN provided
$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" . $meterPAN);

$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'"}';
$verifyResponse = apiCall(VERIFY_METER, $data);
$verifyResponse = json_decode($verifyResponse);
if ($verifyResponse->statusCode == "0"){
	//$meterPAN = $verifyResponse->meterPAN;
	$merchantName = $verifyResponse->merchant;
	//$merchantId = $verifyResponse->merchantId;
	$customerName = $verifyResponse->name;
	description = $verifyResponse->description;
}else{
	die("Unable to pull meter details");
}

$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" . $meterPAN . "|" . $transactionId);

//Going ahead to vend after meter details were pulled
$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'","transactionId":"'. $transactionId .'",'.
			'"value":"' .$value. '"}';


$json_response = apiCall(VEND_CREDIT_TOKEN, $data);
$vendResponse = json_decode($json_response);
$statusCode = $response->statusCode;
if ($statusCode == "0"){
	//$meterPAN = $vendResponse->meterPAN;
	$messageId = $vendResponse->messageId;
	$description = $vendResponse->description;
	$vendTime = $vendResponse->vendTime;
	$tariff = $vendResponse->tariff;
	$unitsActual = $vendResponse->unitsActual;
	$unitName = $vendResponse->unitName;
	$tokenHex = $vendResponse->tokenHex;
	$tokenDec = $vendResponse->tokenDec;

	echo "Your Token is $tokenDec";
}
