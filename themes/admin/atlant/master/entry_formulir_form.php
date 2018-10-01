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
input[type="text"]:disabled {
	color:#000;
}
select[disabled] { 
	color:#000;
}
</style>
<?php js_validate(); ?>
     <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
        <input type="hidden" name="kta_npapg" id="kta_npapg" value="<?php echo isset($val->kta_nomor_kartu)?$val->kta_nomor_kartu:'';?>" />
        <input type="hidden" name="kta_nomor" id="kta_nomor" value="<?php echo isset($val->kta_nomor)?$val->kta_nomor:'';?>" />
        <input type="hidden" name="kta_type_lampiran1" id="kta_type_lampiran1" value="<?php echo isset($val->kta_type_lampiran1)?$val->kta_type_lampiran1:'';?>" />
        <input type="hidden" name="kta_type_lampiran2" id="kta_type_lampiran2" value="<?php echo isset($val->kta_type_lampiran2)?$val->kta_type_lampiran2:'';?>" />
        <div class="panel-body">   		
				<div class="row">
                <div class="col-md-7">
						<div class="form-group">
							<label class="control-label col-md-3">Nama Lengkap</label>
							<div class="col-md-9">
								<input id="kta_nama_lengkap" name="kta_nama_lengkap" class="validate[required] form-control" value="<?php echo isset($val->kta_nama_lengkap)?$val->kta_nama_lengkap:'';?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">NIK</label>
							<div class="col-md-9">
                                <input type="text" name="kta_no_ktp" id="kta_no_ktp"  value="<?php echo isset($val->kta_no_id)?$val->kta_no_id:'';?>" id="kta_no_ktp" class="validate[custom[onlyNumberSp]]  form-control" placeholder="Masukan No. NIK / KTP / E-KTP" maxlength="16"/>
                            <div id="status"></div>
							</div>
						</div>
                    <div class="form-group">
								    <label class="control-label col-md-3">Jenis Kelamin</label>
								<div class="col-md-9">
                                    <?php foreach((array)cfg('jenkel') as $kj=>$vj){?>
									<label class="check"><input type="radio" class="validate[required] iradio" name="kta_jenkel" value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_jenkel==$kj?'checked="checked"':'';?>/> <?php echo $vj;?> </label> &nbsp;
                                    <?php } ?>
								</div>
                        </div>
					<div class="form-group">
							<label class="control-label col-md-3">Tempat Lahir</label>
							<div class="col-md-9">
                                <input type="text" name="kta_tempat_lahir"  value="<?php echo isset($val->kta_tempat_lahir)?$val->kta_tempat_lahir:'';?>" id="kta_tempat_lahir" class="form-control" placeholder="Masukan Tempat Lahir"/>
							</div>
                    </div>
                    <div class="form-group">                                        
								    <label class="control-label col-md-3">Tanggal Lahir</label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <select class="form-control" name="kta_tgl_lahir" id="kta_tgl_lahir">
                                   <option value=""> - tanggal - </option>
                                   <?php for($i=1;$i<=31;$i++){
	                                   		$an = $i<=9?'0'.$i:$i;
	                                   		$tmp1 = isset($tmp_tgl[2])?$tmp_tgl[2]:'';
	                                   	    $slc1 = trim($tmp1)==$an?'selected="selected"':'';
	                                   		echo "<option value='$an' $slc1 >$an</option>";
	                                   }
                                   ?>
                                </select>                                        
                            </div>
                        </div>                        
                        <div class="col-md-3">
                            <div class="input-group">
                                <select class="form-control" name="kta_bln_lahir" id="kta_bln_lahir" >
                                   <option value=""> - bulan - </option>
                                   <?php
	                                   foreach((array)cfg('bulan') as $k=>$v){
	                                   	   $tmp2 = isset($tmp_tgl[1])?$tmp_tgl[1]:'';
	                                   	   $slc2 = trim($tmp2)==$k?'selected="selected"':''; 
		                                   echo "<option value='".$k."' $slc2 >".$v."</option>";
	                                   } 
                                   ?>
                                </select>                                        
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="input-group">
                                <select class="form-control" name="kta_thn_lahir" id="kta_thn_lahir">
                                   <option value=""> - tahun - </option>
                                   <?php for($j=1930;$j<=date("Y");$j++){
	                                   		$tmp3 = isset($tmp_tgl[0])?$tmp_tgl[0]:'';
	                                   	    $slc3 = trim($tmp3)==$j?'selected="selected"':'';
	                                   		echo "<option value='$j' $slc3 >$j</option>";
	                                   }
                                   ?>
                                </select>                                        
                            </div>
                        </div>                        
                    </div>                   
					<div class="form-group">
							<label class="control-label col-md-3">Alamat</label>
							<div class="col-md-9">
                                <input type="text" name="kta_alamat"  value="<?php echo isset($val->kta_alamat)?$val->kta_alamat:'';?>" id="kta_alamat" class="form-control" placeholder="Masukan Alamat Lengkap"/>
							</div>
                    </div>
                    <div class="form-group">                                        
							<label class="control-label col-md-3">RT/RW KODEPOS</label>
							<div class="col-md-2">
                                <input type="text" name="kta_rt"  value="<?php echo isset($val->kta_rt)?$val->kta_rt:'';?>" id="kta_rt" class="validate[custom[onlyNumberSp]] form-control" size="10" maxlength="3" placeholder="RT"/>
							</div>
							<div class="col-md-2">
                                <input type="text" name="kta_rw"  value="<?php echo isset($val->kta_rw)?$val->kta_rw:'';?>" id="kta_rw" class="validate[custom[onlyNumberSp]] form-control" size="10" maxlength="3" placeholder="RW"/>
							</div>
							<div class="col-md-2">
                                <input type="text" name="kta_kodepos"  value="<?php echo isset($val->kta_kodepos)?$val->kta_kodepos:'';?>" id="kta_nama_lengkap" class="validate[custom[onlyNumberSp]] form-control" placeholder="KODE POS" maxlength="5"/>
							</div>
                    </div>						
						<div class="form-group">
							<label class="control-label col-md-3">Provinsi</label>
							<div class="col-md-9">
								<select class="form-control" id="kta_propinsi" name="kta_propinsi" data-live-search="true">
                                    <option value=""> - pilih provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
                                      echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama."</option>";
                                    }?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Kabupaten/Kota</label>
							<div class="col-md-9">
								<select class="form-control" id="kta_kabupaten" name="kta_kabupaten" data-live-search="true">
                                    <option value=""> - pilih kabupaten/kota - </option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Kecamatan</label>
							<div class="col-md-9">
								<select class="form-control" id="kta_kecamatan" name="kta_kecamatan" data-live-search="true">
                                    <option value=""> - pilih kecamatan - </option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Kelurahan</label>
							<div class="col-md-9">
								<select class="form-control" id="kta_kelurahan" name="kta_kelurahan" data-live-search="true">
                                    <option value=""> - pilih kelurahan - </option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Jabatan</label>
							<div class="col-md-9">
								<select class="form-control" id="kta_jabatan" name="kta_jabatan" data-live-search="true">
                                    <option value=""> - pilih jabatan - </option>
                                    <?php foreach ((array)get_jabatan() as $m) {
                                      echo "<option value='".$m->jabatan_id."' $s >".$m->jabatan_nama."</option>";
                                    }?>
								</select>
							</div>
						</div>						
					<div class="form-group">
							<label class="control-label col-md-3">Divisi</label>
							<div class="col-md-9">
                                <input type="text" name="kta_divisi"  value="<?php echo isset($val->kta_divisi)?$val->kta_divisi:'';?>" id="kta_divisi" class="form-control" placeholder="Masukan Divisi"/>
							</div>
                    </div>				</div>
				 <div class="col-md-5">
					<img alt="" id="kta_lampiran1" src="<?php echo get_image(base_url()."assets/collections/kta/ktp/".$val->kta_foto_ktp); ?>" style="height:100%;width:100%; border:1px solid #000;" >
				 </div>
				</div>
				<div class="row">
					<hr>
				</div>
                </div>
        </div>
        <div class="panel-footer">
			<a class="btn btn-default btn-lg" href="<?php echo $own_links;?>">Batal</a>            
			<button class="btn btn-primary pull-right btn-lg" type="submit">Lanjut</button>
            <button type="button" class="btn btn-danger pull-right btn-lg mb-control" data-box="#message-box-danger" style="margin-right:10px">Reject Data</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
   </form>     
     <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/reject" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
        <div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Keterangan</div>
                    <div class="mb-content">
						<div class="form-group">
							<div class="col-md-12">
								<input type="text" name="ket_reject" class="form-control" value="" placeholder="Masukan keterangan Reject"/>
                            </div>
                        </div>
                    </div>
                    <div class="mb-footer">
						<button class="btn btn-primary pull-left" type="submit">Reject Data</button>
                        <button class="btn btn-default pull-right mb-control-close">Batal</button>
                    </div>
                </div>
            </div>
        </div>
   </form>     
        <div class="modal" id="modal_img" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="$('#modal_img').slideUp();"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="defModalHead">Lampiran Surat Keterangan</h4>
                    </div>
                    <div class="modal-body">
						<img alt="" id="kta_lampiran1" src="<?php echo empty($val->kta_lampiran3)?'Lampiran Surat Keterangan':get_image(base_url()."assets/collections/kta/medium/".$val->kta_lampiran3); ?>" style="height:450px;width:300px; border:1px solid #000;" ><br/>
                        <button type="button" class="btn btn-danger" onclick="$('#modal_img').slideUp();">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
    var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';
    var IS_API = "<?php echo cfg('status_get_api')=='Ya'?1:0;?>";

	$(document).ready(function(){		
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


</script>