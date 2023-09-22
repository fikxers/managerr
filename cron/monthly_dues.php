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
              <title>Auto Deduction <FIkxers> Completed</title> 
            </head> 
            <body>'.$m.' 
			  <hr><p>Thank you for choosing Managerr.</p> 
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
			$mail->addAddress('support@managerr.net');
			//Set the subject line
			$mail->Subject = 'Auto Deduction <FIkxers> Completed.';
			$mail->msgHTML($msg);
			//Replace the plain text body with one created manually
			$mail->AltBody = 'Auto Deduction <FIkxers> Completed.';
			$mail->send();
  }
  date_default_timezone_set('Africa/Lagos');
  $pay_date = date("Y-m-d H:i:s"); 
  //date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
  $currentMonth = new DateTime(); // Get the current month
  // Get the last month
  global $lastMonth;
  $lastMonth = clone $currentMonth; // Clone the current month object
  $lastMonth->modify('-1 month'); // Subtract 1 month from the cloned object

  // Get the next month
  $nextMonth = clone $currentMonth; // Clone the current month object
  $nextMonth->modify('+1 month'); // Add 1 month to the cloned object

  $note = "Auto Due Deduction for "; //.". Paid on ".$pay_date;

  function last_day_of_the_month() 
  {
	$lastDayThisMonth = date("Y-m-t");
	$day = date('d', strtotime($lastDayThisMonth));
    return $day;
  }
  function dues_table($estate,$current_monthly_due, $note, $pay_date) 
  {  require('../db.php'); $i=0;
    $get_resident_sql = "SELECT id,email,flat_no,block_no,amount_paid,total_debt FROM flats WHERE estate_code = '".$estate."'";
    $res = $con->query($get_resident_sql); 
    if ($res->num_rows > 0) {
      while($resident = $res->fetch_assoc()) {
        $flat = $resident['flat_no']; $block = $resident['block_no']; $email = $resident['email']; $id = $resident['id'];
        //record due
        $pay_due_query = "INSERT INTO `dues`(`flat`,`estate`, `amount`, `date_paid`, `note`, `category`) VALUES ('".$email."','".$estate."',$current_monthly_due,'".$pay_date."','".$note."','monthly_due')";
        $res2 = mysqli_query($con,$pay_due_query); //$res2 = $con->query($pay_due_query);
        // if ($res2) {
        //   echo "<br>Record #$i updated";
        // }else{
        //    echo mysqli_error($con);
        // } 
        $i++;
      }
      echo "<br>$i Records updated";
    }
  }
  function make_deduction($estate, $current_monthly_due, $note, $pay_date) 
  { 
    require('../db.php');
	  //Get residents in the esate
  	$get_resident_sql = "SELECT flat_no,block_no,amount_paid,total_debt FROM flats WHERE estate_code = '".$estate."'";
  // 	$res = $con->query($sql); 
  // 	if ($res->num_rows > 0) {
  // 	  while($resident = $res->fetch_assoc()) {
  // 	  	$flat = $resident['flat_no']; $block = $resident['block_no']; $email = $resident['email']; $id = $resident['id'];
  // 	  	//record due
  // 	  	$pay_due_query = "INSERT INTO `dues`(`flat`,`estate`, `amount`, `date_paid`, `note`, `category`) VALUES ('".$email."','".$estate."',$current_monthly_due,'".$pay_date."','".$note."','monthly_due')";
  // 	  	$result2 = mysqli_query($con,$pay_due_query); 
  // 	  	//check account balance  
  // 	  	$bal = acct_bal2($resident['amount_paid'], $resident['total_debt']);
  // 	  	$change_bal = "";
  // 	  	if( ($bal >= 0) && ($bal >= $current_monthly_due) ){
  // 	  	  $change_bal = "UPDATE flats set amount_paid=amount_paid-$current_monthly_due, updated_at='".$pay_date."' WHERE id=".$id; 
  // 	  	}
  // 	  	else{
  // 	  	  $change_bal = "UPDATE flats set total_debt=total_debt+$current_monthly_due, updated_at='".$pay_date."'  WHERE id=".$id; 	
  // 	  	}
  // 	  	//update wallet
	// 	    $result = mysqli_query($con,$change_bal);
   //      if ($result->num_rows > 0) { return true; }
   //      else { return false; }
	 //   }
	 // }
   $change_bal = "UPDATE flats set amount_paid=amount_paid-$current_monthly_due, updated_at='".$pay_date.
   "' WHERE estate_code='".$estate."' AND (amount_paid-total_debt) >= ".$current_monthly_due; 
   $change_bal2 = "UPDATE flats set total_debt=total_debt+$current_monthly_due, updated_at='".$pay_date.
   "'  WHERE estate_code='".$estate."' AND (amount_paid-total_debt) < ".$current_monthly_due; 
   $result = mysqli_query($con,$change_bal); $result2 = mysqli_query($con,$change_bal2);
   if ($result) { 
    echo "Auto Due Deduction Step 1 Complete.<br>";
   }  
   else { 
    echo mysqli_error($con);
   }
   
   if ($result2) { 
    dues_table($estate,$current_monthly_due, $note, $pay_date);
    notification('Dear Admin <br><br>Auto Deduction <FIkxers> Completed.<br>Update time: '.date("d-M-Y H:i:s"));
    echo "<br>Auto Due Deduction Step 2 Complete.";
   }  
   else { 
    notification('Dear Admin <br><br>Error. Auto Detection failed.<br>Update time: '.date("d-M-Y H:i:s"));
    echo mysqli_error($con);
   }
   
  }

  function get_estates(){
    $sql = "SELECT * FROM estates";
    $result = $con->query($sql); 
    $data = array(); // Array to store the vectors
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        // Create a vector from the row data and add it to the array
        $vector = array($row["estate_code"], $row["monthly_due"], $row["deadline_option"], $row['due_date']);
        $data[] = $vector;
      }
    }
    return $data;
  }
  
  function pearl(){
    require('../db.php'); $r = false; 
    //$lastMonth = $lastMonth->format('Y-m-d H:i:s'); 
    $currentMonth = new DateTime(); // Get the current month
    // Get the last month
    $lastMonth = clone $currentMonth; // Clone the current month object
    $lastMonth->modify('-1 month'); // Subtract 1 month from the cloned object
    $pay_date = date("Y-m-d H:i:s"); $due_date = 0; //date("F j, Y");
    $note = "Auto Due Deduction for "; $estate = 'PNP';
    $sql = "SELECT * FROM estates where estate_code = 'PNP'";

    $res = $con->query($sql); 
    if ($res->num_rows > 0) {
      while($row = $res->fetch_assoc()) {
        $current_monthly_due = $row['monthly_due']; //Get Monthly Levy
        $deadline_option =  $row['deadline_option']; //Deadline Option 
        $due_date =  $row['due_date']; //Get Due Day
      }
    }
    $today = date('d'); //today
    $monthend = last_day_of_the_month(); //end of this month

    //Option 1-Last day of month
    if ( ($today == $monthend) && ($deadline_option == 1) ){
      $note = $note.date("F Y");
      make_deduction($estate, $current_monthly_due, $note, $pay_date); //MAKE DEDUCTIONS
    }
    //Option 2-Days after month end 
    else if ( ($today == $due_date) && ($deadline_option == 2) ){
      $note = $note.$lastMonth->format('F Y');
      make_deduction($estate, $current_monthly_due, $note, $pay_date); //MAKE DEDUCTIONS
    }
    //Option 3-Days before month end 
    else if ( ($today == $monthend-$due_date) && ($deadline_option == 3) ){
      $note = $note.date("F Y");
      make_deduction($estate, $current_monthly_due, $note, $pay_date); //MAKE DEDUCTIONS
    }
    // if ($r) { echo "Auto Due Deduction Complete."; }
    // else { echo "Could not Perform Auto Due Deduction."; }
}

function update_all_estates(){
  require('../db.php'); $i=1;
  $note = "Auto Due Deduction for ";
  $currentMonth = new DateTime(); // Get the current month
  $pay_date = date("Y-m-d H:i:s");
  $lastMonth = clone $currentMonth; // Clone the current month object
  $lastMonth->modify('-1 month'); // Subtract 1 month from the cloned object
  $sql = "SELECT * FROM estates";
  $result = $con->query($sql); 
  if ($result->num_rows > 0) {
  	while($row = $result->fetch_assoc()) {
  	  $estate = $row['estate_code'];
  	  //Get Monthly Levy
  	  $current_monthly_due = $row['monthly_due']; 
  	  //Deadline Option 1-Last day of month | 2-Days after month end | 3-Days before month end 
  	  $deadline_option =  $row['deadline_option']; 
  	  //Get Due Day
  	  $due_date =  $row['due_date']; $today = date('d');
  	  $monthend = last_day_of_the_month();

  	  //Option 1-Last day of month
  	  if ( ($today == $monthend) && ($deadline_option == 1) ){
  	  	$note = $note.date("F Y");
  	  	make_deduction($estate, $current_monthly_due, $note, $pay_date); //MAKE DEDUCTIONS
  	  }
  	  //Option 2-Days after month end 
  	  else if ( ($today == $due_date) && ($deadline_option == 2) ){
  	  	$note = $note.$lastMonth->format('F Y');
  	  	make_deduction($estate, $current_monthly_due, $note, $pay_date); //MAKE DEDUCTIONS
  	  }
  	  //Option 3-Days before month end 
  	  else if ( ($today == $monthend-$due_date) && ($deadline_option == 3) ){
  	  	$note = $note.date("F Y");
  	  	make_deduction($estate, $current_monthly_due, $note, $pay_date); //MAKE DEDUCTIONS
  	  }
  	  //Default
  	  // else{
  		//   echo "Could not Perform Auto Due Deduction."; // do nothing
  	  // }
  	}
  }
}

//For only Pearl Nuga Estate
pearl();
?>