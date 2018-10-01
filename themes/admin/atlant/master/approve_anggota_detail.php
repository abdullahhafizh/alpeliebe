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
                            
    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
        <input type="hidden" name="kta_npapg" id="kta_npapg" value="<?php echo isset($val->kta_nomor_kartu)?$val->kta_nomor_kartu:'';?>" />
        <input type="hidden" name="kta_nama" id="kta_nama" value="<?php echo isset($val->kta_nama_lengkap)?$val->kta_nama_lengkap:'';?>" />

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
                                <td colspan="3"><hr></td>
                            </tr>
                            <tr>
                                <td>Tipe KTA</td>
                                <td width="1">:</td>
                                <td><?php echo $val->kta_tipe_kta;?><br/>
								<?php if($val->kta_tipe_kta == "SUKET"){ ?> 
									<button class="btn btn-primary" id="btn-suket" type="button" title="Download cropped image" onclick="$('#modal_img').slideDown();" style="margin-top: 10px;">Lihat Surat Keterangan</button>
								<?php } ?>
								</td>
                            </tr>
                            <tr>
                                <td>NPAPG</td>
                                <td width="1">:</td>
                                <td><?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,6)." ".substr($val->kta_nomor_kartu,12,4);?></td>
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
									<img alt="" src="<?php echo empty($val->kta_foto_wajah)?base_url().'assets/images/no_image.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah;?>" width="150">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<img alt="" src="<?php echo empty($val->kta_foto_ktp)?base_url().'assets/images/no_image.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_ktp;?>" width="300">
								</td>
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
			                                <td><?php echo myDate($val->time_reject_scan,"d M Y H:i:s");?></td>
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
														<?php $qrcode = generate_qr_code(substr($val->kta_nomor_kartu,0,6).substr($val->kta_nomor_kartu,6,4).substr($val->kta_nomor_kartu,10,6));?>
														<img src="<?php echo $qrcode;?>" style="height:38px; width:38px;" />
													</div>
													
													<div style="clear:both;float:right;margin:3px 22px 0 0;">
														<img alt="" src="<?php echo empty($val->kta_foto_wajah)?base_url().'assets/images/no_photo.jpg':base_url()."assets/collections/kta/photo/".$val->kta_foto_wajah;?>" style="height:97px; width:74px;" >
													</div>
											
													<div style="clear:both;float:right;margin-right:22px;">
														<div class="nama"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
														<div class="nomor">NPAPG <?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,6)." ".substr($val->kta_nomor_kartu,12,4);?></div>
														<div class="domisili"><?php echo $val->kab_nama." - ".$val->propinsi_nama;?></div>
														<div class="masa"><?php echo date('m/Y',strtotime($val->time_add));?></div>
													</div>
												</div><br/>
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
            <button type="button" class="btn btn-danger mb-control" data-box="#message-box-danger">Reject</button>
            <button type="submit" name="approve" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Approve</button>
          </div>
        </div>
        <div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Keterangan Reject</div>
                    <div class="mb-content">
						<div class="form-group">
							<div class="col-md-10">
                                <textarea name="ket_reject"  value="" id="ket_reject" class="form-control" placeholder="Masukan Alasan Reject"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-footer">
						<button class="btn btn-primary pull-right" type="submit" name="reject">Reject</button>
                        <button class="btn btn-default pull-left mb-control-close">Close</button>
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
                            