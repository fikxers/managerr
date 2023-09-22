<?php
   session_start();
   unset($_SESSION['flat_no']);unset($_SESSION['block_no']);unset($_SESSION['estate']);
   header("Location: ../flash.php");
?>