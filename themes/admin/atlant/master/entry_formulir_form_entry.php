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
				 <div class="col-md-5">
					<img alt="" id="kta_lampiran1" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_lampiran1); ?>" style="height:100%;width:100%; border:1px solid #000;" >
				 </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <div class="col-md-12">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <!--<input type="text" name="kta_nama_lengkap"  value="<?php echo isset($val->kta_nama_lengkap)?$val->kta_nama_lengkap:'';?>" id="kta_nama_lengkap" class="validate[required] form-control" placeholder="<?php echo $_GET['pengusul']; ?> Masukan Nama Lengkap sesuai KTP"/>-->
								<input type="text" name="kta_nama_lengkap"  value="<?php echo isset($val->kta_nama_lengkap)?$val->kta_nama_lengkap:'';?>" id="kta_nama_lengkap" class="validate[required] form-control" placeholder="Masukan Nama Lengkap sesuai KTP" maxlength="100"/>
                            </div>  
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <div class="col-md-12">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_no_ktp" id="kta_no_ktp"  value="<?php echo isset($val->kta_no_id)?$val->kta_no_id:'';?>" id="kta_no_ktp" class="validate[required] form-control" placeholder="Masukan No. NIK / KTP / E-KTP" maxlength="16" disabled="disabled" />
                            </div>  
                            <div id="status"></div>
							<span class="help-block"><code>* Wajib Diisi</code></span>						
                       </div>
                    </div>					
                    <div class="form-group">                                        
                        <div class="col-md-12">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_tempat_lahir"  value="<?php echo isset($val->kta_tempat_lahir)?$val->kta_tempat_lahir:'';?>" id="kta_tempat_lahir" class="validate[required] form-control" placeholder="Masukan Tempat Lahir" maxlength="100"/>
                            </div>  
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                        </div>
                    <?php	                    
	                    $tmp_tgl = isset($val)&&trim($val->kta_tgl_lahir)!=""?explode("-",$val->kta_tgl_lahir):array();
                    ?>
                    <div class="form-group">                                        
                        <div class="col-md-4">
                            <div class="input-group">
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
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>                        
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                                
                                <select class="validate[required] form-control" name="kta_bln_lahir" id="kta_bln_lahir" >
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
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                        
                        <div class="col-md-4">
                            <div class="input-group">
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
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>                        
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">  
                            <div class="input-group">                                         
                                <span class="input-group-addon"> Jenis Kelamin </span> &nbsp;
                                    <?php foreach((array)cfg('jenkel') as $kj=>$vj){?>
									<label class="check"><input type="radio" class="validate[required] iradio" name="kta_jenkel" value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_jenkel==$kj?'checked="checked"':'';?>/> <?php echo $vj;?> </label> &nbsp;
                                    <?php } ?>
                            </div>                                                                                                                                       
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-xs-12">                                            
                                <input type="text" name="kta_alamat"  value="<?php echo isset($val->kta_alamat)?$val->kta_alamat:'';?>" id="kta_alamat" class="form-control" placeholder="Masukan Alamat Lengkap"/>
                        </div>
                    </div>
                    <div class="form-group">                                        
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                                
                                <input type="text" name="kta_rt"  value="<?php echo isset($val->kta_rt)?$val->kta_rt:'';?>" id="kta_rt" class="validate[custom[onlyNumberSp]] form-control" size="10" maxlength="3" placeholder="RT"/>
                            </div>
                        </div>                        
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                                
                                <input type="text" name="kta_rw"  value="<?php echo isset($val->kta_rw)?$val->kta_rw:'';?>" id="kta_rw" class="validate[custom[onlyNumberSp]] form-control" size="10" maxlength="3" placeholder="RW"/>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>                                
                                <input type="text" name="kta_kodepos"  value="<?php echo isset($val->kta_kodepos)?$val->kta_kodepos:'';?>" id="kta_nama_lengkap" class="validate[custom[onlyNumberSp]] form-control" placeholder="KODE POS" maxlength="5"/>
                            </div>
                        </div>                        
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control validate[required] " id="kta_propinsi" name="kta_propinsi">
                                    <option value=""> - pilih provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
                                      $s = isset($val)&&$val->kta_propinsi==$m->propinsi_id?'selected="selected"':'';
                                      echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama." (".$m->propinsi_kode.")</option>";
                                    }?>
                                </select> 
                            </div>
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control validate[required] " id="kta_kabupaten" name="kta_kabupaten">
                                    <option value=""> - pilih kabupaten - </option>
                                </select> 
                            </div>
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                    </div>
                    <div class="form-group">
						<div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control validate[required] " id="kta_kecamatan" name="kta_kecamatan">
                                    <option value=""> - pilih kecamatan - </option>
                                </select> 
                            </div>
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control validate[required] " id="kta_kelurahan" name="kta_kelurahan">
                                    <option value=""> - pilih kelurahan - </option>
                                </select> 
                            </div>
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                    <div class="form-group">
                            <div class="input-group">                                         
                                <span class="input-group-addon"> Apakah anda bertempat tinggal di daerah Kab/Kota sesuai dg. KTP/E-KTP? </span> &nbsp;
                                    <?php foreach((array)cfg('domisili') as $kj=>$vj){?>
									<label class="check"><input type="radio" class="iradio" name="kta_domisili" value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_domisili==$kj?'checked="checked"':'';?>/> <?php echo $vj;?> &nbsp;</label>
                                    <?php } ?>
                            </div>                                                                                                                                       
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="alert alert-warning" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong>Perhatian!</strong> Domisili mempengaruhi penomoran pada NPAPG, mohon isi dengan benar sesuai formulir.
                            </div>                       
                        </div>
                    </div>
                    <?php
	                    
	                    $tmp_tgl = isset($val)&&trim($val->kta_tgl_lahir)!=""?explode("-",$val->kta_tgl_lahir):array();
                    ?>
                    <div class="form-group">
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_nomor_kartu_old"  value="<?php echo isset($val->kta_nomor_kartu_old)?$val->kta_nomor_kartu_old:'';?>" id="kta_nomor_kartu_old" class="validate[custom[onlyNumberSp]] form-control" placeholder="Masukan No. KTA Lama" maxlength="11"/>
                            </div>  
                       </div>
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_nomor_kartu"  value="<?php echo isset($val->kta_nomor_kartu)?$val->kta_nomor_kartu:'';?>" id="kta_nomor_kartu_old" class="validate[custom[onlyNumberSp]] form-control" placeholder="No. KTA Baru" disabled="disabled" />
                            </div>  
                       </div>
                    </div>
				</div>

				
				</div>
				</div>
				<div class="row">
					<hr>
				</div>
				<div class="row">
				 <div class="col-md-5">
					<img alt="" id="kta_lampiran2" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_lampiran2); ?>" style="height:100%;width:100%; border:1px solid #000;" />
					<button class="btn btn-primary" id="btn-suket" type="button" title="Download cropped image" onclick="$('#modal_img').slideDown();" style="margin-top: 10px;">Lihat Surat Keterangan</button>
				 </div>
                <div class="col-md-7">		
                    <div class="form-group">
                        <div class="col-md-12 ">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <!--<select class="form-control validate[required]" id="kta_status_nikah" name="kta_status_nikah">-->
                                <select class="validate[required] form-control" id="kta_status_nikah" name="kta_status_nikah">
                                    <option value=""> - pilih status nikah - </option>
                                    <?php foreach((array)cfg('status_nikah') as $kj=>$vj){
											  $s = isset($val)&&$val->kta_status_nikah==$kj?'selected="selected"':'';
											  echo "<option value='".$kj."' $s >".$vj."</option>";
                                    } ?>
                                </select> 
                            </div>
                            <!--<span class="help-block"><code>* Wajib Diisi</code></span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_nama_pasangan"  value="<?php echo isset($val->kta_namasuami)?$val->kta_namasuami:'';?>" id="kta_nama_pasangan" class="form-control" placeholder="Masukan Nama Suami / Istri" disabled="disabled" maxlength="100">
                            </div>  
                        </div>
                     </div>
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"> Agama </span> &nbsp;
                                    <?php foreach ((array)get_agama() as $m) {
                                      $s = isset($val)&&$val->kta_agama==$m->agama_id?'checked="checked"':'';
                                      echo "<label class='check'><input type='radio' class='iradio' name='kta_agama' value='".$m->agama_id."' $s /> ".$m->agama_nama." &nbsp; </label> 	";
                                    }?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon">Pendidikan</span> &nbsp;
                                <!--<select class="form-control validate[required]" id="kta_pendidikan" name="kta_pendidikan">-->
                                    <?php foreach((array)cfg('pendidikan') as $kj=>$vj){?>
									<label class="check"><input type="radio" class="iradio" name="kta_pendidikan" value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_pendidikan==$kj?'checked="checked"':'';?>/> <?php echo $vj;?> </label> &nbsp;
                                    <?php } ?>
                            </div>
                            <!--<span class="help-block"><code>* Wajib Diisi</code></span>-->
                        </div>
                        </div>
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <span class="input-group-addon">Pekerjaan </span> &nbsp;
                            <div class="input-group">                                         
                                <!--<select class="form-control validate[required] " id="kta_pekerjaan" name="kta_pekerjaan">-->
                                    <?php foreach ((array)get_pekerjaan() as $m) {
                                      $s = isset($val)&&$val->kta_pekerjaan==$m->pekerjaan_id?'checked="checked"':'';
                                      echo "<label class='check'><input type='radio' class='validate[required] iradio' name='kta_pekerjaan' value='".$m->pekerjaan_id."' $s /> ".$m->pekerjaan_nama." &nbsp; </label> 	";
                                    }?>
                            </div>
                            <!--<span class="help-block"><code>* Wajib Diisi</code></span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                                <input type="text" value="<?php echo isset($val->kta_hp)?$val->kta_hp:'';?>" class="validate[custom[onlyNumberSp]] form-control" name="kta_hp" id="kta_hp" placeholder="Masukan No. HP" maxlength="12"/>
                            </div>  
                        </div>
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                                <input type="text" value="<?php echo isset($val->kta_telp)?$val->kta_telp:'';?>" class="validate[custom[onlyNumberSp]] form-control" name="kta_telp" id="kta_telp" placeholder="Masukan No. Telp Rumah " maxlength="12"/>
                            </div>  
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                <input type="text" name="kta_email"  value="<?php echo isset($val->kta_email)?$val->kta_email:'';?>" id="kta_email" class="validate[custom[email]] form-control" placeholder="Masukan Alamat Email" maxlength="100"/>
                            </div>  
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                <input type="text" name="kta_sosmed_fb"  value="<?php echo isset($val->kta_facebook)?$val->kta_facebook:'';?>" id="kta_sosmed_fb" class="form-control" placeholder="Facebook" maxlength="100"/>
                            </div>  
                        </div>
                        </div>
                    <div class="form-group">					
                        <div class="col-md-12">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                <input type="text" name="kta_sosmed_twitter"  value="<?php echo isset($val->kta_twitter)?$val->kta_twitter:'';?>" id="kta_sosmed_fb" class="form-control" placeholder="Twitter" maxlength="100"/>
                            </div>  
                        </div>
                        </div>
                    <div class="form-group">					
                        <div class="col-md-12">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                <input type="text" name="kta_sosmed_ig"  value="<?php echo isset($val->kta_instagram)?$val->kta_instagram:'';?>" id="kta_sosmed_fb" class="form-control" placeholder="Instagram" maxlength="100"/>
                            </div>  
                        </div>
                    </div>
                    <div class="form-group">
<!--
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
								<select class="form-control" id="kta_jabatan" name="kta_jabatan">
                                    <option value="0"> - pilih jabatan	 - </option>
                                    <?php foreach((array)cfg('jabatan') as $kj=>$vj){?>
                                    <option value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_jabatan==$kj?'selected="selected"':'';?> ><?php echo $vj;?></option>
                                    <?php } ?>
                                </select> 
                            </div>							
                        </div>
-->
                        <div class="col-md-12">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control" id="kta_tingkatan" name="kta_tingkatan">
                                    <option value=""> - pilih tingkat kepengurusan - </option>
                                    <?php foreach((array)cfg('tingkatan') as $kj=>$vj){
											  $s = isset($val)&&$val->kta_tingkatan==$kj?'selected="selected"':'';
											  echo "<option value='".$kj."' $s >".$vj."</option>";
                                    } ?>
                                </select> 
                            </div>
                            <!--<span class="help-block"><code>* Wajib Diisi</code></span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control" id="kta_tingkat_propinsi" name="kta_tingkat_propinsi" disabled="disabled">
                                    <option value=""> - pilih nama DPP provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
                                      $s = isset($val)&&$val->kta_tingkatan_provinsi==$m->propinsi_id?'selected="selected"':'';
                                      echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama."</option>";
                                    }?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control" id="kta_tingkat_kabupaten" name="kta_tingkat_kabupaten" disabled="disabled">
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
						<div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control" id="kta_tingkat_kecamatan" name="kta_tingkat_kecamatan" disabled="disabled">
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control" id="kta_tingkat_kelurahan" name="kta_tingkat_kelurahan" disabled="disabled">
                                </select> 
                            </div>
                        </div>
						</div>
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"> Keanggotaan Trikarya </span> &nbsp;
                                    <?php foreach((array)cfg('trikarya') as $kj=>$vj){?>
									<label class="check"><input type="radio" class="iradio" name="trikarya" value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_trikarya==$kj?'checked="checked"':'';?>/> <?php echo $vj;?> </label> &nbsp;
                                    <?php } ?>
                            </div>
                        </div>
						</div>
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"> Keanggotaan ORSA </span> &nbsp;
                                    <?php foreach((array)cfg('sayap') as $kj=>$vj){?>
									<label class="check"><input type="radio" class="iradio" name="sayap" value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_sayap==$kj?'checked="checked"':'';?>/> <?php echo $vj;?> </label> &nbsp;
                                    <?php } ?>
                            </div>
                        </div>
						</div>
						<div class="form-group">
						<?php	                    
							$tmp_hk = isset($val)&&trim($val->kta_hastakarya)!=""?explode(",",$val->kta_hastakarya):array();
						?>
                        </div>
                        <div class="col-md-12">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"> ORMAS </span> &nbsp;
                                    <?php 
										$a=-1;
									foreach((array)cfg('hasta_karya') as $kj=>$vj){
										$a++;
                                  		$tmp1 = isset($tmp_hk[$a])?$tmp_hk[$a]:'';
									?>
                                     <label class="check"><input type="checkbox" class="icheckbox" name="hastakarya[]" value="<?php echo $kj;?>" <?php echo isset($val)&&$tmp1==$kj?'checked="checked"':'';?>/> <?php echo $kj;?> </label> &nbsp;   
                                    <?php }  ?>
                            </div>
                            </div>
                        </div>
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
/*    $(document).ready(function(){
        $('#kta_no_ktp').keyup(check_ktp); //use keyup,blur, or change
    });

/*    function check_ktp(){
        var ktp = $('#kta_no_ktp').val();
        jQuery.ajax({
            type: 'POST',
            url: URL_AJAX,
            data: 'ktp='+ ktp,
            cache: false,
            success: function(response){
                if(response == 0){
                    alert('available')
                }else {
                    alert('not available')
                    //do perform other actions like displaying error messages etc.,
                }
            }
        });
    }
*/
    pic1 = new Image(16, 16); 
    pic1.src = "<?php echo themeUrl();?>img/loader.gif";
    $(document).ready(function(){
				$("#kta_status_nikah").change(function() { 
					var e = document.getElementById("kta_status_nikah");
					var selectedTingkat = e.options[e.selectedIndex].text;
					if(selectedTingkat == "Kawin"){
					   $("#kta_nama_pasangan").removeAttr('disabled');						
					}else{
					   $("#kta_nama_pasangan").attr('disabled','disabled');												
					}		
				});
				$("#kta_tingkatan").change(function() { 
					var e = document.getElementById("kta_tingkatan");
					var selectedTingkat = e.options[e.selectedIndex].text;
					if(selectedTingkat == "DPD PROV."){
					   $("#kta_tingkat_kabupaten").attr('disabled','disabled')												
					   $("#kta_tingkat_kecamatan").attr('disabled','disabled');												
					   $("#kta_tingkat_kelurahan").attr('disabled','disabled');												
					   $("#kta_tingkat_propinsi").removeAttr('disabled');												
					}else if(selectedTingkat == "DPD KAB/KOTA"){
					   $("#kta_tingkat_kabupaten").removeAttr('disabled');												
					   $("#kta_tingkat_kecamatan").attr('disabled','disabled');												
					   $("#kta_tingkat_kelurahan").attr('disabled','disabled');												
					   $("#kta_tingkat_propinsi").removeAttr('disabled');												
					}else if(selectedTingkat == "PK KEC"){
					   $("#kta_tingkat_kabupaten").removeAttr('disabled');												
					   $("#kta_tingkat_kecamatan").removeAttr('disabled');												
					   $("#kta_tingkat_kelurahan").attr('disabled','disabled');												
					   $("#kta_tingkat_propinsi").removeAttr('disabled');												
					}else if(selectedTingkat == "PL DS/KEL"){
					   $("#kta_tingkat_kabupaten").removeAttr('disabled');												
					   $("#kta_tingkat_kecamatan").removeAttr('disabled');												
					   $("#kta_tingkat_kelurahan").removeAttr('disabled');												
					   $("#kta_tingkat_propinsi").removeAttr('disabled');																		
					}else{
					   $("#kta_tingkat_kabupaten").attr('disabled','disabled');												
					   $("#kta_tingkat_kecamatan").attr('disabled','disabled');												
					   $("#kta_tingkat_kelurahan").attr('disabled','disabled');												
					   $("#kta_tingkat_propinsi").attr('disabled','disabled');																		
					}		
				});
		$("#kta_no_ktp").change(function() { 
            var usr = $("#kta_no_ktp").val();
                if(usr.length == 16){                   
                    $("#status").html('<img src="<?php echo themeUrl();?>img/loader.gif" />&nbsp;Cek Daftar No. KTP...');
/*                  if(usr == "1111111111111111" || usr == "2222222222222222" || usr == "3333333333333333" || usr == "4444444444444444" || usr == "5555555555555555"){
                        $("#status").html('<font color="red">No. KTP telah digunakan.</font>');                             
                            $("#kta_no_ktp").removeClass('object_ok'); // if necessary
                            $("#kta_no_ktp").addClass("object_error");
                            $("button").attr('disabled','disabled');
                    }else{
*/
                    /*if(cek > 0){
                        $("#status").html('<font color="red">No. KTP <strong></strong> telah digunakan.</font>');                               
                        $("#kta_no_ktp").removeClass('object_ok'); // if necessary
                        $("#kta_no_ktp").addClass("object_error");
                    }else{*/

                        $.ajax({  
                            type: "POST",  
                            //url: "<?php echo base_url();?>/check.php",  
                            url: URL_AJAX + "/ktp",
                            data: {ktp: usr},
                            success: function(msg){  
                            //  $("#status").html('<img src="<?php echo themeUrl();?>img/tick.gif" /> Data KTP dapat digunakan');
                            //  $("#kta_no_ktp").removeClass('object_error'); // if necessary
                            //  $("#kta_no_ktp").addClass("object_ok");
                            //  $("button").removeAttr('disabled');                                                             
                            //  $("#status").ajaxComplete(function(event, request, settings){ 
                                    if(msg == 'OK') { 
                                        $("#status").html('&nbsp;<img src="tick.gif" align="absmiddle"> Data KTP dapat digunakan');
                                        $("#kta_no_ktp").removeClass('object_error'); // if necessary
                                        $("#kta_no_ktp").addClass("object_ok");
                                    }else {
                                        $("#status").html(msg);
                                        $("#kta_no_ktp").removeClass('object_ok'); // if necessary
                                        $("#kta_no_ktp").addClass("object_error");
                                        
                                    }  
                            //  });
                            } 
                        }); 
//                  }
                }else {
                    $("#status").html('<font color="red">' +
                    'No. KTP / NIK harus <strong>16</strong> karakter</font>');
                    $("#username").removeClass('object_ok'); // if necessary
                    $("#username").addClass("object_error");
                }
        });
    });
    $(document).ready(function(){
    	$('#kta_lampiran1,#kta_lampiran2').elevateZoom({
//    		zoomLevel: 2,
//			lensSize: 50,
//			lensShape: "round",
//			scrollZoom: true,
    	    zoomType: "inner",
    	    easing: true,
    		cursor: "crosshair"
		}); 
		   
	    $("#upload_lampiran_1,#upload_lampiran_2").fileinput({
            showUpload: false,
            showCaption: true,
            browseClass: "btn btn-danger",
            fileType: "any"
	    });

       $("input[type='button']").click(function(){
            var radioValue = $("input[name='gender']:checked").val();
            if(radioValue){
                alert("Your are a - " + radioValue);
            }
        });
	$('#kta_status_nikah').change(function(){
  		  var e = $("input[name='kta_status_nikah']:checked").val();
		  if(e == "1" || selectedTingkat == "2"){
				$("#kta_nama_pasangan").attr('disabled','disabled');
		  }
      });

      <?php if(isset($val)){?>
      get_kabupaten('<?php echo $val->kta_propinsi;?>','<?php echo $val->kta_kabupaten;?>');
      get_t_kabupaten('<?php echo $val->kta_tingkatan_provinsi;?>','<?php echo $val->kta_tingkatan_kabkota;?>');
      get_kecamatan('<?php echo $val->kta_kabupaten;?>','<?php echo $val->kta_kecamatan;?>');
      get_t_kecamatan('<?php echo $val->kta_tingkatan_kabkota;?>','<?php echo $val->kta_tingkatan_kecamatan;?>');
      get_kelurahan('<?php echo $val->kta_kecamatan;?>','<?php echo $val->kta_kelurahan;?>');
      get_t_kelurahan('<?php echo $val->kta_tingkatan_kecamatan;?>','<?php echo $val->kta_tingkatan_desa;?>');
					var e = document.getElementById("kta_status_nikah");
					var selectedTingkat = e.options[e.selectedIndex].text;
					if(selectedTingkat == "Kawin"){
					   $("#kta_nama_pasangan").removeAttr('disabled');						
					}else{
					   $("#kta_nama_pasangan").attr('disabled','disabled');												
					}		

					var e = document.getElementById("kta_tingkatan");
					var selectedTingkat = e.options[e.selectedIndex].text;
					if(selectedTingkat == "DPD PROV."){
					   $("#kta_tingkat_kabupaten").attr('disabled','disabled')												
					   $("#kta_tingkat_kecamatan").attr('disabled','disabled');												
					   $("#kta_tingkat_kelurahan").attr('disabled','disabled');												
					   $("#kta_tingkat_propinsi").removeAttr('disabled');												
					}else if(selectedTingkat == "DPD KAB/KOTA"){
					   $("#kta_tingkat_kabupaten").removeAttr('disabled');												
					   $("#kta_tingkat_kecamatan").attr('disabled','disabled');												
					   $("#kta_tingkat_kelurahan").attr('disabled','disabled');												
					   $("#kta_tingkat_propinsi").removeAttr('disabled');												
					}else if(selectedTingkat == "PK KEC"){
					   $("#kta_tingkat_kabupaten").removeAttr('disabled');												
					   $("#kta_tingkat_kecamatan").removeAttr('disabled');												
					   $("#kta_tingkat_kelurahan").attr('disabled','disabled');												
					   $("#kta_tingkat_propinsi").removeAttr('disabled');												
					}else if(selectedTingkat == "PL DS/KEL"){
					   $("#kta_tingkat_kabupaten").removeAttr('disabled');												
					   $("#kta_tingkat_kecamatan").removeAttr('disabled');												
					   $("#kta_tingkat_kelurahan").removeAttr('disabled');												
					   $("#kta_tingkat_propinsi").removeAttr('disabled');																		
					}else{
					   $("#kta_tingkat_kabupaten").attr('disabled','disabled');												
					   $("#kta_tingkat_kecamatan").attr('disabled','disabled');												
					   $("#kta_tingkat_kelurahan").attr('disabled','disabled');												
					   $("#kta_tingkat_propinsi").attr('disabled','disabled');																		
					}		
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

      $('#kta_tingkat_propinsi').change(function(){
          get_t_kabupaten($(this).val(),"");
      });
      $('#kta_tingkat_kabupaten').change(function(){
          get_t_kecamatan($(this).val(),"");
      });
	  
      $('#kta_tingkat_kecamatan').change(function(){
          get_t_kelurahan($(this).val(),"");
      });

	 
	  
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

    function get_t_kabupaten(prov,kab){
      $.post(URL_AJAX+"/kabupaten",{prov:prov,kab:kab},function(o){
        $('#kta_tingkat_kabupaten').html(o);
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

    function get_t_kecamatan(prov,kab){
      $.post(URL_AJAX+"/kecamatan",{prov:prov,kab:kab},function(o){
        $('#kta_tingkat_kecamatan').html(o);
      });
    }

    function get_t_kelurahan(prov,kab){
      $.post(URL_AJAX+"/kelurahan",{prov:prov,kab:kab},function(o){
        $('#kta_tingkat_kelurahan').html(o);
      });
    }

    function get_ktp(ktp){
      $.post(URL_AJAX+"/ktp",{ktp:ktp},function(o){
        $('#kta_no_ktp').html(o);
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