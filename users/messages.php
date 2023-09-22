<?php require('auth.php'); $title ='Contact Facility Manager'; ?>

    <?php include('flat_sidebar.php'); ?>
    <?php
		require('../db.php');
		$estate_code = $_SESSION['estate'];
		  if (isset($_POST['send_msg'])){
			$subject = $_REQUEST['subject'];
			$message = $_REQUEST['message'];
			if( ! ini_get('date.timezone') ){
			  date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT into `messages` (sender,receiver,subject, message, date_received) VALUES ('".$_SESSION['email']."','$estate_code','$subject', '$message', '$trn_date')";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Message sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='messages.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Message was not sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='messages.php';</script>"; exit;
			}
		  }
		  elseif (isset($_POST['reply'])){
			$subject = $_REQUEST['subject'];
			$message = $_REQUEST['message'];	
			$flat = $_REQUEST['sender'];
			$reply_to = $_REQUEST['reply_to'];
			if( ! ini_get('date.timezone') ){
			  date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT into `messages` (sender,receiver,subject, message, date_received,replied_to) VALUES ('".$_SESSION['email']."','".$estate_code."','$subject', '$message', '$trn_date',$reply_to)";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Reply sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='messages.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Reply not sent. Please try again.');</script>";
			  echo "<script type='text/javascript'>window.top.location='messages.php';</script>"; exit;
			}
		  }
		  else{
		?>
                    <div class="row">
						<div class="col-lg-12">
						  <div class="card m-b-30">
                            <div class="card-body">
							  <h4 class="mt-0 header-title">Messages from FM</h4>
							  <button type='button' class='btn btn-success btn-sm' style='border-radius: 10px; float: right;' data-toggle='modal' data-target='#complainmodal' data-original-title='Complaint'><b>Report an Issue</b></button><br><br>
							  <!-- Modal -->
							  <div class="modal fade" id="complainmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
								  <div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLongTitle">Contact FM</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
									<div class="modal-body">
									  <form action="" method="POST"> 
										<div class="form-group">
										  <!--<input type="text" name="subject" class="form-control" required placeholder="Subject"/>-->
										  <select class="form-control" name="subject" >
										     <option value="Others">Subject</option>
											 <option value="Water Supply">Water Supply</option>
											 <option value="Electric power">Electric power</option>
											 <option value="Internet">Internet</option>
											 <option value="Common Area">Common Area</option>
											 <option value="Road">Road</option>
											 <option value="Others">Others</option>
										  </select>
										</div>
										<div class="form-group">
										  <textarea class="form-control form-control-sm" name="message" placeholder="Type message" style="height:50px"></textarea>
										</div>
										<div class="form-group">
										  <button type="submit" name="send_msg" class="btn btn-outline-primary btn-block">Send Message</button>
										</div>
									  </form>		    
									</div>
								  </div>
								</div>
							  </div>
							  <!-- /Modal -->
							  <div class="table-responsive b-0" data-pattern="priority-columns">
							    <?php include ('../db.php');
									$sql = "SELECT * FROM messages where receiver='".$_SESSION['email']."' ";
									$result = $con->query($sql);
									if ($result->num_rows > 0) { ?>
									<table id="tech-companies-1" class="table  table-bordered">
                                      <thead>
                                        <tr class="titles">
                                          <th>Subject</th><th>Message</th>
                                          <th>Date Sent</th> <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody><?php while($row = $result->fetch_assoc()) { ?>
										<tr>
										  <td><?php echo $row['subject']; ?></td>
										  <td><?php echo $row['message']; ?></td>
										  <td><?php echo $row['date_received']; ?></td>
										  <td><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target="#replymodal-<?php echo $row['mid']; ?>" data-original-title="Reply Message"><i class="fa fa-reply" aria-hidden="true"></i></button></td>
								        </tr>
								        <!-- Modal -->
                    						<div class="modal fade" id="replymodal-<?php echo $row['mid']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    							<div class="modal-dialog modal-dialog-centered" role="document">
                    							  <div class="modal-content">
                    								<div class="modal-header">
                    								  <h5 class="modal-title" id="exampleModalLongTitle">Reply This Message</h5>
                    								  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    									<span aria-hidden="true">&times;</span>
                    								  </button>
                    								</div>
                    								<div class="modal-body">
                    								  <form action="" method="POST"> 
                    									<input type="hidden" name="subject" value="Re: <?php echo $row['subject']; ?>"/> <input type="hidden" name="sender" value="<?php echo $row['sender']; ?>"/>
                    									<input type="hidden" name="reply_to" value="<?php echo $row['mid']; ?>"/>
                    									<div class="form-group"><textarea class="form-control form-control-sm" name="message" placeholder="Type message" style="height:50px"></textarea></div>
                    									<div class="form-group"><button type="submit" name="reply" class="btn btn-outline-success btn-block">Send Reply</button></div>
                    								  </form>   
                    								</div>
                    							  </div>
                    							</div>
                    						</div>
                    						<!-- Modal -->
										<?php }
										  } else {echo "No messages yet.";} $con->close();
									    ?>
                                       </tbody>
                                    </table>
							  </div>
							</div>
                          </div>
						</div>
						<!-- <div class="col-lg-12">
						  <div class="card m-b-30">
                            <div class="card-body">
							  <h4 class="mt-0 header-title">Contact FM</h4>
                              <form action="" method="POST"> 
								<div class="form-group">
                                  <input type="text" name="subject" class="form-control" required placeholder="Subject"/>
                                </div>
								<div class="form-group">
                                  <textarea class="form-control form-control-sm" name="message" placeholder="Type message" style="height:50px"></textarea>
                                </div>
								<div class="form-group">
                                  <button type="submit" name="send_msg" class="btn btn-outline-primary btn-block">Send Message</button>
                                </div>
							  </form>
                            </div>
                          </div>
						</div> -->
                    </div>
                    <!-- end row -->
                  </div>
                  <!-- container -->
                </div>
                <!-- Page content Wrapper -->
            </div>
            <!-- content -->

		  <?php include('footer.php'); } ?>

</html>