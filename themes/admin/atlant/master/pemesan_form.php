<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="penggunaID" id="penggunaID" value="<?php echo isset($val->penggunaID)?$val->penggunaID:'';?>" />
        <div class="row">
          <div class="col-md-5">
            <div class="row form-group">
              <div class="col-md-5 control-label">Tingkat</div>
              <div class="col-md-7" style="margin-left:0px;">
                  <select name="tingkat" class="form-control select" id="tingkat">
                    <option value="" class="validate[required]"> - pilih -</option>
                    <option value="DPP" class="validate[required]">Dewan Perwakilan Propinsi (DPP)</option>
                    <option value="DPD" class="validate[required]">Dewan Perwakilan Daerah (DPD)</option>
                  </select>

              </div> 
            </div> 
            <div class="row form-group">  
              <div class="col-md-5 control-label">Nama Lengkap</div>
              <div class="col-md-7">
                <input type="text" id="user_fullname" name="user_fullname" class="validate[required] form-control" value="<?php echo isset($val->nama_pengguna)?$val->nama_pengguna:'';?>" />
              </div>
            </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">No. HP / Telp</div>
              <div class="col-md-7">
                <input type="text" id="user_phone" name="user_phone" class="form-control" value="<?php echo isset($val->notelp_pengguna)?$val->notelp_pengguna:'';?>" maxlength="12"/>
              </div> 
            </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">Email</div>
              <div class="col-md-7">
                <input type="text" id="user_email" name="user_email" class="form-control" value="<?php echo isset($val->email_pengguna)?$val->email_pengguna:'';?>" />
              </div> 
            </div> 




            <div class="row form-group">
              <div class="col-md-5 control-label">Propinsi</div>
              <div class="col-md-7" style="margin-left:0px;">

                  <select name="propinsi" class="form-control select" id="propinsi">
                    <option value="" class="validate[required]"> - pilih -</option>
                    <?php foreach ((array)get_propinsi() as $m) {
                      $s = isset($val)&&$val->propinsi_id==$m->propinsi_kode?'selected="selected"':'';
                      echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama."</option>";
                    }?>
                  </select>

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
