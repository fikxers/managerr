<?php

  use PHPMailer\PHPMailer\PHPMailer;

  use PHPMailer\PHPMailer\SMTP;

  use PHPMailer\PHPMailer\Exception;



  require '../PHPMailer/src/Exception.php';

  require '../PHPMailer/src/PHPMailer.php';

  require '../PHPMailer/src/SMTP.php';

  require('../db.php');

  

  function notification($m) {

	  	$msg = ' 

          <html> 

            <head> 

              <title>Cron job completed</title> 

            </head> 

            <body>'.$m.' 

			  <hr><p>Thank you for choosing HAIVEN.</p> 

            </body> 

          </html>'; 

	  	  //Create a new PHPMailer instance

		  $mail = new PHPMailer();

			//Set PHPMailer to use the sendmail transport

			$mail->isSendmail();

			//Set who the message is to be sent from

			$mail->setFrom('support@HAIVEN.net', 'Manager Support');

			//Set an alternative reply-to address

			$mail->addReplyTo('info@HAIVEN.net', 'Manager Support');

			//Set who the message is to be sent to

			$mail->addAddress('support@HAIVEN.net');

			//Set the subject line

			$mail->Subject = 'Cron job completed.';

			$mail->msgHTML($msg);

			//Replace the plain text body with one created manually

			$mail->AltBody = 'Cron job completed.';

			$mail->send();

  }



  $query = "UPDATE dues_old set due_status='Bad' where flat='ypolycarp@yahoo.com'";

  $result = mysqli_query($con,$query); 

  

  

  if($result){

	//echo 'No-shows successfully confirmed.';

	notification('Dear Admin <b><b>No-show successfully implemented!!!');

  }

  else{

	notification('Dear Admin <br><br>Error. No-show could not be implemented.');

  }