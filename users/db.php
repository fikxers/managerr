<?php
  /*
  https://www.codewall.co.uk/5-ways-to-loop-through-array-php/
	https://1bestcsharp.blogspot.com/2016/07/php-mysql-pdo-using-foreach-loop.html
		https://stackoverflow.com/questions/15553107/efficient-way-to-get-data-from-mysql-in-a-php-foreach-loop
			https://www.zope-europe.org/avoid-mysql-queries-within-loops/
				*/
  //$dsn = 'mysql:host=localhost;dbname=realeoki_fikxers'; $username = 'root'; $password = '';
  $dsn = 'mysql:host=localhost;dbname=realeoki_fikxers2'; $username = 'realeoki_root'; $password = 'tamgenius';
  try{
    // connect to mysql
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$con->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
  } catch (Exception $ex) {
	echo 'Not Connected '.$ex->getMessage();
  }
?>