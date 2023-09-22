<?php
 include('db.php');
 // $sql = "ALTER TABLE entrance_codes MODIFY COLUMN id int AUTO_INCREMENT";
 // "delete from dues where note like '%privileged%'";
 // "create table entrance_codes(id int, code varchar(5), visitor varchar(50), reg_no varchar(10), comp int, primary key (id) )";
 //$sql2 = "alter table student_requests add feedback varchar(1000)";
 // $sql = "alter table orders add image_code varchar(7)";
 // $sql2 = "create table images(image_id int AUTO_INCREMENT, image_code varchar(7), file_name varchar(100), uploaded_on datetime, primary key (image_id) )";
 $sql = "ALTER TABLE `student_requests` ADD `fee` REAL NULL AFTER `feedback`";
 // $sql = "ALTER TABLE `messages` ADD `archived` INT NULL AFTER `message`";
 // $sql2 = "ALTER TABLE messages ALTER archived SET DEFAULT 0";//set all vals to zero
 // $sql3 = "UPDATE messages SET archived = 0";
 $result = $con->query($sql);//$result2 = $con->query($sql2);$result3 = $con->query($sql3);
 if($result){
	echo "SQL1 OK\n";
 // }else{
	// echo 'SQL1 NOT OK';
 // }
 // if($result2){
	// echo "SQL2 OK\n";
 // }else{
	// echo "SQL2 NOT OK\n";
 // }
 // if($result3){
	// echo "SQL3 OK\n";
 }else{
	echo "SQL1 NOT OK\n";
 }
 //echo substr("Hello world",2,8).time()."<br>";


// Query to get columns from table
// $query = $con->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'realeoki_fikxers' AND TABLE_NAME = 'orders'");

// while($row = $query->fetch_assoc()){
//     //$result[] =  
//     echo $row;
// }

// Array of all column names
// $columnArr = array_column($result, 'COLUMN_NAME');
// echo $columnArr;
// // $sql = "SELECT * FROM orders";
// $result = $con->query($sql);

// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     echo "Asset: " . $row["order_name"]. " - Type: " . $row["order_type"]. " - Image: " . $row["image_code"]. "<br>";
//   }
// } else {
//   echo "0 results";
// }
$con->close();
?>

<!--<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
  Select images to upload:
  <input type="file" name="files[]" multiple >
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>-->