<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>Update/Delete Skill</title>
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
    $id = $_GET['id'];$op = $_GET['op'];//1-Update**2-Delete

    if (isset($_POST['update'])){
    	$skill = stripslashes($_REQUEST['skill']);
      $query = "UPDATE fikxer_skills SET skill='".$skill."' WHERE id=$id";
      $result = mysqli_query($con,$query);
      if($result){
        echo "<script>alert('Skill Updated.');</script>";
        echo "<script type='text/javascript'>window.top.location='fikxer_skills.php';</script>"; exit;
      }
      else{
        echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        echo "<script type='text/javascript'>window.top.location='fikxer_skills.php';</script>"; exit;
      }
    }
    else if (isset($_POST['delete'])){
      $query = "DELETE FROM fikxer_skills WHERE id=$id";
      $result = mysqli_query($con,$query);
      if($result){
        echo "<script>alert('Skill Deleted.');</script>";
        echo "<script type='text/javascript'>window.top.location='fikxer_skills.php';</script>"; exit;
      }
      else{
        echo '<script type="text/javascript">alert("'.mysqli_error($con).'");</script>';
        echo "<script type='text/javascript'>window.top.location='fikxer_skills.php';</script>"; exit;
      }
    }
    else if (isset($_POST['cancel'])){
  	 echo "<script type='text/javascript'>window.top.location='fikxer_skills.php';</script>";
    }
    else if (isset($_POST['intruder'])){
     echo "<script type='text/javascript'>window.top.location='../logout.php';</script>";
    }
    else{
      switch ($op) {
        case 1:
          echo "<h1>Update Skill</h1>"; ?>
          <form class="" action="" method="POST">
            <div class="form-group"><input type="text" name="skill" class="form-control" required placeholder="New Skill"/></div>                   
            <div class="form-group">
              <button type="submit" name="update" class="btn btn-primary">Update</button> 
              <button type="submit" name="cancel" class="btn btn-primary">Cancel</button>
            </div>
          </form> <?php 
          break;
        case 2:
          echo "<h1>Delete this Skill</h1>";
          echo '<form class="" action="" method="POST">
            <div class="form-group">
              <button type="submit" name="delete" class="btn btn-primary">Delete</button> 
              <button type="submit" name="cancel" class="btn btn-primary">Cancel</button>
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