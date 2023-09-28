<?php function auto_copyright($year = 'auto'){
	if(intval($year) == 'auto'){ $year = date('Y'); } 
	if(intval($year) == date('Y')){ echo intval($year); } 
	if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); } 
	if(intval($year) > date('Y')){ echo date('Y'); } 
 } ?>
<footer class="footer">
                &copy; <?php auto_copyright("2018"); ?> <i class="mdi mdi-settings text-info"></i> Managerr
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <!--Morris Chart-->
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/plugins/raphael/raphael-min.js"></script>
    <script src="assets/pages/dashborad.js"></script>
    <!-- App js -->
    <script src="assets/js/app.js"></script>
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
	</script>
</body>