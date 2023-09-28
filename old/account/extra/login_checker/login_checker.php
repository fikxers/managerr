<?php
	/* Login Checker Script */
	/*
		This script can be used in your other files to check to make sure a user
		is logged in. 

		You just need to make sure that the file you add this script to is a 
		PHP file. If you have a HTML file, you can simply rename it with the 
		.php extension.

		If you include this file from another directory, you'll need to uncomment
		the $system_path and $application_folder lines.

	*/

 	ob_start();
 	define("REQUEST", "external");

 	/* Directory paths
		Only change these if your files are outside the original directory
		of the application. Use ../ for each folder you are out by.

		By default, it uses the original CodeIgniter values.
 	*/
	// $system_path = "../system";
	// $application_folder = "../application";

    include('index_check.php');
    ob_end_clean();
    $CI =& get_instance();

    if(!$CI->user->loggedin) {
    	redirect(site_url("login"));
    }
?>