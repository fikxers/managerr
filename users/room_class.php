<?php
  class Room{
	float price; 
	int number_of_students,room_no;
	var students[];

	function __construct($num, $p, $s) {
	  this->room_no = num; this->price = p; this->students = s;
	}

	//SET VALUES
	function setRoomNo(int $num){this->room_no = num;}
	function setPrice(float $p){this->price = p;}
	function addStudents($s){this->students = s;}

	//GET VALUES
	function getRoomNo(){return this->room_no;}
	function getPrice(){return this->price;}
	function getStudents(){return this->students;}

	//FUNCTIONS
	function resetPassword($newPassword){
	  require('../db.php');	
	  $query = "UPDATE `orders` SET order_status = 'quote_accepted' where order_id=$order_id";
	  $result = mysqli_query($con,$query);
	  reurn $result;
	}

  }
?>