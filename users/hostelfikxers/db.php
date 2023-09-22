<?php
/*
Author: Javed Ur Rehman
Website: http://www.allphptricks.com/
*/


$con = mysqli_connect("localhost","realeoki_root","tamgenius","realeoki_fikxers");
//$con = mysqli_connect("localhost","root","","galaria");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>