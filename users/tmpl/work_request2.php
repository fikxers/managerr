<?php echo '<!-- Modal -->
															<div class="modal hide" id="ordermodal'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="ordermodal'.$row['id'].'" aria-hidden="true" style="z-index: 1500;">
																<div class="modal-dialog modal-dialog-centered" role="document">
																  <div class="modal-content">
																	<div class="modal-header">
																	  <h5 class="modal-title" id="ordermodal'.$row['id'].'">Raise Work Request</h5>
																	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	  </button>
																	</div>
																	<div class="modal-body">
																		<form class="" action="upload.php" method="POST" enctype="multipart/form-data">
																		  <div class="form-group">
																			<div class="form-group">
																			  <label>Asset: </label> '.$row['name'].'
																			</div> <input type="hidden" name="equipment" value="'.$row['name'].'">
																			<div class="form-group">
																			  <select class="form-control" name="service" >
																				<option value="">Select Service</option>
																				<option value="Packers and Movers">Packers and Movers</option>
																				<option value="Cleaning">Cleaning</option>
																				<option value="Real Estate">Real Estate</option>
																				<option value="Electrician">Electrician</option>
																				<option value="Fumigation">Fumigation</option>
																				<option value="Painter">Painter</option>
																				<option value="Interior decoration">Interior decoration</option><option value="Laundry & dry cleaning">Laundry & dry cleaning</option><option value="Carwash and detailing">Carwash and detailing</option>
																				<option value="Carpenter">Carpenter</option>
																				<option value="Electronics">Electronics</option>
																				<option value="Pickup and deliver item from Gate">Pickup and deliver item from Gate</option>
																				<option value="Purchase Gas">Purchase Gas</option><option value="School runs">School runs</option>
																				<option value="Errands">Errands</option><option value="Others">Others</option>
																			 </select>
																			</div>
																			<div class="form-group">
																			  <label>Start Date</label>
																			  <input type="date" name="date" class="form-control" required placeholder="Choose Date">
																			  <!--<input type="datetime-local">-->
																			</div>
																			<!--<div class="form-group">
																			  <label>Expected Completion Date</label>
																			  <input type="date" name="cdate" class="form-control" required placeholder="Choose Date">
																			</div>-->
																			<div class="form-group">
																			  <div class="col-lg-6 form-check">
																			   <input type="radio" class="form-check-input" name="addqr" id="addqr">
																			   <label class="form-check-label" for="addqr">Anytime</label>
																			  </div>
																			  <div class="col-lg-6 form-check">
																			   <input type="radio" class="form-check-input" name="addqr" id="addqr2">
																			   <label class="form-check-label" for="addqr2">8am to 12pm</label>
																			  </div>
																			  <div class="col-lg-6 form-check">
																			   <input type="radio" class="form-check-input" name="addqr" id="addqr3">
																			   <label class="form-check-label" for="addqr3">12 to 4pm</label>
																			  </div>
																			  <div class="col-lg-6 form-check">
																			   <input type="radio" class="form-check-input" name="addqr" id="addqr4">
																			   <label class="form-check-label" for="addqr4">4 to 8pm</label>
																			  </div>
																			</div>
																			<div class="form-group">
																			  <input type="textarea" name="description" class="form-control" placeholder="Description e.g I want to move from Lekki to Ajah"/>
																			</div>
																			
																		  </div>
																		  <div class="form-group">
																			<input type="file" class="form-control" name="files[]" multiple >
																		  </div>
																		  <div class="form-group">
																			<div><button type="submit" name="submit" class="btn btn-primary waves-effect waves-light">Submit</button><button type="reset" class="btn btn-secondary waves-effect m-l-5">Clear Form</button></div>
																		  </div>
																		</form>
																	</div>
																  </div>
																</div>
															</div>
															<!-- Modal -->'; ?>