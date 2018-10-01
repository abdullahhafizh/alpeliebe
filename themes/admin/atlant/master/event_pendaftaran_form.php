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
                        <div class="col-md-8">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_nama_lengkap"  value="<?php echo isset($val->kta_nama_lengkap)?$val->kta_nama_lengkap:'';?>" id="kta_nama_lengkap" class="validate[required] form-control" placeholder="Masukan Nama Lengkap sesuai KTP"/>
                            </div>  
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                        <div class="col-md-4">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_no_ktp" id="kta_no_ktp"  value="<?php echo isset($val->kta_no_id)?$val->kta_no_id:'';?>" id="kta_no_ktp" class="validate[required] form-control" placeholder="Masukan No. NIK / KTP / E-KTP" maxlength="16"/>
                            </div>  
                            <div id="status"></div
							<span class="help-block"><code>* Wajib Diisi</code></span>						
                       </div>
                    </div>
                    <?php
	                    
	                    $tmp_tgl = isset($val)&&trim($val->kta_tgl_lahir)!=""?explode("-",$val->kta_tgl_lahir):array();
                    ?>
                    <div class="form-group">                                        
                        <div class="col-md-3">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_tempat_lahir"  value="<?php echo isset($val->kta_tempat_lahir)?$val->kta_tempat_lahir:'';?>" id="kta_nama_lengkap" class="validate[required] form-control" placeholder="Masukan Tempat Lahir"/>
                            </div>  
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        
                        <div class="col-md-3">
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
                                <span class="input-group-addon"><i class="fa fa-male"></i></span>
                                <select class="validate[required] form-control" name="kta_jenkel" id="kta_jenkel">
                                    <?php foreach((array)cfg('jenkel') as $kj=>$vj){?>
                                    <option value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_jenkel==$kj?'selected="selected"':'';?> ><?php echo $vj;?></option>
                                    <?php } ?>
                                </select>

                            </div>                                                                                                                                       
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-xs-12">                                            
                            <textarea class="form-control" rows="3" style="font-size:18px;" name="kta_alamat" id="kta_alamat" placeholder="Masukan Alamat Lengkap"><?php echo isset($val->kta_alamat)?$val->kta_alamat:'';?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_nomor_kartu_old"  value="<?php echo isset($val->kta_nomor_kartu_old)?$val->kta_nomor_kartu_old:'';?>" id="kta_nomor_kartu_old" class="form-control" placeholder="Masukan No. KTA Lama"/>
                            </div>  
                       </div>
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_nomor_kartu"  value="<?php echo isset($val->kta_nomor_kartu)?$val->kta_nomor_kartu:'';?>" id="kta_nomor_kartu_old" class="form-control" placeholder="No. KTA" readOnly />
                            </div>  
                       </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <!--<select class="form-control validate[required]" id="kta_status_nikah" name="kta_status_nikah">-->
								<select class="form-control" id="kta_status_nikah" name="kta_status_nikah">
                                    <option value=""> - pilih status perkawinan	 - </option>
                                    <?php foreach((array)cfg('status_nikah') as $kj=>$vj){?>
                                    <option value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_status_nikah==$kj?'selected="selected"':'';?> ><?php echo $vj;?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                            <!--<span class="help-block"><code>* Wajib Diisi</code></span>-->
                        </div>
                        <div class="col-md-8">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" name="kta_nama_pasangan"  value="<?php echo isset($val->kta_namasuami)?$val->kta_namasuami:'';?>" id="kta_nama_pasangan" class="form-control" placeholder="Masukan Nama Pasangan (Suami / Istri)"/>
                            </div>  
                        </div>
                            <span class="help-block"><code>* Wajib Diisi (jika sudah menikah)</code></span>						
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <select class="form-control" id="kta_agama" name="kta_agama">
                                    <option value=""> - pilih agama - </option>
                                    <?php foreach ((array)get_agama() as $m) {
                                      $s = isset($val)&&$val->kta_agama==$m->agama_id?'selected="selected"':'';
                                      echo "<option value='".$m->agama_id."' $s >".$m->agama_nama."</option>";
                                    }?>
                                </select> 
                            </div>
                            <span class="help-block"><code>* Wajib Diisi</code></span>						
                        </div>
                        <div class="col-md-4">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <!--<select class="form-control validate[required]" id="kta_pendidikan" name="kta_pendidikan">-->
								<select class="form-control" id="kta_pendidikan" name="kta_pendidikan">
                                    <option value=""> - pilih pendidikan terakhir - </option>
                                    <?php foreach((array)cfg('pendidikan') as $kj=>$vj){?>
                                    <option value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_pendidikan==$kj?'selected="selected"':'';?> ><?php echo $vj;?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                            <!--<span class="help-block"><code>* Wajib Diisi</code></span>-->
                        </div>
                        <div class="col-md-4">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <!--<select class="form-control validate[required] " id="kta_pekerjaan" name="kta_pekerjaan">-->
								<select class="form-control" id="kta_pekerjaan" name="kta_pekerjaan">
                                    <option value=""> - pilih pekerjaan - </option>
                                    <?php foreach ((array)get_pekerjaan() as $m) {
                                      $s = isset($val)&&$val->kta_pekerjaan==$m->pekerjaan_id?'selected="selected"':'';
                                      echo "<option value='".$m->pekerjaan_id."' $s >".$m->pekerjaan_nama."</option>";
                                    }?>
                                </select> 
                            </div>
                            <!--<span class="help-block"><code>* Wajib Diisi</code></span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                                <input type="text" value="<?php echo isset($val->kta_hp)?$val->kta_hp:'';?>" class="form-control" name="kta_hp" id="kta_hp" placeholder="Masukan No. HP"/>
                            </div>  
                        </div>
                        <div class="col-md-3">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                                <input type="text" value="<?php echo isset($val->kta_hp)?$val->kta_hp:'';?>" class="form-control" name="kta_hp" id="kta_hp" placeholder="Masukan No. Telp Rumah "/>
                            </div>  
                        </div>
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                <input type="text" name="kta_email"  value="<?php echo isset($val->kta_email)?$val->kta_email:'';?>" id="kta_email" class="form-control" placeholder="Masukan Alamat Email"/>
                            </div>  
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                <input type="text" name="kta_sosmed_fb"  value="<?php echo isset($val->kta_facebook)?$val->kta_facebook:'';?>" id="kta_sosmed_fb" class="form-control" placeholder="Facebook"/>
                            </div>  
                        </div>
                        <div class="col-md-4">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                <input type="text" name="kta_sosmed_ig"  value="<?php echo isset($val->kta_instagram)?$val->kta_instagram:'';?>" id="kta_sosmed_fb" class="form-control" placeholder="Instagram"/>
                            </div>  
                        </div>
                        <div class="col-md-4">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                <input type="text" name="kta_sosmed_twitter"  value="<?php echo isset($val->kta_twitter)?$val->kta_twitter:'';?>" id="kta_sosmed_fb" class="form-control" placeholder="Twitter"/>
                            </div>  
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <!--<select class="form-control validate[required]" id="kta_jabatan" name="kta_jabatan">-->
								<select class="form-control" id="kta_jabatan" name="kta_jabatan">
                                    <option value=""> - pilih jabatan	 - </option>
                                    <?php foreach((array)cfg('jabatan') as $kj=>$vj){?>
                                    <option value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_jabatan==$kj?'selected="selected"':'';?> ><?php echo $vj;?></option>
                                    <?php } ?>
                                </select> 
                            </div>							
                            <!--<span class="help-block"><code>* Wajib Diisi</code></span>-->
                        </div>
                        <div class="col-md-6">                                                                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <!--<select class="form-control validate[required]" id="kta_tingkat" name="kta_tingkat">-->
								<select class="form-control" id="kta_tingkat" name="kta_tingkat">
                                    <option value=""> - pilih tingkat kepengurusan	 - </option>
                                    <?php foreach((array)cfg('tingkatan') as $kj=>$vj){?>
                                    <option value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_pekerjaan==$kj?'selected="selected"':'';?> ><?php echo $vj;?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                            <!--<span class="help-block"><code>* Wajib Diisi</code></span>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                <input type="text" name="kta_tingkatan_provinsi"  value="<?php echo isset($val->kta_tingkatan_provinsi)?$val->kta_tingkatan_provinsi:'';?>" id="kta_tingkatan_provinsi" class="form-control" placeholder="Nama DPP Provinsi"/>
								</div>  
							</div>
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                <input type="text" name="kta_tingkatan_kabkota"  value="<?php echo isset($val->kta_tingkatan_kabkota)?$val->kta_tingkatan_kabkota:'';?>" id="kta_tingkatan_kabkota" class="form-control" placeholder="Nama DPP Kab / Kota"/>
								</div>  
							</div>
						</div>
                    <div class="form-group">
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                <input type="text" name="kta_tingkatan_kecamatan"  value="<?php echo isset($val->kta_tingkatan_kecamatan)?$val->kta_tingkatan_kecamatan:'';?>" id="kta_tingkatan_kecamatan" class="form-control" placeholder="Nama PK Kecamatan"/>
								</div>  
							</div>
                        <div class="col-md-6">                                            
                            <div class="input-group">                                         
                                <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                <input type="text" name="kta_tingkatan_desa"  value="<?php echo isset($val->kta_tingkatan_desa)?$val->kta_tingkatan_desa:'';?>" id="kta_tingkatan_desa" class="form-control" placeholder="Nama PL Kelurahan / Desa"/>
								</div>  
							</div>
						</div>
                    <div class="form-group">
                        <div class="col-md-12">                                                                                            
                            <div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong>PERHATIAN! LAKUKAN SCAN FORMULIR LEMBAR 1 DAN LEMBAR 2</strong> 
                            </div>                       
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-12" id="btn_upload_foto">
                                    <a href="javascript:void(0);" onclick="upload_foto();" data-toggle="tooltip" data-placement="top" title="Klik disini, foto wajah" class="btn btn-primary btn-lg btn-block"><span class="fa fa-upload"></span>Upload Foto</a>
                                </div>
                    <div class="panel panel-default ithide_upload_foto" style="display:none;">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Upload Foto</h3>
                            </div>
                        </div> 
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px">
									<div class="form-group">
										<input type="file" multiple id="upload_foto" name="upload_foto"/>
									</div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    </div>
					<?php if(isset($val) && trim($val->col1)!=""){?>
                    <div class="panel panel-default">
						<div class="panel-body panel-body-table">
							<div class="row">
								<div class="col-md-8" style="padding: 10px">
									<h3>Foto Yang Terupload</h3>
									<div class="gallery">
										<a href="<?php echo get_image(base_url()."assets/collections/kta/original/".$val->col1);?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
											<div class="image">
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->col1);?>" width="200" class="img-polaroid">
											</div>
											<div class="meta">
												<strong>Foto</strong>
												<span>File hasil dari upload</span>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>						
					<?php } ?>
<!--                            <div class="col-md-6">
                                <div class="col-md-6" id="btn_take_foto_wajah">
                                    <a href="javascript:void(0);" onclick="take_foto_wajah();" data-toggle="tooltip" data-placement="top" title="Klik disini, selanjutnya izinkan browser anda mengakses camera komputer" class="btn btn-primary btn-lg btn-block"><span class="fa fa-camera"></span>Ambil Foto Wajah</a>
                                </div>
                            </div>
                            </div>
-->
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-12" id="btn_upload_ktp">
                                    <a href="javascript:void(0);" onclick="upload_ktp();" data-toggle="tooltip" data-placement="top" title="Klik disini, untuk upload foto KTP" class="btn btn-primary btn-lg btn-block"><span class="fa fa-upload"></span>Upload Foto KTP</a>
                                </div>
<!--                            <div class="col-md-6">
                                <div class="col-md-6" id="btn_take_foto_wajah">
                                    <a href="javascript:void(0);" onclick="take_foto_wajah();" data-toggle="tooltip" data-placement="top" title="Klik disini, selanjutnya izinkan browser anda mengakses camera komputer" class="btn btn-primary btn-lg btn-block"><span class="fa fa-camera"></span>Ambil Foto Wajah</a>
                                </div>
                            </div>
                            </div>
-->
                        </div>
                    </div>
                    <div class="panel panel-default ithide_upload_ktp" style="display:none;">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Upload Foto KTP</h3>
                            </div>
                        </div> 
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px">
									<div class="form-group">
										<input type="file" multiple id="upload_ktp" name="upload_ktp"/>
									</div>
                                </div>
                            </div> 
                        </div>
                    </div>
					<?php if(isset($val) && trim($val->col2)!=""){?>
                    <div class="panel panel-default">
						<div class="panel-body panel-body-table">
							<div class="row">
								<div class="col-md-8" style="padding: 10px">
									<h3>Foto KTP Yang Terupload</h3>
									<div class="gallery">
										<a href="<?php echo get_image(base_url()."assets/collections/kta/original/".$val->col2);?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
											<div class="image">
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->col2);?>" width="200" class="img-polaroid">
											</div>
											<div class="meta">
												<strong>Foto KTP</strong>
												<span>File hasil dari upload</span>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>						
					<?php } ?>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-12" id="btn_upload_lampiran_1">
                                    <a href="javascript:void(0);" onclick="upload_lampiran_1();" data-toggle="tooltip" data-placement="top" title="Klik disini, untuk upload lampiran formulir 1" class="btn btn-primary btn-lg btn-block"><span class="fa fa-upload"></span>Upload Lampiran Formulir 1</a>
                                </div>
<!--                            <div class="col-md-6">
                                <div class="col-md-6" id="btn_take_foto_wajah">
                                    <a href="javascript:void(0);" onclick="take_foto_wajah();" data-toggle="tooltip" data-placement="top" title="Klik disini, selanjutnya izinkan browser anda mengakses camera komputer" class="btn btn-primary btn-lg btn-block"><span class="fa fa-camera"></span>Ambil Foto Wajah</a>
                                </div>
                            </div>
                            </div>
-->
                        </div>
                    </div>
                    <div class="panel panel-default ithide_upload_lampiran_1" style="display:none;">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Upload Formulir Lampiran 1</h3>
                            </div>
                        </div> 
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px">
									<div class="form-group">
										<input type="file" multiple id="upload_lampiran_1" name="upload_lampiran_1"/>
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
										<a href="<?php echo get_image(base_url()."assets/collections/kta/original/".$val->kta_lampiran1);?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
											<div class="image">
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_lampiran1);?>" width="200" class="img-polaroid">
											</div>
											<div class="meta">
												<strong>File Utama</strong>
												<span>File hasil dari upload</span>
											</div>
										</a>
										<?php if(!empty(trim($val->kta_foto_wajah))){?>
										<a href="<?php echo $val->kta_foto_wajah;?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
											<div class="image">
												<img alt="" src="<?php echo $val->kta_foto_wajah;?>" width="200" class="img-polaroid">
											</div>
											<div class="meta">
												<strong>Foto Wajah</strong>
												<span>File hasil dari crop File Utama</span>
											</div>
										</a>
										<?php } 
										if(!empty(trim($val->kta_foto_ktp))){?>
										<a href="<?php echo $val->kta_foto_ktp;?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
											<div class="image">
												<img alt="" src="<?php echo $val->kta_foto_ktp;?>" width="200" class="img-polaroid">
											</div>
											<div class="meta">
												<strong>Foto KTP</strong>
												<span>File hasil dari crop File Utama</span>
											</div>
										</a>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-12" id="btn_upload_lampiran_2">
                                    <a href="javascript:void(0);" onclick="upload_lampiran_2();" data-toggle="tooltip" data-placement="top" title="Klik disini, untuk upload lampiran formulir 1" class="btn btn-primary btn-lg btn-block"><span class="fa fa-upload"></span>Upload Lampiran Formulir 2</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default ithide_upload_lampiran_2" style="display:none;">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Upload Formulir Lampiran 2</h3>
                            </div>
                        </div> 
                        <div class="panel-body panel-body-table">
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px">
									<div class="form-group">
										<input type="file" multiple id="upload_lampiran_2" name="upload_lampiran_2"/>
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
										<a href="<?php echo get_image(base_url()."assets/collections/kta/original/".$val->kta_lampiran2);?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
											<div class="image">
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/medium/".$val->kta_lampiran2);?>" width="200" class="img-polaroid">
											</div>
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
			<button class="btn btn-primary pull-right btn-lg" type="submit">Lanjut</button>
        </div>
    </form>     

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
		$("#kta_no_ktp").change(function() { 
			var usr = $("#kta_no_ktp").val();
				if(usr.length == 16){					
					$("#status").html('<img src="<?php echo themeUrl();?>img/loader.gif" />&nbsp;Cek Daftar No. KTP...');
/*					if(usr == "1111111111111111" || usr == "2222222222222222" || usr == "3333333333333333" || usr == "4444444444444444" || usr == "5555555555555555"){
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
    						//	$("#status").html('<img src="<?php echo themeUrl();?>img/tick.gif" /> Data KTP dapat digunakan');
    						//	$("#kta_no_ktp").removeClass('object_error'); // if necessary
    						//	$("#kta_no_ktp").addClass("object_ok");
    						//	$("button").removeAttr('disabled');																
    						//	$("#status").ajaxComplete(function(event, request, settings){ 
    								if(msg == 'OK') { 
                                        $("#status").html('&nbsp;<img src="tick.gif" align="absmiddle"> Data KTP dapat digunakan');
    									$("#kta_no_ktp").removeClass('object_error'); // if necessary
    									$("#kta_no_ktp").addClass("object_ok");
    								}else {
                                        $("#status").html(msg);
    									$("#kta_no_ktp").removeClass('object_ok'); // if necessary
    									$("#kta_no_ktp").addClass("object_error");
    									
    								}  
    						//	});
    						} 
					    }); 
//					}
				}else {
					$("#status").html('<font color="red">' +
					'No. KTP / NIK harus <strong>16</strong> karakter</font>');
					$("#username").removeClass('object_ok'); // if necessary
					$("#username").addClass("object_error");
				}
		});
	});
	
    $(document).ready(function(){
        
	    $("#upload_lampiran_1,#upload_lampiran_2,#upload_foto,#upload_ktp").fileinput({
            showUpload: false,
            showCaption: true,
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