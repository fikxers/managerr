<?php
session_start();
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $name = "";
            if (isset($column[0])) {
                $name = mysqli_real_escape_string($conn, $column[0]);
            }
            $email = "";
            if (isset($column[1])) {
                $email = mysqli_real_escape_string($conn, $column[1]);
            }
            $phone = "";
            if (isset($column[2])) {
                $phone = mysqli_real_escape_string($conn, $column[2]);
            }
            $gender = "";
            if (isset($column[3])) {
                $gender = mysqli_real_escape_string($conn, $column[3]);
            }
            $password = "";
            if (isset($column[4])) {
                $password = md5(mysqli_real_escape_string($conn, $column[4]));
            }
            $room_no = "";
            if (isset($column[5])) {
                $room_no = mysqli_real_escape_string($conn, $column[5]);
            }
            $price = "";
            if (isset($column[6])) {
                $price = mysqli_real_escape_string($conn, $column[6]);
            }
            if( ! ini_get('date.timezone') )
            {
                date_default_timezone_set('Africa/Lagos');
            }
            $trn_date = date("Y-m-d H:i:s");
            $sqlInsert = "INSERT INTO residents(room_no, hostel, fee, full_name, email, phone, gender, date_joined) VALUES (?,?,?,?,?,?,?,?)";
            $paramType = "isdsssss"; //$paramType = "issss";
            $paramArray = array(
                $room_no, $_SESSION['hostel'],
                $price, $name, $email, $phone,
                $gender, $trn_date
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);

            $admin_type = "student";
            $sqlInsert = "INSERT INTO users(email, password, admin_type) VALUES (?,?,?)";
            $paramType = "sss"; //$paramType = "issss";
            $paramArray = array(
                $email, $password, $admin_type
            );
            $insertId2 = $db->insert($sqlInsert, $paramType, $paramArray);

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
    echo "<script type='text/javascript'>window.top.location='../add_resident.php';</script>"; exit;
}
?>
<!DOCTYPE html>
<html>

<head>
<script src="jquery-3.2.1.min.js"></script>

<style>
body {
    font-family: Arial;
    width: 800px;
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
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Import</button>
                    <br />
                </div>
            </form>
            <form class="form-horizontal" action="" method="post">
                <div class="input-row">
                    <button type="submit"class="col-md-12 control-label" name="home"
                        class="btn-submit">Home</button>
                    <br />
                </div>
            </form>
        </div>
        <label class="control-label">Sample Table <b><em>(To be uploaded without the headings!!!)</em></b></label>
        <table id='userTable'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Password</th>
                    <th>Room No</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Akpan Bassey</td>
                    <td>akbass@ymail.com</td>
                    <td>09011223344</td>
                    <td>Male</td>
                    <td>1234Abassey</td>
                    <td>11</td>
                    <td>100000</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>