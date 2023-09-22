<!--
@company - IMR
@product - IMR Payment Web Service
@author - Software Dev Team
-->
<html>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-dark.min.css">
</head>
<body>
  <div class="container">
	<div class="row">
		<div class="col-xs-12">
			<form name="form1" id="form1" action="receipt.php" method="post" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-4 control-label">Order ID</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="Enter Order ID..." name="orderID">
					</div>
                </div>

				 <div class="form-group">
					<div class="col-sm-8 col-sm-offset-4">
						<input class="btn btn-sm btn-primary" id="statusButton" name="submit" type="submit" />
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
                $("button#statusButton").click(function(){
                  $('form[name=form1]').submit();
                });

            });
        </script>
</body>
</html>