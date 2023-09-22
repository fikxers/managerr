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

?>
  <div class="container">
	<div class="row">
		<div class="col-xs-12">
			<form name="form1" id="form1" action="post.php" method="post" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-4 control-label">Meter PAN</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="Enter Meter PAN..." name="meterPAN">
					</div>
                </div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Currency Value</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="Enter Currency Value..." name="value">
						<input type="hidden" name="transactionId" value="<?php echo $transactionId ?>" />
					</div>
                </div>
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