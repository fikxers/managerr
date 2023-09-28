<h4 class="mt-0 header-title" id="work-requests">Transactions</h4><!--<b>Transactions</b>
<span><button type='button' class='btn btn-primary btn-sm text-primary' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#fikxermodal' data-original-title='Add Fikxer'> <b>Verify Meter</b></button><button type='button' class='btn btn-danger btn-sm text-danger' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#fikxermodal' data-original-title='Add Fikxer'> <b>Vend Credit</b></button></span>-->
<?php if($_SESSION['admin_type'] == 'admin' || $_SESSION['admin_type'] == 'mgr') { 
/*<div style="float: right;"><button type='button' class='btn btn-danger btn-outline btn-sm' data-toggle='modal' data-target='#listmodal' data-original-title='List Meters'>List Meters</button><button class="btn btn-primary">Verify Meter</button><button class="btn btn-danger">Vend Credit</button><br><br></div>*/
$sql = "SELECT sum(amount) as total FROM transactions where estate='".$_SESSION['estate']."'";
$sql2 = "select sum(amount) as total from transactions
       where MONTH(transaction_date) = MONTH(now())
       and YEAR(transaction_date) = YEAR(now()) and estate='".$_SESSION['estate']."'";
$res = $con->query($sql); $values = mysqli_fetch_assoc($res); $total = $values['total'];
$res = $con->query($sql2); $values = mysqli_fetch_assoc($res); $total2 = $values['total'];		
echo '<div class="alert text-dark alert-info" role="alert">Total Electricity Vend: <b>&#8358;'.currency_format($total).'</b>
 | Total Vend This Month: <b>&#8358;'.currency_format($total2).'</b></div>';
 }  ?>
<div class="table-rep-plugin">
    <div class="table-responsive b-0" >
        <?php include ('../db.php');
			//$sql = "SELECT * FROM transactions where estate='".$_SESSION['estate']."' ORDER BY transaction_date"; 
			$sql = "SELECT * FROM `transactions` join flats ON flats.flat_no=transactions.flat AND flats.block_no=transactions.block 
            and transactions.estate = flats.estate_code and transactions.estate = '".$_SESSION['estate']."' order by transaction_date desc";
            // $sql = "SELECT * FROM `transactions` join flats 
            // ON flats.flat_no=transactions.flat AND flats.block_no=transactions.block 
            // and transactions.estate = '".$_SESSION['estate']."'";
			if($_SESSION['admin_type'] == 'flat') { 
			   $sql = "SELECT * FROM transactions where estate='".$_SESSION['estate']."' AND flat='".$_SESSION['flat_no']."' AND block='".$_SESSION['block_no']."' ORDER BY transaction_date desc";
			}
			//echo $sql; 
			$result = $con->query($sql);
			if ($result->num_rows > 0) { ?>
			<table id="example" class="table  table-bordered">
			<thead><tr class="titles"><th>Transaction ID</th><th>Meter PAN</th> <th>Transaction Date</th><th>Value</th><th>Token</th><th>Units</th><th>Transaction By</th><th>Action</th></tr></thead>
			  <tbody> <?php while($row = $result->fetch_assoc()) { ?>
					<tr><td><?php echo $row['transaction_id']; ?></td><td><?php echo $row['meter_pan']; ?></td><td><?php echo format_date($row['transaction_date']); ?></td><td><?php echo $row['amount']; ?></td><td><?php echo $row['token']; ?></td><td><?php echo $row['units']; ?></td>
						<td><?php if($_SESSION['admin_type'] == 'flat')  echo $row['generated_by']; else echo $row['owner']; ?></td><?php if($_SESSION['admin_type'] != 'flat') { echo "<td><a type='button' class='btn btn-success btn-sm' title='Verify Status' style='background-color: transparent; border-width: 0px;' href='electric/verifystatus.php?transactionId=".$row['transaction_id']."&owner=".$row['owner']."'>
						   <i class='fa fa-check text-success m-r-0'></i></a><!--<button type='button' class='btn btn-danger btn-sm' title='Delete Transaction' style='background-color: transparent; border-width: 0px;' data-toggle='modal' data-target='#delmodal-" .$row['tid']."'><i class='fa fa-trash text-danger m-r-0'></i></button>--></td>"; }
						   else { echo "<td><a type='button' class='btn btn-success btn-sm' title='Verify Status' style='background-color: transparent; border-width: 0px;' href='electric/verifystatus.php?transactionId=".$row['transaction_id']."&owner=".$_SESSION['owner']."'><i class='fa fa-check text-success m-r-0'></i></a></td>"; }?>
					</tr>
		<?php } 
		    } else { echo "No transaction recorded.<br><br>"; } $con->close(); ?>
		      </tbody>
			</table>
    </div>
</div>