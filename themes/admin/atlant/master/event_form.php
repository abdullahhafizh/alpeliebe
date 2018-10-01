<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="kec_id" id="kec_id" value="<?php echo isset($val->kec_id)?$val->kec_id:'';?>" />
        <div class="row">
          <div class="col-md-12">		  
		  <div class="row form-group">  
              <div class="col-md-2 control-label">Judul Berita</div>
              <div class="col-md-6">
                <input type="text" id="judul" name="judul" class="validate[required] form-control"maxlength="250" />
              </div>
            </div> 
		  <div class="row form-group">  
              <div class="col-md-2 control-label">Image Cover</div>
              <div class="col-md-6">
                    <input type="file" class="fileinput" name="image_cover" id="image_cover"/>
              </div>
            </div> 
		  <div class="row form-group">  
              <div class="col-md-2 control-label">Isi Berita</div>
              <div class="col-md-10">
                    <textarea class="summernote" name="isi_berita"></textarea>
			</div>
            </div> 
		  <div class="row form-group">  
              <div class="col-md-2 control-label">Image File 1</div>
              <div class="col-md-2">
                    <input type="file" class="fileinput" name="filename1" id="filename1"/>
              </div>
              <div class="col-md-2 control-label">Image File 2</div>
              <div class="col-md-2">
                    <input type="file" class="fileinput" name="filename2" id="filename2"/>
              </div>
              <div class="col-md-2 control-label">Image File 3</div>
              <div class="col-md-2">
                    <input type="file" class="fileinput" name="filename3" id="filename3"/>
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
