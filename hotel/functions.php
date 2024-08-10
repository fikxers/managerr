<?php 
//ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
function notify_admins($service,$service_date,$moreinfo,$equipment,$room,$hostel){
  require('../db.php');
  $sql = "SELECT email FROM hostel_manager where hostel = '".$hostel."'"; 

  $message = '<html><body>';
  $message .= '<img src="//fikxers.com/hostel/assets/images/users/DEX.png" alt="Kanchies Logo" />';
  $message .= '<h2>BOOKING REQUEST FROM ROOM '.$room.'</h2>';
  $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
  $message .= "<tr style='background: #eee;'><td><strong>Service:</strong> </td><td>".$service."</td></tr>";
  $message .= "<tr><td><strong>Service Date:</strong> </td><td>".$service_date."</td></tr>";
  $message .= "<tr><td><strong>Asset:</strong> </td><td>".$equipment."</td></tr>";
  $message .= "<tr><td><strong>More Info:</strong> </td><td>".$moreinfo."</td></tr>";
  $message .= "</table>";
  $message .= "</body></html>";
  echo $message;
  $result = $con->query($sql);
  while($row = $result->fetch_assoc()) {
    notify_admin($row['email'], $message, "Service Booking Request");
   // notify_admin("ypolycarp@gmail.com", $msg);
  }
}
function after_resident_reg($email,$password,$full_name){
  $message = '<html><body>';
  $message .= 'Dear '.$full_name.',<br>You have been added as a resident in Kanchies Hostels Uyo.<br>';
  $message .= '<img src="fikxers.com/hostel/assets/images/users/DEX.png" alt="Kanchies Logo" />';
  $message .= '<h2>YOUR LOGIN DETAILS</h2>';
  $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
  $message .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>".$email."</td></tr>";
  $message .= "<tr><td><strong>Password:</strong> </td><td>".$password."</td></tr>";
  $message .= "<tr><td><strong>Login via:</strong> </td><td>fikxers.com</td></tr>";
  $message .= "</table>"
  $message .= "</body></html>";       
  $subject = "Kanchies Resident Registration";
  notify_admin($email, $message, $subject);
}
function notify_admin($admin_email, $msg, $subject){
  $recipient = $admin_email;
  //$subject = "Service Booking Request";
  $headers = "From: support@fikxers.com \r\n";
  $headers .= "Reply-To: support@fikxers.com \r\n";
  //$headers .= "CC: susan@example.com\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  mail($recipient, $subject, $msg, $headers) or die("Error!");
}
// Generate token
function getToken($length){
  $token = "";
  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
  $codeAlphabet.= "0123456789";
  $max = strlen($codeAlphabet); // edited

  for ($i=0; $i < $length; $i++) {
    $token .= $codeAlphabet[random_int(0, $max-1)];
  }

  return $token;
}
?>