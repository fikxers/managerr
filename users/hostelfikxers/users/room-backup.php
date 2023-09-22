		<?php
          include('auth.php'); $title='Dashboard';
          include('room_sidebar.php');
		  require('../db.php');		  
		?>
    <div class="row">
		  <div class="col-lg-12">
        <div class="card m-b-30">
          <div class="card-body">
            <h4 class="mt-0 header-title">Notice Board</h4>
            <div class="row">
              <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
                  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
                  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
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
                        <textarea class="form-control" name="message" rows="3"></textarea>
                      </div>
                      <div class="form-group">
                            <input type="submit" name="send_notice" value="Send Notice" class="btn btn-primary">
                            <input type="reset" value="Reset" class="btn btn-info">
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
                  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                </div>
              </div>
              <!--Notices-->
              <div class="col-lg-8">
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
              <!--Messages-->
              <div class="col-lg-4">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter">Message Admin</button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Message Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="" action="" method="POST">
                          <label for="exampleFormControlTextarea1">Subject</label>
                          <div class="form-group"><input type="text" name="subject" class="form-control" required /></div>
                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Message</label>
                            <textarea class="form-control" name="message" rows="3"></textarea>
                          </div>
                          <!--<div class="form-group">
                            <input type="submit" name="send_notice" value="Send Notice" class="btn btn-primary">
                            <input type="reset" value="Reset" class="btn btn-info">
                          </div>-->
                     
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" name="send" class="btn btn-primary btn-sm">Send Message</button>
                      </div>
                        </form>
                    </div>
                  </div>
                </div>
                <!--End of Send Message Modal-->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#exampleModalScrollable">
                  My Messages
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                        Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                        Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                        Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                        Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                        Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                        Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                        Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                        Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                        Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.

                        Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

                        Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.

                        Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
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
<?php include('footer.php'); ?>
</html>