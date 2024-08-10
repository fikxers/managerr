<?php 
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    require('auth.php'); $title ='Search Results'; ?>

    <?php include('hmgr_sidebar.php'); require('../db.php');
      $search = $_POST['search']; $column = $_POST['column']; $table = $_POST['table'];
      if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
      } else {
        $page_no = 1;
      }

      $total_records_per_page = 10;
      $offset = ($page_no-1) * $total_records_per_page;
      $previous_page = $page_no - 1;
      $next_page = $page_no + 1;
      $adjacents = "2"; 
      $sql = "select COUNT(*) As total_records from $table where hostel = '".$_SESSION['hostel']."' AND $column like '%$search%'";
      $result_count = mysqli_query($con,$sql);
      //echo  $sql; echo $searchroom;
      $total_records = mysqli_fetch_array($result_count);
      $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
      $second_last = $total_no_of_pages - 1; // total page minus 1
      $result = mysqli_query($con,"SELECT * FROM $table where hostel = '".$_SESSION['hostel']."' AND $column like '%$search%'  LIMIT $offset, $total_records_per_page");

	  if (isset($_POST['send4quotes'])){
		$description = stripslashes($_REQUEST['description']);
		$skill = stripslashes($_REQUEST['skill']);			
		$service_id = stripslashes($_REQUEST['service_id']);
		$query = "UPDATE orders SET required_skill = '$skill', order_status = 'quote_requested', mgr_description='$description' WHERE order_id=$service_id";
		$result = mysqli_query($con,$query);
		if($result){
		  echo "<script>alert('Quote requested.');</script>";
		  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Quote Request not successful.');</script>";
		  echo "<script type='text/javascript'>window.top.location='estate_mgr.php';</script>"; exit;
		}
	   }else{
			//echo "<script>alert('Error');</script>";
		?>
        <div class="row">
		  <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
					         if (mysqli_num_rows($result) != 0) {//if ($result->num_rows > 0) { ?>
					           <table id="tech-companies-1" class="table table-bordered table-striped m-b-0">
                        <thead>
                          <tr class="titles">
                            <?php
                          	 if($table == 'residents'){echo '<th>Room No.</th><th>Fee</th><th>Resident</th><th>Email</th><th>Phone</th><th>Gender</th><th>Action</th>';}
                             else if($table == 'hostel_assets'){echo '<th>Name of Asset</th><th>Status</th><th>Location</th><th>Action</th>';}
                            ?>
                          </tr>
                        </thead>
                        <tbody> <?php $i=1;
            						while($row = $result->fetch_assoc()) { 
                          if($table == 'residents'){
                            echo "<tr><td>".$row['room_no']."</td>"; 
                            echo "<td>&#8358;".number_format($row['fee'])."</td>";  
                            echo "<td>".$row['full_name']."</td>"; 
              							echo "<td>".$row['email']."</td>"; 
                            echo "<td>".$row['phone']."</td>"; 
                            echo "<td>".$row['gender']."</td>"; 
                            echo "<td>"."<a href='resident-update.php?id=" . $row['id'] . "&n=". $row['full_name'] ."&e=". $row['email'] ."' data-toggle='tooltip' data-original-title='Update Resident'><i class='fa fa-check-square text-success m-r-10'></i></a> </td></tr>";  }
                          else if($table == 'hostel_assets'){
                            echo "<tr><td>".$row['name']."</td>";  
                            echo "<td>".$row['status']."</td>";
                            echo "<td>".$row['location']."</td>";
                            echo "<td>"."<a href='update-asset.php?id=" . $row['id'] . "&op=1&st=". $row['status'] ."&l=". $row['location'] ."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-check-square text-success m-r-10'></i></a> "."<a href='update-asset.php?id=" . $row['id'] . "&op=2' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a></td></tr>";
                          }
                        }
            					} else { echo "No search result";
            					} $con->close(); ?>
            						</tbody>
                      </table>
                      <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                      <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
                      </div>
                      <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item" <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
                        <a class="page-link" <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
                        </li>
                             
                          <?php 
                        if ($total_no_of_pages <= 10){     
                          for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                            if ($counter == $page_no) {
                             echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";  
                              }else{
                                 echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                              }
                              }
                        }
                        elseif($total_no_of_pages > 10){
                          
                        if($page_no <= 4) {     
                         for ($counter = 1; $counter < 8; $counter++){     
                            if ($counter == $page_no) {
                             echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";  
                              }else{
                                 echo "<li class='page-item'><a href='?page_no=$counter'>$counter</a></li>";
                              }
                              }
                          echo "<li class='page-item'><a class='page-link'>...</a></li>";
                          echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                          echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                          }

                         elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {     
                          echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
                          echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
                              echo "<li class='page-item'><a class='page-link'>...</a></li>";
                              for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {     
                                 if ($counter == $page_no) {
                             echo "<li class='active'><a class='page-link'>$counter</a></li>";  
                              }else{
                                 echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                              }                  
                             }
                             echo "<li class='page-item'><a class='page-link'>...</a></li>";
                           echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
                           echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
                                  }
                          
                          else {
                              echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
                          echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
                              echo "<li class='page-item'><a class='page-link'>...</a></li>";

                              for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                if ($counter == $page_no) {
                             echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";  
                              }else{
                                 echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                              }                   
                                      }
                                  }
                          }
                        ?>
                          
                        <li class="page-item" <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
                        <a class="page-link" <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
                        </li>
                          <?php if($page_no < $total_no_of_pages){
                          echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                          } ?>
                      </ul>
                    </nav>
                    </div>
				</div>
              </div>
            </div>
          </div> <!-- end col -->
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