<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="" class="form-horizontal" method="post"> 
        <div class="row">


        	<div class="row form-group">  
              <div class="col-md-3 control-label">Password Lama</div>
              <div class="col-md-3">
                <input type="password" id="old_pass" maxlength="50" name="old_pass" class="validate[required] form-control" value="" />
              </div>
            </div> 

            <div class="row form-group">
              <div class="col-md-3 control-label">Password Baru</div>
              <div class="col-md-3">
                <input type="password" id="new_pass" name="new_pass" maxlength="50" class="validate[required] form-control" value="" />
              </div> 
            </div>

             <div class="row form-group">
              <div class="col-md-3 control-label">Ulangi Password Baru</div>
              <div class="col-md-3">
                <input type="password" id="new_pass2" name="new_pass2" maxlength="50" class="validate[equals[new_pass]] form-control" value="<?php echo isset($val->ag_group_desc)?$val->ag_group_desc:'';?>" />
              </div> 
            </div> 


        </div>
        <br />
        <div class="panel-footer">
          <div class="pull-left">
            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button>
          </div>
          <div class="pull-right">
            <button type="submit" name="btn_simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Ganti Password</button>
          </div>
        </div>

</form>