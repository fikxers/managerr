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
  
//   $query = "SELECT arr_date FROM `entrance_codes` WHERE status != 'no-show'";
//   $result = mysqli_query($con,$query) or die(mysql_error());
//   $arrival = $result->fetch_object()->arr_date;
  //$atime = date("H:i:sa",strtotime($arrival));
  //$adate = date("YYYY-MM-DD",strtotime($arrival));
  //$nowtime = date('h:i:sa', strtotime("10:00:00 pm"));//date("h:i:sa");  
  //$nowdate = date("Y-m-d");
  date_default_timezone_set('Africa/Lagos');
  $time_check = date('h:i:s',strtotime("10 PM")); $time = date("h:i:s");
  //if ($time >= '22:00:00'){
  //if ( ((int) date('H', $currentTime) ) >= 22) {
  if ($time >= $time_check) {
    //$query = "UPDATE entrance_codes set status='no-show' where  (CURDATE() >= DATE(".$arrival."))  AND (CURTIME() > '22:00:00'))";
    //$query = "select code,status,arr_date from entrance_codes where status='invite' AND arr_date <= CURDATE()";
    $query = "UPDATE entrance_codes set status='no-show' where status='invite' AND DATE(arr_date) <= CURDATE()";
    $result = mysqli_query($con,$query); 
    if($result){
	  //echo 'No-shows successfully confirmed.';
	  notification('Dear Admin <br><br>No-show successfully implemented using date("h:i:s")!!!<br>Update time: '.$time);
    }
    else{
      //echo 'No-shows No-show could not be implemented.';
	  notification('Dear Admin <br><br>Error. No-show could not be implemented date("h:i:s").<br>Update time: '.$time);
    }
  }