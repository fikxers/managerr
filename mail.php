<?php
    /*$to = 'support@managerr.net';
    $fullname = $_POST["fname"];
    $email= $_POST["email"];
    $text= $_POST["message"];
    $phone= $_POST["phone"];
    $subject= $_POST["subject"];

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= "From: " . $email . "\r\n"; // Sender's E-mail
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//<td>'.$firstname.'  '.$laststname.'</td>
    $message ='<table style="width:100%">
        <tr><td>Full name: '.$fullname.'</td></tr>
        <tr><td>Email: '.$email.'</td></tr>
        <tr><td>Phone: '.$phone.'</td></tr>
		<tr><td>Subject: '.$subject.'</td></tr>
        <tr><td>Message: '.$text.'</td></tr>
        
    </table>';

    if (@mail($to, $email, $message, $headers))
    {
        echo "<script>alert('Message sent. We'll contact you shortly.\nManagerr');</script>";
		echo "<script type='text/javascript'>window.top.location='contact.php';</script>"; exit;
    }else{
        echo "<script>alert('Message was not sent. Please try again.');</script>";
		echo "<script type='text/javascript'>window.top.location='contact.php';</script>"; exit;
    }*/

   /*
    if (isset($_POST['email'])){		
		$email = $_REQUEST['email']; 
		$message = $_REQUEST['message'];
		$fullname = $_REQUEST['fullname'];
		$phone= $_POST["phone"];
		$subject= $_POST["subject"];
		$subject2 = 'Copy of your Enquiry, '.$fullname;
		$message2 = 'Thank you '.$fullname.' for contacting us. Below is the copy of your enquiry.\n'.$message;
		$headers = 'From: support@managerr.net';
		$headers2 = 'From: '.$email;
		$email_body = "New Enquiry.\n\n"."Here are the details:\n\nName: $fullname\n\nEmail: $email\n\nSubject: $subject\n\nMessage:\n$message";
		mail('support@managerr.net',$subject,$email_body,$headers2); //to admin
		mail($email,$subject2,$message2,$headers); //to customer
		echo "<script>alert('Thanks for contacting us, we'll get back to you shortly.\nManagerr');</script>";
		echo "<script type='text/javascript'>window.top.location='contact.php';</script>";
    }else{
	   echo "<script type='text/javascript'>window.top.location='contact.php';</script>";
	}

// configure
$from = 'Demo contact form <support@managerr.net>';
$sendTo = 'Demo contact form <support@managerr.net>';
$subject = 'New message from contact form';
$fields = array('fullname' => 'Name', 'subject' => 'Subject', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message'); // array variable name => Text to appear in email
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

// let's do the sending

try
{
    $emailText = "You have new message from contact form\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    mail($sendTo, $subject, $emailText, "From: " . $from);

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
else {
    echo $responseArray['message'];
}*/

?>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$formcontent="From: $name \n Message: $message";
$recipient = "support@managerr.net";
$subject = "Contact Form";
$mailheader = "From: $email \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
//echo "<script>alert('Thanks for contacting us, we'll get back to you shortly.\nManagerr');</script>";
//echo "<script type='text/javascript'>window.top.location='contact.php';</script>";
/*echo
'<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
	  <div class="row">
        <div class="alert alert-success" role="alert">Thanks for contacting us, we will get back to you shortly.</div>
        <a href="index.php" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Home</a>
        <a href="contact.php" class="btn btn-info btn-sm active" role="button" aria-pressed="true">Send another message</a>
	  </div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>';*/
echo '<script language="javascript">';
echo 'alert("Thanks for contacting us, we will get back to you shortly.")';
echo '</script>';
echo "<script type='text/javascript'>window.top.location='contact.php';</script>";
?>