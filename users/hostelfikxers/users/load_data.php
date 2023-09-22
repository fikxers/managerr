<?php

//get the selected option that was sent in jQuery's ajax call.  This can be used to filter your query
$selectedOption = $_POST['selectedOption'];


//connect to mysql and select a db
$conn=mysql_connect('localhost', 'realeoki_root', 'tamgenius') or die(mysql_error());
mysql_select_db('realeoki_fikxers', $conn) or die(mysql_error());

//select data from the db
$query="SELECT email,admin_type FROM users";
$result=mysql_query($query, $conn) or die(mysql_error());

//create an array to contain people selected from your DB.
$people = array();
while ($resultsArray=mysql_fetch_array($result))
{
    array_push($people, array("email"=>$resultsArray['email'], "admin_type"=>$resultsArray['admin_type']));
}

echo json_encode($people);

?>