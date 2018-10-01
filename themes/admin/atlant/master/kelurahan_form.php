<?php js_validate();?>
<?php 
?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="kel_id" id="kel_id" value="<?php echo isset($val->kel_id)?$val->kel_id:'';?>" />
        <div class="row">
          <div class="col-md-8">
            
             <div class="row form-group">  
              <div class="col-md-5 control-label">Propinsi</div>
              <div class="col-md-7">
                                <select class="form-control " id="kta_propinsi" name="kta_propinsi">
                                    <option value=""> - pilih provinsi - </option>
										<?php 
											$propid= isset($val->kel_prop_id)?$val->kel_prop_id:'';
											echo option_province($propid);
										?>
                                </select> 
              </div>
            </div> 

             <div class="row form-group">  
              <div class="col-md-5 control-label">Kabupaten</div>
              <div class="col-md-7">
                    <select class="form-control " id="kta_kabupaten" name="kta_kabupaten">
                                    <option value=""> - pilih Kabupaten - </option>
					</select> 
              </div>
            </div> 

			<div class="row form-group">  
              <div class="col-md-5 control-label">Kecamatan</div>
              <div class="col-md-7">
                    <select class="form-control " id="kta_kecamatan" name="kta_kecamatan">
                                    <option value=""> - pilih Kecamatan - </option>
					</select> 
              </div>
            </div> 

			<div class="row form-group">  
              <div class="col-md-5 control-label">Kode Kelurahan</div>
              <div class="col-md-7">
                <input type="text" id="kel_kode" name="kel_kode" class="validate[required,custom[onlyNumberSp]] form-control" 
				value="<?php if(isset($val->kel_kode)){
								echo $val->kel_kode;
							 }else{
								foreach ((array)get_max_kel_kode() as $k => $v) {
									echo $v->kel + 1;
								}
						     }
					?>" maxlength="6"/>
              </div>
            </div> 

			<div class="row form-group">  
              <div class="col-md-5 control-label">Nama Kelurahan</div>
              <div class="col-md-7">
                <input type="text" id="kel_nama" name="kel_nama" class="validate[required] form-control" value="<?php echo isset($val->kel_nama)?$val->kel_nama:'';?>" />
              </div>
            </div> 

            <div class="row form-group">
              <div class="col-md-5 control-label">Status</div>
              <div class="col-md-7">
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->kel_status==0?'checked="checked"':'';?> name="kel_status" class="icheckbox validate[required]" value="0"/> Aktif</label>
                      <label class="check"><input type="radio" <?php echo isset($val)&&$val->kel_status==1?'checked="checked"':'';?> name="kel_status" class="icheckbox validate[required]" value="1" /> Non Aktif</label>
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
<script type="text/javascript">
    var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';
    var IS_API = "<?php echo cfg('status_get_api')=='Ya'?1:0;?>";
    $(document).ready(function(){

      $('#kta_propinsi').change(function(){
          get_kabupaten($(this).val(),"");
      });

      $('#kta_kabupaten').change(function(){
          get_kecamatan($(this).val(),"");
      });
	  
      $('#kta_koperasi').change(function(){
          get_koperasi($(this).val(),"");
      });

      <?php if(isset($val)){?>
      get_kabupaten('<?php echo $val->kel_prop_id;?>','<?php echo $val->kel_kab_id;?>');
      get_kecamatan('<?php echo $val->kel_kab_id;?>','<?php echo $val->kel_kec_id;?>');
      
      

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
        $('#kta_kabupaten').html(o);
      });
    }

    function get_kecamatan(prov,kab){
      $.post(URL_AJAX+"/kecamatan",{prov:prov,kab:kab},function(o){
        $('#kta_kecamatan').html(o);
      });
    }

</script>
