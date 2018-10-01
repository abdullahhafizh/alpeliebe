<form id="form-validated" class="form-horizontal" action="" method="post" class="input">
<div class="row">
	<div class="col-md-12">
	    
		<!-- jQuery AUTOCOMPLETE -->
		<div class="panel panel-default">
			<div class="panel-body">				
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger" role="alert" id="alert-not-found" style="display: none;">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Peringatan!</strong> Data PENGUSUL tidak ditemukan dalam database, coba input kembali.
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Provinsi</label>
							<div class="col-md-9">
								<div class="input-group date" id="dp-2">
									<!--<input id="quick-search" class="form-control" placeholder="ketik disini untuk pencarian provinsi"/>-->
									<select class="form-control select" id="province" name="province" data-live-search="true">
										<option value=""> - pilih provinsi - </option>
										<?php foreach ((array)get_propinsi() as $m) {
											  echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama."</option>";
										}?>
									</select>
									
									<span class="input-group-btn">
										<button id="generate_report" class="btn btn-primary" type="button"> Buat Laporan </button>
									</span>
								</div>
							</div>
						</div>
						<!-- div class="form-group">
							<label class="control-label col-md-3"></label>
							<div class="col-md-9">
								<button type="button" id="btn-advance" class="btn btn-primary">Advance Search</button>
							</div>
						</div -->
					</div>
				</div>
				<hr />
				<div class="row" id="form-link" style="display: none;">
					<div class="col-md-6">
						<div class="gallery" id="links">
							<h3>Hasil:</h3>
							<a class="gallery-item" href="<?php echo base_url().'assets/report/excel/DataAnggota-'.date('dmy').'.xlsx';?>" id="link-excel" data-gallery style="display: none;">
								<div class="image">
									<img src="<?php echo base_url().'assets/images/excel.png';?>" width="20" alt=""/>
								</div>
								<div class="meta">
									<strong>File Laporan Excel</strong>
									<span>Silahkan download file</span>
								</div>
							</a>
							<a class="gallery-item" href="<?php echo base_url().'assets/report/pdf/DataAnggota-'.date('dmy').'.pdf';?>" id="link-pdf" data-gallery style="display: none;">
								<div class="image">
									<img src="<?php echo base_url().'assets/images/pdf.png';?>" width="20" alt=""/>
								</div>
								<div class="meta">
									<strong>File Laporan PDF</strong>
									<span>Silahkan download file</span>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END jQuery AUTOCOMPLETE -->
	
	</div>
</div>
</form>

<script type="text/javascript">
var URL_GET_PROPOSER = '<?php echo $own_links;?>/get_proposer';
var URL_CHECK_PROPOSER = '<?php echo $own_links;?>/check_proposer';
var URL_EXPORT_EXCEL = '<?php echo $own_links;?>/export_excel';
var URL_EXPORT_PDF = '<?php echo $own_links;?>/export_pdf';
</script>