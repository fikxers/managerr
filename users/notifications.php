<?php require('auth.php'); $title ='Notifications'; 
		 
		require('../db.php');
		if(isset($_GET['id']) && $_SESSION['admin_type']=='admin'){
			include('admin_sidebar.php'); $estate_code = $_GET['id'];
		}
		else if($_SESSION['admin_type']=='mgr'){
			include('mgr_sidebar.php');$estate_code = $_SESSION['estate'];
		}
		else{
			echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
		}
		use PHPMailer\PHPMailer\PHPMailer;
	  use PHPMailer\PHPMailer\SMTP;
	  use PHPMailer\PHPMailer\Exception;

	  require '../PHPMailer/src/Exception.php';
	  require '../PHPMailer/src/PHPMailer.php';
	  require '../PHPMailer/src/SMTP.php';
		//$estate_code = $_SESSION['estate'];
	  function notification($to, $m, $d, $s) {
	  	$msg = ' 
          <html> 
          <head> 
              <title>Estate Broadcast Received</title> 
          </head> 
          <body>
            <p>Message: '.$m.'</p><br>
            <p>Date sent: '.$d.'</p>
			<hr><p>Powered by <a href="https://managerr.net">Managerr</p>.</p> 
          </body> 
          </html>'; 
          if ($s == NULL || $s == ""){
          	$s ='Estate Broadcast Received';
          }
	  	//Create a new PHPMailer instance
			$mail = new PHPMailer();
			//Set PHPMailer to use the sendmail transport
			$mail->isSendmail();
			//Set who the message is to be sent from
			$mail->setFrom('support@managerr.net', 'Manager Support');
			//Set an alternative reply-to address
			$mail->addReplyTo('info@managerr.net', 'Manager Support');
			//Set who the message is to be sent to
			$mail->addAddress($to);//$mail->addAddress('ypolycarp@gmail.com');
			//Set the subject line
			$mail->Subject = $s;
			$mail->msgHTML($msg);
			//Replace the plain text body with one created manually
			$mail->AltBody = $m; //'Signup successful. Welcome on board.';
			//Attach an image file
			//$mail->addAttachment('images/phpmailer_mini.png');

			$mail->send();
	  }
		if (isset($_POST['send_broadcast'])){
			$subject = $_REQUEST['subject'];
			$message = $_REQUEST['message'];	
			/*if( ! ini_get('date.timezone') ){
			  date_default_timezone_set('Africa/Lagos');
			}*/
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT into `broadcast` (estate,subject, message, send_date) VALUES ('$estate_code','$subject', '$message', '$trn_date')";
			$result = mysqli_query($con,$query);
			if($result){
				//Block 4
				// $dbc= mysqli_connect($host,$user,$password, $dbase) 
				// or die("Unable to select database");

				//Block 5
				$query= "SELECT email FROM flats where estate_code='".$estate_code."'";
				$result= mysqli_query ($con, $query) or die ('Error querying database.');

				//Block 6
				while ($row = mysqli_fetch_array($result)) {
					// $first_name= $row['first_name'];
					// $last_name= $row['last_name'];
					$email= $row['email'];

					//Block 7
					// $msg= "Dear $first_name $last_name,\n$body";
					// mail($email, $subject, $msg, 'From:' . $from);
					// echo 'Email sent to: ' . $email. '<br>';
					notification($email, $message, $trn_date, $subject);
				}

				//Block 8
				mysqli_close($con);

			  echo "<script>alert('Broadcast sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='notifications.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Broadcast was not sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='notifications.php';</script>"; exit;
			}
		  }
		  elseif (isset($_POST['send_msg'])){
			$subject = $_REQUEST['subject'];
			$message = $_REQUEST['message'];	
			$flat = $_REQUEST['flat'];
			if( ! ini_get('date.timezone') ){
			  date_default_timezone_set('Africa/Lagos');
			}
			$trn_date = date("Y-m-d H:i:s");
			$query = "INSERT into `messages` (sender,receiver,subject, message, date_received) VALUES ('$estate_code','$flat','$subject', '$message', '$trn_date')";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Message sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='notifications.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Message was not sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='notifications.php';</script>"; exit;
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
			$query = "INSERT into `messages` (sender,receiver,subject, message, date_received,replied_to) VALUES ('$estate_code','".$flat."','$subject', '$message', '$trn_date',$reply_to)";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Reply sent.');</script>";
			  echo "<script type='text/javascript'>window.top.location='notifications.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Reply not sent. Please try again.');</script>";
			  echo "<script type='text/javascript'>window.top.location='notifications.php';</script>"; exit;
			}
		  }
		  else{
		?>
          <div class="row">
						<div class="col-lg-12">
						  <div class="card m-b-30">
                            <div class="card-body">
								<h4 class="mt-0 header-title">Messages</h4>
								<span style="float: right"><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' 
								data-toggle='modal' data-target="#chatmodal" data-original-title="Contact Resident"><i class="fa fa-comment m-b-10"></i> <b>Contact Resident</b></button></span>
								<div class="table-responsive b-0" data-pattern="priority-columns">
								    <?php include ('../db.php');
									$sql = "SELECT * FROM messages join flats on messages.sender=flats.email where receiver='".$estate_code."' AND flats.estate_code='".$estate_code."' order by  date_received desc";
									$result = $con->query($sql);
									if ($result->num_rows > 0) { ?>
									<table id="tech-companies-1" class="table  table-bordered">
                    	               <thead>
                    	                 <tr class="titles">
                    	                    <th>Subject</th><th>Message</th><th>Sender</th><th>Date Sent</th> <th>Action</th> 
                    	                 </tr>
                    	               </thead>
                    	               <tbody><?php while($row = $result->fetch_assoc()) { ?>
											<tr>
											  <td><?php echo $row['subject']; ?></td><td><?php echo $row['message']; ?></td>
											  <td><?php $sender="Flat ".$row['flat_no']."- Block ".$row['block_no']; echo $sender;//$row['sender']; ?></td>
											  <td><?php echo format_date($row['date_received']); ?></td>
											  <td><button type='button' class='btn text-success btn-success btn-sm' style='background-color: transparent; border-width: 0px;' 
								                data-toggle='modal' data-target="#replymodal-<?php echo $row['mid']; ?>" data-original-title="Reply Message"><i class="fa fa-reply" aria-hidden="true"></i></button></td>
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
						<div class="col-lg-12">
						  <div class="card m-b-30">
                            <div class="card-body">
							    <h4 class="mt-0 header-title">Broadcasts</h4>
								<span style="float: right"><button type='button' class='btn btn-success text-success btn-sm' style='background-color: transparent; border-width: 0px;' 
								    data-toggle='modal' data-target="#broadcastmodal" data-original-title="Add Fikxer"><i class="fa fa-bullhorn m-r-10 m-b-10"></i> <b>Send Broadcast</b></button>
								</span>
								<div class="table-responsive b-0" data-pattern="priority-columns">
								    <?php include ('../db.php');
									$sql = "SELECT * FROM broadcast where estate='".$estate_code."'  order by  send_date desc";
									$result = $con->query($sql);
									if ($result->num_rows > 0) { ?>
									<table id="tech-companies-1" class="table  table-stripped table-bordered">
                	                    <thead>
                	                      <tr class="titles">
                	                        <th>Subject</th><th>Message</th><th>Date Sent</th>
                	                      </tr>
                	                    </thead>
                	                   	<tbody><?php while($row = $result->fetch_assoc()) { ?>
											<tr>
											  <td><?php echo $row['subject']; ?></td><td><?php echo $row['message']; ?></td><td><?php echo format_date($row['send_date']); ?></td>
											</tr>
										<?php }
										  } else {echo "No messages yet.";} $con->close();
									    ?>
                                        </tbody>
                                    </table>
							  	</div>
							</div>
                          </div>
						</div>
						<!-- Modal -->
						<div class="modal fade" id="chatmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
							  <div class="modal-content">
									<div class="modal-header">
									  <h5 class="modal-title" id="exampleModalLongTitle">Contact Resident</h5>
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									  </button>
									</div>
									<div class="modal-body">
									  <form action="" method="POST"> 
										<div class="form-group">
										  <input type="text" name="subject" class="form-control" required placeholder="Subject"/>
										</div>
										<div class="form-group">
										  <textarea class="form-control form-control-sm" name="message" placeholder="Type message" style="height:50px"></textarea>
										</div>
										<div class="form-group">
										  <select class="form-control" required name="flat" >
										  <?php  include ('../db.php');
											$sql="select flat_no,block_no,email from flats where estate_code='".$_SESSION['estate']."'"; 
											$result = $con->query($sql); 
											while($row = $result->fetch_assoc()) { 
											$flat = "Flat ".$row['flat_no'].", Block ".$row['block_no'];
										  ?>
										  <option value="<?php echo $row['email']; ?>"><?php echo $flat; ?></option><?php } ?>
										  </select>
										</div>
										<div class="form-group">
										  <button type="submit" name="send_msg" class="btn btn-outline-primary btn-block">Send Message</button>
										</div>
									  </form>   
									</div>
							  </div>
							</div>
						</div>
						<!-- Modal -->
						<div class="modal fade" id="broadcastmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
							  <div class="modal-content">
								<div class="modal-header">
								  <h5 class="modal-title" id="exampleModalLongTitle">Send Broadcast</h5>
								  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								  </button>
								</div>
								<div class="modal-body">
								   <form action="" method="POST"> 
									<div class="form-group">
									  <input type="text" name="subject" class="form-control" required placeholder="Subject"/>
									</div>
									<div class="form-group">
									  <textarea class="form-control form-control-sm" name="message" placeholder="Type message" style="height:50px"></textarea>
									</div>
									<div class="form-group">
									  <button type="submit" name="send_broadcast" class="btn btn-outline-primary btn-block">Send Broadcast</button>
									</div>
								  </form>	
								</div>
							  </div>
							</div>
						</div>
						<!--<div class="col-lg-12">
						  <div class="card m-b-30">
                            <div class="card-body">
							  <h4 class="mt-0 header-title">Send Broadcast</h4>
                              <form action="" method="POST"> 
								<div class="form-group">
                                  <input type="text" name="subject" class="form-control" required placeholder="Subject"/>
                                </div>
								<div class="form-group">
                                  <textarea class="form-control form-control-sm" name="message" placeholder="Type message" style="height:50px"></textarea>
                                </div>
								<div class="form-group">
                                  <button type="submit" name="send_broadcast" class="btn btn-outline-primary btn-block">Send Broadcast</button>
                                </div>
							  </form>	
							  <h4 class="mt-0 header-title">Contact Flat</h4>
                              <form action="" method="POST"> 
							    <div class="form-group">
                                  <input type="text" name="subject" class="form-control" required placeholder="Subject"/>
                                </div>
								<div class="form-group">
                                  <textarea class="form-control form-control-sm" name="message" placeholder="Type message" style="height:50px"></textarea>
                                </div>
								<div class="form-group">
								  <select class="form-control" required name="flat" >
								  <?php  include ('../db.php');
									$sql="select flat_no,block_no,email from flats where estate_code='".$_SESSION['estate']."'"; 
									$result = $con->query($sql);; 
									while($row = $result->fetch_assoc()) { 
									$flat = "Flat ".$row['flat_no'].", Block ".$row['block_no'];
								  ?>
								  <option value="<?php echo $row['email']; ?>"><?php echo $flat; ?></option><?php } ?>
								  </select>
								</div>
								<div class="form-group">
                                  <button type="submit" name="send_msg" class="btn btn-outline-primary btn-block">Send Message</button>
                                </div>
							  </form>
                            </div>
                          </div>
						</div>-->
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