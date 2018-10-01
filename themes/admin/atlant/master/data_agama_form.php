<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="agama_id" id="agama_id" value="<?php echo isset($val->agama_id)?$val->agama_id:'';?>" />
        <div class="row">
          <div class="col-md-8">
    
             <div class="row form-group">  
              <div class="col-md-5 control-label">Nama Agama</div>
              <div class="col-md-7">
                <input type="text" id="agama_nama" name="agama_nama" class="validate[required] form-control" value="<?php echo isset($val->agama_nama)?$val->agama_nama:'';?>" />
              </div>
            </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">Status</div>
              <div class="col-md-7">
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->agama_status==0?'checked="checked"':'';?> name="agama_status" class="icheckbox validate[required]" value="0"/> Aktif</label>
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->agama_status==1?'checked="checked"':'';?> name="agama_status" class="icheckbox validate[required]" value="1" /> Non Aktif</label>
              </div> 
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
