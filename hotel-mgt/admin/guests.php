<!doctype html>
<html lang="en">
<?php
  session_start();  
  $title = 'Guests';require('../db.php'); require('../functions.php');
  if (isset($_POST['task'])){
    $task = stripslashes($_REQUEST['task']);
    if($task == 'add' || $task == 'edit'){
      switch ($task) {
        case "add":
          $fname = stripslashes($_REQUEST['fname']); $address = stripslashes($_REQUEST['address']);
          $lname = stripslashes($_REQUEST['lname']); $dob = stripslashes($_REQUEST['dob']);
          $email = stripslashes($_REQUEST['email']); $hotel = stripslashes($_REQUEST['hotel']);
          $phone = stripslashes($_REQUEST['phone']); 

          $query = "INSERT INTO `guest`(`FirstName`, `LastName`, `dob`, `Address`, `Phone`, `Email`, `hotel_id`) VALUES ('".$fname."','".$lname."','".$dob."','".$address."','".$phone."','".$email."',$hotel)";
          $msg = "adding guest"; $msg2 = "Guest added";
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
      echo "<script type='text/javascript'>window.top.location='guests.php';</script>"; exit;
    }else {
      echo "<script>alert('Error ".$msg.".');</script>";
      echo "<script type='text/javascript'>window.top.location='guests.php';</script>";
    } 
  }
  include('header.php');
?>
<body>
    <div class="wrapper">
        <!-- sidebar navigation component -->
        <?php require('sidebar-top.php'); ?>
        <!-- end of sidebar component -->
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <?php require('navbar.php'); ?>
            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Guests
                            <button type="button" class="btn btn-sm btn-outline-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-plus-circle"></i> Add Guest</button>
                        </h3>
                    </div>
                    <div class="box box-primary">
                        <div class="box-body">
                                    <div class="modal fade" id="exampleModal" role="dialog" tabindex="-1">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Add New Guest</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body text-start">
                                            <?php 
                                                $sql="select * from hotel"; 
                                                $result = $con->query($sql);
                                                if ($result->num_rows > 0) {
                                            ?>
                                            <p>Please fill guest's details correctly.</p>
                                            <form accept-charset="utf-8" method="POST" action="">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">First name</label>
                                                    <input type="text" name="fname" placeholder="Jane" class="form-control">
                                                    <input type="hidden" name="task" value="add">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Last name</label>
                                                    <input type="text" name="lname" placeholder="Doe" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" name="email" placeholder="janedoe@yahoo.com" class="form-control">
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
                                                    <label for="checkin_time" class="form-label">Date of birth</label>
                                                    <?php
                                                      $time = strtotime("-18 year", time());
                                                      $date = date("Y-m-d", $time);
                                                    ?>
                                                    <input type="date" name="dob" min="<?php echo $date; ?>" class="form-control">
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
                                                    <button type="submit" class="btn btn-outline-success">Add Guest</button>
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
                            <?php require('../db.php');  $i=1;
                            $sql = "SELECT *,h.Name hotel_name FROM guest JOIN hotel h using(hotel_id)"; $result = $con->query($sql);
                            if ($result->num_rows > 0) { ?>
                            <table width="100%" class="table table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S/No</th><th>Name</th><th>DOB</th>
                                        <th>Email</th><th>Phone</th>
                                        <th>Address</th><th>Hotel Lodged</th><th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $i;  ?></td>
                                        <td><?php echo $row['FirstName']." ".$row['LastName']; ?></td>
                                        <td><?php echo $row['dob']; ?></td>
                                        <td><?php echo $row['Email']; ?></td>
                                        <td><?php echo $row['Phone']; ?></td>
                                        <td><?php echo $row['Address']; ?></td>                           
                                        <td><?php echo $row['hotel_name']; $i++; ?></td>
                                        <td class="text-end">
                                            <a href="" class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
                                            <a href="" class="btn btn-outline-danger btn-rounded"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?> 
                                </tbody>
                            </table>
                        <?php } else { echo "<br><div class='alert alert-info' role='alert'>No guest in database.</div>"; }
                            $con->close(); ?>
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