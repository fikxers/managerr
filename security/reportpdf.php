<?php
session_start();
// Database connection configuration
require('../db.php');

// Include the TCPDF library
require_once('tcpdf/tcpdf.php');

$option = $_GET['title']; $title = ""; //$sql = "";
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

// Create a new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// Set the document information and metadata
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Managerr');
$pdf->SetTitle('Security Report');
$pdf->SetSubject($title);
$pdf->SetKeywords('Security, PDF, Export, Managerr, '.$title);

// Set default header data
$pdf->SetHeaderData('', 0, '', '', array(0, 0, 0), array(255, 255, 255));

// Set default header font 
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// Set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// Set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('helvetica', '', 11);

// Add a page
$pdf->AddPage();

// $sql = 'SELECT column1, column2, column3 FROM your_table';

$result = $con->query($sql);

// Build the table content
$tableData = '<table>';
$tableData .= '<tr><th>CODE</th><th>GUEST</th><th>VEHICLE NO.</th><th>PHONE</th><th>COMPANIONS</th><th>DURATION</th><th>ARRIVAL</th><th>STATUS</th></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableData .= '<tr>';
        $tableData .= '<td>' . $row['code'] . '</td>';
        $tableData .= '<td>' . $row['visitor'] . '</td>';
        $tableData .= '<td>' . $row['reg_no'] . '</td>';
        $tableData .= '<td>' . $row['phone'] . '</td>';
        $tableData .= '<td>' . $row['comp'] . '</td>';
        $tableData .= '<td>' . $row['duration'] . '</td>';
        $tableData .= '<td>' . $row['arr_date'] . '</td>';
        $tableData .= '<td>' . $row['status'] . '</td>';
        $tableData .= '</tr>';
    }
}

$tableData .= '</table>';

// Output the table content
$pdf->writeHTML($tableData, true, false, false, false, '');

// Close the database connection
$con->close();

// Output the PDF as a download
header('Content-Type: text/pdf'); //new fix
header('X-Content-Type-Options: nosniff'); //new fix
$pdf->Output('security_report.pdf', 'D');
//$pdf->Output('security_report.pdf', 'F');
?>
