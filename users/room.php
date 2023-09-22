		<?php
          include('auth.php'); $title='Dashboard';
          include('room_sidebar.php');
		  require('../db.php');		  

      if (isset($_POST['send'])){
        $subject = stripslashes($_REQUEST['subject']);
        $message = stripslashes($_REQUEST['message']);      
        if( ! ini_get('date.timezone') )
        {
          date_default_timezone_set('Africa/Lagos');
        }
        $trn_date = date("Y-m-d H:i:s");
        $query = "INSERT INTO `messages`(`sender`, `receiver`,`message`, `subject`, `date_received`) VALUES ('".$_SESSION['email']."','".$_SESSION['hostel']."','".$message."','".$subject."','".$trn_date."')";
        $result = mysqli_query($con,$query);
        if($result){
          echo "<script>alert('Message sent.');</script>";
          echo "<script type='text/javascript'>window.top.location='room.php';</script>"; exit;
        }
        else{
          echo "<script>alert('Message could not be sent.');</script>";
          echo "<script type='text/javascript'>window.top.location='room.php';</script>"; exit;
        }
      }
      else{
    ?>
    <div class="row">
		  <div class="col-lg-12">
        <div class="card m-b-30">
          <div class="card-body">
            <!--<h4 class="mt-0 header-title">Notice Board</h4>-->
            <div class="row">
              <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Notice Board</a>
                  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Contact Admin</a>
                  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
                  <!--<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>-->
                </div>
              </div>
              <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="table-rep-plugin">
                      <div class="table-responsive b-0" data-pattern="priority-columns">
                      <?php
                       $sql = "SELECT * FROM notices where hostel='".$_SESSION['hostel']."'";
                       $result = $con->query($sql);
                       if ($result->num_rows > 0) { 
                        while($row = $result->fetch_assoc()) { ?>
                          <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?php echo '<b>'.$row['subject'].'</b> | '.$row['send_date'].'<br>'; 
                             echo $row['message']; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                      <?php }
                      }else { echo "<div class='alert alert-primary' role='alert'> Notice board is empty!</div>"; } $con->close();  ?>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <form class="" action="" method="POST">
                      <label for="exampleFormControlTextarea1">Subject</label>
                      <div class="form-group"><input type="text" name="subject" class="form-control" required /></div>
                      <div class="form-group">
                        <label for="exampleFormControlTextarea1">Message</label>
                        <textarea class="form-control" name="message" rows="2"></textarea>
                      </div>
                      <div class="form-group">
                            <input type="submit" name="send" value="Send" class="btn btn-primary">
                            <input type="reset" value="Reset" class="btn btn-info">
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                      <?php require('../db.php'); 
                       $sql = "SELECT * FROM messages";// where hostel='".$_SESSION['hostel']."'";
                       $result = $con->query($sql);
                       if ($result->num_rows > 0) { 
                        while($row = $result->fetch_assoc()) { ?>
                          <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <?php echo '<b>'.$row['subject'].'</b> | '.$row['date_received'];
                            if($row['sender'] == $_SESSION['email'])  echo ' | To: <b>Admin</b>'.'<br>'; 
                            else  echo ' | From: <b>Admin</b>'.'<br>';
                             //echo '<b>'.$row['sender'].'</b> | '.$row['receiver'].'<br>'; 
                             echo $row['message']; 
                             ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                      <?php }
                      }else { echo "<div class='alert alert-info' role='alert'> Notice board is empty!</div>"; } $con->close();  ?>
                  </div>
                  <!--<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>-->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
		</div>
    <!-- container -->
 	</div>
 	<!-- Page content Wrapper -->
</div>
<!-- content -->
<?php include('footer.php'); } ?>
</html>