<form id="form-validated" class="form-horizontal" action="<?php echo $own_links;?>/search" method="post" class="input">
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
									<!--<input id="quick-search" class="form-control" placeholder="ketik disini untuk pencarian provinsi"/>-->
									<select class="form-control select" id="pengusul" name="pengusul" data-live-search="true">
										<option value="" > - pilih pengusul - </option>
										<?php 
										  $st = 0;
										  if(isset($val)){
											  $isi = $val->kta_pemesan;
										  }else{
											  if(!empty($this->jCfg['user']['penggunaid'])){
												$isi = $this->jCfg['user']['penggunaid'];											  												  
											  }else{
												$isi = "";
											  }
										  }
										  foreach ((array)get_pemesan($st) as $m) {
										  $s = isset($param)&&$param['pengusul']==$m->penggunaID?'selected="selected"':'';
										  echo "<option value='".$m->penggunaID."' $s >".$m->nama_pengguna."</option>";
										  }
									?>
                                </select> 
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Provinsi</label>
							<div class="col-md-9">
									<!--<input id="quick-search" class="form-control" placeholder="ketik disini untuk pencarian provinsi"/>-->
									<select class="form-control select" id="province" name="province" data-live-search="true">
										<option value=""> - pilih provinsi - </option>
										<?php foreach ((array)get_propinsi() as $m) {
											  $s = isset($param)&&$param['propinsi']==$m->propinsi_kode?'selected="selected"':'';
											  echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama."</option>";
										}?>
									</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Kabupaten</label>
							<div class="col-md-9">
									<select class="form-control" id="kabupaten" name="kabupaten" data-live-search="true">
									</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Kecamatan</label>
							<div class="col-md-9">
									<select class="form-control" id="kecamatan" name="kecamatan" data-live-search="true">
									</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Kelurahan</label>
							<div class="col-md-9">
									<select class="form-control" id="kelurahan" name="kelurahan" data-live-search="true">
									</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">Tanggal</label>
							<div class="col-md-3">
								<input type="text" name="date_from" id="date_from"  value="<?php echo isset($param['date_from'])?$param['date_from']:'';?>" class="validate[required] form-control datepicker" placeholder="Cari Data Berdasarkan Tanggal Awal" maxlength="16"/>
							</div>
							<div class="col-md-3">
								<input type="text" name="date_to" id="date_to"  value="<?php echo isset($param['date_to'])?$param['date_to']:'';?>" class="validate[required] form-control datepicker" placeholder="Cari Data Berdasarkan Tanggal Akhir" maxlength="16"/>
							</div>
						</div>
						<!-- <div class="form-group">
							<label class="control-label col-md-2"></label>
							<div class="col-md-9">
								<button type="button" id="btn-advance" class="btn btn-primary">Create Report</button>
							</div>
						</div> -->
						<div class="form-group">
							<label class="control-label col-md-2"></label>
								<div class="col-md-4" style="margin-top:0px;">
									<input type="submit" style="margin-right:5px;" name="btn_search" id="btn_search"  class="btn btn-info col-md-5" value = "Lihat Data">
<!--									<input type="submit" style="margin-right:5px;" name="btn_reset" id="btn_reset"  class="btn btn-danger col-md-5" value = "Reset"> -->
								</div>
						</div>
				</div>
				<hr />
			</div>
		</div>
		<!-- END jQuery AUTOCOMPLETE -->
	
	</div>
</div>
<div class="row">
	<div class="col-md-12">
<div class="panel panel-default">
        <div class="panel-body panel-body-table scroll" style="height:350px;">
			<div class="table-responsive">
            <table class="table table-bordered table-striped table-actions table-fixed" width="100%">
               <thead>
                <tr>
                    <th width="100%" align="center" valign="middle" rowspan="3">No</th>
                    <th align="center" valign="middle" colspan="5">No. NPAPG</th>
                    <th width="400px" align="center" valign="middle">Nama Anggota</th>
                    <th align="center" valign="middle">Nomor NIK / E-KTP</th>
                    <th align="center" valign="middle" colspan="2">Jenis Kelamin</th>
                    <th align="center" valign="middle">Tempat Lahir</th>
                    <th align="center" valign="middle" colspan="5">Tanggal Lahir</th>
                    <th align="center" valign="middle">Umur</th>
                    <th align="center" valign="middle" colspan="3">Status Perkawinan</th>
                    <th align="center" valign="middle">Pekerjaan</th>
                    <th align="center" valign="middle">Alamat (Sesuai KTP)</th>
                    <th align="center" valign="middle">Kelurahan</th>
                    <th align="center" valign="middle">Keterangan</th>
                </tr>
                <tr>
                    <th align="center" valign="middle" colspan="5">(16 Digit)</th>
                    <th align="center" valign="middle" rowspan="2">Sesuai KTP</th>
                    <th align="center" valign="middle">(16 Digit)</th>
                    <th align="center" valign="middle" rowspan="2">L</th>
                    <th align="center" valign="middle" rowspan="2">P</th>
                    <th align="center" valign="middle" rowspan="2">Sesuai KTP</th>
                    <th align="center" valign="middle" rowspan="2">Tgl</th>
                    <th align="center" valign="middle" rowspan="2">/</th>
                    <th align="center" valign="middle" rowspan="2">Bln</th>
                    <th align="center" valign="middle" rowspan="2">/</th>
                    <th align="center" valign="middle" rowspan="2">Thn</th>
                    <th align="center" valign="middle" rowspan="2">Tahun</th>
                    <th align="center" valign="middle" rowspan="2">Kawin</th>
                    <th align="center" valign="middle" rowspan="2">Belum Kawin</th>
                    <th align="center" valign="middle" rowspan="2">Pernah Kawin</th>
                    <th align="center" valign="middle" rowspan="3">Pekerjaan</th>
                    <th align="center" valign="middle" rowspan="3">Alamat (Sesuai KTP)</th>
                    <th align="center" valign="middle" rowspan="2">Sesuai KTP</th>
                    <th align="center" valign="middle" rowspan="3">Keterangan</th>
                </tr>
                <tr>
                    <th align="center" valign="middle">Prop</th>
                    <th align="center" valign="middle">Kab/Kota</th>
                    <th align="center" valign="middle">Kec</th>
                    <th align="center" valign="middle">Kel</th>
                    <th align="center" valign="middle">Angt</th>
                    <th align="center" valign="middle">Sesuai KTP</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $tingkat 	= cfg('tingkatan');
                    $jabatan 	= cfg('jabatan');
                    $jk			= cfg('jenkel');
                    $pekerjaan	= cfg('pekerjaan');
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo substr($r->kta_nomor_kartu,0,2);?></td>
                            <td><?php echo substr($r->kta_nomor_kartu,2,2);?></td>
                            <td><?php echo substr($r->kta_nomor_kartu,4,2);?></td>
                            <td><?php echo substr($r->kta_nomor_kartu,6,6);?></td>
                            <td><?php echo substr($r->kta_nomor_kartu,10,4);?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $r->kta_no_id?></td>
                            <td><?php echo $r->kta_jenkel=='1'?'1':'';?></td>
                            <td><?php echo $r->kta_jenkel=='2'?'1':'';?></td>
                            <td><?php echo $r->kta_tempat_lahir;?></td>		
                            <td><?php echo substr($r->kta_tgl_lahir,8,2);?></td>
                            <td>/</td>
                            <td><?php echo substr($r->kta_tgl_lahir,5,2);?></td>
                            <td>/</td>
                            <td><?php echo substr($r->kta_tgl_lahir,0,4);?></td>
                            <td><?php echo date("Y")-substr($r->kta_tgl_lahir,0,4);?></td>
                            <td><?php echo $r->kta_status_nikah=='2'?'1':'';?></td>
                            <td><?php echo $r->kta_status_nikah=='1'?'1':'';?></td>
                            <td><?php echo $r->kta_status_nikah=='3'?'1':'';?></td>
                            <td><?php echo $r->pekerjaan_nama;?></td>
                            <td><?php echo $r->kta_alamat;?></td>
                            <td><?php echo $r->kel_nama;?></td>
                            <td></td>
						</tr>
                <?php } }?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
    </div>
</div>
<div class="pull-right">
		<input type="submit" name="print_excel" id="print_excel"  class="btn btn-info" value="Cetak Surat Terima Kartu">
</div>
</form>

<script type="text/javascript">
var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';
    $(document).ready(function(){		
	<?php if(isset($param) && !empty($param['propinsi'])){?>
		get_kabupaten('<?php echo $param['propinsi'];?>','<?php echo isset($param['kabupaten'])?$param['kabupaten']:'';?>');
	<?php }
		if(isset($param) && !empty($param['kabupaten'])){?>
		get_kecamatan('<?php echo $param['kabupaten'];?>','<?php echo isset($param['kecamatan'])?$param['kecamatan']:'';?>');
	<?php }
		if(isset($param) && !empty($param['kecamatan'])){?>
		get_kelurahan('<?php echo $param['kecamatan'];?>','<?php echo isset($param['kelurahan'])?$param['kelurahan']:'';?>');
	<?php }?>

	$('#province').change(function(){
          get_kabupaten($(this).val(),"");
      });

      $('#kabupaten').change(function(){
          get_kecamatan($(this).val(),"");
      });
	  
      $('#kecamatan').change(function(){
          get_kelurahan($(this).val(),"");
      });
	});
	
    function get_kabupaten(prov,kab){
      $.post(URL_AJAX+"/kabupaten",{prov:prov,kab:kab},function(o){
        $('#kabupaten').html(o);
      });
    }
    function get_kecamatan(prov,kab){
      $.post(URL_AJAX+"/kecamatan",{prov:prov,kab:kab},function(o){
        $('#kecamatan').html(o);
      });
    }
    function get_kelurahan(prov,kab){
      $.post(URL_AJAX+"/kelurahan",{prov:prov,kab:kab},function(o){
        $('#kelurahan').html(o);
      });
    }

</script>