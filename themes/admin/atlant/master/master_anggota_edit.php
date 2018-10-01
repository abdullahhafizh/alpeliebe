<style type="text/css">
.border_camera{
    width:170px;height:130px;
    border:5px solid #FE4A3F;
    margin: 10px;
}
.content {
	background-image: url('<?php echo base_url()."assets/images/id_card_front.jpg";?>'); 
	background-size: 350px 220px;
	background-repeat: no-repeat; 
	height:220px; 
	width:350px;
}
.nama,.nomor,.domisili,.masa{
	text-align: right;
}
.nama{
	font-size: 16px;
	font-weight: bold;
	line-height: 20px;
}
.nomor{
	font-size: 12px;
	line-height: 12px;
}
.domisili{
	font-size: 10px;
	line-height: 15px;
}
.masa{
	font-size: 7px;
	margin-top: 5px;
}

.canvas {
	height:650px; 
	width:1063px;
}
.content-lg { 
	background-image: url('<?php echo base_url()."assets/images/id_card_front.jpg";?>'); 
	background-size: 100% 100%;
	background-repeat: no-repeat;
	height:650px; 
	width:1063px;
}
.content-lg-no-foto { 
	background-image: url('<?php echo base_url()."assets/images/id_card_no_foto.jpg";?>'); 
	background-size: 100% 100%;
	background-repeat: no-repeat;
	height:650px; 
	width:1063px;
}
.content-lg-no-image { 
	background-color:transparent; 
	/*background-size: 100% 100%;
	background-repeat: no-repeat;*/
	height:650px; 
	width:1063px;
}
.nama-lg,.nomor-lg,.domisili-lg,.masa-lg{
	text-align: right;
}
.nama-lg{
	font-size: 50px;
	font-weight: bold;
	line-height: 50px;
}
.nomor-lg{
	font-size: 35px;
	line-height: 50px;
}
.domisili-lg{
	font-size: 30px;
	line-height: 28px;
}
.masa-lg{
	font-size: 18px;
	margin-top: 30px;
}
</style>
<?php js_validate();?>
<?php
$status = cfg('status_anggota');
$asuransi = cfg('status_asuransi');
$tipe_kta = cfg('tipe_kta');
$jenkel = cfg('jenkel');
$jenis_bayar = cfg('jenis_bayar');
$status_nikah = cfg('status_nikah');
$pendidikan = cfg('pendidikan');
$pekerjaan = cfg('pekerjaan');
$tingkat = cfg('tingkatan');
$jabatan = cfg('jabatan');
$hastakarya = cfg('hasta_karya');
?>
                            
<div class="panel-body panel-body-table" style="padding:20px 0;">   
    <div class="panel panel-default tabs">
		<div class="panel-body tab-content">
			<div class="tab-pane active" id="tab1">
			    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
			        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />			
			        <input type="hidden" name="npapg_old" id="npapg_old" value="<?php echo isset($val->kta_npapg_old)?$val->kta_npapg_old:'';?>" />			
			        <input type="hidden" name="kta_nomor" id="kta_nomor" value="<?php echo isset($val->kta_nomor)?$val->kta_nomor:'';?>" />			
			        <div class="panel-body">                                                                        			            
			            <div class="row">
			             <div class="col-md-6" style="border:1px solid #000;">
						<img alt="" src="<?php echo empty($val->kta_lampiran1)?base_url().'assets/images/formulir1.jpg':base_url()."assets/collections/kta/original/".$val->kta_lampiran1;?>" style="height:100%;width:100%;" >
						 </div>                
			                <div class="col-md-6">
			                    <h3>Data Anggota</h3>
			                    <table class="table table-striped">
			                        <tbody>
                            <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                                <tr>
                                <td>NPAPG</td>
                                <td width="1">:</td>
                                <td><?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,6)." ".substr($val->kta_nomor_kartu,12,4);?></td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <td width="1">:</td>
                                <td>
								<input type="text" name="kta_nama_lengkap"  value="<?php echo isset($val->kta_nama_lengkap)?$val->kta_nama_lengkap:'';?>" id="kta_nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap sesuai KTP" maxlength="100"/>								
								</td>
                            </tr>
                            <tr>
                                <td>No. KTP / NIK / SUKET</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_no_id; echo $val->kta_no_suket;?></td>
                            </tr>
                        <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td width="1">:</td>
                                <td><?php if(empty($val->kta_jenkel)){ echo "-"; }else{ echo $jenkel[$val->kta_jenkel]; }?></td>
                            </tr>
                            <tr>
                                <td>Tempat / Tanggal lahir</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_tempat_lahir;?> / <?php echo myDate($val->kta_tgl_lahir,"d M Y");?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_alamat;?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="1"></td>
                                <td><?php 
								$rt = isset($val->kta_rt)?$val->kta_rt:'-';
								$rw = isset($val->kta_rw)?$val->kta_rw:'-';
								$kp = isset($val->kta_kodepos)?$val->kta_kodepos:'-';								
								echo "RT/RW : ".$rt." / ".$rw." KODE POS : ".$kp;?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="1"></td>
                                <td>
									<?php 
									foreach ((array)get_domisili_kta($val->kta_id) as $k => $v) {
										echo $v->kel_nama." , ".$v->kec_nama." , ".$v->kab_nama." - ".$v->propinsi_nama;
									}
									?>														
								</td>
                            </tr>
                            <tr>
                                <td>Propinsi</td>
                                <td width="1">:</td>
                                <td>
                                <select class="form-control validate[required] " id="kta_propinsi" name="kta_propinsi">
                                    <option value=""> - pilih provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
                                      $s = isset($val)&&$val->kta_propinsi==$m->propinsi_id?'selected="selected"':'';
                                      echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama." (".$m->propinsi_kode.")</option>";
                                    }?>
                                </select> 
								</td>
                            </tr>
                            <tr>
                                <td>Kabupaten</td>
                                <td width="1">:</td>
                                <td>
                                <select class="form-control validate[required] " id="kta_kabupaten" name="kta_kabupaten">
                                    <option value=""> - pilih kabupaten - </option>
                                </select> 
								</td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td width="1">:</td>
                                <td>
                                <select class="form-control validate[required] " id="kta_kecamatan" name="kta_kecamatan">
                                    <option value=""> - pilih kecamatan - </option>
                                </select> 
								</td>
                            </tr>
                            <tr>
                                <td>Kode Kel. Lama</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_kelurahan;?>
								</td>
                            </tr>
                            <tr>
                                <td>Kelurahan</td>
                                <td width="1">:</td>
                                <td>
                                <select class="form-control validate[required] " id="kta_kelurahan" name="kta_kelurahan">
                                    <option value=""> - pilih kelurahan - </option>
                                </select> 
								</td>
                            </tr>
                            <tr>
                                <td>NPAPG BARU</td>
                                <td width="1">:</td>
                                <td><input type="text" name="npapg"  value="<?php echo isset($val->kta_nomor_kartu)?$val->kta_nomor_kartu:'';?>" id="npapg" class="form-control"/></td>
                            </tr>
                            <tr>
                                <td>Domisili Sesuai KTP</td>
                                <td width="1">:</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>NPAPG Lama</td>
                                <td width="1">:</td>
                                <td><?php echo empty($val->kta_nomor_kartu_old)?"-":$val->kta_nomor_kartu_old;?></td>
                            </tr>
                         <tr>
                                <td colspan="3" align="center">
												<?php if(empty($val->kta_foto_wajah)){ ?>
												<img alt="" src="<?php echo get_image(base_url()."assets/images/no_image.jpg");?>" width="200">
												<img alt="" src="<?php echo get_image(base_url()."assets/images/no_image.jpg");?>" width="200">
												<?php }else{ ?>
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah);?>" width="200">
												<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>												
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/photo/".$val->kta_foto_ktp);?>" width="200">
												<?php } ?>
								</td>
                            </tr>
                            <tr>
                                <td>Upload Foto</td>
                                <td width="1">:</td>
                                <td><input type="file" id="upload_foto" name="upload_foto" class="form-control" accept="image/*"/></td>
                            </tr>
                            <tr>
                                <td>Upload KTP</td>
                                <td width="1">:</td>
                                <td><input type="file" id="upload_ktp" name="upload_ktp" class="form-control" accept="image/*"/></td>
                            </tr>
			                        </tbody>
			                    </table>
			                  
			                </div>
						 </div>
			            <div class="row">
							<hr>
						 </div>                				
			            <div class="row">
			             <div class="col-md-6" style="border:1px solid #000;">
						<img alt="" src="<?php echo empty($val->kta_lampiran2)?base_url().'assets/images/formulir2.jpg':base_url()."assets/collections/kta/original/".$val->kta_lampiran2;?>" style="height:100%;width:100%;" >
						 </div>                				
			                <div class="col-md-6">
			                    <h3>Data Tambahan</h3>
			                        <table class="table table-striped">
			                        <tbody>
                            <tr>
                                <td>Status Pernikahan</td>
                                <td width="1">:</td>
                                <td><?php if($val->kta_status_nikah==0){ echo "-"; }else{ echo $status_nikah[$val->kta_status_nikah];} ?></td>
                            </tr>
                            <tr>
                                <td>Nama Suami / Istri</td>
                                <td width="1">:</td>
                                <td><?php if(empty($val->kta_namasuami) || $val->kta_namasuami =='0'){ echo "-"; }else{ echo $val->kta_namasuami;}?></td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td width="1">:</td>
                                <td>									
								<?php 
									if(empty($val->kta_pekerjaan)){
										echo "-";
									}else{										
										foreach ((array)agama($val->kta_agama) as $k => $v) {
											echo $v->agama_nama;
										}
									}									
									?>														
							</td>
                            </tr>
                            <tr>
                                <td>Pendidikan Terakhir</td>
                                <td width="1">:</td>
                                <td><?php if(empty($val->kta_pendidikan) || $val->kta_pendidikan =='0'){ echo "-"; }else{ echo $pendidikan[$val->kta_pendidikan];}?></td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td width="1">:</td>
                                <td>									
								<?php 
									if(empty($val->kta_pekerjaan)){
										echo "-";
									}else{										
										foreach ((array)pekerjaan($val->kta_pekerjaan) as $k => $v) {
											echo $v->pekerjaan_nama;
										}
									}
									?>														
							</td>
                            </tr>
                            <tr>
                                <td>No. HP</td>
                                <td width="1">:</td>
                                <td><?php  if(empty($val->kta_hp) || $val->kta_hp =='0'){ echo "-"; }else{ echo $val->kta_hp;}?></td>
                            </tr>
                            <tr>
                                <td>No. Telp</td>
                                <td width="1">:</td>
                                <td><?php if(empty($val->kta_telp) || $val->kta_telp =='0'){ echo "-"; }else{ echo $val->kta_telp;}?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td width="1">:</td>
                                <td><?php if(empty($val->kta_email) || $val->kta_email =='0'){ echo "-"; }else{ echo $val->kta_email;}?></td>
                            </tr>
                            <tr>
                                <td>Sosial Media</td>
                                <td width="1"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Facebook</td>
                                <td width="1">:</td>
                                <td><?php echo empty($val->kta_facebook)?"-":$val->kta_facebook;?></td>
                            </tr>
                            <tr>
                                <td>Instagram</td>
                                <td width="1">:</td>
                                <td><?php echo empty($val->kta_instagram)?"-":$val->kta_instagram;?></td>
                            </tr>
                            <tr>
                                <td>Twitter</td>
                                <td width="1"></td>
                                <td><?php echo empty($val->kta_twitter)?"-":$val->kta_twitter;?></td>
                            </tr>
                            <tr>
                                <td>Tingkat Kepengurusan</td>
                                <td width="1">:</td>
                                <td><?php if($val->kta_tingkatan==0){ echo "-"; }else{ echo $tingkat[$val->kta_tingkatan];}?></td>
                            </tr>
<?php
	foreach ((array)get_dpp_kta($val->kta_id) as $k => $v) {
?>
                            <tr>
                                <td>Nama DPD Propinsi</td>
                                <td width="1">:</td>
                                <td><?php echo empty($v->propinsi_nama)?"-":$v->propinsi_nama;?></td>
                            </tr>
                            <tr>
                                <td>Nama DPD Kab / Kota</td>
                                <td width="1">:</td>
                                <td><?php echo empty($v->kab_nama)?"-":$v->kab_nama;;?></td>
                            </tr>
                            <tr>
                                <td>Nama PK Kecamatan</td>
                                <td width="1">:</td>
                                <td><?php echo empty($v->kec_nama)?"-":$v->kec_nama;;?></td>
                            </tr>
                            <tr>
                                <td>Nama PL Kel / Desa</td>
                                <td width="1">:</td>
                                <td><?php echo empty($v->kel_nama)?"-":$v->kel_nama;;?></td>
                            </tr>
<?php
	}
?>
                            <tr>
                                <td>Keanggotaan Hasta Karya</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_trikarya.", ".$val->kta_sayap.", ".$val->kta_hastakarya;?></td>
                            </tr>
			                            <tr>
			                                <td colspan="3"><hr></td>
			                            </tr>
										<tr>
											<td>Operator Scan</td>
											<td width="1">:</td>
											<td><?php echo $val->col3."<i>  Tanggal Upload : ".myDate($val->time_scan,"d M Y H:i:s")."</i>";?></td>
										</tr>
			                            <tr>
			                                <td>Operator Entry</td>
			                                <td width="1">:</td>
											<td><?php echo $val->nama_user."<i>  Tanggal Entry : ".myDate($val->time_entry,"d M Y H:i:s")."</i>";?></td>
			                            </tr>
			                            <tr>
			                                <td>Koordinator Data</td>
			                                <td width="1">:</td>
			                                <td><?php echo $val->user_fullname;?></td>
			                            </tr>
										<tr>
											<td>Status KTA</td>
											<td width="1">:</td>
											<td width="400">
											<?php if($val->kta_status_data == 0 ){
													echo '<span class="label label-warning label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Waiting to Approve"><li class="fa fa fa-spinner"></li> Pending</span>';								
												  }elseif($val->kta_status_data == 1 ){
													echo '<span class="label label-success label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Approved"><li class="fa fa-check-circle"></li> Approved</span>';								
												  }elseif($val->kta_status_data == 2 ){
													echo '<span class="label label-info label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Waiting to Entry"><li class="fa fa fa-spinner"></li> Uploaded</span>';								
												  }elseif($val->kta_status_data == 3){
													echo '<span class="label label-danger label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected by Operator Entry"><li class="glyphicon glyphicon-ban-circle"></li> Rejected</span>';								
												  }elseif($val->kta_status_data == 4){
													echo '<span class="label label-danger label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected by Koordinator Data"><li class="glyphicon glyphicon-ban-circle"></li> Rejected</span>';								
												  }else{
													echo '<span class="label label-danger label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected"><li class="glyphicon glyphicon-ban-circle"></li></span>';								
												  }
											?>
											<?php // link_action($links_table_item,"?_id="._encrypt($r->kta_id));?>
											</td>
										</tr>
			                            <tr>
			                                <td>Tanggal Approve</td>
			                                <td width="1">:</td>
			                                <td><?php echo myDate($val->time_approve,"d M Y H:i:s");?></td>
			                            </tr>
			                            <tr>
			                                <td>Tanggal Reject</td>
			                                <td width="1">:</td>
			                                <td><?php echo myDate($val->time_reject_entry,"d M Y H:i:s");?></td>
			                            </tr>
			                            <tr>
			                                <td>Keterangan Reject</td>
			                                <td width="1">:</td>
			                                <td><?php echo $val->col6;?></td>
			                            </tr>
			                            <tr>
			                                <td>Status Kartu</td>
			                                <td width="1">:</td>
			                                <td>
												<?php if($val->is_cetak == 0 ){
														echo '<span class="label label-warning label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Belum Tercetak"><li class="fa fa fa-spinner"></li> Belum Tercetak</span>';								
													  }elseif($val->is_cetak == 1 ){
														echo '<span class="label label-success label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Tercetak"><li class="fa fa-check-circle"></li> Tercetak</span>';								
													  }else{
														echo '<span class="label label-danger label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected"><li class="glyphicon glyphicon-ban-circle"></li> Rejected</span>';								
													  }
												?>											
											</td>
			                            </tr>
			                            <tr>
			                                <td colspan="3" align="center">
			                                	<div class="content">
													<div style="clear:both;float:right;margin:8px 9px;">
														<?php $qrcode = generate_qr_code(substr($val->kta_nomor_kartu,0,6).substr($val->kta_nomor_kartu,6,6).substr($val->kta_nomor_kartu,12,4));?>
														<img src="<?php echo $qrcode;?>" style="height:38px; width:38px;" />
													</div>
													
													<div style="clear:both;float:right;margin:3px 22px 0 0;">
														<img alt="" src="<?php echo empty($val->kta_foto_wajah)?base_url().'assets/images/no_photo.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah;?>" style="height:97px; width:74px;" >
														<!--
														<img alt="" src="<?php //echo get_image(base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah);?>" style="height:97px; width:74px;" >
														-->
													</div>
											
													<div style="clear:both;float:right;margin-right:22px;">
														<div class="nama"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
														<div class="nomor">NPAPG <?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,6)." ".substr($val->kta_nomor_kartu,12,4);?></div>
														<div class="domisili"><?php echo $val->kab_nama." - ".$val->propinsi_nama;?></div>
														<div class="masa"><?php echo date('m/Y',strtotime($val->time_add));?></div>
													</div>
												</div><br/>
				                                <div class="row">                                
				                                    <div class="form-group">
				                                        <div class="col-md-6">
				                                            <button type="button" onclick="open_tab('card')" class="btn btn-primary pull-left"> Hi-Res Card </button>
				                                        </div>
				                                        <div class="col-md-6">
				                                            <button type="button" onclick="open_tab('data')" class="btn btn-primary pull-right"> Hi-Res Data </button>
				                                        </div>
				                                    </div>
				                                </div>
												<!-- 
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/original/".$val->kta_kartu);?>" width="350" align = "center">
												<img alt="" src="</?php echo get_image(base_url()."assets/images/id_card_front.jpg");?>" width="350" align="center">
												 -->			
											</td>
			                            </tr>
			                        </tbody>
			                    </table>
			                </div>
			                
			            </div>
			
			        </div>
			        <div class="panel-footer">
			          <div class="pull-left">
						<button class="btn btn-primary pull-left" type="submit">Lanjut</button>
			            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Kembali</button>
			          </div>
			          <div class="pull-right">
			          </div>
			        </div>
			    </form>
	        </div>
			<div class="tab-pane" id="tab2">
				<div class="panel-body">                                                                        
					<div class="row">
						<div class="col-md-11">
						    <?php if(empty($val->kta_foto_wajah)){ ?>
							<div id="canvas-card" class="canvas"> 
								<div class="content-lg-no-foto">
									<div style="clear:both;float:right;margin:20px 25px; 0 0">
										<?php $qrcode = generate_qr_code(substr($val->kta_nomor_kartu,0,6).substr($val->kta_nomor_kartu,6,6).substr($val->kta_nomor_kartu,12,4));?>
										<img src="<?php echo $qrcode;?>" style="height:120px; width:120px;" />
									</div>
									
									<div style="clear:both;float:right;margin:7px 65px 0 0;">
										<!--<img alt="" src="</?php echo empty($val->kta_foto_wajah)?base_url().'assets/images/no_photo.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah;?>" style="height:290px; width:230px;" >
										 img alt="" src="</?php echo empty($val->kta_foto_wajah)?base_url().'assets/images/no_image.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah;?>" style="height:290px; width:230px;" -->
									</div>
							
									<div style="clear:both;float:right;margin-right:65px;margin-top:290px;">
										<div class="nama-lg"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
										<div class="nomor-lg">NPAPG <?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,6)." ".substr($val->kta_nomor_kartu,12,4);?></div>
										<div class="domisili-lg"><?php echo $val->kab_nama." - ".$val->propinsi_nama;?></div>
										<div class="masa-lg"><?php echo date('m/Y',strtotime($val->time_add));?></div>
									</div>
								</div>
							</div>								
							<?php }else{ ?>
							<div id="canvas-card" class="canvas"> 
								<div class="content-lg">
									<div style="clear:both;float:right;margin:20px 25px; 0 0">
										<?php $qrcode = generate_qr_code(substr($val->kta_nomor_kartu,0,6).substr($val->kta_nomor_kartu,6,6).substr($val->kta_nomor_kartu,12,4));?>
										<img src="<?php echo $qrcode;?>" style="height:120px; width:120px;" />
									</div>
									
									<div style="clear:both;float:right;margin:7px 65px 0 0;">
										<img alt="" src="<?php echo empty($val->kta_foto_wajah)?base_url().'assets/images/no_photo.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah;?>" style="height:290px; width:230px;" >
										<!-- img alt="" src="</?php echo empty($val->kta_foto_wajah)?base_url().'assets/images/no_image.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah;?>" style="height:290px; width:230px;" -->
									</div>
							
									<div style="clear:both;float:right;margin-right:65px;">
										<div class="nama-lg"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
										<div class="nomor-lg">NPAPG <?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,6)." ".substr($val->kta_nomor_kartu,12,4);?></div>
										<div class="domisili-lg"><?php echo $val->kab_nama." - ".$val->propinsi_nama;?></div>
										<div class="masa-lg"><?php echo date('m/Y',strtotime($val->time_add));?></div>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div><br/>
					<div class="row">                                
						<div class="form-group">
							<div class="col-md-12">
								<button type="button" onclick="open_tab('detail')" class="btn btn-primary pull-left"> Kembali ke Detail </button>
								<button type="button" onclick="print_card('card','<?php echo str_replace('=','',base64_encode($val->kta_nomor_kartu));?>','<?php echo str_replace('=','',base64_encode($val->kta_foto_wajah));?>','<?php echo str_replace('=','',base64_encode($val->kta_nama_lengkap));?>','<?php echo str_replace('=','',base64_encode($val->kab_nama));?>','<?php echo str_replace('=','',base64_encode($val->propinsi_nama));?>','<?php echo str_replace('=','',base64_encode($val->time_add));?>')" class="btn btn-info pull-right"> Cetak Kartu </button>
							</div>
						</div>
					</div>
				</div>
	        </div>
			<div class="tab-pane" id="tab3">
				<div class="panel-body">                                                                        
					<div class="row">
						<div class="col-md-11">
							<div id="canvas-data" class="canvas"> 
								<div class="content-lg-no-image">
									<div style="clear:both;float:right;margin:20px 25px; 0 0">
										<?php $qrcode = generate_qr_code(substr($val->kta_nomor_kartu,0,6).substr($val->kta_nomor_kartu,6,4).substr($val->kta_nomor_kartu,10,6));?>
										<img src="<?php echo $qrcode;?>" style="height:120px; width:120px;" />
									</div>
									
									<div style="clear:both;float:right;margin:7px 65px 0 0;">
										<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah);?>" style="height:290px; width:230px;" >
										<!-- img alt="" src="</?php echo empty($val->kta_foto_wajah)?base_url().'assets/images/no_image.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah;?>" style="height:290px; width:230px;" -->
									</div>
							
									<div style="clear:both;float:right;margin-right:65px;">
										<div class="nama-lg"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
										<div class="nomor-lg">NPAPG <?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,6)." ".substr($val->kta_nomor_kartu,12,4);?></div>
										<div class="domisili-lg"><?php echo $val->kab_nama." - ".$val->propinsi_nama;?></div>
										<div class="masa-lg"><?php echo date('m/Y',strtotime($val->time_add));?></div>
									</div>
								</div>
							</div>
						</div>
					</div><br/>
					<div class="row">                                
						<div class="form-group">
							<div class="col-md-12">
								<button type="button" onclick="open_tab('detail')" class="btn btn-primary pull-left"> Kembali ke Detail </button>
								<button type="button" onclick="print_card('data','<?php echo str_replace('=','',base64_encode($val->kta_nomor_kartu));?>','<?php echo str_replace('=','',base64_encode($val->kta_foto_wajah));?>','<?php echo str_replace('=','',base64_encode($val->kta_nama_lengkap));?>','<?php echo str_replace('=','',base64_encode($val->kab_nama));?>','<?php echo str_replace('=','',base64_encode($val->propinsi_nama));?>','<?php echo str_replace('=','',base64_encode($val->time_add));?>')" class="btn btn-info pull-right"> Cetak Kartu </button>
							</div>
						</div>
					</div>
				</div>
	        </div>
        </div>
	</div>
</div>
    <script type="text/javascript">
    var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';
    $(document).ready(function(){
      var usr = $("#kta_nomor_kartu_old").val();
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

      $('#kta_kelurahan').change(function(){
		  var npapg = $("#kta_kelurahan").val();
          $.ajax({  
            type: "POST",  
            url: URL_AJAX + "/npapg",
            data: {npapg: usr},
            success: function(msg){  
              if(msg == 'OK') { 
                 $("#status").html('&nbsp;<img src="tick.gif" align="absmiddle"> Data KTP dapat digunakan');
                 $("#kta_no_ktp").removeClass('object_error'); // if necessary
                 $("#kta_no_ktp").addClass("object_ok");
              }else {
                 $("#status").html(msg);
                 $("#kta_no_ktp").removeClass('object_ok'); // if necessary
                 $("#kta_no_ktp").addClass("object_error");                                       
              }  
           } 
        });  		  
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