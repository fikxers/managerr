<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team
-->
<?php session_start();
include 'atl_constants.php';
$meterPAN = $_GET["meterPAN"];
$responseurl = PATH . "/receipt.php";

//pull meter details first to verify meterPAN provided
$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" .$meterPAN);

$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '",'.
			'"meterPAN":"' . $meterPAN .'"}';
$verifyResponse = apiCall(VERIFY_METER, $data);
$verifyResponse = json_decode($verifyResponse);
if ($verifyResponse->statusCode == "0"){
	// echo "METER VERIFICATION SUCCESSFUL \r\n <br>";
	//$meterPAN = $verifyResponse->meterPAN;
	$merchantName = $verifyResponse->merchant;
	//$merchantId = $verifyResponse->merchantId;
	$customerName = $verifyResponse->customerName;
	$description = $verifyResponse->description;
	// echo "<br><h2>Customer: ".$customerName;
	// echo "<br>Merchant name: ".$merchantName;
	// echo "<br>Description: ".$description."</h2><br><br>";
	$message = '
	<html lang="en">
	  <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta charset="utf-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	    <title>METER VERIFICATION SUCCESSFUL</title>
	    <meta
	      name="viewport"
	      content="width=device-width, initial-scale=1"
	    />
	    <!-- html2pdf CDN link -->
	    <script
	      src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
	      integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
	      crossorigin="anonymous"
	      referrerpolicy="no-referrer"
	    ></script>
	    <style>
	      #back{
	        border-radius: 10px; margin-top: 20px !important;
	        background-color: black; font-size: 20px; padding: 10px 15px; color: #ffffff; margin: 30px 0px;
	        box-shadow: 0 4px 2px 0 rgba(0,0,0,0.2), 0 1px 10px 0 rgba(0,0,0,0.01);
	      }
		  body{
		    padding: 20px; float: center;
		  }
	      div{
	        /*border: solid; padding: 20px; */
	        float: center; overflow-x:auto;
	        width: auto;
	      }
	      #title{
	        /*background-color: green;
	        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); */
	        color: green; padding: 5px 0px; 
	        font-weight: 800;        
	      }
	      img{ margin-bottom: 20px !important; }
	      table{
	        margin-top: 20px;
	        float: center; border: 2px solid;
	      }
	      @media (max-width: 414px) {
	        body{ padding: 10px; }
	      }
	    </style>
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	  </head>
	  <body>
	    <div id="receipt">
	      <img src="../../img/logo.png" alt="Managerr" width="200" height="auto"><br>
	      <h2><span id="title">METER VERIFICATION SUCCESSFUL</span></h2>
	      <table class="table table-sm table-bordered border-success">
	        <tbody>          
	          <tr> <td><strong>Customer </strong></td><td><strong>'.$customerName.'</strong></td></tr>
	          <tr> <td><strong>Merchant name </strong></td><td><strong>'.$merchantName.'</strong></td></tr>
	          <tr> <td><strong>Description </strong></td><td><strong>'.$description.'</strong></td></tr>
	        </tbody>
	      </table>
	    </div>
		<button id="back" class="btn btn-primary" onclick="history.back()">Go Back</button>
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
	  </body>
	</html>';
	echo $message;	
}else{
	die("<h3>Unable to pull meter details</h3><br><br><button class='btn btn-primary' onclick='history.back()'>Go Back</button>");
}
?>
<!-- <br><br><button class="btn btn-primary" onclick="history.back()">Go Back</button> -->