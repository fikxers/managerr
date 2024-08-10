<!doctype html>
<html lang="en">
<?php
  session_start(); $title = "Bookings";
  require('../db.php'); require('../functions.php');
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
                                        $sql2="select *,h.Name hotel_name  from room join hotel h using (hotel_id) where Status != 'Occupied' AND h.hotel_id=".$_SESSION['hotel']; 
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
                                           echo "<div class='alert alert-success'>No room available.</div>"; 
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
                                      <button type="submit" class="btn btn-outline-success">Add Booking</button>
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
                                $sql = "SELECT *,r.room_number room_number, CONCAT(g.FirstName, ' ', g.LastName) AS fullname FROM booking b JOIN room r using(room_id) JOIN guest g using(guest_id) where b.hotel_id=".$_SESSION['hotel']; $result = $con->query($sql);
                                if ($result->num_rows > 0) { ?>
                            <table width="100%" class="table table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S/No</th><th>Guest</th>
                                        <th>Room</th><th>Checkin</th>
                                        <th>Checkout</th><th>Total Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $j;  ?></td>
                                        <td><?php echo $row['fullname']; ?></td>
                                        <td><?php echo $row['room_number']; ?></td>
                                        <td><?php echo $row['checkin_date']; ?></td>
                                        <td><?php echo $row['checkout_date']; $j++; ?></td>
                                        <td><?php echo $row['total_price']; ?></td>
                                        <td class="text-end">
                                            <a href="" class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
                                            <a href="" class="btn btn-outline-danger btn-rounded"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>  
                                </tbody>
                            </table>
                        <?php } else { echo "<br><div class='alert alert-primary' role='alert'>No bookings yet.</div>"; } ?>
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