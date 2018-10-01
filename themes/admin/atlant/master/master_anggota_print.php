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
							<div id="canvas-card" class="canvas"> 
								<div class="content-lg">
									<div style="clear:both;float:right;margin:20px 25px; 0 0">
										<?php $qrcode = generate_qr_code(substr($val->kta_nomor_kartu,0,6).substr($val->kta_nomor_kartu,6,4).substr($val->kta_nomor_kartu,10,6));?>
										<img src="<?php echo $qrcode;?>" style="height:120px; width:120px;" />
									</div>
									
									<div style="clear:both;float:right;margin:7px 65px 0 0;">
														<img alt="" src="<?php echo empty($val->kta_foto_wajah)?base_url().'assets/images/no_image.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah;?>" style="height:290px; width:230px;" >
									</div>
							
									<div style="clear:both;float:right;margin-right:65px;">
										<div class="nama-lg"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
										<div class="nomor-lg">NPAPG <?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,4)." ".substr($val->kta_nomor_kartu,10,6);?></div>
										<div class="domisili-lg"><?php echo $val->kab_nama." - ".$val->propinsi_nama;?></div>
										<div class="masa-lg"><?php echo date('m/Y',strtotime($val->time_add));?></div>
									</div>
								</div>
							</div>