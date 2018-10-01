<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="propinsi_id" id="propinsi_id" value="<?php echo isset($val->propinsi_id)?$val->propinsi_id:'';?>" />
        <div class="row">
          <div class="col-md-8">
    
             <div class="row form-group">  
              <div class="col-md-5 control-label">Kode Provinsi</div>
              <div class="col-md-7">
                <input type="text" id="propinsi_kode" maxlength="2" name="propinsi_kode" class="validate[required] form-control" value="<?php echo isset($val->propinsi_kode)?$val->propinsi_kode:'';?>" />
              </div>
            </div> 

			<div class="row form-group">  
              <div class="col-md-5 control-label">Nama Provinsi</div>
              <div class="col-md-7">
                <input type="text" id="propinsi_nama" name="propinsi_nama" class="validate[required] form-control" value="<?php echo isset($val->propinsi_nama)?$val->propinsi_nama:'';?>" />
              </div>
            </div> 

<!--            <div class="row form-group">
              <div class="col-md-5 control-label">Status</div>
              <div class="col-md-7">
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->propinsi_status==0?'checked="checked"':'';?> name="propinsi_status" class="icheckbox validate[required]" value="0"/> Aktif</label>
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->propinsi_status==1?'checked="checked"':'';?> name="propinsi_status" class="icheckbox validate[required]" value="1" /> Non Aktif</label>
              </div> 
            </div> 
-->

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
