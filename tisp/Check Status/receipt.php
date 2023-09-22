<!--
@company - IMR
@product - IMR Payment Web Service
@author - Software Dev Team
-->
<?php
require 'imr_constants.php';
$orderID = "";
if( isset( $_REQUEST['orderID'] )) {
	$orderID = $_REQUEST["orderID"];
}
$response_code ="";
$rrr = "";
$response_message = "";
echo "OrderID =$orderID";

//Verify Transaction
function getTransactionStatus($orderID){
		$mac = hash('sha512', APISALT . "|" . APIKEY . "|" .CLIENTCODE);
		$data = '{"apiKey":"' . APIKEY . '", "clientCode":"' . CLIENTCODE . '", "mac":"' . $mac . '", "orderId":"'. $orderID. '"}';

		$curl = curl_init(CHECKSTATUSURL);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
				array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$json_response = curl_exec($curl);

		return json_decode($json_response, true);
}
if($orderID !=null){
	$response = getTransactionStatus($orderID);
	$response_code = $response['statusCode'];
	if (isset($response['rrr']))
		{
			$rrr = $response['rrr'];
		}
	$response_message = $response['statusMessage'];
}
?>
<html>
<head>
<title></title>
</head>
<body>
	<div style="text-align: center;">
		<?php if($response_code == '01' || $response_code == '00') { ?>
		<h2>Transaction Successful</h2>
		<p><b>Remita Retrieval Reference: </b><?php echo $rrr; ?><p>
		<?php }else if($response_code == '021') { ?>
						<h2>RRR Generated Successfully</h2>
						<p><b>Remita Retrieval Reference: </b><?php echo $rrr; ?><p>
		<?php }	else{ ?>
						<h2>Your Transaction was not Successful</h2>
						<?php if ($rrr !=null){ ?>
						 <p>Your Remita Retrieval Reference is <span><b><?php echo $rrr; ?></b></span><br />
						<?php } ?>
						  <p><b>Reason: </b><?php echo $response_message; ?><p>
		 <?php }?>
	</div>
</body>
</html>