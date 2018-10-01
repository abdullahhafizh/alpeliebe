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
	width: 350px;
}
.content-no-foto {
	background-image: url('<?php echo base_url()."assets/images/id_card_front.jpg";?>'); 
	background-size: 350px 220px;
	background-repeat: no-repeat; 
	height:220px; 
	width: 350px;
}
.nama,.nomor,.domisili,.masa{
	text-align: left;
}
.nama{
	font-size: 16px;
	font-weight: bold;
	line-height: 20px;
	color:black;
}
.nomor{
	font-size: 12px;
	line-height: 12px;
	color:black;
}
.domisili{
	font-size: 10px;
	line-height: 15px;
	color:black;
}
.masa{
	font-size: 7px;
	margin-top: 5px;
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
                            
    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/detail" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
        <input type="hidden" name="kta_nama" id="kta_nama" value="<?php echo isset($val->kta_nama_lengkap)?$val->kta_nama_lengkap:'';?>" />
        <input type="hidden" name="kta_ktp" id="kta_ktp" value="<?php echo isset($val->kta_no_id)?$val->kta_no_id:'';?>" />

        <div class="panel-body">                                                                        
            
            <div class="row">
                <div class="col-md-6">
                    <h3>Data Anggota</h3>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                                <tr>
                                <td>NPAKKSS</td>
                                <td width="1">:</td>
                                <td><?php echo substr($val->kta_nomor_kartu,0,3)." ".substr($val->kta_nomor_kartu,3,4)." ".substr($val->kta_nomor_kartu,7,6);?></td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_nama_lengkap;?></td>
                            </tr>
                            <tr>
                                <td>No. KTP / NIK</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_no_id;?></td>
                            </tr>
                        <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td width="1">:</td>
                                <td><?php echo $jenkel[$val->kta_jenkel];?></td>
                            </tr>
                            <tr>
                                <td>Tempat / Tanggal lahir</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_tempat_lahir;?> / <?php echo date_format(date_create($val->kta_tgl_lahir),"d F Y");?></td>
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
								$rt 		= empty($val->kta_rt)?"-":$val->kta_rt;
								$rw 		= empty($val->kta_rw)?"-":$val->kta_rw;
								$kodepos 	= empty($val->kta_kodepos)?"-":$val->kta_kodepos;								
								echo "RT/RW : ".$rt." / ".$rw." KODE POS : ".$kodepos;?></td>
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
                                <td>Domisili Sesuai KTP</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_domisili;?></td>
                            </tr>
                            <tr>
                                <td>NPAPG Lama</td>
                                <td width="1">:</td>
                                <td><?php echo empty($val->kta_nomor_kartu_old)?"-":$val->kta_nomor_kartu_old;?></td>
                            </tr>
                         <tr>
                                <td colspan="3" align="center">
												<?php if(empty($val->kta_foto_ktp)){ ?>
												<img alt="" src="<?php echo get_image(base_url()."assets/images/no_image.jpg");?>" width="200">
												<img alt="" src="<?php echo get_image(base_url()."assets/images/no_image.jpg");?>" width="200">
												<?php }else{ ?>
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/ktp/".$val->kta_foto_wajah);?>" width="150" >
												<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>												
												<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/ktp/".$val->kta_foto_ktp);?>" width="330" >
												<?php } ?>
								</td>
                            </tr>
                        </tbody>
                    </table>
                  
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
                                <td>Tanggal Registrasi</td>
                                <td width="1">:</td>
                                <td><?php echo myDate($val->time_add,"d M Y H:i:s");?></td>
                            </tr>
                            <tr>
                                <td>Status KTA</td>
                                <td width="1">:</td>
                                <td width="400">
								<?php if($val->kta_status_data == 0 ){
										echo '<span class="label label-warning">Pending</span>';
									  }elseif($val->kta_status_data == 1 ){
										echo '<span class="label label-success">Approved</span>';								
									  }elseif($val->kta_status_data == 2 ){
										echo '<span class="label label-info">Uploaded</span>';								
									  }else{
										echo '<span class="label label-danger">Upload</span>';																		  
									  }
								?>                                        
									</div>								
								</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                	<div class="content">
										<div style="float:right;margin:90px 22px 0 0;">
											<?php $qrcode = generate_qr_code(substr($val->kta_nomor_kartu,0,6)."".substr($val->kta_nomor_kartu,6,6)."".substr($val->kta_nomor_kartu,12,4));?>
											<img src="<?php echo $qrcode;?>" style="height:45px; width:50px;" />
										</div>
								
										<div style="float:left;margin:90px 22px 10px 20px;">
											<div class="nama"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
											<div class="nomor">NPAKKSS <?php echo substr($val->kta_nomor_kartu,0,3)." ".substr($val->kta_nomor_kartu,3,4)." ".substr($val->kta_nomor_kartu,7,6);?></div>
											<div class="domisili">
											<?php 
											foreach ((array)get_domisili_kta($val->kta_id) as $k => $v) {
												echo $v->kab_nama." - ".$v->propinsi_nama;
											}
											?>																									
											<?php // echo $val->kab_nama." - ".$val->propinsi_nama;?></div>
										</div>
<!--										<div id="image">
											<p>Image:</p>
										</div>				-->						
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
<!--            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button> -->
          </div>
          <div class="pull-right">		  
            <button type="button" onclick="document.location='<?php echo $own_links."/edit/?_id="._encrypt($val->kta_id);?>'" class="btn btn-white btn-cons">Edit</button>
            <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Submit Data</button>
          </div>
        </div>
    </form>
	<script src="http://html2canvas.hertzen.com/build/html2canvas.js"></script>
    <script type="text/javascript">
	html2canvas([document.getElementById('mydiv')], {
		onrendered: function (canvas) {
			document.getElementById('canvas').appendChild(canvas);
			var data = canvas.toDataURL('image/png');
			// AJAX call to send `data` to a PHP file that creates an image from the dataURI string and saves it to a directory on the server

			var image = new Image();
			image.src = data;
			document.getElementById('image').appendChild(image);
		}
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
	}); 
    </script>
                            