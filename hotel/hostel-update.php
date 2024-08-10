<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Hostel Updates</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700" rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">

    <link rel="stylesheet" href="../fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
   <!-- Theme Style -->
   <link rel="stylesheet" href="../css/style.css"><link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
</head>
<body>

<section class="site-section">
 <div class="container">
   <?php
    session_start();
    // connect to the database
    include ('../db.php');
    $id = $_GET['id'];
    $op = $_GET['op'];//1-Assign**2-Confirm***3-Delete***4-Feedback

    if (isset($_POST['assign'])){
    	$fikxer = stripslashes($_REQUEST['fikxer']);
      $query = "UPDATE student_requests SET status='Assigned',fikxer='".$fikxer."' WHERE id=$id";
      $result = mysqli_query($con,$query);
      // echo '<script type="text/javascript">alert("'.$query.'");</script>';
      // echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      if($result){
        echo "<script>alert('Job Assigned.');</script>";
        echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      }
      else{
        //echo "<script>alert('Error Assigning Job');</script>"; 
        echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      }
    }
    else if (isset($_POST['confirm'])){
      $fee = $_REQUEST['fee'];
      $query = "UPDATE student_requests SET status='Completed',fee=$fee WHERE id=$id";
      $result = mysqli_query($con,$query);
      if($result){
        echo "<script>alert('Job Completion Confirmed.');</script>";
        if($_SESSION['admin_type'] == 'hmgr'){
          echo "<script type='text/javascript'>window.top.location='hostel_workorder.php';</script>"; exit;
        }
        echo "<script type='text/javascript'>window.top.location='my_requests.php';</script>"; exit;
      }
      else{
        //echo "<script>alert('Error Assigning Job');</script>"; 
        echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      }
    }
    else if (isset($_POST['archive'])){
      $query = "UPDATE messages SET archived=1 WHERE mid=$id";
      $result = mysqli_query($con,$query);
      if($result){
        echo "<script>alert('Message archived.');</script>";
        if($_SESSION['admin_type'] == 'hmgr'){
          echo "<script type='text/javascript'>window.top.location='hmessages.php';</script>"; exit;
        }
        echo "<script type='text/javascript'>window.top.location='my_requests.php';</script>"; exit;
      }
      else{
        echo "<script>alert('Error archiving message');</script>"; 
       // echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        echo "<script type='text/javascript'>window.top.location='hmessages.php';</script>"; exit;
      }
    }
    else if (isset($_POST['delete'])){
      $fikxer = stripslashes($_REQUEST['fikxer']);
      $query = "DELETE FROM student_requests WHERE id=$id";
      $result = mysqli_query($con,$query);
      if($result){
        echo "<script>alert('Request Deleted.');</script>";
        echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      }
      else{
        //echo "<script>alert('Error Assigning Job');</script>"; 
        echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      }
    }
    else if (isset($_POST['feedback'])){
      $feedback = stripslashes($_REQUEST['feedbackta']);
      $query = "UPDATE student_requests SET feedback='".$feedback."' WHERE id=$id";
      $result = mysqli_query($con,$query);
      if($result){
        echo "<script>alert('Feedback sent.');</script>";
        echo "<script type='text/javascript'>window.top.location='my_requests.php';</script>"; exit;
      }
      else{
        //echo "<script>alert('Error Assigning Job');</script>"; 
        echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>"; exit;
      }
    }
    else if (isset($_POST['cancel'])){
  	 echo "<script type='text/javascript'>window.top.location='hostel_mgr.php';</script>";
    }
    else if (isset($_POST['intruder'])){
     echo "<script type='text/javascript'>window.top.location='../logout.php';</script>";
    }
    else{
      switch ($op) {
        case 1:
          echo "<h1>Assign Fikxer</h1>";
          $query="select * from hostel_fikxers where hostel='".$_SESSION['hostel']."'"; 
          $result = $con->query($query);
          if ($result->num_rows > 0)
          { ?>
          <form class="" action="" method="POST">
            <div class="form-group">
              <select class="form-control" name="fikxer" >
              <?php while($row = $result->fetch_assoc()) { 
                echo '<option value="'.$row['name'].'">'.$row['name'].'</option>'; 
              } ?>
              </select>
            </div>                    
            <div class="form-group">
              <button type="submit" name="assign" class="btn btn-primary">Assign Fikxer</button> 
              <button type="submit" name="cancel" class="btn btn-primary">Cancel</button>
            </div>
          </form> <?php }
          break;
        case 2:
          echo "<h1>Confirm Job Completion</h1>";
          echo '<form class="" action="" method="POST">
            <div class="form-group row">
              <div class="col-sm-12"><label>Service Charge</label></div><div class="col-sm-5">
              <input type="number" value="0" step="100" min="500" class="form-control" name="fee"></div>
            </div>
            <div class="form-group">
              <button type="submit" name="confirm" class="btn btn-primary">Confirm Job</button> 
              <a class="btn btn-primary" href="javascript:history.go(-1)" title="Return to previous page">&laquo; Cancel</a>
            </div>
          </form>';
          //https://perishablepress.com/go-back-via-javascript-and-php/
          //<button type="submit" name="cancel" class="btn btn-primary">Cancel</button>
          break;
        case 3:
          echo "<h1>Delete this Request</h1>";
          echo '<form class="" action="" method="POST">
            <div class="form-group">
              <button type="submit" name="delete" class="btn btn-primary">Delete</button> 
              <a class="btn btn-primary" href="javascript:history.go(-1)" title="Return to previous page">&laquo; Cancel</a>
            </div>
          </form>';
          break;
        case 4:
          echo "<h1>Give Feedback</h1>";
          echo '<form class="" action="" method="POST">
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Please give your feedback on the job done</label>
              <textarea class="form-control" name="feedbackta" rows="3"></textarea>
            </div>
            <div class="form-group">
              <button type="submit" name="feedback" class="btn btn-primary">Send Feedback</button> 
              <a class="btn btn-primary" href="javascript:history.go(-1)" title="Return to previous page">&laquo; Cancel</a>
            </div>
          </form>';
          break;
        case 5:
          echo "<h1>Archive message?</h1>";
          echo '<form class="" action="" method="POST">
            <div class="form-group">
              <button type="submit" name="archive" class="btn btn-primary">Archive</button> 
              <a class="btn btn-primary" href="javascript:history.go(-1)" title="Return to previous page">&laquo; Cancel</a>
            </div>
          </form>';
          break;
        default:
          echo "<h1 class='text-danger'>Wrong URL</h1>";
          echo '<form class="" action="" method="POST">
            <div class="form-group">
              <button type="submit" name="intruder" class="btn btn-primary">Back to Previous Page</button>
            </div>
          </form>';
          }
      }
    ?>
    </div>
  </section>
</body>
</html>