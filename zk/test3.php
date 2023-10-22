<?php
//DB Connection
require ('db2.php');


//-----------------------------
//The socket functions described here are part of an extension to PHP which must be enabled at compile time by giving the --enable-sockets option to configure.
//Add extension=php_sockets.dll in php.ini and remove ; from extension=sockets statement
include "zklibrary.php";
//Library Loaded
$zk = new ZKLibrary('192.168.0.103', 4370, 'TCP');
//Requesting for connection
$zk->connect();
//Connected
$zk->disableDevice();
//disabling device
echo '</br>All Set</br>';

$sql = "SELECT * FROM user_template where uid='2'";
$result = mysqli_query($conn, $sql);
$arr=mysqli_fetch_array($result);
$x=$arr[0].$arr[1].$arr[2].$arr[3].$arr[4];
$zk->setUserTemplate($x,2);


$zk->enableDevice();
$zk->disconnect();
?>
