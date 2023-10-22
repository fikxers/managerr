<?php 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "zk";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	if (!mysqli_set_charset($conn, "utf8")) {
		printf("Error loading character set utf8: %s\n", mysqli_error($conn));
		exit();
	} else {
		printf("Current character set: %s\n", mysqli_character_set_name($conn));
	}
	echo 'connected';
?>