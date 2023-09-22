<?php
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $userId = "";
            if (isset($column[0])) {
                $userId = mysqli_real_escape_string($conn, $column[0]);
            }
            $userName = "";
            if (isset($column[1])) {
                $userName = mysqli_real_escape_string($conn, $column[1]);
            }
            $password = "";
            if (isset($column[2])) {
                $password = mysqli_real_escape_string($conn, $column[2]);
            }
            $firstName = "";
            if (isset($column[3])) {
                $firstName = mysqli_real_escape_string($conn, $column[3]);
            }
            $lastName = "";
            if (isset($column[4])) {
                $lastName = mysqli_real_escape_string($conn, $column[4]);
            }
            
            $sqlInsert = "INSERT into users (userId,userName,password,firstName,lastName)
                   values (?,?,?,?,?)";
            $paramType = "issss";
            $paramArray = array(
                $userId,
                $userName,
                $password,
                $firstName,
                $lastName
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
?>
<h2>Import CSV file into Mysql using PHP</h2>
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
        </div>
               <?php require('../db.php');
            $sqlSelect = "SELECT * FROM inventory";
            //$result = $con->select($sqlSelect);
            $result = mysqli_query($con,$sqlSelect);
            if (! empty($result)) {
                ?>
            <table id='userTable'>
            <thead>
                <tr>
                    <th>Part</th>
                    <th>Quantity</th>
                    <th>Hostel</th>
                </tr>
            </thead>
<?php
                
                foreach ($result as $row) {
                    ?>
                    
                <tbody>
                <tr>
                    <td><?php  echo $row['part']; ?></td>
                    <td><?php  echo $row['qty']; ?></td>
                    <td><?php  echo $row['hostel']; ?></td>
                </tr>
                    <?php
                }
                ?>
                </tbody>
        </table>
        <?php } ?>
    </div>



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