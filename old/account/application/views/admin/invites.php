<div class="white-area-content">
<div class="db-header clearfix">
    <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_1") ?></div>
    <div class="db-header-extra">      <input type="button" class="btn btn-primary btn-sm" value="<?php echo lang("ctn_491") ?>" data-toggle="modal" data-target="#addModal" />
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li><a href="<?php echo site_url("admin") ?>"><?php echo lang("ctn_1") ?></a></li>
  <li class="active"><?php echo lang("ctn_486") ?></li>
</ol>


<hr>

<div class="table-responsive">
<table id="blog-table" class="table table-striped table-hover table-bordered">
<thead>
<tr class="table-header"><td><?php echo lang("ctn_24") ?></td><td><?php echo lang("ctn_487") ?></td><td><?php echo lang("ctn_488") ?></td><td><?php echo lang("ctn_489") ?></td><td><?php echo lang("ctn_490") ?></td><td><?php echo lang("ctn_52") ?></td></tr>
</thead>
<tbody>
</tbody>
</table>
</div>

</div>
<script type="text/javascript">
$(document).ready(function() {

   var st = $('#search_type').val();
    var table = $('#blog-table').DataTable({
        "dom" : "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "processing": false,
        "pagingType" : "full_numbers",
        "pageLength" : 15,
        "serverSide": true,
        "orderMulti": false,
        "order": [
        ],
        "columns": [
        null,
        null,
        null,
        null,
        null,
        { "orderable" : false }
    ],
        "ajax": {
            url : "<?php echo site_url("admin/invite_page") ?>",
            type : 'GET',
            data : function ( d ) {
                d.search_type = $('#search_type').val();
            }
        },
        "drawCallback": function(settings, json) {
        $('[data-toggle="tooltip"]').tooltip();
      }
    });
    $('#form-search-input').on('keyup change', function () {
    table.search(this.value).draw();
});

} );
function change_search(search) 
    {
      var options = [
        "search-like", 
        "search-exact",
      ];
      set_search_icon(options[search], options);
        $('#search_type').val(search);
        $( "#form-search-input" ).trigger( "change" );
    }

function set_search_icon(icon, options) 
    {
      for(var i = 0; i<options.length;i++) {
        if(options[i] == icon) {
          $('#' + icon).fadeIn(10);
        } else {
          $('#' + options[i]).fadeOut(10);
        }
      }
    }
</script>


 <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang("ctn_491") ?></h4>
      </div>
      <div class="modal-body">
      <?php echo form_open(site_url("admin/add_invite_pro"), array("class" => "form-horizontal")) ?>
            <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_24") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email-in" name="email">
                        <span class="help-block"><?php echo lang("ctn_492") ?></span>
                    </div>
            </div>
            <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_493") ?></label>
                    <div class="col-md-9">
                       <input type="text" class="form-control" id="email-in" name="expires" value="48">
                       <span class="help-block"><?php echo lang("ctn_494") ?></span>
                    </div>
            </div>
            <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_495") ?></label>
                    <div class="col-md-9">
                        <input type="checkbox" id="email-in" name="expire_upon_use" value="1" checked> <?php echo lang("ctn_53") ?>
                        <span class="help-block"><?php echo lang("ctn_496") ?></span>
                    </div>
            </div>
            <div class="form-group">
                        <label for="password-in" class="col-md-3 label-heading"><?php echo lang("ctn_497") ?></label>
                        <div class="col-md-9">
                            <input type="checkbox" id="email-in" name="bypass_registration" value="1" checked> <?php echo lang("ctn_53") ?>
                            <span class="help-block"><?php echo lang("ctn_498") ?></span>
                        </div>
                </div>
               
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
        <input type="submit" class="btn btn-primary" value="<?php echo lang("ctn_491") ?>" />
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>