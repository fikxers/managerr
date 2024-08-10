<!doctype html>
<?php  session_start(); 
  require('db.php');
  if (isset($_POST['task'])){
    $task = stripslashes($_REQUEST['task']);
    // $hotel_code = stripslashes($_REQUEST['hotel_code']);
    // $msg = "deleting"; $msg2 = "Deleted"; 
    // $query = "DELETE FROM hotels WHERE hotel_code = '".$hotel_code."'";
    if($task == 'edit' || $task == 'add'){
      $hotel_name = stripslashes($_REQUEST['hotel_name']);
      $address = stripslashes($_REQUEST['address']); $email = stripslashes($_REQUEST['email']);
      $phone = stripslashes($_REQUEST['phone']); $stars = stripslashes($_REQUEST['stars']);
      $checkin_time = stripslashes($_REQUEST['checkin_time']); 
      $checkout_time = stripslashes($_REQUEST['checkout_time']);
      $query = "INSERT INTO `hotel`(`Name`, `Address`, `Phone`, `Email`, `Stars`, `checkin_time`, `checkout_time`, `hotel_code`) VALUES ('".$hotel_name."','".$address."','".$phone."','".$email."',$stars,'".$checkin_time."','".$checkout_time."','".generateCode()."')";
      switch ($task) {
        case "edit":
          $query = "UPDATE hotels set address='".$address."',no_of_rooms=$no_of_rooms,hotel_name='".$hotel_name."' WHERE hotel_code = '".$hotel_code."'";
          $msg = "updating"; $msg2 = "Updated";
          break;
        default:
          //$query = "INSERT into `hotels` (hotel_name, hotel_code,no_of_rooms, address) VALUES ('$hotel_name', '$hotel_code',$no_of_rooms,'$address')";
          $msg = "adding"; $msg2 = "Added";
      }
    }
    $result = mysqli_query($con,$query);
    if($result){
      echo "<script>alert('".$msg2." Successfully.');</script>";
      echo "<script type='text/javascript'>window.top.location='hotels.php';</script>"; exit;
    }else {
      echo "<script>alert('Error ".$msg.".');</script>";
      echo "<script type='text/javascript'>window.top.location='hotels.php';</script>";
    }
  }
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tables | Bootstrap Simple Admin Template</title>
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
                        <h3>Hotels
                            <button type="button" class="btn btn-sm btn-outline-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus-circle"></i> Add New Hotel</button>
                        </h3>
                    </div>
                    <!-- <div class="row"> -->
                    <div class="box box-primary">
                       <div class="box-body">
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <!-- <div class="card-header">View Hotels in DB</div> -->
                                <div class="card-body">
                                    <p class="card-title"></p>
                                    <!-- <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Hotel</button> -->
                                    <div class="modal fade" id="exampleModal" role="dialog" tabindex="-1">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Add New Hotel</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body text-start">
                                            <p>Please fill hotel details correctly.</p>
                                            <form accept-charset="utf-8" method="POST" action="">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" name="hotel_name" placeholder="Golden Tulip" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" name="email" placeholder="gtulip@yahoo.com" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" name="phone" placeholder="09011223344" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <textarea name="address" class="form-control"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Stars</label>
                                                    <input type="number" min="1" max="5" name="stars" placeholder="1" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="checkin_time" class="form-label">Checkin Time</label>
                                                    <input type="time" name="checkin_time" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="checkin_time" class="form-label">Checkout Time</label>
                                                    <input type="time" name="checkout_time" class="form-control">
                                                    <input type="hidden" name="task" value="add">
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-outline-success">Add Hotel</button>
                                                </div>
                                            </form>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <?php include ('db.php');  $i=1;
                                    $sql = "SELECT * FROM hotel"; $result = $con->query($sql);
                                    if ($result->num_rows > 0) { ?>
                                    <table class="table table-hover table-bordered" id="dataTables-example" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Stars</th>
                                                <th>Checkin Time</th>
                                                <th>Checkout Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $i;  ?></td>
                                                <td><?php echo $row['Name']; ?></td>
                                                <td><?php echo $row['Address']; ?></td>
                                                <td><?php echo $row['Email']; ?></td>
                                                <td><?php echo $row['Phone']; ?></td>
                                                <td><?php echo $row['Stars']; ?></td>
                                                <td><?php echo $row['checkin_time']; ?></td>
                                                <td><?php echo $row['checkout_time']; ?></td>
                                                <?php  
                                                echo '<td><button type="button" class="btn btn-primary btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-toggle="modal" data-target="#editmodal-'.$row['hotel_code'].'" data-original-title="Edit" title="Update Hotel"><i class="fas fa-pen text-primary"></i></button>&emsp;<button type="button" class="btn btn-danger text-danger btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#delmodal-'.$row['hotel_code'].'" data-original-title="Delete" title="Delete Hotel"><i class="fa fa-trash text-danger"></i></button></td>'; $i++;
                                               ?>
                                            </tr>
                                        <?php } ?>  
                                        </tbody>
                                    </table>
                                    <?php } else { echo "<br><div class='alert alert-info' role='alert'>No hotel in database.</div>"; }
                                        $con->close(); ?>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div><!-- Close box -->
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