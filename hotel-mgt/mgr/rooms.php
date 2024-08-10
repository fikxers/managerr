<!doctype html>
<html lang="en">
<?php session_start(); $title = "Room Management";
  require('../db.php'); require('../functions.php');
  if (isset($_POST['task'])){
    $task = stripslashes($_REQUEST['task']);
    if($task == 'add_room' || $task == 'add_type'){
      
      switch ($task) {
        case "add_room":
          $room_no = stripslashes($_REQUEST['room_no']);
          $type = stripslashes($_REQUEST['type']); 
          $status = stripslashes($_REQUEST['status']); 
          $query = "INSERT INTO `room`(`room_number`, `hotel_id`, `type_id`, `Status`) VALUES ($room_no,".$_SESSION['hotel'].",$type,'".$status."')";
          $msg = "adding room"; $msg2 = "Room added";
          break;
        default:
          $type_name = stripslashes($_REQUEST['type_name']);
          $description = stripslashes($_REQUEST['description']); 
          $price_per_night = stripslashes($_REQUEST['price_per_night']);
          $capacity = stripslashes($_REQUEST['capacity']); 
          $query = "INSERT INTO `room_type`(`Name`, `Description`, `price_per_night`, `Capacity`, `hotel_id`) VALUES ('".$type_name."','".$description."','".$price_per_night."',$capacity,".$_SESSION['hotel'].")";
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
                                                    <label for="password" class="form-label">Room Type</label>
                                                    <select class="form-control" required name="type" >
                                                    <?php 
                                                    $sql="select * from room_type where hotel_id=".$_SESSION['hotel']; 
                                                    $result = $con->query($sql);
                                                    if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) { 
                                                    ?>
                                                    <option value="<?php echo $row['type_id']; ?>">
                                                      <?php echo $row['Name']; ?>
                                                    </option><?php } 
                                                    }
                                                    else{
                                                      echo "<option value=''>You need to add a room type!</option>";
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
                                    <?php $j=1; //require('../db.php');  
                                    $sql = "SELECT *, t.Name type_name FROM room r JOIN room_type t using(type_id) where r.hotel_id=".$_SESSION['hotel'].""; $result = $con->query($sql);
                                    if ($result->num_rows > 0) { ?>
                                    <table class="table table-hover responsive-tbl table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S/No</th>
                                                <th>Room No.</th>
                                                <th>Room Type</th>
                                                <th>Status</th><th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $j;  ?></td>
                                                <td><?php echo $row['room_number']; ?></td>
                                                <td><?php echo $row['type_name']; ?></td>
                                                <td><?php echo $row['Status']; ?></td>
                                                <?php
                                                //echo '<td><button type="button" class="btn btn-success btn-sm" style="background-color: transparent; border-width: 0px;" data-toggle="modal" data-target="#bookroom-'.$row['room_number'].'" data-original-title="Edit" title="Update Hotel"><i class="fas fa-book text-success"> Book</i></button></td>';
                                                if($row['Status'] == 'Occupied'){
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
                                    <?php $i=1; //require('../db.php');  
                                    $sql = "SELECT *,r.Name type FROM room_type r where hotel_id=".$_SESSION['hotel'].""; $result = $con->query($sql);
                                    if ($result->num_rows > 0) { ?>
                                    <table class="table table-hover responsive-tbl table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S/No</th><th>Name</th>
                                                <th>Description</th>
                                                <th>Price Per Night</th>
                                                <th>Capacity</th><th>Action</th>
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
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/datatables/datatables.min.js"></script>
    <script src="../assets/js/initiate-datatables.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>