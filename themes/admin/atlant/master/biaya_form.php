<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="bk_id" id="bk_id" value="<?php echo isset($val->bk_id)?$val->bk_id:'';?>" />
        <div class="row">
          <div class="col-md-8">
		  
		  <div class="row form-group">  
              <div class="col-md-5 control-label">Tujuan</div>
              <div class="col-md-7">

                  <select class="validate[required] form-control select" name="bk_tujuan" id="bk_tujuan">
                    <option value=""> - pilih provinsi - </option>
                    <?php foreach ((array)get_propinsi() as $m) {
                      $s = isset($val)&&$val->bk_tujuan==$m->propinsi_id?'selected="selected"':'';
                      echo "<option value='".$m->propinsi_id."' $s >".$m->propinsi_nama."</option>";
                    }?>
                  </select>

              </div>
            </div> 

			<div class="row form-group">  
              <div class="col-md-5 control-label">Biaya Kirim</div>
              <div class="col-md-3">
                <input type="text" id="bk_biaya" name="bk_biaya" class="validate[required] form-control" value="<?php echo isset($val->bk_biaya)?$val->bk_biaya:'';?>" style="text-align: right;" />
              </div>
            </div>
			
			<div class="row form-group">  
              <div class="col-md-5 control-label">Kurir</div>
              <div class="col-md-2">
                <input type="text" id="bk_kurir" name="bk_kurir" class="validate[required] form-control" value="<?php echo isset($val->bk_kurir)?$val->bk_kurir:'';?>" />
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