<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team

Public Key: ekcg9qRa8CCa8nYzQ4in
Private Key: DiG94rsq4STzroJKqoK5nJdT6NUoYjE7biUO4RdM
Merchant ID: TIS/2105
MeterPAN: 04191738758
-->
<?php
define("PUBLICKEY", "ekcg9qRa8CCa8nYzQ4in"); //define("PUBLICKEY", "rl7SOQynJXB6ushTnM1b");
define("PRIVATEKEY", "DiG94rsq4STzroJKqoK5nJdT6NUoYjE7biUO4RdM"); 
//define("PRIVATEKEY", "JgWGTtHd1T2ebIGI3QJX9dXvTxBFLPiMhlMMNSYG");
define("MERCHANTID", "TIS/2105"); //define("MERCHANTID", "TIS/9999");
define("VEND_CREDIT_TOKEN", "https://vendingdemo.tisdynamicssolutions.com/api/vend/credit-token");
define("VERIFY_METER", "https://vendingdemo.tisdynamicssolutions.com/api/verify/meter");
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