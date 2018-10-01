<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="topup_id" id="topup_id" value="<?php echo isset($val->topup_id)?$val->topup_id:'';?>" />
        <input type="hidden" name="penggunaID" id="penggunaID" value="<?php echo isset($val->penggunaID)?$val->penggunaID:'';?>" />
        <div class="row">
          <div class="col-md-5">
            <div class="row form-group">  
              <div class="col-md-5 control-label">Nama Pemesan</div>
              <div class="col-md-7">
                <input type="text" id="topup_desc" readonly name="topup_desc" class="validate[required,custom[onlyLetterSp]] form-control" value="<?php echo isset($val->nama_pengguna)?$val->nama_pengguna:'';?>" />
              </div>
            </div> 
            <div class="row form-group">  
              <div class="col-md-5 control-label">Domisili</div>
              <div class="col-md-7">
                <input type="text" id="topup_desc" readonly name="topup_desc" class="validate[required,custom[onlyLetterSp]] form-control" value="<?php echo isset($val->propinsi_nama)?$val->propinsi_nama:'';?>" />
              </div>
            </div> 

            <div class="row form-group">  
              <div class="col-md-5 control-label">Jumlah Top Up</div>
              <div class="col-md-7">
                <input type="text" id="topup_amount" readonly name="topup_amount" class="validate[required] form-control" value="<?php echo isset($val->topup_amount)?$val->topup_amount:'';?>" />
              </div>
            </div> 
			
            <div class="row form-group">  
              <div class="col-md-5 control-label">Keterangan</div>
              <div class="col-md-7">
                <input type="text" id="topup_desc" readonly name="topup_desc" class="validate[required,custom[onlyLetterSp]] form-control" value="<?php echo isset($val->topup_desc)?$val->topup_desc:'';?>" />
              </div>
            </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">Bukti</div>
              <div class="col-md-7">
                  <?php if( isset($val->topup_foto) && trim($val->topup_foto)!="" ){?>
                  <a href="<?php echo get_image(base_url()."assets/collections/photo/medium/".$val->topup_foto);?>" title="Image Photo" class="act_modal" rel="700|400">
                    <img alt="" src="<?php echo get_image(base_url()."assets/collections/photo/thumb/".$val->topup_foto);?>" style="height:50px;width:50px" >
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
            <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Konfirmasi Top Up</button>
          </div>
        </div>

</form>
