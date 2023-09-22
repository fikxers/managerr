<!--
@company - ATL
@product - TIS&P Token Vending Platform API
@author - Software Dev Team
-->
<html>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-dark.min.css">
</head>
<body>
<?php
	$transactionId = "O" . DATE("dmyHis");
	
	//https://vendingdemo.tisdynamicssolutions.com/api/verify/status?filter=meterPAN eq' 04191738758' & filter=transactionId eq 'O251022082025' & filter=publicKey eq 'mEzPoePWld78BJQcZdyQ' & filter=merchantId eq 'TIS/2105' & filter=mac eq '0237e80427c8ecac4f52d1f1cfae6abe73c538a06264d3e09d1f0ccfc46f2edfe8cd9cbee1aeb6013544e05872d6e2315ce3eca661f87f6fa605396e23383386'

?>
  <div class="container">
	<div class="row">
		<div class="col-xs-12">
			<form name="form1" id="form1" action="status-post.php" method="post" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-4 control-label">Meter PAN</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="Enter Meter PAN..." name="meterPAN">
					</div>
                </div>
				<input type="hidden" name="transactionId" value="<?php echo $transactionId ?>" />
				 <div class="form-group">
					<div class="col-sm-8 col-sm-offset-4">
						<input class="btn btn-sm btn-primary" id="payButton" name="submit" type="submit" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $("button#payButton").click(function(){
                  $('form[name=form1]').submit();
                });

            });
        </script>
</body>
</html>