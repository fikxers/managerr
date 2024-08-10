<?php
/*
https://www.instructables.com/Control-Arduino-using-PHP/
https://github.com/Xowap/PHP-Serial

*/
// include 'php-serial/src/PhpSerial.php';
// $comPort = "COM9"; //$comPort = "/dev/ttyACM0";
// $msg = '';
// if(isset($_POST["hi"])){
//   $serial = new phpSerial;
//   $serial->deviceSet($comPort);
//   $serial->confBaudRate(9600);
//   $serial->confParity("none");
//   $serial->confCharacterLength(8);
//   $serial->confStopBits(1);
//   $serial->deviceOpen();
//   sleep(2); //Unfortunately this is nessesary, arduino requires a 2 second delay in order to receive the message
//   $serial->sendMessage("Well hello!");
//   $serial->deviceClose();
//   $msg = "You message has been sent! WOHOO!";
// }
?>
<!-- <html>
  <head>
	<title>Arduino control</title>
  </head>
  <body>
	<form method="POST">
	  <input type="submit" value="Send" name="hi">
	</form><br>
	<?=$msg?>
  </body>
</html> -->

<!DOCTYPE html>
<html>
<head>
  <title>Arduino Control</title>
</head>
<body>
  <h1>Arduino Control Panel</h1>
  <form action="index.php" method="post">
    <button type="submit" name="action" value="1">Turn On</button>
    <button type="submit" name="action" value="0">Turn Off</button>
  </form>

  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['action'])) {
        $action = $_POST['action'];
        // Open a serial connection to Arduino and send the command
        $serial = fopen('COM9', 'w');  // Change 'COM3' to the appropriate port
        fwrite($serial, $action);
        fclose($serial);
      }
    }
  ?>
</body>
</html>