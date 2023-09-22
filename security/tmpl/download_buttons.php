<?php  
  if(isset($_GET['title'])){
    $title = $_GET['title']; 
  } else{
    $title = 3;   
  }
?>
<button type='button' onclick="window.location.href = 'report.php?title=<?php echo $title; ?>';" class='btn btn-success btn-sm ml-1 mb-3' style='border-radius: 10px; float: right;'><b>Download CSV Report</b></button>
<!--<button type='button' onclick="window.location.href = 'reportpdf.php?title=3';" class='btn btn-danger btn-sm mb-3' style='border-radius: 10px; float: right;'><b>Download PDF Report</b></button>-->