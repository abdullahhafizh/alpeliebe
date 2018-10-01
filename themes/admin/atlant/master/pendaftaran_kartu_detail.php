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

        <div class="panel-body">                                                                        
            
            <div class="row">
             <div class="col-md-6" style="border:1px solid #000;">
			<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/original/".$val->kta_lampiran1);?>" style="height:100%;width:550px;" >
			 </div>                
                <div class="col-md-6">
                    <h3>Data Anggota</h3>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td colspan="3" align="center">
									<img alt="" src="<?php echo $val->kta_foto_wajah; get_image(base_url()."assets/collections/kta/original/".$val->col1);?>" width="200" >
								</td>
                            </tr>
                            <tr>
                                <td>NPAPG</td>
                                <td width="1">:</td>
                                <td><?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,4)." ".substr($val->kta_nomor_kartu,10,6);?></td>
                            </tr>
                            <tr>
                                <td>NPAPG Lama</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_nomor_kartu_old;?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_nama_lengkap." - ".$val->kta_no_id;?></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td width="1">:</td>
                                <td><?php echo $jenkel[$val->kta_jenkel];?></td>
                            </tr>
                            <tr>
                                <td>Domisili</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_alamat;?></td>
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
                                <td>Status Keanggotaan</td>
                                <td width="1">:</td>
                                <td><?php echo $status[$val->kta_status];?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Daftar</td>
                                <td width="1">:</td>
                                <td><?php echo myDate($val->time_add,"d M Y H:i:s");?></td>
                            </tr>
                            <tr>
                                <td>Tempat / Tanggal lahir</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_tempat_lahir;?> / <?php echo myDate($val->kta_tgl_lahir,"d M Y");?></td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td width="1">:</td>
                                <td>									
								<?php 
									foreach ((array)agama($val->kta_agama) as $k => $v) {
										echo $v->agama_nama;
									}
									?>														
							</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_email;?></td>
                            </tr>
                            <tr>
                                <td>No. Telp</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_hp." | No. Rumah : ".$val->kta_telp;?></td>
                            </tr>
                        </tbody>
                    </table>
                  
                </div>
			 </div>
            <div class="row">
             <div class="col-md-6" style="border:1px solid #000;">
			<img alt="" src="<?php echo get_image(base_url()."assets/collections/kta/original/".$val->kta_lampiran2);?>" style="height:100%;width:550px;" >
			 </div>                				
                <div class="col-md-6">
                    <h3>Data Tambahan</h3>
                        <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td>Status Pernikahan</td>
                                <td width="1">:</td>
                                <td><?php echo $status_nikah[$val->kta_status_nikah];?></td>
                            </tr>
                            <tr>
                                <td>Nama Pasangan</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_namasuami;?></td>
                            </tr>
                            <tr>
                                <td>Pendidikan Terakhir</td>
                                <td width="1">:</td>
                                <td><?php echo $pendidikan[$val->kta_pendidikan];?></td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td width="1">:</td>
                                <td>									
								<?php 
									foreach ((array)pekerjaan($val->kta_pekerjaan) as $k => $v) {
										echo $v->pekerjaan_nama;
									}
									?>														
							</td>
                            </tr>
                            <tr>
                                <td>Sosial Media</td>
                                <td width="1">:</td>
                                <td><?php echo "Facebook : ". $val->kta_facebook;?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="1"></td>
                                <td><?php echo "Instagram : ". $val->kta_instagram;?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width="1"></td>
                                <td><?php echo "Twitter : ". $val->kta_twitter;?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr></td>
                            </tr>
                            <tr>
                                <td>Tingkatan</td>
                                <td width="1">:</td>
                                <td><?php echo $tingkat[$val->kta_tingkatan];?></td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td width="1">:</td>
                                <td><?php echo $jabatan[$val->kta_jabatan];?></td>
                            </tr>
                            <tr>
                                <td>Nama DPD Propinsi</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_tingkatan_provinsi;?></td>
                            </tr>
                            <tr>
                                <td>Nama DPD Kab / Kota</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_tingkatan_kabkota;?></td>
                            </tr>
                            <tr>
                                <td>Nama PK Kecamatan</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_tingkatan_kecamatan;?></td>
                            </tr>
                            <tr>
                                <td>Nama PL Kel / Desa</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_tingkatan_desa;?></td>
                            </tr>
                            <tr>
                                <td>Keanggotaan Hasta Karya</td>
                                <td width="1">:</td>
                                <td><?php echo $hastakarya[$val->kta_hastakarya];?></td>
                            </tr>
                            <tr>
                                <td>Status Data Anggota</td>
                                <td width="1">:</td>
                                <td width="400">
							<?php if($val->kta_status_data == 0 ){
										echo '<span class="label label-warning">Pending</span>';
									  }elseif($val->kta_status_data == 1 ){
										echo '<span class="label label-success">Approved</span>';								
									  }else{
										echo '<span class="label label-danger">Rejected</span>';																		  
									  }
							?>                                        
									</div>								
								</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                	<div class="content">
										<div style="clear:both;float:right;margin:8px 9px;">
											<?php $qrcode = generate_qr_code(substr($val->kta_nomor_kartu,0,6)."".substr($val->kta_nomor_kartu,6,4)."".substr($val->kta_nomor_kartu,10,6));?>
											<img src="<?php echo $qrcode;?>" style="height:38px; width:38px;" />
										</div>
										
										<div style="clear:both;float:right;margin:3px 22px 0 0;">
											<img alt="" src="<?php echo $val->kta_foto_wajah; get_image(base_url()."assets/collections/kta/original/".$val->col1);?>" style="height:97px; width:74px;" >
										</div>
								
										<div style="clear:both;float:right;margin-right:22px;">
											<div class="nama"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
											<div class="nomor">NPAPG <?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,4)." ".substr($val->kta_nomor_kartu,10,6);?></div>
											<div class="domisili">
											<?php 
											foreach ((array)get_domisili_kta($val->kta_id) as $k => $v) {
												echo $v->kab_nama." - ".$v->propinsi_nama;
											}
											?>																									
											<?php // echo $val->kab_nama." - ".$val->propinsi_nama;?></div>
											<div class="masa"><?php echo date('m/Y',strtotime('+1 year',strtotime($val->time_add)));?></div>
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
            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button>
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
        is_edc();
        $('#kta_jenis_bayar').change(function(){
            is_edc();
        });
    });
    function is_edc(){
        m = $('#kta_jenis_bayar').val();
        if(m==1){
            $('.edc_div').fadeIn();
        }else{
            $('.edc_div').fadeOut();
        }
    }
    </script>
                            