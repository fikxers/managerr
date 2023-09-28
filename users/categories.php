<?php require('auth.php'); $title ='Forum - Categories'; 
include('mgr_sidebar.php'); require('../db.php');
$estate_code = $_SESSION['estate'];
$_SESSION['show']= 0; $v=""; $code=""; $comp=0; $regno="";
?>
		<div class="row">
		  <div class="col-lg-3">
			<div class="card m-b-30">
              <div class="card-body">
			    <h4 class="mt-0 header-title">Add Category</h4>
			    <form action="" method="POST">
			      <div class="form-row">
				    <div class="form-group col-lg-12">
				      <input type="text" name="cat" id="code" class="form-control" placeholder="Category Name" required />
				    </div>
					<div class="form-group col-lg-12">
					  <textarea class="form-control" placeholder="Category Description"></textarea>
				    </div>
				    <div class="form-group col-lg-12">
				      <input type="submit" name="vcode" value="Add Category" class="btn btn-block btn-outline-info">
					  <input type="reset" name="vcode" value="Clear Form" class="btn btn-block btn-outline-info">
				    </div>
			      </div>
			    </form>
			  </div>
            </div>
		  </div>
		  <div class="col-lg-9">
			<div class="card m-b-30">
              <div class="card-body">
			    <h4 class="mt-0 header-title">Category List</h4>
				<div class="table-rep-plugin">
				  <div class="table-responsive b-0" data-pattern="priority-columns">
				  <?php include ('../db.php');
						$sql = "SELECT * FROM categories order by name asc";
						$result = $con->query($sql); $i=1;
						if ($result->num_rows > 0) { ?>
						  <table id="tech-companies-1" class="table  table-bordered">
							<thead>
							  <tr class="titles"><th>#</th><th>Name</th><th>Description</th><th>Action</th></tr>
							</thead>
							<tbody> <?php while($row = $result->fetch_assoc()) { ?>
							  <tr><td><?php echo $i; ?></td><td><?php echo $row['name']; ?></td><td><?php echo $row['description']; ?></td>
							  <td class="text-center">
								<button class="btn btn-sm btn-primary edit_category" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>">Edit</button>
								<button class="btn btn-sm btn-danger delete_category" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
							  </td>
							  </tr>
							<?php $i++; }
						} else { echo "Please add a category."; }
						$con->close(); ?>                                                       
							</tbody>
						  </table>
				  </div>
				</div>
			  </div>
            </div>
		  </div>
        </div><!-- end row -->
      </div><!-- container -->
    </div><!-- Page content Wrapper -->
  </div><!-- content -->
  <script>
	
	$('#manage-category').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_category',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_category').click(function(){
		start_load()
		var cat = $('#manage-category')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		end_load()
	})
	$('.delete_category').click(function(){
		_conf("Are you sure to delete this category?","delete_category",[$(this).attr('data-id')])
	})
	function delete_category($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_category',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>
  <?php include('footer.php'); ?>
</html>