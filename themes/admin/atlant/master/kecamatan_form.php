<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="kec_id" id="kec_id" value="<?php echo isset($val->kec_id)?$val->kec_id:'';?>" />
        <div class="row">
          <div class="col-md-8">
		  
		  <div class="row form-group">  
              <div class="col-md-5 control-label">Nama Propinsi</div>
              <div class="col-md-5">

                  <select class="validate[required] form-control select" name="kab_propinsi_id" id="kab_propinsi_id">
                    <option value=""> - pilih provinsi - </option>
                    <?php foreach ((array)get_propinsi() as $m) {
                      $s = isset($val)&&$val->kec_prop_id==$m->propinsi_id?'selected="selected"':'';
                      echo "<option value='".$m->propinsi_id."' $s >".$m->propinsi_nama."</option>";
                    }?>
                  </select>

              </div>
            </div> 

			<div class="row form-group">  
				<div class="col-md-5 control-label">Nama Kabupaten</div>
				<div class="col-md-7">
					<select class="form-control " id="kec_kab_id" name="kec_kab_id">
						<option value=""> - pilih kabupaten - </option>
					</select> 
				</div>
			</div> 

			<div class="row form-group">  
              <div class="col-md-5 control-label">Kode Kecamatan</div>
              <div class="col-md-7">
                <input type="text" id="kec_kode" name="kec_kode" class="validate[required,custom[onlyNumberSp]] form-control" value="<?php echo isset($val->kec_kode)?substr($val->kec_kode,4,2):'';?>" maxlength="2" />
              <span class="help-block"><code>Format Kode Kecamatan <2 digit Kode Kecamatan></code></span>						
              </div>
            </div>
			
			<div class="row form-group">  
              <div class="col-md-5 control-label">Nama Kecamatan</div>
              <div class="col-md-7">
                <input type="text" id="kec_nama" name="kec_nama" class="validate[required] form-control" value="<?php echo isset($val->kec_nama)?$val->kec_nama:'';?>" />
              </div>
            </div>
<!--
            <div class="row form-group">
              <div class="col-md-5 control-label">Status</div>
              <div class="col-md-7">
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->kec_status==0?'checked="checked"':'';?> name="kec_status" class="icheckbox validate[required]" value="0"/> Aktif</label>
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->kec_status==1?'checked="checked"':'';?> name="kec_status" class="icheckbox validate[required]" value="1" /> Non Aktif</label>
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
<script type="text/javascript">
    var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';
    var IS_API = "<?php echo cfg('status_get_api')=='Ya'?1:0;?>";
    $(document).ready(function(){

      $('#kab_propinsi_id').change(function(){
          get_kabupaten($(this).val(),"");
      });

      $('#kta_kabupaten').change(function(){
          get_kecamatan($(this).val(),"");
      });
	  
      $('#kta_koperasi').change(function(){
          get_koperasi($(this).val(),"");
      });

      <?php if(isset($val)){?>
      get_kabupaten('<?php echo $val->kec_prop_id;?>','<?php echo $val->kec_kab_id;?>');
      get_kecamatan('<?php echo $val->kec_kab_id;?>','<?php echo $val->kta_kecamatan;?>');
      
      

      $('#div_result_wajah,#div_result_ktp').fadeIn();

      <?php } ?>
	  
      

    });



    /*function take_snapshot(){
        $('#btn-foto-show').hide();
        $('.ithide').fadeIn();
        init_camera_wajah();
        init_camera_ktp();
    }*/

    

    function get_kabupaten(prov,kab){
      $.post(URL_AJAX+"/kabupaten",{prov:prov,kab:kab},function(o){
        $('#kec_kab_id').html(o);
      });
    }

    function get_kecamatan(prov,kab){
      $.post(URL_AJAX+"/kecamatan",{prov:prov,kab:kab},function(o){
        $('#kta_kecamatan').html(o);
      });
    }

</script>
