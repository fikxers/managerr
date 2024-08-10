<?php require('auth.php'); $title ='Inventory'; ?>

    <?php include('hmgr_sidebar.php'); ?>
    <?php
		  require('../db.php');
		  if (isset($_POST['add'])){
			$mat = stripslashes($_REQUEST['mat']);
			$qty = stripslashes($_REQUEST['qty']);			
			$query = "INSERT INTO `inventory`(`part`, `qty`,`hostel`) VALUES ('".$mat."',$qty,'".$_SESSION['hostel']."')";
			$result = mysqli_query($con,$query);
			if($result){
			  echo "<script>alert('Material added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='inventory.php';</script>"; exit;
			}
			else{
			  echo "<script>alert('Material not added.');</script>";
			  echo "<script type='text/javascript'>window.top.location='inventory.php';</script>"; exit;
			}
		  }
		  else{
			//echo "<script>alert('Error');</script>";

		?>
        <div class="row">
		  <div class="col-lg-12">
            <div class="card m-b-30">
              <div class="card-body">
                <!--<h4 class="mt-0 header-title">View Rooms</h4>-->
                <form class="" action="" method="POST">
                  <div class="row">
                  	<div class="col-md-4 form-group"><input type="text" name="mat" class="form-control" required placeholder="Item"/></div>
                    <div class="col-md-4 form-group"><input type="number" name="qty" min="1" step="1" class="form-control" required placeholder="Quantity"/></div>
					<div class="col-md-4 form-group">
					  <input type="submit" name="add" value="Add" class="btn btn-primary">
					  <input type="reset" value="Reset" class="btn btn-info">
					  <a href="import-csv/inventory.php" class="btn btn-success" role="button">Upload CSV</a>
					</div>
				  </div>
                </form>
                <div class="table-rep-plugin">
                  <div class="table-responsive b-0" data-pattern="priority-columns">
                  <?php include ('../db.php');
					$sql = "SELECT * FROM inventory where hostel = '".$_SESSION['hostel']."'";
					$result = $con->query($sql);
					if ($result->num_rows > 0) { ?>
					  <table id="tech-companies-1" class="table table-bordered table-striped m-b-0">
                        <thead>
                          <tr class="titles">
                          	<th>Item</th><th>Quantity</th><th>Action</th>
							<?php if($_SESSION['admin_type']=='admin'){echo 'Estate';} ?>
                          </tr>
                        </thead>
                        <tbody> <?php
						while($row = $result->fetch_assoc()) { ?>
						<tr><td><?php echo $row['part']; ?></td>
							<td><?php echo $row['qty']; ?></td>
							<?php echo "<td>"."<a href='update-inventory.php?id=" . $row['id'] . "&op=1' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-check-square text-success m-r-10'></i></a> "."<a href='update-inventory.php?id=" . $row['id'] . "&op=2' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a></td>"; ?>
							<?php if($_SESSION['admin_type']=='admin'){echo '<td>'.$row['estate'].'</td>';} ?>
						</tr> <?php }
								} else { echo "Please add equipments.";
							} $con->close(); ?>
						</tbody>
                      </table>
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