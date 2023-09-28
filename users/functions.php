<?php
  function format_date($the_date){
    $phpdate = strtotime( $the_date );
	$myFormatForView = date("d-M-Y g:i A", $phpdate);
	return $myFormatForView;
  }
  function format_date2($the_date){
    $phpdate = strtotime( $the_date );
	$myFormatForView = date("d-M-Y", $phpdate);
	return $myFormatForView;
  }
  function deadline(int $day = 10) {
	//$m = date("m");$y = date("Y"); 
	$d = date("d");
	//$val=$y."-".($m+1)."-$day"; //$val=$y."-".($m+1)."-".$d;
	$today=date("Y/m/d");
	$next_month = date('Y/m/d', strtotime('+1 month', strtotime($today)));
	$next_date = date('Y/m/d', strtotime('+$day day', strtotime($next_month)));
	$date1=date_create($today);
	$date2=date_create($next_date);
	$diff=date_diff($date1,$date2);
	$res = $diff->format("%a"); 	
	$res = $diff->format("%R%a"); return $res;
	/*echo $res;if($day < $d) {$r = $res+$day;}
	else if($res==0) {$r = 0;}
	else {$r = $day-$d;}
	return $r;*/
  }
  function days2due(int $due_day=10){
	//$today=date("Y/m/d");
	$y = date("Y"); $m = date("m"); $today = date("d");	
	$nextmonth_date = date('m',strtotime('first day of +1 month'));
	$no_of_days_in_month=cal_days_in_month(CAL_GREGORIAN,$m,$y); //no_of_days_in_given_month_of_year	
	$days_left = (($no_of_days_in_month - $today) + $due_day)%$no_of_days_in_month;
	return $days_left;
  }
  function add_due(int $day = 10, float $due=10000) {
	$m = date("m");$y = date("Y"); $d = date("d");
	if($d == $day) echo 0-$due;
	else echo $due;
  }
  function check_if_due(int $updated, int $day = 10, float $due=10000) {
	$m = date("m");$y = date("Y"); $d = date("d");
	if( ($day == 5) && (time() >= strtotime("00:00:00")) && ($updated == 0) )  return 1;
	else 0;
  }
  function acct_bal(float $amount_paid=0, float $total_debt=0) {
	$bal = $amount_paid-$total_debt;
	if($bal >= 0)echo "&#8358;".$bal;
	else echo "-&#8358;".($bal*-1);
  }
  function acct_bal2(float $amount_paid=0, float $total_debt=0) {
	$bal = $amount_paid-$total_debt;
	//if($bal >= 0) return $bal;
	//else  return ($bal*-1);
	return $bal;
  }
  function noshow($arrtime=NULL, $arrdate=NULL){
	$time = date("H:i:s",strtotime($arrtime)); 
  }
  function submystr_to_array($str, $length, $arr_result = array() )
  {
	$istr_len = strlen($str);
	if ( $istr_len == 0 )
		return $arr_result;
	$result = substr($str, 0, $length);
	$tail = substr($str, $length, $istr_len );
	if ( $result )
		array_push( $arr_result, $result );
	if( !$tail )
		return $arr_result;

	return submystr_to_array( $tail, $length, $arr_result);
  }
  function count_checks($date_to_check){
	//$today=date("Y/m/d");
	//int $checkins, $checkouts;
  }
  function last_day_of_the_month() //last_day_of_the_month($date = '')
  {
    //$month  = date('m', strtotime($date));
    //$year   = date('Y', strtotime($date));
	//$day = date('d', strtotime($date));
    //$result = strtotime("{$year}-{$month}-01");
    //$result = strtotime('-1 second', strtotime('+1 month', $result));
	
	$lastDayThisMonth = date("Y-m-t");
	$day = date('d', strtotime($lastDayThisMonth));

    return $day; 
	//return date('Y-m-d', $result);
  }
  function service_charge($duedur, $acct_bal){
	$last_day = last_day_of_the_month();
	//$d = date("d"); 
	//if there's 10 or less days to month end
	include('../db.php');
	if($duedur <= 10){
	  date_default_timezone_set('Africa/Lagos');
	  $pay_date = date("Y-m-d H:i:s");  $msg = 0;
	  $_SESSION['pay_date'] = $pay_date;
	  if($acct_bal >= 0){ 
	    //service charge payment
		$amount = 30000; $note = "Service charge payment";
		$pay_due_query = "INSERT INTO `dues`(`flat`,`estate`, `amount`, `date_paid`, `note`, `category`) VALUES ('".$_SESSION['email']."','".$_SESSION['estate']."',$amount,'".$pay_date."','".$note."','service_charge')"; $result2 = mysqli_query($con,$pay_due_query); 
		if($result2){
		  $change_bal = "UPDATE flats set amount_paid=amount_paid-$amount WHERE email='".$_SESSION['email']."'"; $result = mysqli_query($con,$change_bal); 
		  $msg = 1;//'Service Charge Paid Successfully, today - '.$pay_date;
		}else{
	      $msg = 2;//"Error: ".mysqli_error();
		}
	  }else{
		$msg = 3;//'Service Charge could not be paid. You need to Fund your  Wallet.';
	  }
	}
	else{
	  $msg = 4;
	}
	return $msg;
  }
  function currency_format($number)
  {
   $decimalplaces = 2;
   $decimalcharacter = '.';
   $thousandseparater = ',';
   return number_format($number,$decimalplaces,$decimalcharacter,$thousandseparater);
  }
  function check_electric_max($amount, $max, $this_month, $last_payment){
	  //$return_value = true;
	  $electric_this_month = $amount + $this_month;
	  if( $amount > $max || $electric_this_month > $max ){
	  	return -1; //cannot pay
	  } else{
	    if (check_if_current_month($last_payment)) {
	      //change in db
	    	// $query = "UPDATE flats set maxMonthlyPayment =  $electric_this_month WHERE flat_no = '".$_SESSION['flat_no']."' AND block_no = '".$_SESSION['block_no']."' AND estate_code = '".$_SESSION['estate']."'";
				// $result2 = mysqli_query($con,$query); 
				// if($result2){
				//   echo "<script>alert('Meter PAN set successfully.');</script>";
				//   echo "<script type='text/javascript'>window.top.location='electric-bill.php';</script>"; exit;
				// }
				// else{
				//   echo "<script>alert('Error: ".mysqli_error()."');</script>";
				//   echo "<script type='text/javascript'>window.top.location='electric-bill.php';</script>"; exit;
				// }
				return $electric_this_month;
	    } else{ return -1; }
	  }
	}

	function check_if_current_month($last_payment){
		$paymentMonth = date('m', strtotime($last_payment));
	    $paymentYear = date('Y', strtotime($last_payment));
	    $month = date('m'); $year = date('Y');
	    if ($paymentMonth <= $month && $paymentYear == $year) {
	    	return true;
	    } else{ 
	    	return false;
	    }
	}
?>