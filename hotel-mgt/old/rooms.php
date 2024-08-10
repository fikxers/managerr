<!doctype html>
<?php session_start();  
  require('db.php'); require('functions.php');
  if (isset($_POST['task'])){
    $task = stripslashes($_REQUEST['task']);
    if($task == 'add_room' || $task == 'add_type'){
      
      switch ($task) {
        case "add_room":
          $room_no = stripslashes($_REQUEST['room_no']);
          $type = stripslashes($_REQUEST['type']); 
          $hotel = stripslashes($_REQUEST['hotel']);
          $status = stripslashes($_REQUEST['status']); 
          $query = "INSERT INTO `room`(`room_number`, `hotel_id`, `type_id`, `Status`) VALUES ($room_no,$hotel,$type,'".$status."')";
          $msg = "adding room"; $msg2 = "Room added";
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
      echo "<script type='text/javascript'>window.top.location='rooms.php';</script>"; exit;
    }else {
      echo "<script>alert('Error ".$msg.".');</script>";
      echo "<script type='text/javascript'>window.top.location='rooms.php';</script>";
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
                        <h3>Room Management
                            <!-- <button type="button" class="btn btn-sm btn-outline-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus-circle"></i> Add New Room</button> -->
                            <!-- <button type="button" class="btn btn-sm btn-outline-success float-end mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus-circle"></i> Add New Room</button> -->
                        </h3>
                    </div>
                    <!-- <div class="row"> -->
                    <div class="box box-primary">
                      <div class="box-body">
                        <!--Rooms-->
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">View Rooms</div>
                                <div class="card-body">
                                    <p class="card-title"></p>
                                    <button type="button" class="btn btn-sm btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Room</button>
                                    <div class="modal fade" id="exampleModal" role="dialog" tabindex="-1">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Add New Room</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body text-start">
                                            <p>Please fill room details correctly.</p>
                                            <form accept-charset="utf-8" method="POST" action="">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Room No.</label>
                                                    <input type="number" name="room_no" min="100" step="1" placeholder="100" class="form-control">
                                                    <input type="hidden" name="task" value="add_room">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Hotel</label>
                                                    <select class="form-control" required name="hotel" >
                                                    <?php // ('db.php');
                                                    $sql="select * from hotel"; 
                                                    $result = $con->query($sql);
                                                    if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) { 
                                                    ?>
                                                    <option value="<?php echo $row['hotel_id']; ?>">
                                                      <?php echo $row['Name']; ?>
                                                    </option><?php } 
                                                    }
                                                    else{
                                                      echo "<option value=''></option>";
                                                    }
                                                    ?>
                                                  </select>
                                                </div>   
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Room Type</label>
                                                    <select class="form-control" required name="type" >
                                                    <?php 
                                                    $sql="select * from room_type"; 
                                                    $result = $con->query($sql);
                                                    if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) { 
                                                    ?>
                                                    <option value="<?php echo $row['type_id']; ?>">
                                                      <?php echo $row['Name']; ?>
                                                    </option><?php } 
                                                    }
                                                    else{
                                                      echo "<option value=''></option>";
                                                    }
                                                    ?>
                                                  </select>
                                                </div>   
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Status</label>
                                                    <select class="form-control" required name="status" >
                                                      <option value="Vacant">Vacant</option>
                                                      <option value="Occupied">Occupied</option>
                                                    </select>
                                                </div>                           
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-outline-success">Add Room</button>
                                                </div>
                                            </form>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <?php $j=1; //include ('db.php');  
                                    $sql = "SELECT *, h.Name hotel_name,t.Name type_name FROM room JOIN hotel h using(hotel_id) JOIN room_type t using(type_id)"; $result = $con->query($sql);
                                    if ($result->num_rows > 0) { ?>
                                    <table class="table table-hover responsive-tbl table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S/No</th>
                                                <th>Room No.</th>
                                                <th>Hotel</th>
                                                <th>Room Type</th>
                                                <th>Status</th><th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $j;  ?></td>
                                                <td><?php echo $row['room_number']; ?></td>
                                                <td><?php echo $row['hotel_name']; ?></td>
                                                <td><?php echo $row['type_name']; ?></td>
                                                <td><?php echo $row['Status']; ?></td>
                                                <?php
                                                //echo '<td><button type="button" class="btn btn-success btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#bookroom-'.$row['room_number'].'" data-original-title="Edit" title="Update Hotel"><i class="fas fa-book text-success"> Book</i></button></td>';
                                                if($row['Status'] != 'Occupied'){
                                                    echo '<a type="button" class="btn btn-primary btn-sm" style="background-color: transparent; border-width: 0px;" href="view_booking.php?room_number='.$row['room_number'].'"><i class="fas fa-file-signature text-primary"> View Booking</i></button></a>';
                                                }
                                                else{
                                                    echo '<td><a type="button" class="btn btn-success btn-sm" style="background-color: transparent; border-width: 0px;" href="book_room.php?room_number='.$row['room_number'].'"><i class="fas fa-book text-success"> Book</i></button></a>';
                                                }
                                                echo '</td>';
                                                $j++;
                                                ?>
                                            </tr>
                                            <div class="modal fade" id="bookroom-<?php echo $row['room_number']; ?>" role="dialog" tabindex="-1">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title">Book Room</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body text-start">
                                                    <p>Please fill to add a new room type.</p>
                                                    <form accept-charset="utf-8" method="POST" action="">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" name="type_name" placeholder="Golden Tulip" class="form-control">
                                                            <input type="hidden" name="task" value="add_type">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Description</label>
                                                            <textarea name="description" class="form-control"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Price per Night</label>
                                                            <input type="number" name="price_per_night" min="5000" step="1000" placeholder="5000" class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Capacity</label>
                                                            <input type="number" name="capacity" min="1" placeholder="1" class="form-control">
                                                        </div>                                               
                                                        <div class="mb-3">
                                                            <button type="submit" class="btn btn-outline-success">Add Room Type</button>
                                                        </div>
                                                    </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <?php } ?>  
                                        </tbody>
                                    </table>
                                <?php } else { echo "<br><div class='alert alert-primary' role='alert'>Please add room.</div>"; }
                                        //$con->close(); ?>
                                </div>
                            </div>
                        </div>
                        <!--/Rooms-->
                        <!--Room Types-->
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">View Room Types</div>
                                <div class="card-body">
                                    <p class="card-title"></p>
                                    <button type="button" class="btn btn-sm btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#typeModal">Add New Room Type</button>
                                    <div class="modal fade" id="typeModal" role="dialog" tabindex="-1">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Add New Room Type</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body text-start">
                                            <?php 
                                                $sql="select * from hotel"; 
                                                $result = $con->query($sql);
                                                if ($result->num_rows > 0) {
                                            ?>
                                            <p>Please fill to add a new room type.</p>
                                            <form accept-charset="utf-8" method="POST" action="">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" name="type_name" placeholder="Golden Tulip" class="form-control">
                                                    <input type="hidden" name="task" value="add_type">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Description</label>
                                                    <textarea name="description" class="form-control"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Price per Night</label>
                                                    <input type="number" name="price_per_night" min="5000" step="1000" placeholder="5000" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Capacity</label>
                                                    <input type="number" name="capacity" min="1" placeholder="1" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Hotel</label>
                                                    <select class="form-control" required name="hotel" >
                                                    <?php 
                                                    while($row = $result->fetch_assoc()) { 
                                                    ?>
                                                    <option value="<?php echo $row['hotel_id']; ?>">
                                                      <?php echo $row['Name']; ?>
                                                    </option><?php
                                                    }
                                                    ?>
                                                  </select>
                                                </div>                                                
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-outline-success">Add Room Type</button>
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
                                    <?php $i=1; //include ('db.php');  
                                    $sql = "SELECT *,r.Name type, h.Name hotel_name FROM room_type r JOIN hotel h using(hotel_id)"; $result = $con->query($sql);
                                    if ($result->num_rows > 0) { ?>
                                    <table class="table table-hover responsive-tbl table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S/No</th><th>Name</th>
                                                <th>Description</th>
                                                <th>Price Per Night</th>
                                                <th>Capacity</th><th>Hotel</th><th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $i;  ?></td>
                                                <td><?php echo $row['type']; ?></td>
                                                <td><?php echo $row['Description']; ?></td>
                                                <td><?php echo currency_format($row['price_per_night']); ?></td>
                                                <td><?php echo $row['Capacity']; ?></td>
                                                <td><?php echo $row['hotel_name']; ?></td>
                                                <?php  
                                                echo '<td><button type="button" class="btn btn-primary btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#editmodal-'.$row['type_id'].'" data-original-title="Edit" title="Update Hotel"><i class="fas fa-pen text-primary"></i></button>&emsp;<button type="button" class="btn btn-danger text-danger btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#delmodal-'.$row['type_id'].'" data-original-title="Delete" title="Delete Hotel"><i class="fa fa-trash text-danger"></i></button></td>'; $i++;
                                               ?>
                                            </tr>
                                            <?php } ?>  
                                        </tbody>
                                    </table>
                                    <?php } else { echo "<br><div class='alert alert-success' role='alert'>Please add room types.</div>"; }
                                        $con->close(); ?>
                                </div>
                            </div>
                        </div>
                        <!--/Room Types-->
                      </div>
                    </div><!--close box-->
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