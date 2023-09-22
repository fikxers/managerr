<?php
  $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/:reference",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer pk_live_18871cca91b9d3051c849daa0f9a5e079c8bca21",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  
  if ($err) {
    $error = "cURL Error #:" . $err;
	echo '<script type="text/javascript">alert("'.$err.'");</script>';//echo "cURL Error #:" . $err;
  } else {
    echo '<script type="text/javascript">alert("'.$response.'");</script>';//echo $response;
  }
?>