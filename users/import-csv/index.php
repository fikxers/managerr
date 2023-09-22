<?php
session_start();
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

$flat_no = $block_no = $owner = $email = $phone = $ownership = $password = ""; $meter_pan = ""; 
 if( isset($_SESSION['estate']) ){ $estate_code = $_SESSION['estate']; }

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            if (isset($column[0])) {
                $flat_no= mysqli_real_escape_string($conn, $column[0]);
            }
            if (isset($column[1])) {
                $block_no = mysqli_real_escape_string($conn, $column[1]);
            }
            if (isset($column[2])) {
                $owner = mysqli_real_escape_string($conn, $column[2]);
            }
            if (isset($column[3])) {
                $phone = mysqli_real_escape_string($conn, $column[3]);
            }
            if (isset($column[4])) {
                $email = mysqli_real_escape_string($conn, $column[4]);
            }
			if (isset($column[5])) {
                $pass = mysqli_real_escape_string($conn, $column[5]);
				$password = md5($pass);
            }
            if (isset($column[6])) {
                $meter_pan = mysqli_real_escape_string($conn, $column[6]);
            }
            if (isset($column[7])) {
                $ownership = mysqli_real_escape_string($conn, $column[7]);
            }
			$admin_type = "flat"; $status = 1;
			$sql = "INSERT into users (email,password,admin_type,status) values ('".$email."','".$password."','".$admin_type."',$status)";
			include('../../db.php'); $result2 = mysqli_query($con,$sql);
			
            $sqlInsert = "INSERT into flats (flat_no,block_no,estate_code,phone,email,owner,ownership,meter_pan)
                   values (?,?,?,?,?,?,?,?)";
            //$sqlInsert = "INSERT into hostel_assets (name,userName,password,firstName)
                   //values (?,?,?,?,?)";
            $paramType = "ssssssss"; //$paramType = "issss";
            $paramArray = array(
                $flat_no, 
				$block_no, 
				$estate_code, 
				$phone,
                $email, 
				$owner, 
				$ownership, 
				$meter_pan
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);

			if (! empty($insertId)) {
                $type = "success"; 
				$message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
else if (isset($_POST["home"])) {
    echo "<script type='text/javascript'>window.top.location='../index.php';</script>"; exit;
}
?>
<!DOCTYPE html>
<html>

<head>
<script src="jquery-3.2.1.min.js"></script>

<style>
body {
    font-family: Arial;
    width: 80%; /*550px;*/
}

.outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
}

.input-row {
    margin-top: 0px;
    margin-bottom: 20px;
}

.btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
}

.outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
}

.outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

.outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display: none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });
});
</script>
</head>

<body>
    <h2>Import CSV file</h2>

    <div id="response"
        class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>">
        <?php if(!empty($message)) { echo $message; } ?>
        </div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport"
                enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file"><!--<input type="file" name="file"
                        id="file" accept=".csv">-->
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Import</button>
                    <br />
                </div>
            </form>
            <button id="back" class="btn col-md-12 control-label btn-primary" onclick="history.back()">Go Back</button>
            <br><br>
        </div>
        <label class="control-label">Sample Table <b><em>(To be uploaded without the headings!!!)</em></b></label>
        <table id='userTable'>
            <thead>
              <tr>
                <th>Flat No.</th><th>Block No.</th><th>Name of Resident</th>
                <th>Phone</th><th>Email</th><th>Password</th><th>Meter PAN</th><th>Ownership</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td><td>33</td><td>Polycarp Yakoi</td><td>07026000053</td><td>ypolycarp@yahoo.com</td><td>abcd1234</td><td>14122322348</td><td>Tenant</td>
              </tr>
            </tbody>
        </table>
    </div>

</body>

</html>