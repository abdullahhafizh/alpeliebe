<style type="text/css">
.border_camera{
    width:170px;height:130px;
    border:5px solid #FE4A3F;
    margin: 10px;
}
.object_ok
{
border: 1px solid green; 
color: #333333; 
}
.object_error
{
border: 1px solid #AC3962; 
color: #333333; 
}
</style>
<?php js_validate(); ?>
     <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
        <input type="hidden" name="kta_type_lampiran1" id="kta_type_lampiran1" value="<?php echo isset($val->kta_type_lampiran1)?$val->kta_type_lampiran1:'';?>" />
        <input type="hidden" name="kta_type_lampiran2" id="kta_type_lampiran2" value="<?php echo isset($val->kta_type_lampiran2)?$val->kta_type_lampiran2:'';?>" />
        <div class="panel-body">                                                                        
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
								<select class="form-control validate[required]" id="kta_pemesan" name="kta_pemesan">
                                    <option value="" > - pilih pengusul - </option>
                                    <?php 
										  $st = 0;
										  if(isset($val)){
											  $isi = $val->kta_pemesan;
										  }else{
											  if(!empty($this->jCfg['user']['penggunaid'])){
												$isi = $this->jCfg['user']['penggunaid'];											  												  
											  }else{
												$isi = "";
											  }
										  }
										  foreach ((array)get_pemesan($st) as $m) {
										  $s = $isi==$m->penggunaID?'selected="selected"':'';												  
										  echo "<option value='".$m->penggunaID."' $s >".$m->nama_pengguna."</option>";
										  }
									?>
                                </select> 
                            </div>
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>                   
						<div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_no_ktp" id="kta_no_ktp"  value="<?php echo isset($val->kta_no_id)?$val->kta_no_id:'';?>" id="kta_no_ktp" class="validate[custom[onlyNumberSp]]  form-control" placeholder="Masukan No. NIK / KTP / E-KTP" maxlength="16"/>
                            </div>  
                            <div id="status"></div>
							<span class="help-block"><code>* Wajib Diisi</code></span>						
                       </div>
                    </div>
                    </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong>PERHATIAN! PASTIKAN FOTO DAN KTP TERLAMPIR DIDALAM FORMULIR LEMBAR 1</strong> 
                            </div>                       
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Upload Formulir Lampiran 1</h3>
                            </div>
                        </div> 
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px">
									<div class="form-group">
										<input type="file" id="upload_lampiran_1" name="upload_lampiran_1" class="form-control" accept="image/*"/>
									</div>
                                </div>
                            </div> 
                        </div>
                    </div>
					<?php if(isset($val) && trim($val->kta_lampiran1)!=""){?>
                    <div class="panel panel-default">
						<div class="panel-body panel-body-table">
							<div class="row">
								<div class="col-md-8" style="padding: 10px">
									<h3>Lampiran 1 Yang Terupload</h3>
									<div class="gallery">
										<a href="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_lampiran1);?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_lampiran1);?>" width="450">
											<div class="meta">
												<strong>File Utama</strong>
												<span>File hasil dari upload</span>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Upload Formulir Lampiran 2</h3>
                            </div>
                        </div> 
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px">
									<div class="form-group ">
										<input type="file" id="upload_lampiran_2" name="upload_lampiran_2" class="form-control" accept="image/*"/>
									</div>
                                </div>
                            </div> 
                        </div>
                    </div>
					<?php if(isset($val) && trim($val->kta_lampiran2)!=""){?>
                    <div class="panel panel-default">
						<div class="panel-body panel-body-table">
							<div class="row">
								<div class="col-md-8" style="padding: 10px">
									<h3>Lampiran 2 Yang Terupload</h3>
									<div class="gallery">
										<a href="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_lampiran2);?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_lampiran2);?>" width="450">
											<div class="meta">
												<strong>File Utama</strong>
												<span>File hasil dari upload</span>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>						
					<?php } ?>
                </div>
            </div>
        </div>
        <div class="panel-footer">
			<a class="btn btn-default btn-lg" href="<?php echo $own_links;?>">Batal</a>            
			<button class="btn btn-primary pull-right btn-lg" type="submit" id="lanjut" name="lanjut" >Lanjut</button>
        </div>
    </form>     

<script type="text/javascript">
    var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';
    var IS_API = "<?php echo cfg('status_get_api')=='Ya'?1:0;?>";
	
//	pic1 = new Image(16, 16); 
//	pic1.src = "<?php echo themeUrl();?>img/loader.gif";

	$(document).ready(function(){
		$('#upload_lampiran_1').bind('change', function() {
			if(this.files[0] != null){
				if(this.files[0].size > 3145728){
				   alert("File terlalu besar. Maksimal ukuran file adalah 3 MB");
				   this.value = '';
				};
			}
		});

		$('#upload_lampiran_2').bind('change', function() {
			if(this.files[0] != null){
				if(this.files[0].size > 3145728){
				   alert("File terlalu besar. Maksimal ukuran file adalah 3 MB");
				   this.value = '';
				};
			}
		});
		
		$('form').submit(function() {
		  var pemesan 	= $("#kta_pemesan").val();
		  var nik 		= $("#kta_no_ktp").val();
		  if(pemesan != '' && nik != '') {
			$(this).find("button[type='submit']").prop('disabled',true);			  
		  }
		});

		$('#lanjut').click(function() {
		  <?php if(isset($val)){?>
			return true;
		  <?php }else{ ?>
			var pemesan 	= $("#upload_lampiran_1").val();
			var ktp		 	= $("#upload_lampiran_2").val();		
			var nik		 	= $("#kta_no_ktp").val();		
			var pengusul 	= $("#kta_pemesan").val();		
			if(pemesan ==  '' || ktp == '' || nik == '' || pengusul == '' ){
				alert("Pastikan Lampiran Lengkap");
				return false;
			}
			var usr = $("#kta_no_ktp").val();
				if(usr.length == 16){					
					$("#status").html('<img src="<?php echo themeUrl();?>img/loader.gif" />&nbsp;Cek Daftar No. KTP...');
						$.ajax({  
    						type: "POST",  
                            url: URL_AJAX + "/ktp",
    						data: {ktp: usr},
    						success: function(msg){  
    								if(msg == 1) { 
										return true;
    								}else {
										alert("No. KTP Sudah Terdaftar");
    									$("#kta_no_ktp").removeClass('object_ok'); // if necessary
    									$("#kta_no_ktp").addClass("object_error");
										$("#lanjut").attr('disabled','disabled');
										$("#kta_no_ktp").val("");
										return false;
    								}  
    						} 
					    }); 
				}else {
					$("#status").html('<font color="red">' +
					'No. KTP / NIK harus <strong>16</strong> karakter</font>');
					$("#username").removeClass('object_ok'); // if necessary
					$("#username").addClass("object_error");
					$("#lanjut").attr('disabled','disabled');
				}
     	  <?php } ?>
		});
		
		$("#kta_no_ktp").change(function() { 
			var usr = $("#kta_no_ktp").val();
				if(usr.length == 16){					
					$("#status").html('<img src="<?php echo themeUrl();?>img/loader.gif" />&nbsp;Cek Daftar No. KTP...');
						$.ajax({  
    						type: "POST",  
                            url: URL_AJAX + "/ktp",
    						data: {ktp: usr},
    						success: function(msg){  
    								if(msg == 1) { 
                                        $("#status").html('&nbsp;<img src="<?php echo base_url();?>assets/images/tick.gif" align="absmiddle"> Data KTP dapat digunakan');
    									$("#kta_no_ktp").removeClass('object_error'); // if necessary
    									$("#kta_no_ktp").addClass("object_ok");
										$("#lanjut").removeAttr('disabled');
    								}else {
                                        $("#status").html(msg);
    									$("#kta_no_ktp").removeClass('object_ok'); // if necessary
    									$("#kta_no_ktp").addClass("object_error");
										$("#lanjut").attr('disabled','disabled');
										$("#kta_no_ktp").val("");
    								}  
    						} 
					    }); 
				}else {
					$("#status").html('<font color="red">' +
					'No. KTP / NIK harus <strong>16</strong> digit</font>');
					$("#username").removeClass('object_ok'); // if necessary
					$("#username").addClass("object_error");
					$("#lanjut").attr('disabled','disabled');
				}
		});
	});
	
    $(document).ready(function(){
        
	    $("#upload_lampiran_1,#upload_lampiran_2,#upload_foto,#upload_ktp").fileinput({
            showUpload: false,
            showCaption: false,
            browseClass: "btn btn-danger",
            fileType: "any"
	    })         
      <?php if(isset($val)){?>
      get_kabupaten('<?php echo $val->kta_propinsi;?>','<?php echo $val->kta_kabupaten;?>');
      get_kecamatan('<?php echo $val->kta_kabupaten;?>','<?php echo $val->kta_kecamatan;?>');
      get_kelurahan('<?php echo $val->kta_kecamatan;?>','<?php echo $val->kta_kelurahan;?>');
      <?php } ?>

      $('#kta_propinsi').change(function(){
          get_kabupaten($(this).val(),"");
      });

      $('#kta_kabupaten').change(function(){
          get_kecamatan($(this).val(),"");
      });
	  
      $('#kta_kecamatan').change(function(){
          get_kelurahan($(this).val(),"");
      });

	 	  

    });

    function take_foto_wajah(){
        $('#btn_take_foto_wajah,.ithide_upload_wajah').hide();
/*        $('#btn_upload_lampiran_1,.ithide_lampiran_1').hide();  */
        $('#btn_upload_foto_wajah').fadeIn();
        $('.ithide_foto_wajah').fadeIn();
        $('#kta_type_wajah').val('foto');
        init_camera_wajah();
    }

    function upload_lampiran_1(){
        $('#btn_upload_lampiran_1,.ithide_lampiran_1').hide();
/*        $('#btn_take_foto_wajah,.ithide_upload_wajah').hide(); */
        $('#btn_take_lampiran_1').fadeIn();
        $('.ithide_upload_lampiran_1').fadeIn();
    }

    function upload_lampiran_2(){
        $('#btn_upload_lampiran_2,.ithide_lampiran_2').hide();
        $('#btn_take_lampiran_2').fadeIn();
        $('.ithide_upload_lampiran_2').fadeIn();
    }

    function upload_foto(){
        $('#btn_upload_foto,.ithide_foto').hide();
        $('#btn_take_foto').fadeIn();
        $('.ithide_upload_foto').fadeIn();
    }

    function upload_ktp(){
        $('#btn_upload_ktp,.ithide_ktp').hide();
        $('#btn_take_ktp').fadeIn();
        $('.ithide_upload_ktp').fadeIn();
    }

    function take_foto_id(){
        $('#btn_take_foto_id,.ithide_upload_id').hide();
        $('#btn_upload_foto_id').fadeIn();
        $('.ithide_foto_id').fadeIn();
        $('#kta_type_ktp').val('foto');
        init_camera_ktp();
    }

    function upload_id(){
        $('#btn_upload_foto_id,.ithide_foto_id').hide();
        $('#btn_take_foto_id').fadeIn();
        $('.ithide_upload_id').fadeIn();
        $('#kta_type_ktp').val('upload');
    }

    function init_camera_wajah(){
        Webcam.set({
            width: 160,
            height: 120,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
        Webcam.attach( '#my_camera_wajah' );

    }
    function take_snapshot_wajah() {
        Webcam.snap( function(data_uri) {
            $('#div_result_wajah').fadeIn();
            
            raw = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
            $('#kta_foto_wajah').val(raw);

            $('#result_camera_wajah').html( '<img src="'+data_uri+'"/>');
        } );
    }

    function init_camera_ktp(){
        Webcam.set({
            width: 160,
            height: 120,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
        Webcam.attach( '#my_camera_ktp' );

    }
    function take_snapshot_ktp() {
        Webcam.snap( function(data_uri) {
            $('#div_result_ktp').fadeIn();

            raw = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
            $('#kta_foto_ktp').val(raw);

            $('#result_camera_ktp').html( '<img src="'+data_uri+'"/>');
        } );
    }

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

    function get_kelurahan(prov,kab){
      $.post(URL_AJAX+"/kelurahan",{prov:prov,kab:kab},function(o){
        $('#kta_kelurahan').html(o);
      });
    }

    function get_ktp(ktp){
      $.post(URL_AJAX+"/ktp",{ktp:ktp},function(o){
        $('#kta_no_ktp').html(o);
      });
    }


</script>