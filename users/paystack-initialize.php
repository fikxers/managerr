<?php
include('auth.php'); //session_start();
$curl = curl_init();

//$email = "your@email.com";
//$amount = 30000;  //the amount in kobo. This value is actually NGN 300

$email = $_SESSION['email'];
$amount = ($_SESSION['amount']*100);
$split_code = $_SESSION['split_code']; //"ACCT_y4m98c3sihmvtxh";
if($split_code == NULL || $split_code == "" || $split_code == " "){ $split_code = "ACCT_zojwl8jr1974ctr"; }

//echo "Split: ".$split_code;
// echo "<script>alert('Split: ".$split_code."');</script>";
// header("Location: " . $_SERVER["HTTP_REFERER"]);
//echo "<script type='text/javascript'>window.top.location='recover_password.php';</script>";

// url to go to after payment
$callback_url = 'https://managerr.net/users/paystack-callback.php';  
//$callback_url = 'http://localhost/Managerr.com/users/paystack-callback.php'; 

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'email'=>$email,
	'subaccount' => $split_code, //"ACCT_zojwl8jr1974ctr",
    //'split_code' => $split_code, //"ACCT_zojwl8jr1974ctr",
	//'purpose'=>$_SESSION['purpose'],
	'phone' => $_SESSION['phone'], //new additional details
	'full_name' => $_SESSION['owner'], //new additional details
    'callback_url' => $callback_url
  ]),
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer sk_live_a90524d08aa8ac2ab0917e43918b5b9c1da33084",
    //"authorization: Bearer sk_test_2d3a8408d19664562d17cd95322b02b3edb886d8", 
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

if(!$tranx['status']){
  // there was an error from the API
  print_r('API returned error: ' . $tranx['message']);
}

// comment out this line if you want to redirect the user to the payment page
print_r($tranx);
// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
header('Location: ' . $tranx['data']['authorization_url']);