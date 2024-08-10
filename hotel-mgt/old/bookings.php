<!doctype html>
<html lang="en">
<?php
  session_start();  
  require('db.php'); require('functions.php');
  if (isset($_POST['task'])){
    $task = stripslashes($_REQUEST['task']);
    if($task == 'add' || $task == 'edit'){
      switch ($task) {
        case "add":
          $fullname = stripslashes($_REQUEST['fullname']); $phone = stripslashes($_REQUEST['phone']);
          $email = stripslashes($_REQUEST['email']); $hotel = stripslashes($_REQUEST['hotel']);
           
          if( ! ini_get('date.timezone') )
          {
          date_default_timezone_set('Africa/Lagos');
          }
          $trn_date = date("Y-m-d H:i:s");
          $query = "INSERT INTO `staff`(`hotel_id`, `name`, `phone`, `email`, `created_at`) VALUES ($hotel,'".$fullname."','".$phone."','".$email."','".$trn_date."')";
          $msg = "adding manager"; $msg2 = "Manager added";
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
    $result = mysqli_query($con,$query);
    if($result){
      echo "<script>alert('".$msg2." Successfully.');</script>";
      echo "<script type='text/javascript'>window.top.location='managers.php';</script>"; exit;
    }else {
      echo "<script>alert('Error ".$msg.".');</script>";
      echo "<script type='text/javascript'>window.top.location='managers.php';</script>";
    } 
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
                        <h3>All Bookings
                            <button type="button" class="btn btn-sm btn-outline-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus-circle"></i> Add a Booking</button>
                        </h3>
                    </div>
                    <div class="modal fade" id="exampleModal" role="dialog" tabindex="-1">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Add New Booking</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body text-start">
                                <?php 
                                  $sql="select * from hotel"; 
                                  $result = $con->query($sql);
                                  if ($result->num_rows > 0) {
                                ?>
                                <p>Please enter booking details correctly.</p>
                                <form accept-charset="utf-8" method="POST" action="">
                                    <div class="mb-3">
                                      <label for="name" class="form-label">Full name</label>
                                      <input type="text" name="fullname" placeholder="Jane Doe" class="form-control">
                                      <input type="hidden" name="task" value="add">
                                    </div>
                                    <div class="mb-3">
                                      <label for="password" class="form-label">Guest</label>
                                      <?php 
                                        $sql1="select * from guest"; 
                                        $result1 = $con->query($sql1);
                                        if ($result1->num_rows > 0) {
                                      ?>
                                      <select class="form-control" required name="hotel" >
                                      <?php 
                                         while($row1 = $result1->fetch_assoc()) { 
                                      ?>
                                      <option value="<?php echo $row1['guest_id']; ?>">
                                      <?php echo $row1['FirstName']." ".$row1['LastName']; ?>
                                      </option><?php  }  ?>
                                      </select>
                                      <?php  }  ?>
                                    </div> 
                                    <div class="mb-3">
                                      <label for="password" class="form-label">Room number</label>
                                      <?php 
                                        $sql2="select *,h.Name hotel_name  from room join hotel h using (hotel_id) where Status != 'Occupied'"; 
                                        $result2 = $con->query($sql2);
                                        if ($result2->num_rows > 0) {
                                      ?>
                                      <select class="form-control" required name="hotel" >
                                      <?php 
                                         while($row2 = $result2->fetch_assoc()) { 
                                      ?>
                                      <option value="<?php echo $row2['room_number']; ?>">
                                      <?php echo $row2['room_number']." - ".$row2['hotel_name']; ?>
                                      </option><?php  }  ?>
                                      </select>
                                      <?php  }
                                        else{
                                           echo "<div class='alert alert-success'>All rooms are occupied.</div>"; 
                                       }  
                                      ?>
                                    </div> 
                                    <!-- <div class="mb-3">
                                      <label for="password" class="form-label">Hotel</label>
                                      <select class="form-control" required name="hotel" >
                                      <?php 
                                         while($row = $result->fetch_assoc()) { 
                                      ?>
                                      <option value="<?php echo $row['hotel_id']; ?>">
                                      <?php echo $row['Name']; ?>
                                      </option><?php  }  ?>
                                      </select>
                                    </div>  --> 
                                    <div class="mb-3">
                                      <button type="submit" class="btn btn-outline-success">Add Manager</button>
                                    </div>
                                </form>
                                <?php
                                  } 
                                  else {
                                    echo "<div class='alert alert-primary'>You cannot add a room type when there is no hotel in DB.</div>";
                                  }
                                ?>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <?php $j=1;  
                                $sql = "SELECT *, h.Name hotel_name FROM staff JOIN hotel h using(hotel_id)"; $result = $con->query($sql);
                                if ($result->num_rows > 0) { ?>
                            <table width="100%" class="table table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S/No</th><th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Hotel</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $j;  ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['hotel_name']; $j++; ?></td>
                                        <td class="text-end">
                                            <a href="" class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
                                            <a href="" class="btn btn-outline-danger btn-rounded"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>  
                                </tbody>
                            </table>
                        <?php } else { echo "<br><div class='alert alert-primary' role='alert'>Please add manager.</div>"; } ?>
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