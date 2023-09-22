<?php function auto_copyright($year = 'auto'){
	if(intval($year) == 'auto'){ $year = date('Y'); } 
	if(intval($year) == date('Y')){ echo intval($year); } 
	if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); } 
	if(intval($year) > date('Y')){ echo date('Y'); } 
 } ?>
<footer class="footer">
                &copy; <?php auto_copyright("2018"); ?> <i class="mdi mdi-settings text-info"></i> Fikxers
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
	
</body>