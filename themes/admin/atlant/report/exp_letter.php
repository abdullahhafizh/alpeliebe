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
							<label class="control-label col-md-2">Pengusul</label>
							<div class="col-md-9">
								<input id="quick-search" class="form-control" placeholder="ketik disini untuk pencarian nama pengusul"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2">Provinsi</label>
							<div class="col-md-9">
								<select class="form-control select" id="province" name="province" data-live-search="true">
                                    <option value=""> - pilih provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
                                      echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama."</option>";
                                    }?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2">Kabupaten/Kota</label>
							<div class="col-md-9">
								<select class="form-control select" id="city" name="city" data-live-search="true">
                                    <option value=""> - pilih kabupaten/kota - </option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2">Kecamatan</label>
							<div class="col-md-9">
								<select class="form-control select" id="district" name="district" data-live-search="true">
                                    <option value=""> - pilih kecamatan - </option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2">Kelurahan</label>
							<div class="col-md-9">
								<select class="form-control select" id="area" name="area" data-live-search="true">
                                    <option value=""> - pilih kelurahan - </option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-9">
								<button id="generate_report" class="btn btn-primary" type="button"> Buat Laporan </button>
							</div>
						</div>
					</div>
				</div>
				<hr />
				<div class="row" id="form-link" style="display: none;">
					<div class="col-md-6">
						<div class="gallery" id="links">
							<h3>Hasil:</h3>
							<a class="gallery-item" href="<?php echo base_url().'assets/report/excel/SuratTandaTerima-'.date('dmy').'.xlsx';?>" id="link-excel" data-gallery style="display: none;">
								<div class="image">
									<img src="<?php echo base_url().'assets/images/excel.png';?>" width="20" alt=""/>
								</div>
								<div class="meta">
									<strong>File Laporan Excel</strong>
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
var URL_GET_DATA_CITY = '<?php echo $own_links;?>/get_city';
var URL_GET_DATA_DISTRICT = '<?php echo $own_links;?>/get_district';
var URL_GET_DATA_AREA = '<?php echo $own_links;?>/get_area';
var URL_EXPORT_EXCEL = '<?php echo $own_links;?>/export_excel';
</script>