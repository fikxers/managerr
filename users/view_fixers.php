<?php require('auth.php'); 
	  $title ='Fikxers'; 
	  require('../db.php');
	  if (isset($_POST['fixer_name'])){
	  $fixer_name = stripslashes($_REQUEST['fixer_name']);
	  
	  if($_SESSION['admin_type']=='admin'){
		$estate_code = stripslashes($_REQUEST['estate_code']); 
	  }
	  else if($_SESSION['admin_type']=='mgr'){
		$estate_code = $_SESSION['estate'];
	  }
	  else if($_SESSION['admin_type']=='hmgr'){
		$estate_code = $_SESSION['hostel'];
	  }
	  $address = stripslashes($_REQUEST['address']);
	  $skill = stripslashes($_REQUEST['skill']);
	  $skill2 = stripslashes($_REQUEST['skill2']);
	  $skill3 = stripslashes($_REQUEST['skill3']);
	  $status = stripslashes($_REQUEST['status']);
	  $phone = stripslashes($_REQUEST['phone']);
	  $email = stripslashes($_REQUEST['email']);
	  $password = stripslashes($_REQUEST['password']);
	  $password2 = stripslashes($_REQUEST['rpassword']);
	  if(trim($password)=='' || trim($password2)=='')
	  {
		echo('All fields are required!');
		header('Location: view_fixers.php');
	  }
	  else if($password != $password2)
	  {
		echo('Passwords do not match!');
		header('Location: view_fixers.php');
	  }
	  else{
		$password = mysqli_real_escape_string($con,$password);
		if( ! ini_get('date.timezone') )
		{
		  date_default_timezone_set('Africa/Lagos');
		}
		$trn_date = date("Y-m-d H:i:s");
		//b4 insert, check if exists
	    $query = "INSERT into `fixers` (name, skill,skill2,skill3,status, phone, email, home_address, estate, created_at) VALUES ('$fixer_name', '$skill','$skill2','$skill3','$status', '$phone', '$email', '$address', '$estate_code', '$trn_date')";
		$query2 = "INSERT into `users` (email, password, admin_type) VALUES ('$email', '".md5($password)."', 'fixer')";
	    $result = mysqli_query($con,$query);
		$result2 = mysqli_query($con,$query2);
		if($result && $result2){
		  echo "<script>alert('Fikxer added successfully.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_fixers.php';</script>"; exit;
		}
		else{
		  echo "<script>alert('Error adding Fikxer.');</script>";
		  echo "<script type='text/javascript'>window.top.location='view_fixers.php';</script>"; exit;
		}
	  }
	  }
	  else{
		//echo "<script>alert('Error');</script>";
		  if($_SESSION['admin_type']=='admin'){
		   include('admin_sidebar.php'); 
		  }
	      else if($_SESSION['admin_type']=='mgr'){
		   include('mgr_sidebar.php');
		  }
		  else if($_SESSION['admin_type']=='hmgr'){
		   include('hmgr_sidebar.php');
		  }
		?>
		<div class="row">       
			<div class="col-lg-12">
        <div class="card m-b-30">
    	    <div class="card-body">
            <h4 class="mt-0 header-title">All Fikxers</h4>
					  <span style="float: right"><button type='button' class='btn text-dark btn-dark btn-sm' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#fikxermodal' data-original-title='Add Fikxer'><i class="fa fa-user-plus m-r-10 m-b-10"></i><b>Add Fikxer</b></button></span>
				  	<!--<span style="float: right"><a data-toggle="modal" data-target="#fikxermodal" data-original-title="Add Fikxer"><i class="fa fa-user-plus text-dark m-r-10 m-b-10"> <b>Add Fikxer</b></i></a></span>-->
            <div class="table-rep-plugin">
              <div class="table-responsive b-0" data-pattern="priority-columns">
               <?php include ('../db.php');
								$sql = "SELECT * FROM fixers";
								if($_SESSION['admin_type']=='mgr'){
								  $sql = "SELECT * FROM fixers where estate='".$_SESSION['estate']."'";
								}$result = $con->query($sql);
								if ($result->num_rows > 0) { ?>
								<table id="tech-companies-1" class="table table-bordered table-striped">
			            <thead><tr class="titles"><th>Name</th><th>Skill</th><th>Skill #2</th><th>Skill #3</th><th>Phone</th><th>Status</th> <?php if($_SESSION['admin_type']=='admin'){echo "<th>Estate</th>";} ?>  <th colspan="2">Action</th></tr></thead>
								  <tbody> <?php while($row = $result->fetch_assoc()) { 
										echo "<tr><td>". $row['name']. "</td>";	
										echo "<td>". $row['skill']. "</td>";
										echo "<td>". $row['skill2']. "</td>";
										echo "<td>". $row['skill3']. "</td>";
										echo "<td>". $row['phone']. "</td>";
										echo "<td>". $row['status']. "</td>";
										if($_SESSION['admin_type']=='admin'){echo "<td>". $row['estate']. "</td>";}
										  echo "<td><a href='update_fixer.php?id=" .$row['email']."&phone=" .$row['phone']."' data-toggle='tooltip' data-original-title='Update'><i class='fa fa-pencil text-success m-r-10'></i></a><a href='delete_fixer.php?id=" . $row['email'] . "' data-toggle='tooltip' data-original-title='Delete'><i class='fa fa-trash text-danger m-r-10'></i></a> </td></tr>"; }
										} else { echo "No Fikxer in database."; } $con->close(); ?>
			            </tbody>
			          </table>
          		</div>
				 		</div>
          </div>
        </div>
      </div> <!-- end col -->
			 <!-- Modal -->
			 <div class="modal fade" id="fikxermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
				  <div class="modal-content">
				    <div class="modal-header">
					  <h5 class="modal-title" id="exampleModalLongTitle">Add Fikxer</h5>
					  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>
					<div class="modal-body">
					   <form class="" action="" method="POST">
						<div class="form-group">
						  <input type="text" name="fixer_name" class="form-control" required placeholder="Name of Fikxer"/></div>
							<?php  if($_SESSION['admin_type']=='admin'){
							include('estate_div.php'); } ?>
						<div class="form-group">
						  <input type="text" name="address" class="form-control" required placeholder="Home address"/> </div>
						<div class="form-group">
						  <select class="form-control" required name="skill" >
							<option value="">Choose Skill</option>
							<option value="Generator Repairs">Generator Repairs</option><option value="Air Conditioner">Air Conditioner</option>	<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
							<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option><option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
						  </select>
						</div>
						<div class="form-group">
						  <select class="form-control" name="skill2" >
							<option value="">2nd Skill (Optional)</option>				<option value="Generator Repairs">Generator Repairs</option><option value="Air Conditioner">Air Conditioner</option>	<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
							<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option><option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
						  </select>
						</div>
						<div class="form-group">
						  <select class="form-control" name="skill3" >
							<option value="">3rd Skill (Optional)</option>				<option value="Generator Repairs">Generator Repairs</option><option value="Air Conditioner">Air Conditioner</option>	<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
							<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option><option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
						  </select>
						</div>
						<div class="form-group">
						  <div><input name="phone" type="text" class="form-control" required placeholder="Phone"/></div>
						</div> 
						<div class="form-group">
						  <div><input name="email" type="text" class="form-control" required placeholder="Email"/></div>
						</div>
						<div class="form-group">
						  <div><input name="password" type="password" class="form-control" required placeholder="Password"/></div>
						</div> 
						<div class="form-group">
						  <div><input name="rpassword" type="password" class="form-control" required placeholder="Repeat password"/></div>
						</div>
						<div class="form-group">
						  <select class="form-control" required name="status" >
							<option value="">Status</option>						
							<option value="available">Available</option> <option value="occupied">Occupied</option><option value="holiday">On holiday</option><option value="suspended">Suspended</option><option value="trial">On trial</option>
						  </select>
						</div>
						<div class="form-group">
						  <div><button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button><button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button></div>
						</div>
					  </form>
					</div>
				  </div>
				</div>
			  </div>			  
			  <!-- <div class="col-lg-12">
                <div class="card m-b-30">
                  <div class="card-body">
                  <h4 class="mt-0 header-title">Add Fikxer</h4>
                  <form class="" action="" method="POST">
                    <div class="form-group">
                      <input type="text" name="fixer_name" class="form-control" required placeholder="Name of Fikxer"/></div>
						<?php  if($_SESSION['admin_type']=='admin'){
					  	include('estate_div.php'); } ?>
					<div class="form-group">
                      <input type="text" name="address" class="form-control" required placeholder="Home address"/> </div>
					<div class="form-group">
					  <select class="form-control" required name="skill" >
						<option value="">Choose Skill</option>
						<option value="Generator Repairs">Generator Repairs</option><option value="Air Conditioner">Air Conditioner</option>	<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
						<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option><option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
					  </select>
					</div>
					<div class="form-group">
					  <select class="form-control" name="skill2" >
						<option value="">2nd Skill (Optional)</option>				<option value="Generator Repairs">Generator Repairs</option><option value="Air Conditioner">Air Conditioner</option>	<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
						<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option><option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
					  </select>
					</div>
					<div class="form-group">
					  <select class="form-control" name="skill3" >
						<option value="">3rd Skill (Optional)</option>				<option value="Generator Repairs">Generator Repairs</option><option value="Air Conditioner">Air Conditioner</option>	<option value="Inverter Repairs">Inverter Repairs</option><option value="Mobile Phone Repairs">Mobile Phone Repairs</option><option value="Computer & Laptop">Computer & Laptop</option><option value="CCTV Repairs">CCTV Repairs</option><option value="Gas Appliances">Gas Appliances</option><option value="Plumbing">Plumbing</option><option value="Refrigeration Repairs">Refrigeration Repairs</option>
						<option value="Packers & Movers">Packers & Movers</option><option value="Cleaning">Cleaning</option><option value="Real Estate">Real Estate</option><option value="Electrician">Electrician</option><option value="Fumigation">Fumigation</option><option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Painting">Painting</option><option value="Carwash and detailing">Carwash and detailing</option>					
					  </select>
					</div>
					<div class="form-group">
                      <div><input name="phone" type="text" class="form-control" required placeholder="Phone"/></div>
                    </div> 
					<div class="form-group">
                      <div><input name="email" type="text" class="form-control" required placeholder="Email"/></div>
                    </div>
					<div class="form-group">
                      <div><input name="password" type="password" class="form-control" required placeholder="Password"/></div>
                    </div> 
					<div class="form-group">
                      <div><input name="rpassword" type="password" class="form-control" required placeholder="Repeat password"/></div>
                    </div>
					<div class="form-group">
					  <select class="form-control" required name="status" >
						<option value="">Status</option>						
						<option value="available">Available</option> <option value="occupied">Occupied</option><option value="holiday">On holiday</option><option value="suspended">Suspended</option><option value="trial">On trial</option>
					  </select>
					</div>
                    <div class="form-group">
                      <div><button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button><button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button></div>
                    </div>
                  </form>
                  </div>
                </div>
              </div>--> <!-- end col -->
            </div><!-- container -->
		  </div><!-- Page content Wrapper -->
		</div><!-- content -->
		<?php include('footer.php');  } ?>
</html>