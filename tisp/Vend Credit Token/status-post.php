<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team
-->
<?php
include 'atl_constants.php';
$transactionId = $_POST["transactionId"]; //"O210220104709";
$meterPAN = $_POST["meterPAN"];
$responseurl = PATH . "/receipt.php";


//Verify Status
$mac = "975ea68bcd90d420a7d0fadbff5defe2e2d6d9efe86b32b0a322827ff94d2997138fb6202b5e193cac0169281d0ea9e66d5c1a3d88502dd4fb7f1fe80217d82a";
$publicKey = "mEzPoePWld78BJQcZdyQ";
$merchantId = "TIS/0001";
$transactionId = "O210220104741";
//Going ahead to vend after meter details were pulled
$data = '{"publicKey":"' .$publicKey. '","merchantId":"'.$merchantId.'","mac":"' .$mac. '",'.
			'"transactionId":"'. $transactionId .'"}';
//$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.'"meterPAN":"' . $meterPAN .'","transactionId":"'. $transactionId .'"}';
			
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