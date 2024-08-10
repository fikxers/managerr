<?php function auto_copyright($year = 'auto'){
	if(intval($year) == 'auto'){ $year = date('Y'); } 
	if(intval($year) == date('Y')){ echo intval($year); } 
	if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); } 
	if(intval($year) > date('Y')){ echo date('Y'); } 
 } ?>
<footer class="footer">
                &copy; <?php auto_copyright("2018"); ?> <i class="mdi mdi-settings text-info"></i> HAIVEN
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="../users/assets/js/jquery.min.js"></script>
    <script src="../users/assets/js/popper.min.js"></script>
    <script src="../users/assets/js/bootstrap.min.js"></script>
    <script src="../users/assets/js/modernizr.min.js"></script>
    <script src="../users/assets/js/detect.js"></script>
    <script src="../users/assets/js/fastclick.js"></script>
    <script src="../users/assets/js/jquery.slimscroll.js"></script>
    <script src="../users/assets/js/jquery.blockUI.js"></script>
    <script src="../users/assets/js/waves.js"></script>
    <script src="../users/assets/js/jquery.nicescroll.js"></script>
    <script src="../users/assets/js/jquery.scrollTo.min.js"></script>

    <!--Morris Chart-->
    <script src="../users/assets/plugins/morris/morris.min.js"></script>
    <script src="../users/assets/plugins/raphael/raphael-min.js"></script>

    <script src="../users/assets/pages/dashborad.js"></script>
	
	<script src="https://js.paystack.co/v1/inline.js"></script> 
							<script>
							  function payWithPaystack(e) {
								  e.preventDefault();
								  let handler = PaystackPop.setup({
									key: 'pk_live_18871cca91b9d3051c849daa0f9a5e079c8bca21', // Replace with your public key
									//var email = "<?php echo $_SESSION['email']; ?>";
									email: document.getElementById("email-address").value,
									amount: document.getElementById("amount").value * 100,
									//firstname: document.getElementById("first-name").value,
									//lastname: document.getElementById("first-name").value,
									ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
									// label: "Optional string that replaces customer email"
									onClose: function(){
									  alert('Window closed.');
									},
									callback: function(response){
									  let message = 'Payment complete! Reference: ' + response.reference;
									  alert(message);
									}
								  });
								  handler.openIframe();
								}
							</script>

    <!-- App js -->
    <script src="../users/assets/js/app.js"></script>
	
	<script>
	  $( document ).ready(function() {
		$("input[type='radio']").change(function(){
		  if($(this).val()=="Others")
		  {
		   $("#otherAnswer").show();
		  }
		  else
		  {
		   $("#otherAnswer").hide(); 
		  }
		});
	  });
	  $(document).ready(function () {
		$('#example').DataTable();
	  });
	  $(document).on('show.bs.modal', '.modal', function () {
		$(this).appendTo('body');
	  });
	</script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
	<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> 
	<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script> 
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<script>
	 $(document).ready(function () {
	    $('#example').DataTable(); $('#tech-companies-1').DataTable(); $('.table').DataTable(); 
	 }); 
	//  function myFunction() {
	//   // Get the checkbox
	//   var checkBox = document.getElementById("others");
	//   // Get the output text
	//   var text = document.getElementById("text");

	//   // If the checkbox is checked, display the output text
	//   if (checkBox.checked == true){
	//     text.style.display = "block";
	//   } else {
	//     text.style.display = "none";
	//   }
	// }
	$( document ).ready(function() {
		$("input[type='radio']").change(function(){
		  if($(this).val()=="Others")
		  {
		   $("#text").show();
		  }
		  else
		  {
		   $("#text").hide(); 
		  }
		});
	});
	</script>
	
</body>