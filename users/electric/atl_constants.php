<?php

/**
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team

Public Key: ekcg9qRa8CCa8nYzQ4in
Private Key: DiG94rsq4STzroJKqoK5nJdT6NUoYjE7biUO4RdM
Merchant ID: TIS/2105
MeterPAN: 04191738758

LIVE KEYS
Public Key - pz0LREeqH35Z9bj7MI3j
Private Key - mB9cMU8SEMr3hRZ9NM8Qyr4Luxsrffv4TpEg1WiQ
Merchant ID  - TIS/0001

Verify Meter Post URL: https://vending.tisdynamicssolutions.com/api/verify/meter
Vend Credit Token Post URL: Verify Meter Post URL: https://vending.tisdynamicssolutions.com/api/vend/credit-token
Verify Token Transaction Status Post URL: https://vending.tisdynamicssolutions.com/api/verify/status
**/
define("PUBLICKEY", "pz0LREeqH35Z9bj7MI3j"); 
define("PRIVATEKEY", "mB9cMU8SEMr3hRZ9NM8Qyr4Luxsrffv4TpEg1WiQ"); 
define("MERCHANTID", "TIS/0001"); 
/*define("VEND_CREDIT_TOKEN", "https://vendingdemo.tisdynamicssolutions.com/api/vend/credit-token");
define("VERIFY_METER", "https://vendingdemo.tisdynamicssolutions.com/api/verify/meter");
define("VERIFY_STATUS", "https://vendingdemo.tisdynamicssolutions.com/api/verify/status");*/
define("VEND_CREDIT_TOKEN", "https://vending.tisdynamicssolutions.com/api/vend/credit-token");
define("VERIFY_METER", "https://vending.tisdynamicssolutions.com/api/verify/meter");
define("VERIFY_STATUS", "https://vending.tisdynamicssolutions.com/api/verify/status");
define("PATH", 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));

function apiCall($url, $data){
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER,
			array("Content-type: application/json"));
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$json_response = curl_exec($curl);

	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	if ( $status != 200 ) {
		die($json_response);
	}

	return $json_response;
}
?>