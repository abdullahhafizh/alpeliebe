<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
<input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
	<div class="panel-body panel-body-table">
		<div class="row">
			<div class="col-md-12" style="padding: 10px">
				<form action="#" class="form-horizontal">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3><span class="fa fa-pencil"></span> Profile Anggota</h3>
							<p>Data profile anggota.</p>
						</div>
						<div class="row">
							<div class="<?php echo (isset($val) && (!empty($val->kta_foto_wajah) || !empty($val->kta_foto_ktp)))?"col-md-6":"col-md-12"?>">
								<div class="panel-body form-group-separated">
									<div class="form-group">
										<label class="col-md-4 col-xs-5">NPAPG</label>
										<label class="col-md-8 col-xs-7"><?php echo substr($val->kta_nomor_kartu,0,6)." ".substr($val->kta_nomor_kartu,6,4)." ".substr($val->kta_nomor_kartu,10,6);?></label>
									</div>
									<div class="form-group">
										<label class="col-md-4 col-xs-5">Nama Lengkap</label>
										<label class="col-md-8 col-xs-7"><?php echo $val->kta_nama_lengkap." - ".$val->kta_no_id;?></label>
									</div>
									<div class="form-group">
										<label class="col-md-4 col-xs-5">Gender</label>
										<label class="col-md-8 col-xs-7"><?php $j = cfg('jenkel'); echo $j[$val->kta_jenkel];?></label>
									</div>
									<div class="form-group">
										<label class="col-md-4 col-xs-5">Status Keanggotaan</label>
										<label class="col-md-8 col-xs-7"><?php $s = cfg('status_anggota'); echo $s[$val->kta_status];?></label>
									</div>
								</div>
							</div>
							<?php if(isset($val) && (!empty($val->kta_foto_wajah) || !empty($val->kta_foto_ktp))){?>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-body style="padding: 10px">
										<h3>Gambar Tersimpan</h3>
										<div class="gallery">
										<?php if(!empty($val->kta_foto_wajah)){?>
											<a href="<?php echo $val->kta_foto_wajah;?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
												<div class="image">
													<img alt="" src="<?php echo $val->kta_foto_wajah;?>" width="200" class="img-polaroid">
													</div>
												<div class="meta">
													<strong>Foto Wajah</strong>
													<span>File hasil dari crop</span>
												</div>
											</a>
										<?php } 
										if(!empty($val->kta_foto_ktp)){?>
											<a href="<?php echo $val->kta_foto_ktp;?>" title="Image Photo" class="act_modal gallery-item" data-gallery>
												<div class="image">
													<img alt="" src="<?php echo $val->kta_foto_ktp;?>" width="200" class="img-polaroid">
												</div>
												<div class="meta">
													<strong>Foto KTP</strong>
													<span>File hasil dari crop</span>
												</div>
											</a>
										<?php }?>
										</div>
									</div>
								</div>
							</div>
							<?php }?>
						</div>
					</div>
				</form>
			</div>
<?php if(isset($val) && trim($val->kta_lampiran1)!=""){?>
				<div class="row">
					<div class="col-md-7">
						<div class="panel panel-default" id="panel-crop">
							<div class="panel-heading">
								<div class="panel-title-box">
									<h3>Form Crop</h3>
								</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-7">
										<div class="img-container" id="img-container">
										<?php if(isset($val) && trim($val->kta_lampiran1)!=""){?>
											<img src="<?php echo base_url();?>assets/collections/kta/original/<?php echo $val->kta_lampiran1;?>" id="img-responsive">
										<?php } else {?>
											<img src="<?php echo base_url();?>assets/images/no_image.jpg" id="img-responsive">
										<?php }?>
										</div>
										<div class="docs-toolbar">
											<div class="btn-group">
												<button class="btn btn-primary" data-method="zoom" data-option="0.1" type="button" title="Zoom In" id="zoom_in">
													<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
														<span class="glyphicon glyphicon-zoom-in"></span>
													</span>
												</button>
												<button class="btn btn-primary" data-method="zoom" data-option="-0.1" type="button" title="Zoom Out" id="zoom_out">
													<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
														<span class="glyphicon glyphicon-zoom-out"></span>
													</span>
												</button>
												<button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate Left" id="rotate_left">
													<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, -90)">
														<span class="glyphicon glyphicon-share-alt docs-flip-horizontal"></span>
													</span>
												</button>
												<button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate Right" id="rotate_right">
													<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, 90)">
														<span class="glyphicon glyphicon-share-alt"></span>
													</span>
												</button>
												<button class="btn btn-primary" data-method="setDragMode" data-option="move" type="button" title="Move" id="move">
													<span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
														<span class="glyphicon glyphicon-move"></span>
													</span>
												</button>
											<?php if(isset($val) && trim($val->kta_lampiran1)!=""){?>
												<button class="btn btn-primary" id="download" type="button" title="Download cropped image">
													<span class="docs-tooltip" data-toggle="tooltip" title="Export image with &quot;getDataURL&quot;">
														<span class="glyphicon glyphicon-download"></span>
													</span>
												</button>
											<?php } else {?>
												<button class="btn btn-primary" id="download" type="button" title="Download cropped image" disabled="disabled">
													<span class="docs-tooltip" data-toggle="tooltip" title="Export image with &quot;getDataURL&quot;">
														<span class="glyphicon glyphicon-download"></span>
													</span>
												</button>
											<?php }?>
											</div>
										</div>
									</div>
									<div class="col-md-5">
										<h3>Preview:</h3>
										<div class="row">
											<div class="col-md-12">
												<div class="img-preview img-preview-sm"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="panel panel-default" id="panel-result" style="opacity:0.2;">
							<div class="panel-heading">
								<div class="panel-title-box">
									<h3>Hasil</h3>
								</div>
							</div>
							<div class="panel-body">
								<input type="hidden" id="num" value="1">
								<div class="gallery" id="links"></div>
							</div> 
							<div class="panel-footer">
								<button type="button" id="btn-reset" class="btn btn-danger" disabled="disabled"><i class="fa fa-refresh"></i>Batal</button>
								<button type="submit" id="btn-save" class="btn btn-primary pull-right" disabled="disabled"><i class="fa fa-refresh"></i>Simpan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> 
	</div>
<?php
} else {?>
	<div class="alert alert-danger" role="alert">
		<strong>Ops!</strong> Data file formulir tidak ditemukan, silahkan upload terlebih dahulu. Klik di<a href="<?php echo $own_links;?>">sini</a> untuk kembali ke halaman daftar anggota
	</div>
<?php }?>
</form>