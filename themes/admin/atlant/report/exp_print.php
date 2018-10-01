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
							<label class="control-label col-md-2">Jumlah Data</label>
							<div class="col-md-9">
								<select class="form-control select" id="limit" name="limit" data-live-search="true">
                                    <option value="50"> 50 </option>
                                    <option value="100"> 100 </option>
                                    <option value="500"> 500 </option>
                                    <option value="1000"> 1000 </option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-9">
								<button id="show_data" class="btn btn-primary" type="button"> Load Data </button>
								<a class="btn btn-info" href="javascript:void(0)" id="download-file" onclick="EXPORT_PRINT.downloadFile()" style="display: none;"> Download File </a>
								<input type="hidden" id="kta-ids" value="" />
								<input type="hidden" id="count" value="" />
								<input type="hidden" id="filezip" value="" />
							</div>
						</div>
					</div>
				</div>
				<hr />
                    <!-- START RESPONSIVE TABLES -->
                    <div class="row" id="list-data" style="display: none;">
                        <div class="col-md-12" align="center">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <h3 class="panel-title">Report Data Cetak</h3>
                                </div>

                                <div class="panel-body panel-body-table scroll" style="height: 350px;">

                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>NPAPG</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten/Kota</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-print">  
                                            </tbody>
                                        </table>
                                    </div>                                

                                </div>
                            </div>                                                

                        </div>
                    </div>
                    <!-- END RESPONSIVE TABLES -->
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
var URL_SHOW_DATA = '<?php echo $own_links;?>/show_data';
var URL_EXPORT_EXCEL = '<?php echo $own_links;?>/export_excel';
var URL_UPDATE_DATA = '<?php echo $own_links;?>/update_data';
var URL_FILE_ARCHIVE = '<?php echo $own_links;?>/file_archive';
var URL_DOWNLOAD = '<?php echo base_url();?>assets/report/zip/';
</script>