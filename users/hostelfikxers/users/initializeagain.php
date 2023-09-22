<?php
$curl = curl_init();

$email = $_SESSION['email'];//"ypolycarp@yahoo.com";
$amount = ($_SESSION['price']*100);//30000;  //the amount in kobo. This value is actually NGN 300

// url to go to after payment
//$callback_url = 'https://fikxers.com/users/pay_response.php';  
$callback_url = 'https://fikxers.com/users/callback2.php'; 
//$callback_url = 'myapp.com/pay/callback.php';

//echo "<script>alert('".$callback_url."');</script>";
//echo "<script type='text/javascript'>window.top.location='pay.php';</script>"; exit;

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>50000,
    'email'=>"tolu@test.com",
    //'callback_url' => $callback_url
  ]),
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer sk_test_e31b342c71a1f7993759e29ba115519c05866968", //replace this with your own test key
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response, true);
/*
if(!$tranx->status){
  // there was an error from the API
  print_r('API returned error: ' . $tranx['message']);
}*/
//if($tranx->status != 1){ // there was an error from the API 
if(!$tranx->status === '1'){
  print_r('API returned error: ' . $tranx['message']); }

// comment out this line if you want to redirect the user to the payment page
print_r($tranx);
// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
header('Location: ' . $tranx['data']['authorization_url']);
