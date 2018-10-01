<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="kab_id" id="kab_id" value="<?php echo isset($val->kab_id)?$val->kab_id:'';?>" />
        <div class="row">
          <div class="col-md-8">
            
            <div class="row form-group">  
              <div class="col-md-5 control-label">Nama Provinsi</div>
              <div class="col-md-5">

                  <select class="validate[required] form-control select" name="kab_propinsi_id" id="kab_propinsi_id">
                    <option value=""> - pilih provinsi - </option>
                    <?php foreach ((array)get_propinsi() as $m) {
                      $s = isset($val)&&$val->kab_propinsi_id==$m->propinsi_id?'selected="selected"':'';
                      echo "<option value='".$m->propinsi_id."' $s >".$m->propinsi_nama."</option>";
                    }?>
                  </select>

              </div>
            </div> 
             <div class="row form-group">  
              <div class="col-md-5 control-label">Kode Kabupaten</div>
              <div class="col-md-7">
                <input type="text" id="kab_kode" name="kab_kode" class="validate[required] form-control" value="<?php echo isset($val->kab_kode)?$val->kab_kode:'';?>" />
              <div class="col-md-12"><code>Format Kode <2 digit kode Propinsi><2 digit kode kabupaten></code></div>
              </div>
            </div> 
             <div class="row form-group">  
              <div class="col-md-5 control-label">Nama Kabupaten</div>
              <div class="col-md-7">
                <input type="text" id="kab_nama" name="kab_nama" class="validate[required] form-control" value="<?php echo isset($val->kab_nama)?$val->kab_nama:'';?>" />
              </div>
            </div> 
<!--            <div class="row form-group">
              <div class="col-md-5 control-label">Status</div>
              <div class="col-md-7">
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->kab_status==0?'checked="checked"':'';?> name="kab_status" class="icheckbox validate[required]" value="0"/> Aktif</label>
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->kab_status==1?'checked="checked"':'';?> name="kab_status" class="icheckbox validate[required]" value="1" /> Non Aktif</label>
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
