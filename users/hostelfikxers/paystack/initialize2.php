<?php

$result = array();
//Set other parameters as keys in the $postdata array
$postdata =  array('email' => 'customer@email.com','callback_url' => 'https://gasciti.com/paystack/callback2.php', 'amount' => 500000,"reference" => '7PVGX8MEk85tgeEpVDtD');
$url = "https://api.paystack.co/transaction/initialize";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
  'Authorization: Bearer sk_test_e31b342c71a1f7993759e29ba115519c05866968',
  'Content-Type: application/json',

];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$request = curl_exec ($ch);

curl_close ($ch);

if ($request) {
  $result = json_decode($request, true);
}
//Use the $result array to get redirect URL