<?php js_validate(); ?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Nama Lengkap</label>
							<div class="col-md-9">
								<input id="kta_nama_lengkap" name="kta_nama_lengkap" class="validate[required] form-control" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">NIK</label>
							<div class="col-md-9">
								<input id="kta_no_id" name="kta_no_id" class="validate[required] form-control" />
							</div>
						</div>
                    <div class="form-group">
								    <label class="control-label col-md-3">Jenis Kelamin</label>
								<div class="col-md-9">
                                    <?php foreach((array)cfg('jenkel') as $kj=>$vj){?>
									<label class="check"><input type="radio" class="validate[required] iradio" name="kta_jenkel" value="<?php echo $kj;?>" <?php echo isset($val)&&$val->kta_jenkel==$kj?'checked="checked"':'';?>/> <?php echo $vj;?> </label> &nbsp;
                                    <?php } ?>
								</div>
                        </div>
                    <div class="form-group">                                        
								    <label class="control-label col-md-3">Tanggal Lahir</label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <select class="validate[required] form-control" name="kta_tgl_lahir" id="kta_tgl_lahir">
                                   <option value=""> - tanggal - </option>
                                   <?php for($i=1;$i<=31;$i++){
	                                   		$an = $i<=9?'0'.$i:$i;
	                                   		$tmp1 = isset($tmp_tgl[2])?$tmp_tgl[2]:'';
	                                   	    $slc1 = trim($tmp1)==$an?'selected="selected"':'';
	                                   		echo "<option value='$an' $slc1 >$an</option>";
	                                   }
                                   ?>
                                </select>                                        
                            </div>
                        </div>                        
                        <div class="col-md-3">
                            <div class="input-group">
                                <select class="validate[required] form-control" name="kta_bln_lahir" id="kta_bln_lahir" >
                                   <option value=""> - bulan - </option>
                                   <?php
	                                   foreach((array)cfg('bulan') as $k=>$v){
	                                   	   $tmp2 = isset($tmp_tgl[1])?$tmp_tgl[1]:'';
	                                   	   $slc2 = trim($tmp2)==$k?'selected="selected"':''; 
		                                   echo "<option value='".$k."' $slc2 >".$v."</option>";
	                                   } 
                                   ?>
                                </select>                                        
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="input-group">
                                <select class="validate[required] form-control" name="kta_thn_lahir" id="kta_thn_lahir">
                                   <option value=""> - tahun - </option>
                                   <?php for($j=1930;$j<=date("Y");$j++){
	                                   		$tmp3 = isset($tmp_tgl[0])?$tmp_tgl[0]:'';
	                                   	    $slc3 = trim($tmp3)==$j?'selected="selected"':'';
	                                   		echo "<option value='$j' $slc3 >$j</option>";
	                                   }
                                   ?>
                                </select>                                        
                            </div>
                        </div>                        
                    </div>                    <div class="form-group">
							<label class="control-label col-md-3">Alamat</label>
							<div class="col-md-9">
                                <input type="text" name="kta_alamat"  value="<?php echo isset($val->kta_alamat)?$val->kta_alamat:'';?>" id="kta_alamat" class="form-control" placeholder="Masukan Alamat Lengkap"/>
							</div>
                    </div>
                    <div class="form-group">                                        
							<label class="control-label col-md-3">RT/RW KODEPOS</label>
							<div class="col-md-2">
                                <input type="text" name="kta_rt"  value="<?php echo isset($val->kta_rt)?$val->kta_rt:'';?>" id="kta_rt" class="validate[custom[onlyNumberSp]] form-control" size="10" maxlength="3" placeholder="RT"/>
							</div>
							<div class="col-md-2">
                                <input type="text" name="kta_rw"  value="<?php echo isset($val->kta_rw)?$val->kta_rw:'';?>" id="kta_rw" class="validate[custom[onlyNumberSp]] form-control" size="10" maxlength="3" placeholder="RW"/>
							</div>
							<div class="col-md-2">
                                <input type="text" name="kta_kodepos"  value="<?php echo isset($val->kta_kodepos)?$val->kta_kodepos:'';?>" id="kta_nama_lengkap" class="validate[custom[onlyNumberSp]] form-control" placeholder="KODE POS" maxlength="5"/>
							</div>
                    </div>						
						<div class="form-group">
							<label class="control-label col-md-3">Provinsi</label>
							<div class="col-md-9">
								<select class="form-control select" id="kta_propinsi" name="kta_propinsi" data-live-search="true">
                                    <option value=""> - pilih provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
                                      echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama."</option>";
                                    }?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Kabupaten/Kota</label>
							<div class="col-md-9">
								<select class="form-control select" id="kta_kabupaten" name="kta_kabupaten" data-live-search="true">
                                    <option value=""> - pilih kabupaten/kota - </option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Kecamatan</label>
							<div class="col-md-9">
								<select class="form-control select" id="kta_kecamatan" name="kta_kecamatan" data-live-search="true">
                                    <option value=""> - pilih kecamatan - </option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3">Kelurahan</label>
							<div class="col-md-9">
								<select class="form-control select" id="kta_kelurahan" name="kta_kelurahan" data-live-search="true">
                                    <option value=""> - pilih kelurahan - </option>
								</select>
							</div>
						</div>
						
					</div>
					<div class="col-md-3">
						<div class="alert alert-danger" role="alert" id="fwarning" style="display: none;">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>WARNING!</strong> Capture wajah belum dilakukan.
						</div>
						<video id="fvideo"></video>
						<canvas id="fcanvas" style="display:none;"></canvas>
						<input type="hidden" id="ftext" name="ftext" value="" class="validate[required]">
						<button id="ftake" class="btn btn-info" type="button" style="margin-top: 10px;">CAPTURE WAJAH</button>
					</div>
					<div class="col-md-3">
						<div class="alert alert-danger" role="alert" id="cwarning" style="display: none;">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>WARNING!</strong> Capture KTP belum dilakukan.
						</div>
						<video id="cvideo"></video>
						<canvas id="ccanvas" style="display:none;"></canvas>
						<input type="hidden" id="ctext" name="ctext" value="" class="validate[required]">
						<button id="ctake" class="btn btn-info" type="button" style="margin-top: 10px;">CAPTURE KTP</button>
					</div>
				</div>
			</div>
	        <div class="panel-footer">
				<a class="btn btn-default btn-lg" href="<?php echo $own_links;?>">Batal</a>            
				<button id="btn-save" name="btn-save" class="btn btn-primary pull-right btn-lg" type="button">Simpan</button>
	        </div>
		</div>
	</div>
</div>
</form>

<script type="text/javascript">
var URL_GET_DATA_CITY = '<?php echo $own_links;?>/get_city';
var URL_GET_DATA_DISTRICT = '<?php echo $own_links;?>/get_district';
var URL_GET_DATA_AREA = '<?php echo $own_links;?>/get_area';
</script>