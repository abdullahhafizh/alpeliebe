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
							<label class="control-label col-md-2">Dikirim Ke</label>
							<div class="col-md-9">
								<select class="form-control select" id="to" name="to" data-live-search="true">
                                    <option value=""> - pilih provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
                                      echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama."</option>";
                                    }?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-9">
								<button id="show_data" class="btn btn-primary" type="button"> Load Data </button>
							</div>
						</div>
					</div>
				</div>
				<hr />
                    <!-- START RESPONSIVE TABLES -->
                    <div class="alert alert-danger" role="alert" id="alert-not-select" style="display: none;">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>Peringatan!</strong> Data Cetak belum dipilih.
					</div>
                    <div class="row" id="list-data" style="display: none;">
                        <div class="col-md-12">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <h3 class="panel-title">List Data Cetak</h3>
                                </div>

                                <div class="panel-body panel-body-table">

                                    <div class="table-responsive">
                                    	<input type="hidden" id="count" value=""/>
                                        <table class="table table-hover table-bordered table-striped" id="data-table">
                                            <thead>
                                                <tr>
                                                    <th width="5">No</th>
                                                    <th width="5"><input type="checkbox" id="select_all" value="1"></th>
                                                    <th width="10">Kode Cetak</th>
                                                    <th width="10">Jumlah KTA</th>
                                                    <th>Pengusul</th>
                                                    <th width="30">Tgl. Export</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-print"> 
                                            </tbody>
                                        </table>
                                    </div>                                

                                </div>
                                <button id="gen-invoice" class="btn btn-primary" type="button" style="margin:10px;"> Buat Invoice </button>
								<a class="btn btn-info" href="javascript:void(0)" id="download-file" onclick="EXPORT_INVOICE.downloadFile()" style="display: none;"> Download File </a>
								<input type="hidden" id="invcode" value="" />
								<input type="hidden" id="proposerid" value="" />
								<input type="hidden" id="printids" value="" />
								<input type="hidden" id="qty" value="" />
								<input type="hidden" id="weight" value="" />
								<input type="hidden" id="receiver" value="" />
								<input type="hidden" id="cost" value="" />
								<input type="hidden" id="price" value="" />
								<input type="hidden" id="filepdf" value="" />
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
var URL_SHOW_DATA = '<?php echo $own_links;?>/show_data';
var URL_GEN_INVOICE = '<?php echo $own_links;?>/gen_invoice';
var URL_UPDATE_DATA = '<?php echo $own_links;?>/update_data';
var URL_DOWNLOAD = '<?php echo base_url();?>assets/report/pdf/';
</script>