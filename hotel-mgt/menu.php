 <!--Menu-->
 <li> <a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
 <?php if($_SESSION['admin_type'] == 'admin'){ ?>
 <li><a href="hotels.php"><i class="fas fa-hotel"></i> Hotels</a></li>
 <li><a href="managers.php"><i class="fas fa-user-tie"></i> Managers</a></li>
 <?php } ?>
 <li><a href="rooms.php"><i class="fas fa-building"></i> Room Mgt</a></li>
 <li><a href="guests.php"><i class="fas fa-users"></i> Guests</a></li>
 <li><a href="bookings.php"><i class="fas fa-receipt"></i> Bookings</a></li>
 <li><a href="payments.php"><i class="fas fa-wallet"></i> Payments</a></li>
 <!--Menu-->