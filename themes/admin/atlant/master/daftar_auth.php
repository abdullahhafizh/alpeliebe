<style type="text/css">
.border_camera{
    width:170px;height:130px;
    border:5px solid #FE4A3F;
    margin: 10px;
}
</style>
<?php js_validate();?>
                            
    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
        <input type="hidden" name="kta_type_wajah" id="kta_type_wajah" value="<?php echo isset($val->kta_type_wajah)?$val->kta_type_wajah:'';?>" />
        <input type="hidden" name="kta_type_ktp" id="kta_type_ktp" value="<?php echo isset($val->kta_type_ktp)?$val->kta_type_ktp:'';?>" />
        <div class="panel-body">                                                                        
            
            <div class="row">
                
                <div class="col-md-7">
                    
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                <select class="validate[required] form-control" name="kta_tipe" id="kta_tipe">
                                    <option value="1" <?php echo isset($val)&&$val->kta_tipe==1?'selected="selected"':'';?>>Koperasi</option>
                                    <option value="0" <?php echo isset($val)&&$val->kta_tipe==0?'selected="selected"':'';?>>Non-Koperasi</option>
                                </select>
                            </div>
                            <span class="help-block">Apakah Tipe Kartu Koperasi atau Non-Koperasi</span>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control validate[required]" id="kta_koperasi" name="kta_koperasi">
                                    <option value=""> - pilih koperasi - </option>
                                    <?php foreach ((array)get_koperasi() as $m) {
                                      $s = isset($val)&&$val->coop_name==$m->coop_id?'selected="selected"':'';
                                      echo "<option value='".$m->coop_id."' $s >".$m->coop_name."</option>";
                                    }?>
                                </select> 
                            </div>
                            <span class="help-block">Pilih Koperasi</span>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_nama_lengkap"  value="<?php echo isset($val->kta_nama_lengkap)?$val->kta_nama_lengkap:'';?>" id="kta_nama_lengkap" class="validate[required] form-control" placeholder="Masukan Nama Lengkap"/>
                            </div>  
                            <span class="help-block">Masukan Nama Lengkap Pada Kartu Anggota</span>                                        
                        </div>
                    </div>
                    
                    <?php
	                    
	                    $tmp_tgl = isset($val)&&trim($val->kta_tgl_lahir)!=""?explode("-",$val->kta_tgl_lahir):array();
                    ?>
                    <div class="form-group">
                        <div class="col-md-12">  
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-male"></i></span>

                                <select class="validate[required] form-control" name="kta_jenkel" id="kta_jenkel">
                                    <?php foreach((array)cfg('jenkel') as $kj=>$vj){?>
                                    <option value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_jenkel==$kj?'selected="selected"':'';?> ><?php echo $vj;?></option>
                                    <?php } ?>
                                </select>

                            </div>                                                                                                                                       
                            <span class="help-block">Pilih Gender ( Pria/Wanita )</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_tempat_lahir"  value="<?php echo isset($val->kta_tempat_lahir)?$val->kta_tempat_lahir:'';?>" id="kta_nama_lengkap" class="validate[required] form-control" placeholder="Masukan Tempat Lahir"/>
                            </div>  
                            <span class="help-block">Masukan Tempat Lahir</span>                                        
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <div class="col-md-3">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                                
                                <select class="validate[required] form-control" name="kta_tgl_lahir" id="kta_tgl_lahir">
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
                            <span class="help-block">Masukan Tanggal lahir</span>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                                
                                <select class="validate[required] form-control" name="kta_bln_lahir" id="kta_bln_lahir">
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
                            <span class="help-block">Masukan Bulan lahir</span>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                                
                                <select class="validate[required] form-control" name="kta_thn_lahir" id="kta_thn_lahir">
                                   <option value=""> - tahun - </option>
                                   <?php for($j=1930;$j<=date("Y");$j++){
	                                   		$tmp3 = isset($tmp_tgl[0])?$tmp_tgl[0]:'';
	                                   	    $slc3 = trim($tmp3)==$j?'selected="selected"':'';
	                                   		echo "<option value='$j' $slc3 >$j</option>";
	                                   }
                                   ?>
                                </select>                                        
                            </div>
                            <span class="help-block">Masukan Tahun lahir</span>
                        </div>
                        
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                <input type="text" name="kta_email"  value="<?php echo isset($val->kta_email)?$val->kta_email:'';?>" id="kta_email" class="form-control" placeholder="Masukan Email"/>
                            </div>  
                            <span class="help-block">Masukan Email</span>                                        
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control" id="kta_agama" name="kta_agama">
                                    <option value=""> - pilih agama - </option>
                                    <?php foreach ((array)get_agama() as $m) {
                                      $s = isset($val)&&$val->kta_agama==$m->agama_id?'selected="selected"':'';
                                      echo "<option value='".$m->agama_id."' $s >".$m->agama_nama."</option>";
                                    }?>
                                </select> 
                            </div>
                            <span class="help-block">Pilih Agama dari Calon Pemilik Kartu</span>

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-7">                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                                <input type="text" value="<?php echo isset($val->kta_hp)?$val->kta_hp:'';?>" class="form-control validate[required]" name="kta_hp" id="kta_hp" placeholder="+629999999"/>
                            </div>  
                            <span class="help-block">Masukan No Handphone Dari Calon Pemilik Kartu</span>                                             
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control validate[required]" id="kta_pekerjaan" name="kta_pekerjaan">
                                    <option value=""> - pilih Pekerjaan - </option>
                                    <option value="1">  PNS (Pegawai Negeri Sipil) </option>
                                    <option value="2">  Pegawai Swasta  </option>
                                    <option value="3">  Wirausaha  </option>
                                    <option value="4">  Petani  </option>
                                    <option value="5">  Nelayan  </option>
                                    <option value="6">  Ibu Rumah Tangga  </option>
                                    <option value="7">  Konsultan  </option>
                                    <option value="8">  Mahasiswa / Pelajar  </option>
                                    <option value="9">  Lainnya  </option>
                                </select> 
                            </div>
                            <span class="help-block">Pilih Jenis Pekerjaan</span>

                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-md-12 col-xs-12">                                            
                            <textarea class="form-control" rows="3" style="font-size:18px;" name="kta_alamat" id="kta_alamat" placeholder="Masukan Alamat Lengkap"><?php echo isset($val->kta_alamat)?$val->kta_alamat:'';?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control " id="kta_propinsi" name="kta_propinsi">
                                    <option value=""> - pilih provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
                                      $s = isset($val)&&$val->kta_propinsi==$m->propinsi_id?'selected="selected"':'';
                                      echo "<option value='".$m->propinsi_id."' $s >".$m->propinsi_nama."</option>";
                                    }?>
                                </select> 
                            </div>
                            <span class="help-block">Pilih Provinsi dari Calon Pemilik Kartu</span>

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control " id="kta_kabupaten" name="kta_kabupaten">
                                    <option value=""> - pilih kabupaten - </option>
                                    <option value="124"> Jakarta Selatan </option>
                                </select> 
                            </div>
                            <span class="help-block">Pilih Kabupaten dari Calon Pemilik Kartu</span>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group input-group-lg">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control " id="kta_kecamatan" name="kta_kecamatan">
                                    <option value=""> - pilih kecamatan - </option>
                                    <option value="10075"> Kebayoran Lama </option>
                                </select> 
                            </div>
                            <span class="help-block">Pilih Kecamatan dari Calon Pemilik Kartu</span>

                        </div>
                    </div>
					
                    
                    
                </div>
                <div class="col-md-5">

                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-6" id="btn_take_foto_wajah">
                                    <a href="javascript:void(0);" onclick="take_foto_wajah();" data-toggle="tooltip" data-placement="top" title="Klik disini, selanjutnya izinkan browser anda mengakses camera komputer" class="btn btn-primary btn-lg btn-block"><span class="fa fa-camera"></span>Ambil Foto Wajah</a>
                                </div>
                                <div class="col-md-6" id="btn_upload_foto_wajah">
                                    <a href="javascript:void(0);" onclick="upload_foto_wajah();" data-toggle="tooltip" data-placement="top" title="Klik disini, untuk upload foto wajah anda" class="btn btn-primary btn-lg btn-block"><span class="fa fa-upload"></span>Upload Foto Wajah</a>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:10px;">
                                <div class="col-md-6" id="btn_take_foto_id">
                                    <a href="javascript:void(0);" onclick="take_foto_id();" data-toggle="tooltip" data-placement="top" title="Klik disini, selanjutnya izinkan browser anda mengakses camera komputer" class="btn btn-primary btn-lg btn-block"><span class="fa fa-camera"></span>Ambil Foto KTP</a>
                                </div>
                                <div class="col-md-6" id="btn_upload_foto_id">
                                    <a href="javascript:void(0);" onclick="upload_id();" data-toggle="tooltip" data-placement="top" title="Klik disini, Untuk Upload Identitas anda" class="btn btn-primary btn-lg btn-block"><span class="fa fa-upload"></span>Upload Foto KTP</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default ithide_foto_wajah" style="display:none;">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Foto Wajah</h3>
                            </div>
                        </div> 
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group border_camera">
                                        <div id="my_camera_wajah"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group border_camera" id="div_result_wajah" style="display:none;">
                                        <div id="result_camera_wajah">
                                            <?php if(isset($val) && trim($val->kta_foto_wajah)!="" && trim($val->kta_type_wajah)=="foto" ){?>
                                            <img src="data:image/jpeg;base64,<?php echo $val->kta_foto_wajah;?>" />
                                            <?php } ?>
                                        </div>
                                        <input type="hidden" id="kta_foto_wajah" name="kta_foto_wajah" />
                                    </div>
                                </div>
                            </div> 
                            <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="javascript:void(0);" onclick="take_snapshot_wajah();" class="btn btn-primary btn-lg btn-block"><span class="fa fa-camera"></span>Ambil Foto Wajah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default ithide_upload_wajah" style="display:none;">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Upload Foto Wajah</h3>
                            </div>
                        </div> 
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:20px;">
                                        <input type="file" class="fileinput btn-info" name="upload_foto_wajah">
                                            <i class="help-block">Ukuran panjang : 480px, lebar : 360px</i>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group border_camera" id="div_result_wajah" style="display:none;">
                                        <div id="result_camera_wajah">
                                            <?php if(isset($val) && trim($val->kta_foto_wajah)!="" && trim($val->kta_type_wajah)=="upload" ){?>
                                                  <a href="<?php echo get_image(base_url()."assets/collections/kta/original/".$val->kta_foto_wajah);?>" title="Image Photo" class="act_modal" rel="700|400">
                                                    <img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_foto_wajah);?>" style="height:120px;width:160px" class="img-polaroid">
                                                  </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                           
                        </div>
                    </div>


                    <div class="panel panel-default ithide_foto_id" style="display:none;">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Foto Identitas</h3>
                            </div>
                        </div>
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group border_camera">
                                        <div id="my_camera_ktp"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group border_camera" id="div_result_ktp" style="display:none;">
                                        <div id="result_camera_ktp">
                                            <?php if(isset($val) && trim($val->kta_foto_ktp)!="" && trim($val->kta_type_ktp)=="foto" ){?>
                                            <img src="data:image/jpeg;base64,<?php echo $val->kta_foto_ktp;?>" />
                                            <?php } ?>
                                        </div>
                                        <input type="hidden" id="kta_foto_ktp" name="kta_foto_ktp" />
                                    </div>
                                </div>
                            </div> 
                            <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select class="validate[required] form-control" id="kta_jenis_id" name="kta_jenis_id">
                                            <option value=""> - pilih jenis ID - </option>
                                            <?php foreach ((array)cfg('jenis_id') as $key => $value) {
                                                $s = isset($val)&&$val->kta_jenis_id==$key?'selected="selected"':'';
                                                echo "<option value='".$key."' $s >".$key."</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                            <input type="text" class="form-control" name="kta_no_id"  placeholder="No. ID" id="kta_no_id" value="<?php echo isset($val->kta_no_id)?$val->kta_no_id:'';?>">                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="javascript:void(0);" onclick="take_snapshot_ktp();" class="btn btn-primary btn-lg btn-block"><span class="fa fa-camera"></span>Ambil Foto Identitas</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default ithide_upload_id" style="display:none;">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Upload Foto Identitas</h3>
                            </div>
                        </div>
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="padding:20px;">
                                        <input type="file" class="fileinput btn-info" name="upload_foto_id">
                                        <i class="help-block">Ukuran Maksimal 2mb</i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group border_camera" id="div_result_ktp" style="display:none;">
                                        <div id="result_camera_ktp">
                                            <?php if(isset($val) && trim($val->kta_foto_ktp)!="" && trim($val->kta_type_ktp)=="upload" ){?>
                                                  <a href="<?php echo get_image(base_url()."assets/collections/kta/original/".$val->kta_foto_ktp);?>" title="Image Photo" class="act_modal" rel="700|400">
                                                    <img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_foto_ktp);?>" style="height:120px;width:160px" class="img-polaroid">
                                                  </a>                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select class="validate[required] form-control" id="kta_jenis_id" name="kta_jenis_id">
                                            <option value=""> - pilih jenis ID - </option>
                                            <?php foreach ((array)cfg('jenis_id') as $key => $value) {
                                                $s = isset($val)&&$val->kta_jenis_id==$key?'selected="selected"':'';
                                                echo "<option value='".$key."' $s >".$key."</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                            <input type="text" class="form-control" name="kta_no_id"  placeholder="No. ID" id="kta_no_id" value="<?php echo isset($val->kta_no_id)?$val->kta_no_id:'';?>">                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                
            </div>

        </div>
        <div class="panel-footer">
<a class="btn btn-default btn-lg" href="<?php echo $own_links;?>">Batal</a>            
<button class="btn btn-primary pull-right btn-lg" type="submit">Simpan</button>
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
	  
      <?php if(isset($val)){?>
      get_kabupaten('<?php echo $val->kta_propinsi;?>','<?php echo $val->kta_kabupaten;?>');
      get_kecamatan('<?php echo $val->kta_kabupaten;?>','<?php echo $val->kta_kecamatan;?>');
      
      <?php if($val->kta_type_wajah == "foto"){?>
            take_foto_wajah();
      <?php }else{ ?>
            upload_foto_wajah();
      <?php } ?>

      <?php if($val->kta_type_ktp == "foto"){?>
            take_foto_id();
      <?php }else{ ?>
            upload_id();
      <?php } ?>

      $('#div_result_wajah,#div_result_ktp').fadeIn();

      <?php } ?>
	  
      if(IS_API==1){
    	  $('#kta_id_pbsi').blur(function(){
    		  get_atlet_pbsi();
    	  });
      }
	  
      is_atlet();
      $('#kta_tipe').change(function(){
        is_atlet();
      });

    });



    /*function take_snapshot(){
        $('#btn-foto-show').hide();
        $('.ithide').fadeIn();
        init_camera_wajah();
        init_camera_ktp();
    }*/

    function take_foto_wajah(){
        $('#btn_take_foto_wajah,.ithide_upload_wajah').hide();
        $('#btn_upload_foto_wajah').fadeIn();
        $('.ithide_foto_wajah').fadeIn();
        $('#kta_type_wajah').val('foto');
        init_camera_wajah();
    }

    function upload_foto_wajah(){
        $('#btn_upload_foto_wajah,.ithide_foto_wajah').hide();
        $('#btn_take_foto_wajah').fadeIn();
        $('.ithide_upload_wajah').fadeIn();
        $('#kta_type_wajah').val('upload');
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

    function is_atlet(){
        m = $('#kta_tipe').val();
        if( m == 1 ){
            $('.is_atlet').fadeIn();
        }else{
            $('.is_atlet').fadeOut();
        }
    }
    
    function get_atlet_pbsi(){
    	URL_API_PBSI = '<?php echo cfg("url_api");?>';
	    id = $('#kta_id_pbsi').val();
	    $.post(URL_API_PBSI+id,{},function(m){
            if( m.status == 1 ){
                //set value to form..
                obj = m.data[0];
                tgl_lahir = obj.atlet_tgl_lahir.split("-");
                jenkel = obj.atlet_jenis_kelamin=='PRIA'?0:1;
                $('#kta_nama_lengkap').val(obj.atlet_nama);
                $('#kta_id_bwf').val(obj.atlet_id_bwf_intl);
                $('#kta_jenkel').val(jenkel);//0 pria, 1 wanita
                $('#kta_tgl_lahir').val(tgl_lahir[2]);
                $('#kta_bln_lahir').val(tgl_lahir[1]);
                $('#kta_thn_lahir').val(tgl_lahir[0]);
                $('#kta_telp').val(obj.atlet_telepon);
                $('#kta_hp').val(obj.atlet_handphone);
                $('#kta_email').val(obj.atlet_email);
                $('#kta_kodepos').val(obj.atlet_kode_pos);
                $('#kta_alamat').val(obj.atlet_alamat);
                //$('#kta_propinsi').val(obj.atlet_propinsi);
                //get_kabupaten(obj.atlet_propinsi,obj.atlet_kabupaten);
                //$('#kta_kabupaten').val(obj.atlet_kabupaten);
            }
	    });
    }

</script>