<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="topup_id" id="topup_id" value="<?php echo isset($val->topup_id)?$val->topup_id:'';?>" />
        <div class="row">
          <div class="col-md-5">
            <div class="row form-group">  
              <div class="col-md-5 control-label">Nama Pengusul</div>
              <div class="col-md-7">
                 <select class="form-control" id="kta_pemesan" name="kta_pemesan">
                        <option value=""> - pilih nama pengusul - </option>
                           <?php foreach ((array)get_pemesan() as $m) {
                               $s = isset($val)&&$val->kta_pemesan==$m->penggunaID?'selected="selected"':'';
                               echo "<option value='".$m->penggunaID."' $s >".$m->nama_pengguna."</option>";
                            }?>
                 </select> 
              </div>
            </div> 
            <div class="row form-group">  
              <div class="col-md-5 control-label">Jumlah Top Up Kuota</div>
              <div class="col-md-7">
                <input type="text" id="topup_amount" name="topup_amount" class="validate[required] form-control" value="<?php echo isset($val->topup_amount)?$val->topup_amount:'';?>" />
              </div>
            </div> 
			
            <div class="row form-group">  
              <div class="col-md-5 control-label">Keterangan</div>
              <div class="col-md-7">
                <input type="text" id="topup_desc" name="topup_desc" class="validate[required,custom[onlyLetterSp]] form-control" value="<?php echo isset($val->topup_desc)?$val->topup_desc:'';?>" />
              </div>
            </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">Bukti</div>
              <div class="col-md-7">
                  <input type="file" id="topup_foto" class="fileinput btn-primary" name="topup_foto" />
                  <?php if( isset($val->topup_foto) && trim($val->topup_foto)!="" ){?>
                  <a href="<?php echo get_image(base_url()."assets/collections/photo/medium/".$val->topup_foto);?>" title="Image Photo" class="act_modal" rel="700|400">
                    <img alt="" src="<?php echo get_image(base_url()."assets/collections/photo/thumb/".$val->topup_foto);?>" style="height:25px;width:25px" class="img-polaroid">
                  </a>
                  <?php } ?>
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
