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
	font-family: 'PT Sans', sans-serif;
}
.nama{
	font-size: 12px;
	font-weight: bold;
	line-height: 15px;
	color:black;
}
.nomor{
	font-size: 10px;
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
	text-align: left;
	font-family: 'PT Sans', sans-serif;
	color:black;
}
.nama-lg{
	font-size: 34px;
	font-weight: bold;
	line-height: 40px;
}
.nomor-lg{
	font-size: 40px;
	line-height: 40px;
}
.domisili-lg{
	font-size: 35px;
	line-height: 40px;
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
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab" id="tab-detail">Detail</a></li>
			<li><a href="#tab2" id="tab-card">Hi-Res Card</a></li>
			<li><a href="#tab3" id="tab-data">Hi-Res Data</a></li>
		</ul>
		<div class="panel-body tab-content">
			<div class="tab-pane active" id="tab1">
			    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post">
			        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />

			        <div class="panel-body">

			            <div class="row">
			                <div class="col-md-6">
			                    <h3>Data Anggota</h3>
                    <table class="table table-striped">
                        <tbody>
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
                                <td>Jabatan</td>
                                <td width="1">:</td>
								<td><?php echo $val->jabatan_nama." ".$val->kta_divisi." BPP KKSS";?></td>
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
										echo $v->kel_nama." , ".$v->kec_nama." , ".$v->kab_nama."<br>";
										echo $v->propinsi_nama." - ".$v->negara_nama;
									}
									?>
								</td>
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
			                                <td colspan="3" align="center">
												<div class="content">
													<div style="float:right;margin:90px 22px 0 0;">
														<?php $qrcode = generate_qr_code($val->kta_nomor_kartu);?>
														<img src="<?php echo $qrcode;?>" style="height:45px; width:50px;" />
													</div>

													<div style="float:left;margin:90px 22px 10px 20px;">
														<div class="nama"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
														<div class="nomor">NPAKKSS <?php echo substr($val->kta_nomor_kartu,0,3)." ".substr($val->kta_nomor_kartu,3,4)." ".substr($val->kta_nomor_kartu,7,6);?></div>
														<div class="domisili">
														<?php
														foreach ((array)get_domisili_kta($val->kta_id) as $k => $v) {
															echo $v->propinsi_nama." - ".$v->negara_nama;
														}
														?>
														<?php // echo $val->kab_nama." - ".$val->propinsi_nama;?></div>
													</div>
			<!--										<div id="image">
														<p>Image:</p>
													</div>				-->
												</div>   <br/>
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
							<div id="canvas-card" class="canvas">
								<div class="content-lg">
									<div style="float:right;margin:270px 100px;">
										<?php $qrcode = generate_qr_code($val->kta_nomor_kartu);?>
										<img src="<?php echo $qrcode;?>" style="height:140px; width:140px;" />
									</div>

									<div style="float:left;margin:280px 0px 10px 60px;">
										<div class="nama-lg"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
										<div class="nomor-lg">NPAKKSS <?php echo substr($val->kta_nomor_kartu,0,3)." ".substr($val->kta_nomor_kartu,3,4)." ".substr($val->kta_nomor_kartu,7,6);?></div>
										<div class="domisili-lg"><?php echo $val->propinsi_nama." - ".$val->negara_nama;?></div>
									</div>
								</div>
							</div>
						</div>
					</div><br/>
					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<button type="button" onclick="open_tab('detail')" class="btn btn-primary pull-left"> Kembali ke Detail </button>
							<!--	<button type="button" onclick="print_card('card','<//?php echo str_replace('=','',base64_encode($val->kta_nomor_kartu));?>','<//?php echo str_replace('=','',base64_encode($val->kta_foto_wajah));?>','<//?php echo str_replace('=','',base64_encode($val->kta_nama_lengkap));?>','<//?php echo str_replace('=','',base64_encode($val->kab_nama));?>','<//?php echo str_replace('=','',base64_encode($val->propinsi_nama));?>','<//?php echo str_replace('=','',base64_encode($val->time_add));?>','<//?php echo str_replace('=','',base64_encode($val->kta_id))?>','<//?php echo str_replace('=','',base64_encode($own_links.'/update'))?>')" class="btn btn-info pull-right"> Cetak Kartu </button> -->
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
									<div style="float:right;margin:260px 73px;">
										<?php $qrcode = generate_qr_code($val->kta_nomor_kartu);?>
										<img src="<?php echo $qrcode;?>" style="height:140px; width:140px;" />
									</div>

									<div style="float:left;margin:260px 0px 10px 60px;">
										<div class="nama-lg"><?php echo strtoupper($val->kta_nama_lengkap);?></div>
										<div class="nomor-lg">NPAKKSS <?php echo substr($val->kta_nomor_kartu,0,3)." ".substr($val->kta_nomor_kartu,3,4)." ".substr($val->kta_nomor_kartu,7,6);?></div>
										<div class="domisili-lg"><?php echo $val->propinsi_nama." - ".$val->negara_nama;?></div>
									</div>
								</div>
							</div>
						</div>
					</div><br/>
					<div class="row">
						<div class="form-group">
							<div class="col-md-12">
								<button type="button" onclick="open_tab('detail')" class="btn btn-primary pull-left"> Kembali ke Detail </button>
								<?php if($val->is_cetak == 0){?>
									<?php if($this->jCfg['user']['userrole'] == 1 || $this->jCfg['user']['userrole'] == 39 ){ ?>
									<button type="button" onclick="print_card('data','<?php echo str_replace('=','',base64_encode($val->kta_nomor_kartu));?>','<?php echo str_replace('=','',base64_encode($val->kta_foto_wajah));?>','<?php echo str_replace('=','',base64_encode($val->kta_nama_lengkap));?>','<?php echo str_replace('=','',base64_encode($val->propinsi_nama));?>','<?php echo str_replace('=','',base64_encode($val->negara_nama));?>','<?php echo str_replace('=','',base64_encode($val->time_add));?>','<?php echo str_replace('=','',base64_encode($val->kta_id))?>','<?php echo str_replace('=','',base64_encode($own_links.'/update'))?>')" class="btn btn-info pull-right"> Cetak Kartu </button>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
	        </div>
        </div>
	</div>
</div>
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
    var URL_PREVIEW = '<?php echo $own_links;?>/print_preview/';
    $(document).ready(function(){
    	$.base64.utf8encode = true;

        var canvas_card = $('#canvas-card');
//        	cc = canvas_card.getContext("2d");
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
    function print_card(type,nomor,foto,nama,knama,pnama,time,id,url){
    	if (typeof win != "undefined") win.close();
    	var h = screen.height,
    		w = screen.width;

    	win = window.open(URL_PREVIEW+'?type='+type+'&n='+nomor+'&f='+foto+'&na='+nama+'&k='+knama+'&p='+pnama+'&t='+time+'&i='+id+'&u='+url, "Print Preview", "width=1063,height=650,left="+((w-1063)/2)+",top="+((h-650)/2));
    }
    function open_tab(id){
    	$('#tab-'+id).attr('data-toggle','tab');
        if(id != 'detail') {
			$('#canvas-'+id).html2canvas({
				onrendered: function (canvas) {
					var img = canvas.toDataURL("image/png");
					$('#canvas-'+id).html('<img alt="" src="'+img+'" style="height:auto;width:100%px;" >');
				}
			});
    	} else $('#tab-card,#tab-data').attr('data-toggle');
    	$('#tab-'+id).click();
    }
    </script>
