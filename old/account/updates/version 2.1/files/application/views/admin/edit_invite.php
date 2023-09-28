<div class="white-area-content">
<div class="db-header clearfix">
    <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_1") ?></div>
    <div class="db-header-extra">     
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li><a href="<?php echo site_url("admin") ?>"><?php echo lang("ctn_1") ?></a></li>
  <li class="active"><?php echo lang("ctn_486") ?></li>
</ol>


<hr>

 <div class="panel panel-default">
                <div class="panel-body">
 <?php echo form_open(site_url("admin/edit_invite_pro/" . $invite->ID), array("class" => "form-horizontal")) ?>
            <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_24") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email-in" name="email" value="<?php echo $invite->email ?>">
                        <span class="help-block"><?php echo lang("ctn_492") ?></span>
                    </div>
            </div>
            <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_493") ?></label>
                    <div class="col-md-9">
                       <input type="text" class="form-control" id="email-in" name="expires" value="<?php echo $invite->expires ?>">
                       <span class="help-block"><?php echo lang("ctn_494") ?></span>
                    </div>
            </div>
            <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_495") ?></label>
                    <div class="col-md-9">
                        <input type="checkbox" id="email-in" name="expire_upon_use" value="1" <?php if($invite->expire_upon_use) echo "checked" ?>> <?php echo lang("ctn_53") ?>
                        <span class="help-block"><?php echo lang("ctn_496") ?></span>
                    </div>
            </div>
            <div class="form-group">
                        <label for="password-in" class="col-md-3 label-heading"><?php echo lang("ctn_497") ?></label>
                        <div class="col-md-9">
                            <input type="checkbox" id="email-in" name="bypass_registration" value="1" <?php if($invite->bypass_register) echo "checked" ?>> <?php echo lang("ctn_53") ?>
                            <span class="help-block"><?php echo lang("ctn_498") ?></span>
                        </div>
                </div>
                <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_487") ?></label>
                    <div class="col-md-9">
                        <select name="status" class="form-control">
                          <option value="0"><?php echo lang("ctn_499") ?></option>
                          <option value="1" <?php if($invite->status == 1) echo "selected" ?>><?php echo lang("ctn_500") ?></option>
                          <option value="2" <?php if($invite->status == 2) echo "selected" ?>><?php echo lang("ctn_501") ?></option>"
                        </select>
                    </div>
            </div>

                <input type="submit" class="btn btn-primary form-control" value="<?php echo lang("ctn_13") ?>" />
        <?php echo form_close() ?>

                  </div>
                </div>

</div>