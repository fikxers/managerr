<?php  
session_start(); include('../db.php');
$sql = "SELECT flats.owner resident,flats.email email,dues.amount amount,dues.date_paid date, dues.category category,dues.note remarks FROM dues join flats on dues.flat=flats.email where dues.estate='".$_SESSION['estate']."'";
$result = $con->query($sql);  
  
// Check if the query returned any results  
if ($result->num_rows > 0) {  
    // Create a file to store the CSV data  
    $filename = 'resident_transactions.csv';  
    $handle = fopen($filename, 'w');  
  
    // Write the header row to the CSV file  
    $headers = array();  
    foreach ($result->fetch_assoc() as $key => $value) {  
        $headers[] = $key;  
    }  
    fputcsv($handle, $headers);  
  
    // Write each row of data to the CSV file  
    while ($row = $result->fetch_assoc()) {  
        fputcsv($handle, $row);  
    }  
  
    // Close the file handle  
    fclose($handle);  
  
    //echo "CSV file exported successfully!";  
    echo "<script>alert('Reported downloaded successfully.');</script>";
    echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit;
} else {  
    echo "<script>alert('No results found.');</script>";
    echo "<script type='text/javascript'>window.top.location='dues.php';</script>"; exit; 
}  
  
// Close the database conection  
$con->close();  
?>