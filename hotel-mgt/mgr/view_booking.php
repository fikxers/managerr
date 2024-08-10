<!doctype html>
<html lang="en">
<?php
  session_start();  $title = 'View Booking';
  require('../db.php'); require('../functions.php');
  if (isset($_GET['room_number'])){
     $room_no = $_GET['room_number']; $hotel_id = $_GET['hotel_id']; $room_id = $_GET['room_id'];
    $sql = "SELECT t.price_per_night price FROM room r JOIN room_type t USING(type_id) where r.room_id=$room_id";
    $result = mysqli_query($con,$sql) or die(mysql_error());
    $price = $result->fetch_object()->price;
  }
  else{
    echo "<script type='text/javascript'>window.top.location='rooms.php';</script>"; exit;
  }
  if (isset($_POST['task'])){
    $task = stripslashes($_REQUEST['task']);
    if (isset($_POST['task'])){
    $query="";
    $task = stripslashes($_REQUEST['task']);
    // if( ! ini_get('date.timezone') )
    // {
    // date_default_timezone_set('Africa/Lagos');
    // }
    // $trn_date = date("Y-m-d H:i:s");
    $query = "UPDATE `room` SET `Status`='Vacant' WHERE room_id=$room_id";
    $result = mysqli_query($con,$query);
    if($result){
      echo "<script>alert('Guest checked out successfully.');</script>";
      echo "<script type='text/javascript'>window.top.location='rooms.php';</script>"; exit;
    }else {
      echo "<script>alert('Error occured during checkout.');</script>";
      echo "<script type='text/javascript'>window.top.location='view_booking.php';</script>";
    } 
  }
  include('../admin/header.php');
?>
<body>
    <div class="wrapper">
        <!-- sidebar navigation component -->
        <?php require('../admin/sidebar-top.php'); ?>
        <!-- end of sidebar component -->
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <?php require('../admin/navbar.php'); ?>
            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Booking Details for Room <?php echo $room_no; ?>
                            <a href="rooms.php" class="btn btn-sm btn-outline-primary float-end mb-3"><i class="fas fa-angle-left"></i> Other Rooms</a>
                        </h3>
                    </div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <?php 
                              $booking = "SELECT *,CONCAT(g.FirstName, ' ', g.LastName) AS fullname FROM `booking` JOIN guest g using (guest_id) WHERE booking_id = (SELECT MAX(booking_id) from booking WHERE room_id=$room_id)";
                              $result = $con->query($booking);
                              if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                            ?>
                            <h5>Guest: <?php echo $row['fullname']; ?></h5>
                            <h5>Checkin Date: <?php echo $row['checkin_date']; ?></h5>
                            <h5>Checkout Date: <?php echo $row['checkout_date']; ?></h5>
                            <?php } 
                              }
                              else{
                                echo "<br><div class='alert alert-primary' role='alert'>Wrong booking details.</div>";
                              }
                            ?>
                            <form method="POST" action="">
                                <input type="hidden" name="task" value="checkout">
                                <button type="submit" class="btn btn-outline-primary">Checkout Guest</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/datatables/datatables.min.js"></script>
    <script src="../assets/js/initiate-datatables.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>