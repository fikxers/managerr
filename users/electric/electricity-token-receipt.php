<!doctype html>
<?php session_start();
//Email Notification Section
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
require('../../db.php');

$meterPAN=$_SESSION['meterPAN']; $customerName=$_SESSION['customerName']; $description=$_SESSION['description']; 
$value=$_SESSION['value'];$tariff=$_SESSION['tariff']; $formatted_token=$_SESSION['token']; $unitsActual=$_SESSION['unitsActual']; 
$unitName=$_SESSION['unitName']; $generated_by=$_SESSION['generated_by']; $transactionDate=$_SESSION['transactionDate']; 
$transactionId=$_SESSION['transactionId']; $estate=$_SESSION['estate_name'];$address= $_SESSION['estate_address'];

function notification($m) {
	$msg = ' 
        <html> 
            <head> 
              <title>Electricty Token Receipt</title> 
            </head> 
            <body>'.$m.' 
			  
            </body> 
        </html>'; 
	//Create a new PHPMailer instance
	$mail = new PHPMailer();
	//Set PHPMailer to use the sendmail transport
	$mail->isSendmail();
	//Set who the message is to be sent from
	$mail->setFrom('support@managerr.net', 'Manager Support');
	//Set an alternative reply-to address
	$mail->addReplyTo('info@managerr.net', 'Manager Support');
	//Set who the message is to be sent to
	$mail->addAddress($_SESSION['email']);
	//Set the subject line
	$mail->Subject = 'Cron job completed.';
	$mail->msgHTML($msg);
	//Replace the plain text body with one created manually
	$mail->AltBody = 'Cron job completed.';
	$mail->send();
    
}
//Email Notification Section



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
      <h2><span id="title">Electricity Token Receipt</span></h2>
      <table class="table table-sm table-bordered border-success">
        <tbody>
          <!--<tr> <td><strong>Meter PAN: </strong></td><td><strong>012440009222</strong></td></tr>
          <tr> <td><strong>Meter Name: </strong></td><td><strong>Mr Abbimbola Cole</strong></td></tr>
          <tr> <td><strong>Description: </strong></td><td><strong>Pearl Nuga Estate Electricity Token</strong></td></tr>
          <tr> <td><strong>Transaction Charge: </strong></td><td><strong>100</strong></td></tr> 
          <tr> <td><strong>Token Value: </strong></td><td><strong>10, 000</strong></td></tr> 
          <tr> <td><h3><strong>Electricity Token: </strong></h3></td><td><h3>1234 0000 1203 5698</h3></td></tr>
          <tr> <td><strong>Units: </strong></td><td><strong>121 kw</strong></td></tr>
          <tr> <td><strong>Vending by: </strong></td><td><strong>Self</strong></td></tr>
          <tr> <td><strong> Date: </strong></td><td><strong>4-06-2023</strong></td></tr>
          <tr> <td><strong>Ticket no.: </strong></td><td><strong>1213900002kw</strong></td></tr>-->
          
          <tr> <td><strong>Meter PAN: </strong></td><td><strong>'.$meterPAN.'</strong></td></tr>
          <tr> <td><strong>Meter Name: </strong></td><td><strong>'.$customerName.'</strong></td></tr>
          <tr> <td><strong>Description: </strong></td><td><strong>'.$description.'</strong></td></tr> 
          <tr> <td><strong>Address: </strong></td><td><strong>'.$estate.', '.$address.'</strong></td></tr> 
          <tr> <td><strong>Transaction Charge: </strong></td><td><strong>&#8358;'.$tariff.'</strong></td></tr> 
          <tr> <td><strong>Token Value: </strong></td><td><strong>&#8358;'.$value.'</strong></td></tr> 
          <tr> <td><h3><strong>Electricity Token: </strong></h3></td><td><h3>'.$formatted_token.'</h3></td></tr>
          <tr> <td><strong>Units: </strong></td><td><strong>'.$unitsActual.' '.$unitName.'</strong></td></tr>
          <tr> <td><strong>Vending by: </strong></td><td><strong>'.$generated_by.'</strong></td></tr>
          <tr> <td><strong> Date: </strong></td><td><strong>'.$transactionDate.'</strong></td></tr>
          <tr> <td><strong>Ticket no.: </strong></td><td><strong>'.$transactionId.'</strong></td></tr>
        </tbody>
      </table><!--#914c53  &emsp;&emsp;
      <h4>Powered by <a href="https://managerr.net">Managerr</a>  </h4> -->
    </div>
	<button id="download-button">  Download Receipt </button><button id="back">  Back to Dashboard </button>
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
      btn.addEventListener("click", goback);
    </script>
  </body>
</html>';

notification($message);
echo $message;

?>