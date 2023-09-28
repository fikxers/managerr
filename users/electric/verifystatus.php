<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team
-->
<?php session_start();
include 'atl_constants.php';
$transactionId = $_GET["transactionId"];
$responseurl = PATH . "/receipt.php";

$mac = hash('sha512', PRIVATEKEY . "|" . PUBLICKEY . "|" . $transactionId);

//Going ahead to vend after meter details were pulled
$data = '{"publicKey":"' .PUBLICKEY. '","merchantId":"'.MERCHANTID.'","mac":"' .$mac. '","transactionId":"'. $transactionId .'"}';

$json_response = apiCall(VERIFY_STATUS, $data);
$vendResponse = json_decode($json_response);
//$statusCode = $vendResponse->statusCode; 
$status = $vendResponse->status; 
// echo "<br>TOKEN TRANSACTION STATUS<br>";
if ($vendResponse->statusCode == "0"){
	//$tokenDec = $vendResponse->vendingData->tokenDec; $unitsActual = $vendResponse->vendingData->unitsActual;
	//echo json_encode($vendResponse, JSON_PRETTY_PRINT)
	$meterPAN = $vendResponse->meterPAN;
	$value = $vendResponse->value;
	$vendTime = $vendResponse->vendTime;
	$tariff = $vendResponse->tariff;
	$unitsActual = $vendResponse->unitsActual;
	$unitName = $vendResponse->unitName;
	$tokenDec = $vendResponse->tokenDec;
	$description = $vendResponse->description;
	include_once("../functions.php");
	$arr_result = submystr_to_array($tokenDec, 4);
	$formatted_token = $arr_result[0]." ".$arr_result[1]." ".$arr_result[2]." ".$arr_result[3]." ".$arr_result[4];
	$estate=$_SESSION['estate_name']; $address= $_SESSION['estate_address']; $customerName = $_GET['owner'];
	$message = '
	<html lang="en">
	  <head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta charset="utf-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	    <title>Electricity Token Receipt</title>
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
	      #download-button{
	        border-radius: 10px; margin-top: 20px !important;
	        background-color: green; font-size: 20px; padding: 10px 15px; color: #ffffff; margin: 30px 0px;
	        box-shadow: 0 4px 2px 0 rgba(0,0,0,0.2), 0 1px 10px 0 rgba(0,0,0,0.01);
	      }
	      #back{
	        border-radius: 10px; margin-top: 20px !important;
	        background-color: black; font-size: 20px; padding: 10px 15px; color: #ffffff; margin: 30px 10px;
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
	      <h2><span id="title">TOKEN TRANSACTION STATUS</span></h2>
	      <table class="table table-sm table-bordered border-success">
	        <tbody>          
	          <tr> <td><strong>Meter PAN </strong></td><td><strong>'.$meterPAN.'</strong></td></tr>
	          <tr> <td><strong>Meter Name </strong></td><td><strong>'.$customerName.'</strong></td></tr>
	          <tr> <td><strong>Address </strong></td><td><strong>'.$estate.', '.$address.'</strong></td></tr>
	          <tr> <td><strong>Amount </strong></td><td><strong>&#8358;'.$value.'</strong></td></tr>
	          <tr> <td><strong>Vend Time </strong></td><td><strong>'.$vendTime.'</strong></td></tr> 
	          <tr> <td><strong>Units </strong></td><td><strong>'.$unitsActual.'</strong></td></tr> 
	          <tr> <td><h3><strong>Electricity Token </h3></td><td><h3>'.$formatted_token.'</strong></h3></td></tr>
	          <tr> <td><strong>Description </strong></td><td><strong>'.$description.'</strong></td></tr>
	          <tr> <td><strong> Vend Time </strong></td><td><strong>'.$vendTime.'</strong></td></tr>
	          <tr> <td><strong> Status </strong></td><td><strong>'.$status.'</strong></td></tr>
	        </tbody>
	      </table>
	    </div>
		<button id="download-button">  Download Receipt </button>
		<button id="back" class="btn btn-primary" onclick="history.back()">Go Back</button>
		<!--<button id="back">  Back to Dashboard </button>-->
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
	    <script>
	      const button = document.getElementById("download-button");
	      const btn = document.getElementById("back"); 
	      function generatePDF() {
	        // Choose the element that your content will be rendered to.
	        var element = document.getElementById("receipt");
	        element.style.width = "100%";
	        element.style.height = "100%";
	        var opt = {
	          margin:       1,
	          filename:     "electricity-token-receipt.pdf",
	          image:        { type: "jpeg", quality: 0.98 },
	          html2canvas:  { scale: 2 },
	          jsPDF:        { unit: "in", format: "a4", orientation: "portrait" }
	        };
	        // Avoid page-breaks on all elements, and add one before #page2el.
	        html2pdf().set({
	          pagebreak: { mode: "avoid-all" }
	        });
	        // Choose the element and save the PDF for your user.
	        //html2pdf().from(element).save();
	        html2pdf().set(opt).from(element).save();
	      }
	      button.addEventListener("click", generatePDF);    
	      function goback() {
	        window.location.replace("../electric-bill.php");
	      }
	      //btn.addEventListener("click", goback);
	    </script>
	  </body>
	</html>';
	echo $message;
	
	// echo "<h2>Meter PAN: ".$meterPAN;
	// echo "<br>Amount: ".$value;
	// echo "<br>Vend Time: ".$vendTime;
	// echo "<br>Units: ".$unitsActual;
	// echo "<br>Token: <b>".$tokenDec."</b>";
	// echo "<br>Description: ".$description;
	// echo "<br>Vend Time: ".$vendTime."</h2><br><br>";
}
else{
	echo "<h2>Error occured: Status = ".$status."<h2>";
	echo "<br><br><button class='btn btn-primary' onclick='history.back()'>Go Back</button>";
}

?>