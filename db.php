<?php
/*
Author: Javed Ur Rehman
Website: http://www.allphptricks.com/
*/

$con = mysqli_connect("localhost","koryoesz","admin","managerr");
//$con = mysqli_connect("localhost","root","","realeoki_fikxers");
mysqli_set_charset($con, "utf8");
//$con = mysqli_connect("localhost","root","","galaria");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>