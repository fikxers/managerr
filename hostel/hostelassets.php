<?php require('auth.php'); $title ='Assets'; ?>

    <?php include('hmgr_sidebar.php'); require('../db.php'); 
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

      $result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM `hostel_assets`");
      $total_records = mysqli_fetch_array($result_count);
      $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
      $second_last = $total_no_of_pages - 1; // total page minus 1

      $result = mysqli_query($con,"SELECT * FROM `hostel_assets` LIMIT $offset, $total_records_per_page");
    ?>
      <div class="row">
		    <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <!--<h4 class="mt-0 header-title">View Rooms</h4>-->
                <form class="row" action="search_results.php" method="post">
                  <div class="form-group col-md-2"><input type="text" placeholder="Search for" name="search" class="form-control form-control-sm" /></div>
                  <div class="form-group col-md-2">
                    <select class="form-control form-control-sm" name="column" >
                    <option value="">In</option>
                    <option value="name">Name</option>
                    <option value="status">Status</option>
                    <option value="location">Location</option>
                    </select></div>
                  <input type="hidden" name="table" value="hostel_assets" />
                  <div class="col-md-2 form-group">
                    <input type="submit" value="Search" class="btn btn-block btn-sm btn-primary">
                  </div>
                </form>
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php //include ('../db.php');
        					//$sql = "SELECT * FROM hostel_assets where hostel = '".$_SESSION['hostel']."'";
        					//$result = $con->query($sql);
        					if (mysqli_num_rows($result) > 0) { //if ($result->num_rows > 0) { ?>
        					  <table id="tech-companies-1" class="table editable-table table-bordered table-striped m-b-0">
                        <thead>
                          <tr class="titles">
                          	<th>Name of Asset</th><th>Status</th><th>Location</th><th>Action</th>
							           <?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?>
                          </tr>
                        </thead>
                        <tbody> <?php
            						while($row = $result->fetch_assoc()) { ?>
            						<tr><td><?php echo $row['name']; ?></td>
            							<td><?php echo $row['status']; ?></td>
            							<td><?php echo $row['location']; ?></td>
            							<?php echo "<td>"."<a href='update-asset.php?id=" . $row['id'] . "&op=1&st=". $row['status'] ."&l=". $row['location'] ."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-check-square text-success m-r-10'></i></a> "."<a href='update-asset.php?id=" . $row['id'] . "&op=2' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a></td>"; ?>
            							<?php if($_SESSION['admin_type']=='admin'){echo '<td>'.$row['estate'].'</td>';} ?>
            						</tr> <?php }
            								} else { echo "No available Fikxer.";
            							} $con->close(); ?>
            						</tbody>
                      </table>
                      <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                      <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
                      </div>
                      <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <?php // if($page_no > 1){ echo "<li class='page-item'><a href='?page_no=1'>First Page</a></li>"; } ?>
                          
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

<?php include('footer.php'); ?>
</html>