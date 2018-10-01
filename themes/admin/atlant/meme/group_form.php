<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="group_id" id="group_id" value="<?php echo isset($val->ag_id)?$val->ag_id:'';?>" />
        <div class="row">


        	<div class="row form-group">  
              <div class="col-md-3 control-label">Group Name</div>
              <div class="col-md-5">
                <input type="text" id="group_name" maxlength="50" name="group_name" class="validate[required] form-control" value="<?php echo isset($val->ag_group_name)?$val->ag_group_name:'';?>" />
              </div>
            </div> 

            <div class="row form-group">
              <div class="col-md-3 control-label">Group Desc</div>
              <div class="col-md-5">
                <input type="text" id="group_desc" name="group_desc" maxlength="50" class="validate[required] form-control" value="<?php echo isset($val->ag_group_desc)?$val->ag_group_desc:'';?>" />
              </div> 
            </div> 

            <div class="row form-group">
              <div class="col-md-3 control-label">Status</div>
              <div class="col-md-5">

              	<label class="check"><input name="ag_group_status" type="checkbox" id="ag_group_status" <?php echo (isset($val->ag_group_status)&& $val->ag_group_status=="1")?'checked="checked"':'';?> class="icheckbox" /> Aktif</label>

              </div> 
            </div> 


        </div>
        <br />
        <div class="panel-footer">
          <div class="pull-left">
            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button>
          </div>
          <div class="pull-right">
            <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
          </div>
        </div>

</form>