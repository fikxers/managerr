<?php
//https://dev.to/ijsucceed/how-to-integrate-paystack-payment-system-with-php-5a8m
//https://paystack.com/docs/payments/accept-payments/#redirect
session_start();
$curl = curl_init();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    //"authorization: Bearer sk_test_2d3a8408d19664562d17cd95322b02b3edb886d8",
	"authorization: Bearer sk_live_a90524d08aa8ac2ab0917e43918b5b9c1da33084",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
    // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}

if('success' == $tranx->data->status){
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
  //echo "<h2>Thank you for making a purchase. Your file has bee sent your email.</h2>";
  $ref = $tranx->data->reference;
  include ("../db.php");
  $amount = $_SESSION['amount'];
  //if( ! ini_get('date.timezone') ){ date_default_timezone_set('Africa/Lagos'); }
  date_default_timezone_set('Africa/Lagos'); $trn_date = date("Y-m-d H:i:s");
  $change_bal = "UPDATE flats set amount_paid=amount_paid+$amount, last_payment_date = '".$trn_date."', last_payment_type = 'online' WHERE email = '".$_SESSION['email']."' and estate_code='".$_SESSION['estate']."'";
  $result2 = mysqli_query($con,$change_bal);

  $insertPayment = "INSERT INTO `payments`(`flat`, `block`, `estate`, `amount`, `reference`, `pay_date`, `description`) VALUES ('".$_SESSION['flat_no']."','".$_SESSION['block_no']."','".$_SESSION['estate']."',$amount,'$ref','$trn_date', 'Deposit to Wallet')";
  $result3 = mysqli_query($con,$insertPayment); //$result3 = $con->query($insertPayment);
  
  if($tranx->data->authorization->reusable==TRUE){
  //$insert_payment = "insert into amount_paid=amount_paid+$amount, last_payment_date = '".$trn_date."' WHERE email = '".$_SESSION['email']."'";
  $insertAuthorization = "INSERT INTO `authorization`(`authorization_code`, `card_type`, `last4`, `exp_month`, `exp_year`, `bin`, `bank`, `channel`, `signature`, `reusable`, `country_code`, `account_name`, `email`, `flat`, `block`, `estate`) VALUES ('".$tranx->data->authorization->authorization_code."','".$tranx->data->authorization->card_type."','".$tranx->data->authorization->last4."',".$tranx->data->authorization->exp_month.",".$tranx->data->authorization->exp_year.",'".$tranx->data->authorization->bin."', '".$tranx->data->authorization->bank."','".$tranx->data->authorization->channel."','".$tranx->data->authorization->signature."',".$tranx->data->authorization->reusable.",'".$tranx->data->authorization->country_code."','".$tranx->data->authorization->account_name."','".$_SESSION['email']."','".$_SESSION['flat_no']."','".$_SESSION['block_no']."','".$_SESSION['estate']."')";
  $result2 = mysqli_query($con,$insertAuthorization);
  }
  echo "<script>alert('Thank you. Your receipt has been sent to your email.');</script>";
  echo "<script type='text/javascript'>window.top.location='flat.php';</script>"; 
}
else{
	echo '<div class="alert alert-danger" role="alert">Transaction was unsuccessful!</div>';
	echo "<script type='text/javascript'>window.top.location='pay.php';</script>";
    //echo "Transaction was unsuccessful";
}