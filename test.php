<?php
  // include ('db.php');
  // $query = "UPDATE entrance_codes set status='invite'";
  // $result2 = mysqli_query($con,$query); 
  // if($result2){
	// echo "<script>alert('Successfully.');</script>";
	// //echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
  // }
  // else{
	// echo "<script>alert('Error: ".mysql_error($con)."');</script>";
	// //echo "<script type='text/javascript'>window.top.location='invites.php';</script>"; exit;
  // }


/**
 * This example shows how to handle a simple contact form safely.
 */

//Import PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/**
 * This example shows sending a message using a local sendmail binary.
 */
$msg = ' 
          <html> 
          <head> 
              <title>Password Reset</title> 
          </head> 
          <body> 
              <p>Hello,</p> <br>
              <p>Please use this temporary password to login: <b>'.$token.'</b></p>
              <h3>Ensure you create a new password after login!</h3>
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
$mail->addAddress('ypolycarp@gmail.com', 'John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer sendmail test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($msg);//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}

// $msg = '';
// //Don't run this unless we're handling a form submission
// if (array_key_exists('email', $_POST)) {
//     date_default_timezone_set('Etc/UTC');

//     //require '../vendor/autoload.php';

//     //Create a new PHPMailer instance
//     $mail = new PHPMailer();
//     //Send using SMTP to localhost (faster and safer than using mail()) – requires a local mail server
//     //See other examples for how to use a remote server such as gmail
//     $mail->isSMTP();
//     $mail->Host = 'localhost';
//     $mail->Port = 25;

//     //Use a fixed address in your own domain as the from address
//     //**DO NOT** use the submitter's address here as it will be forgery
//     //and will cause your messages to fail SPF checks
//     $mail->setFrom('support@managerr.net', 'Managerr Support');
//     //Choose who the message should be sent to
//     //You don't have to use a <select> like in this example, you can simply use a fixed address
//     //the important thing is *not* to trust an email address submitted from the form directly,
//     //as an attacker can substitute their own and try to use your form to send spam
//     $addresses = [
//         'sales' => 'info@managerr.net',
//         'support' => 'support@managerr.net',
//         //'accounts' => 'accounts@example.com',
//     ];
//     //Validate address selection before trying to use it
//     if (array_key_exists('dept', $_POST) && array_key_exists($_POST['dept'], $addresses)) {
//         $mail->addAddress($addresses[$_POST['dept']]);
//     } else {
//         //Fall back to a fixed address if dept selection is invalid or missing
//         $mail->addAddress('info@managerr.net');
//     }
//     //Put the submitter's address in a reply-to header
//     //This will fail if the address provided is invalid,
//     //in which case we should ignore the whole request
//     if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
//         $mail->Subject = 'PHPMailer contact form';
//         //Keep it simple - don't use HTML
//         $mail->isHTML(false);
//         //Build a simple message body
//         $mail->Body = <<<EOT
// Email: {$_POST['email']}
// Name: {$_POST['name']}
// Message: {$_POST['message']}
// EOT;
//         //Send the message, check for errors
//         if (!$mail->send()) {
//             //The reason for failing to send will be in $mail->ErrorInfo
//             //but it's unsafe to display errors directly to users - process the error, log it on your server.
//             $msg = 'Sorry, something went wrong. Please try again later: '.$mail->ErrorInfo;
//         } else {
//             $msg = 'Message sent! Thanks for contacting us.';
//         }
//     } else {
//         $msg = 'Invalid email address, message ignored.';
//     }
// }
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact form</title>
</head>
<body>
<h1>Contact us</h1>
<?php if (!empty($msg)) {
    echo "<h2>$msg</h2>";
} ?>
<form method="POST">
    <label for="name">Name: <input type="text" name="name" id="name"></label><br>
    <label for="email">Email address: <input type="email" name="email" id="email"></label><br>
    <label for="message">Message: <textarea name="message" id="message" rows="8" cols="20"></textarea></label><br>
    <label for="dept">Send query to department:</label>
    <select name="dept" id="dept">
        <option value="sales">Sales</option>
        <option value="support" selected>Technical support</option>
        <option value="accounts">Accounts</option>
    </select><br>
    <input type="submit" value="Send">
</form>
</body>
</html> -->