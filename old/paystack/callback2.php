<?php
$result = array();
//The parameter after verify/ is the transaction reference to be verified
//$url = 'https://api.paystack.co/transaction/verify/7PVGX8MEk85tgeEpVDtD';

/*****************************demo********************************/
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
$url = 'https://api.paystack.co/transaction/verify/'.$reference;
/*****************************demo********************************/

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
  $ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer sk_test_e31b342c71a1f7993759e29ba115519c05866968']
);
$request = curl_exec($ch);
if(curl_error($ch)){
 echo 'error:' . curl_error($ch);
 }
curl_close($ch);

if ($request) {
  $result = json_decode($request, true);
}

if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
  echo '<div class="alert alert-success" role="alert">Payment was successful! We will contact you shortly.</div>';
  //echo "Transaction was successful";
	//Perform necessary action
    if( ! ini_get('date.timezone') ){ date_default_timezone_set('Africa/Lagos'); }
	$trn_date = date("Y-m-d H:i:s");
	$user_name = $_SESSION['user_name'];$user_phone = $_SESSION['phone'];
	$user_id = $_SESSION['user_id'];$address = $_SESSION['address']; $price = $_SESSION['price'];
	//STEP 1
	$insertOrder = "INSERT INTO `orders`(`user_name`, `user_phone`,`user_id`, `order_date`, `price`, `location`, `payment_type`, `order_status`) VALUES ('$user_name','$user_phone',$user_id,'$trn_date',$price,'$address','online','paid')";
	$result = mysqli_query($con,$insertOrder);// or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error(), E_USER_ERROR
	//STEP 2
	$getCurrentOrderID = "SELECT COUNT(*) AS cnt FROM orders"; 							
	$result2 = $con->query($getCurrentOrderID);
	$values = mysqli_fetch_assoc($result2); 
	$current_order = $values['cnt'];  //current order 
	foreach ($_SESSION["cart_item"] as $item){
	  $item_price = $item["quantity"]*$item["price"];
	  $item_name = $item["name"];//$item["id"] $item["code"];
	  $qty = $item["quantity"];
	  $insertOrderItem = "INSERT INTO `ordered_item`(`order_id`, `product_name`, `item_price`, `quantity`) VALUES ($current_order ,'$item_name',$item_price,$qty)";
	  $result3 = $con->query($insertOrderItem);
	}
	//STEP 3
	$insertPayment = "INSERT INTO `payment`(`order_id`, `payment_status`, `payment_response`, `created_at`) VALUES ($current_order,'successful','successful','$trn_date')";
	$result3 = $con->query($insertPayment);
}else{
	echo '<div class="alert alert-danger" role="alert">Transaction was unsuccessful!</div>';
	echo '<div class="alert alert-warning" role="alert"><a href="https://gasciti.com/checkout.php">Click to Try Again</a>!</div>';
  //echo "Transaction was unsuccessful";
}