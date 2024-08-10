<!doctype html>
<html lang="en">
<?php
  session_start();  
  require('db.php'); require('functions.php');
  if (isset($_GET['room_number'])){
    $room_no = $_GET['room_number'];
    $sql = "SELECT room_id,t.price_per_night price FROM room r JOIN room_type t USING(type_id)";
    $result = mysqli_query($con,$sql) or die(mysql_error());
    $price = $result->fetch_object()->price;
    $result = mysqli_query($con,$sql) or die(mysql_error());
    $room_id = $result->fetch_object()->room_id;
  }
  else{
    echo "<script type='text/javascript'>window.top.location='rooms.php';</script>"; exit;
  }
  if (isset($_POST['task'])){
    $task = stripslashes($_REQUEST['task']);
    if($task == 'book' || $task == 'edit'){
      switch ($task) {
        case "book":
          $guest = stripslashes($_REQUEST['guest']); 
          $checkin = $_REQUEST['checkin_date'];
          $checkout = $_REQUEST['checkout_date'];
          $datetime1 = new DateTime($checkin);
          $datetime2 = new DateTime($checkout);
          $difference = $datetime1->diff($datetime2);
          $no_of_days = $difference->d;
          $total_price = $no_of_days * $price;
          //echo 'No. of days: '.$difference->d.'<br>';
          $msg = "Guest: $guest | Checkin: ".$checkin." | Checkout: ".$checkout." | No. of days: ".$no_of_days." | Total fee: ".currency_format($total_price)." | Room ID: $room_id<br>";
          // $hotel = stripslashes($_REQUEST['hotel']);
          $msg2 = $msg."Room $room_no booked.";
          if($checkin > $checkout){
            $msg2 = $msg."Checkout date should be after checkin date. Room $room_no not booked";
          }
          // if( ! ini_get('date.timezone') )
          // {
          // date_default_timezone_set('Africa/Lagos');
          // }
          // $trn_date = date("Y-m-d H:i:s");
          $add_booking = "INSERT INTO `booking`(`guest_id`, `room_id`, `checkin_date`, `checkout_date`, `total_price`) VALUES ($guest,$room_id,'".$checkin."','".$checkout."',$total_price)";
          $change_room_status = "UPDATE `room` SET `Status`='Occupied' WHERE room_number = $room_no";
          $booking_result = mysqli_query($con,$add_booking);
          $status_result = mysqli_query($con,$change_room_status);
          echo "<script>alert('".$msg2." successfully.');</script>";
          echo "<script type='text/javascript'>window.top.location='book_room.php';</script>"; exit;
          break;
        default:
          $type_name = stripslashes($_REQUEST['type_name']);
          $description = stripslashes($_REQUEST['description']); 
          $price_per_night = stripslashes($_REQUEST['price_per_night']);
          $capacity = stripslashes($_REQUEST['capacity']); $hotel = stripslashes($_REQUEST['hotel']);
          $query = "INSERT INTO `room_type`(`Name`, `Description`, `price_per_night`, `Capacity`, `hotel_id`) VALUES ('".$type_name."','".$description."','".$price_per_night."',$capacity,$hotel)";
          $msg = "adding room type"; $msg2 = "Room type added";
      }
    }
    // $result = mysqli_query($con,$query);
    // if($result){
    //   echo "<script>alert('".$msg2." Successfully.');</script>";
    //   echo "<script type='text/javascript'>window.top.location='managers.php';</script>"; exit;
    // }else {
    //   echo "<script>alert('Error ".$msg.".');</script>";
    //   echo "<script type='text/javascript'>window.top.location='managers.php';</script>";
    // } 
  }
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HAIVEN Hotel Management | </title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- sidebar navigation component -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="assets/img/bootstraper-logo.png" alt="bootraper logo" class="app-logo">
            </div>
            <ul class="list-unstyled components text-secondary">
                <?php include('menu.php'); ?>
            </ul>
        </nav>
        <!-- end of sidebar component -->
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav1" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-link"></i> <span>Quick Links</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu" aria-labelledby="nav1">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-list"></i> Access Logs</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-user-shield"></i> Roles</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span>John Doe</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Booking for Room <?php echo $room_no; ?>
                            <a href="rooms.php" class="btn btn-sm btn-outline-primary float-end mb-3"><i class="fas fa-angle-left"></i> Other Rooms</a>
                        </h3>
                    </div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <form accept-charset="utf-8" method="POST" action="">
                              <div class="mb-3">
                                <label for="password" class="form-label">Guest</label>
                                <select class="form-control" required name="guest" >
                                 <?php 
                                  $guests_sql="select * from guest"; 
                                  $guests_result = $con->query($guests_sql);
                                  if ($guests_result->num_rows > 0) {
                                    while($guest_row = $guests_result->fetch_assoc()) { 
                                  ?>
                                    <option value="<?php echo $guest_row['guest_id']; ?>">
                                    <?php echo $guest_row['FirstName']." ".$guest_row['LastName']; ?>
                                    </option><?php
                                    }
                                  }
                                  else{
                                    echo "<div class='alert alert-primary'>No guest registered.</div>";
                                  }
                                  ?>
                                </select>
                              </div> 
                              <div class="mb-3">
                                <label for="email" class="form-label">Checkin Date</label>
                                <input type="date" name="checkin_date" class="form-control">
                                <input type="hidden" name="task" value="book">
                              </div>    
                              <div class="mb-3">
                                <label for="email" class="form-label">Checkout Date</label>
                                <input type="date" name="checkout_date" class="form-control">
                              </div>                                            
                              <div class="mb-3">
                                <button type="submit" class="btn btn-outline-success">Book Room</button>
                              </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>