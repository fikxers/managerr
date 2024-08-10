<?php //header("Location: ../hotel.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php'; 
$title='Hotel Management'; include('db.php');
function send_booking_mail($to,$hotel,$fullname,$room_no)  {
      $msg = ' 
          <html> 
          <head> 
              <title>Hotel Room Booked via HAIVEN</title> 
          </head> 
          <body> 
              <p>Hello '.$fullname.',</p> <br><br>
              <p>You have successfully booked Room '.$room_no.' in '.$hotel.'.</p><br><br>
              <h5>Enjoy your stay.</h5><br><br>
              <p>Powered by <a target="_blank" href="HAIVEN.net">HAIVEN</a></p>
          </body> 
          </html>'; 
      //Create a new PHPMailer instance
        $mail = new PHPMailer();
        //Set PHPMailer to use the sendmail transport
        //$mail->isSendmail(); 
        //$mail->IsSMTP(); 
        //Set who the message is to be sent from
        $mail->setFrom('support@HAIVEN.net', 'HAIVEN');
        //Set an alternative reply-to address
        $mail->addReplyTo('info@HAIVEN.net', 'HAIVEN');
        //Set who the message is to be sent to
        $mail->addAddress($to);//$mail->addAddress('ypolycarp@gmail.com');
        //Set the subject line
        $mail->Subject = 'Hotel Booking Successful';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($msg);//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually
        $mail->AltBody = 'You have successfully booked Room via HAIVEN!';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors
        if (!$mail->send()) {
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            echo "<script>alert('Error: ".$mail->ErrorInfo."');</script>";
            echo "<script type='text/javascript'>window.top.location='index.php';</script>";
        } else {
            //echo 'Message sent!';
            echo "<script>alert('Check email for reset token.');</script>";
            echo "<script type='text/javascript'>window.top.location='index.php';</script>";
        }
    }
$hotel="";
if (isset($_GET['room_no']) && isset($_GET['room_type'])){
    $room_no = $_GET['room_no']; $room_type = $_GET['room_type'];
    $sql = "SELECT t.price_per_night price,r.hotel_id hotel_id FROM room r JOIN room_type t USING(type_id) where r.room_id=$room_no";
    $result = mysqli_query($con,$sql) or die(mysql_error());
    $price = $result->fetch_object()->price;
    $result = mysqli_query($con,$sql) or die(mysql_error());
    $hotel_id = $result->fetch_object()->hotel_id;
}
else{
	$room_type = "Room";
}

if (isset($_POST['task'])){
    $task = stripslashes($_REQUEST['task']);
    $to=$hotel=$fullname=$room="";
    if($task == 'book' || $task == 'cancel'){
      switch ($task) {
        case "book":
          //guest details
          $fname = stripslashes($_REQUEST['fname']); 
          $lname = stripslashes($_REQUEST['lname']); 
          $email = stripslashes($_REQUEST['email']); 
          $phone = stripslashes($_REQUEST['phone']); 
          //for email
          $to=$email; $fullname=$fname." ".$lname;
          //booking 
          //get the just-added guest
          $sql = "select max(guest_id) g FROM guest where hotel_id=$hotel_id";
          $result = mysqli_query($con,$sql) or die(mysql_error());
          $guest = $result->fetch_object()->g;
          //other details
          $checkin = $_REQUEST['checkin_date'];
          $checkout = $_REQUEST['checkout_date'];
          $datetime1 = new DateTime($checkin);
          $datetime2 = new DateTime($checkout);
          $difference = $datetime1->diff($datetime2);
          $no_of_days = $difference->d;
          $total_price = $no_of_days * $price;
          //1-add guest 2-add booking
          $query = "INSERT INTO `guest`(`FirstName`, `LastName`,`Phone`, `Email`, `hotel_id`) VALUES ('".$fname."','".$lname."','".$phone."','".$email."',$hotel_id)";
          $query2 = "INSERT INTO `booking`(`guest_id`, `room_id`, `checkin_date`, `checkout_date`, `total_price`) VALUES ($guest,$room_no,'".$checkin."','".$checkout."',$total_price)";
          //change room status to occupied
          $change_room_status = "UPDATE `room` SET `Status`='Occupied' WHERE room_id = $room_no";
          $add_guest_result = mysqli_query($con,$query);
          $booking_result = mysqli_query($con,$query2);
          $status_result = mysqli_query($con,$change_room_status);
          $msg = "comfirming booking"; $msg2 = "Booking confirmed";
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
    	include('script.php');send_booking_mail($to,$hotel,$fullname,$room_no);
      echo "<script>alert('".$msg2." Successfully.');</script>";
      echo "<script type='text/javascript'>window.top.location='index.php';</script>"; exit;
    }else {
      echo "<script>alert('Error ".$msg.".');</script>";
      echo "<script type='text/javascript'>window.top.location='index.php';</script>";
    } 
  }
//min="2019-06-02"
?>
<!DOCTYPE html>
<html>
	<?php 
	include('script.php'); ?>
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="../img/favicon.ico">
		<!-- Author Meta -->
		<meta name="HAIVEN" content="HAIVEN">
		<!-- Meta Description -->
		<meta name="description" content="HAIVEN is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead.">
		<!-- Meta Keyword -->
		<!-- <meta name="about" content="HAIVEN is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead."> -->
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Open Graph Tags -->
		<meta name="og:title" property="og:title" content="HAIVEN">
		<!-- Twitter card -->
		<meta name="twitter:card" content="HAIVEN is a Cloud-based Integrated Facilities Management Application designed to drive efficiency, eliminate wastages and minimize estates and facilities overhead.">
		<!-- Canonical Tage -->
		<link rel="canonical" href="https://HAIVEN.net/">
		<!-- Robots Tage -->
		<meta name="robots" content="noindex, nofollow">
		<!-- Site Title -->
		<title>HAIVEN | <?php echo $title; ?></title>
		<!-- Manifest for A2HS -->
		<!-- <link rel="manifest" href="manifest.webmanifest" /> -->
		<link rel="manifest" href="manifest.json" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<meta name="theme-color" content="#ffffff">


	    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,400,300,500,600,700" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Nunito Sans:100,200,400,300,500,600,700" rel="stylesheet">
		<!--CSS
		============================================= -->
		<link rel="stylesheet" href="../css/linearicons.css">
		<link rel="stylesheet" href="../css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../css/magnific-popup.css">
		<link rel="stylesheet" href="../css/nice-select.css">							
		<link rel="stylesheet" href="../css/animate.min. css">
		<link rel="stylesheet" href="../css/owl.carousel.css">
		<link rel="stylesheet" href="../css/main.css">
		<style>
			@media (max-width: 768px) {
			  .float-left-sm {
				float: left;
			  }
			}
			@media (min-width: 769px) {
			  .float-right {
				float: right;
			  }
			}
			.add-button {
			  position: absolute;
			  top: 1px;
			  left: 1px;
			}
			.hidden {
			  display: none !important;
			}
			.login-btn a{
				color:  background: #13247E;
			}
			.login-label{
				color: #1D2C4D;
				font-family: Montserrat;
				font-size: 36px;
				font-weight: 500;
				line-height: 44px;
				letter-spacing: 0em;
				text-align: left;
			}
			#installContainer {
			  position: absolute;
			  bottom: 1em;
			  display: flex;
			  justify-content: center;
			  width: 100%;
			}

			#installContainer button {
			  background-color: inherit;
			  border: 1px solid white;
			  color: white;
			  font-size: 1em;
			  padding: 0.75em;
			}
			img#family-img {
			    width: 500px;
			}
			img.this-for-col-img {
			    width: 90%;
			}
		</style>
	</head>
	<body>	
			<section class="banner-area" id="home">
				<div class="container">
                <header id="header" id="home">
			    <div class="main-menu">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="index.php"><img src="../img/logo.png" alt="" title="" /></a><br>
						<!--<small class="text-muted"><i>Ensuring exceptional service delivery for less</i></small>-->
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav">
						  <!-- <li class="nav-item login-btn"><a href="login.php">LOG IN</a></li> -->
						  <!-- <li class="nav-item menu-active get-started-btn"><a href="login.php">LOGIN</a></li> -->
						</ul>
				      </nav>			  
			    	</div>
			    </div>
			  </header><!-- #header --><br><br><br>
					<div class="fullscreen d-flex align-items-center wall-paper">
						<div class="banner-content col-lg-8 col-md-6 justify-content-center ">
							<h1>
								Book a <?php echo $room_type; ?>		
							</h1>
							<p class="description-o">
								Experience a harmonious living environment where convenience, security, and community converge seamlessly.
							</p>
						</div>	
					</div>
					<!-- <br><br><br><br> -->
				</div>
			</section>
            <div class="body-wrapper">

			<!-- Start discount-section Area -->
			<section class="discount-section-area relative">
				<div class="row">
					<!-- <div class="row pt-5 pl-5">
						<div class="col-md-9 this-for">
							<h1>Book a room</h1>
							<p class="mt-5">
								...
							</p>
						</div>
					</div> -->
					<div class="row p-5">
						<?php $j=1; include ('db.php');  include ('functions.php');  
              $sql = "SELECT *, h.Name hotel_name,t.Name type_name,t.price_per_night price FROM room JOIN hotel h using(hotel_id) JOIN room_type t using(type_id)"; $result = $con->query($sql);
              if ($result->num_rows > 0) { 
                while($row = $result->fetch_assoc()) { ?>
								<div class="col-md-6 mb-5 pr-3 this-for-col">
									<img src="./../img/3970.png" class="this-for-col-img" />
									<h4 class="pt-4 pb-4 pr-4"><?php echo $row['type_name']; ?></h4>
									<!-- Deluxe Room -->
									<?php $hotel = $row['hotel_name']; ?>
                  <p>Hotel: <?php echo $hotel; ?></p>
                  <p>Description: <?php echo $row['Description']; ?></p>
                  <h5 class="pb-4 "><?php echo currency_format($row['price']); ?></h5>
                  <!-- <button type="button" class="primary-btn add-btn btn btn-green btn-green-rd" data-bs-toggle="modal" data-bs-target="#bookroom">Book Room</button> -->
								</div>
            <?php } ?> 
						<div class="col-md-6 mb-5 pr-2 this-for-col">
							<form  method="POST" action="">
                              <div class="mb-3">
                                <label for="name" class="form-label">First name</label>
                                <input type="text" name="fname" placeholder="Jane" class="form-control">
                                <input type="hidden" name="task" value="book">
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
                                <label for="email" class="form-label">Checkin Date</label>
                                <input type="date" min="<?php echo date("Y-m-d"); ?>" name="checkin_date" class="form-control">
                                <input type="hidden" name="task" value="book">
                              </div>    
                              <div class="mb-3">
                                <label for="email" class="form-label">Checkout Date</label>
                                <input type="date" min="<?php echo date("Y-m-d"); ?>" name="checkout_date" class="form-control">
                              </div>                                            
                              <div class="mb-3">
                                <button type="submit" class="btn btn-outline-success">Book Room</button>
                              </div>
                            </form>
						</div>
						<?php } 
						  else { echo "<br><div class='alert alert-primary' role='alert'>Sorry, you cannot book a room now.</div>"; }
                        ?>
					</div>
				</div>	
			</section>
			<!-- End discount-section Area -->
			
			<!-- Start work-process Area -->
			<section class="work-process-area pt-20 pb-20">
			<div class="container main-menu">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="index.php"><img src="../img/logo.png" height="40px" alt="" title="" /></a><br>
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu footer">
						  <li class="menu-active"><a href="index.php">Home</a></li>
				          <li><a href="#">Terms and Conditions</a></li>						          
			              <li><a href="#">Privacy Policy</a></li>			          
				          <li><a href="#">FAQ</a></li>
				        </ul>
				      </nav>
					</div>
			    </div>
			</section>
            </div>
		<?php include('../footer.php'); ?>