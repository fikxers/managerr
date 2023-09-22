<?php
session_start();
// Database connection configuration
// $servername = 'localhost';
// $username = 'your_username';
// $password = 'your_password';
// $dbname = 'your_database';

$option = $_GET['title']; $title = ""; 
$sql = "SELECT code,visitor,reg_no,phone,comp,duration,arr_date,status FROM entrance_codes where estate='".$_SESSION['estate']."'";

if($option == 1){
    $title = "Security Report - All Invites";
}
else if($option == 2){
    $title = "Security Report - All Visits"; $sql .= " and (status='signed-in' OR status='signed-out')"; 
}
else if($option == 3){
    $title = "Security Report -No-Shows"; $sql .= " and status='no-show'"; 
}
else if($option == 4){
    $title = "Security Report - Pending Visits"; $sql .= " and status='invite'"; 
}
else{
    echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
}


require('../db.php');

// Establish database connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die('Connection failed: ' . $conn->connect_error);
// }

// MySQL query to retrieve the data
//$sql = 'SELECT column1, column2, column3 FROM your_table';

// Execute the query and fetch the data
$result = $con->query($sql);

// Create a file pointer
$fp = fopen('security_report.csv', 'w');

// Write the column headers to the CSV file
$headers = ['CODE', 'GUEST', 'VEHICLE NO.', 'PHONE', 'COMPANIONS',  'DURATION', 'ARRIVAL', 'STATUS'];
fputcsv($fp, $headers);

// Write the data rows to the CSV file
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($fp, $row);
    }
}

// Close the file pointer
fclose($fp);

// Provide the CSV file as a download
//header('Content-Type: application/csv');
header('Content-Type: text/csv'); //new fix
header('X-Content-Type-Options: nosniff'); //new fix
header('Content-Disposition: attachment; filename="security_report.csv"');
readfile('security_report.csv');

// Clean up the temporary CSV file
unlink('security_report.csv');

// Close the database connection
$con->close();
?>
