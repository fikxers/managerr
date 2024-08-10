<?php
  function generateCode() {
    $tokenLength = 5; // Set the desired token length
    $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $token = '';
    for ($i = 0; $i < $tokenLength; $i++) {
      $token .= $charset[rand(0, strlen($charset) - 1)];
    }
    return $token;
  }
  function currency_format($number)
  {
    $decimalplaces = 2;
    $decimalcharacter = '.';
    $thousandseparater = ',';
    return "&#8358;".number_format((int)$number,$decimalplaces,$decimalcharacter,$thousandseparater);
  }
  function hotel_login() {
    if(!isset($_SESSION['email'])){
      echo "<script type='text/javascript'>window.top.location='login.php';</script>"; exit;
    }
  }
?>