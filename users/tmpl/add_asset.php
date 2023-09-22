<form class="" action="" method="POST">
													<div class="form-group">
													  <select class="form-control" name="name" >
													    <option value="">Asset Type</option>
													   <?php require('../db.php'); 
													   $query="select * from asset_type where estate='".$_SESSION['estate']."'"; 
													   $r = $con->query($query);
													   while($row = $r->fetch_assoc()) { 
														  echo '<option value="'.$row['type'].'">'.$row['type'].'</option>'; 
													   } ?>
													   
													   <option value="Appliance">Appliance</option>
													   <option value="Equipment">Equipment</option>
													   <option value="Software">Software</option>
													   <option value="Lighting">Lighting</option>
													   <option value="Safety Equipment">Safety Equipment</option>
													   <option value="Vehicle">Vehicle</option>
													   <option value="Furniture">Furniture</option>
													   <option value="Civil Structure">Civil Structure</option>
													   <option value="House">House</option>
													   <option value="Plumbing">Plumbing</option>
													   <option value="Electrical">Electrical</option>
													   <option value="Others">Others</option>
													   <!--<option value="Generator">Generator</option>
													   <option value="Air Conditioner">Air Conditioner</option>
													   <option value="Inverter">Inverter</option>
													   <option value="Mobile Phone">Mobile Phone</option>
													   <option value="Computer / Laptop">Computer / Laptop</option>
													   <option value="CCTV">CCTV</option>
													   <option value="Gas Appliances">Gas Appliances</option>
													   <option value="Plumbing">Plumbing</option>
													   <option value="Refrigerator">Refrigerator</option>-->
													  </select>
													</div>
													<?php 
													  if($_SESSION['admin_type']=='admin'){
													   include('../flats_div.php'); 
													  }
													?>
													<div class="form-group">
													  <input type="text" name="description" class="form-control" placeholder="Equipment Description"/>
													</div>
													<div class="form-group">
													  <input type="text" name="location" class="form-control" required placeholder="Location in the flat"/>
													</div>
													<div class="form-group">
													  <input type="text" name="brand" class="form-control" placeholder="Brand"/>
													  <input type="text" name="model" class="form-control" placeholder="Model"/>
													  <input type="text" name="size" class="form-control" placeholder="Size"/>
													</div>
													<div class="form-group">
													   <div>
														  <button type="submit" class="btn btn-primary waves-effect waves-light">
																	Submit</button>
														  <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button>
													   </div>
													</div>
												  </form>