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
        <div class="table-invoice">
            <table class="table">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Tanggal Registrasi</th>
                    <th>NPAKKSS</th>
                    <th>Nama Lengkap</th>
                    <th>Domisili</th>
                    <th colspan="2">Status</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $tingkat 	= cfg('tingkatan');
                    $jabatan 	= cfg('jabatan');
                    $jk			= cfg('jenkel');
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->time_add;?></td>
                            <td><?php echo $r->kta_nomor_kartu;?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $r->propinsi_nama." - ".$r->negara_nama;?></td>		
                            <td>
							<?php if($r->kta_status_data == 0 ){
									echo '<span class="label label-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Waiting to Approve"><li class="fa fa fa-spinner"></li> Pending</span>';								
								  }elseif($r->kta_status_data == 1 ){
									echo '<span class="label label-success" data-toggle="tooltip" data-placement="top" title data-original-title="Approved"><li class="fa fa-check-circle"></li> Approved</span>';								
								  }elseif($r->kta_status_data == 2 ){
									echo '<span class="label label-info" data-toggle="tooltip" data-placement="top" title data-original-title="Waiting to Entry"><li class="fa fa fa-spinner"></li> Uploaded</span>';								
								  }elseif($r->kta_status_data == 3){
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected by Operator Entry"><li class="glyphicon glyphicon-ban-circle"></li> Rejected</span>';								
								  }elseif($r->kta_status_data == 4){
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected by Koordinator Data"><li class="glyphicon glyphicon-ban-circle"></li> Rejected</span>';								
								  }elseif($r->kta_status_data == 9){
									echo '<span class="label label-info" data-toggle="tooltip" data-placement="top" title data-original-title="Data Event"><li class="glyphicon glyphicon-ban-circle"></li> Event</span>';								
								  }else{
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected"><li class="glyphicon glyphicon-ban-circle"></li></span>';								
								  }
							?>
                            </td>							
                            <td align="center">
							<?php if($r->is_cetak == 0 ){
									echo '<span class="label label-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Belum Tercetak"><li class="fa fa fa-spinner"></li> Belum Cetak</span>';								
								  }elseif($r->is_cetak == 1 ){
									echo '<span class="label label-success" data-toggle="tooltip" data-placement="top" title data-original-title="Sudah Tercetak"><li class="fa fa-download"></li> Sudah Cetak</span>';								
								  }elseif($r->is_cetak == 2 ){
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Dikirim ke Pabrik Untuk Dicetak"><li class="fa fa fa-spinner"></li> Sedang Cetak</span>';								
								  }else{
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected"><li class="glyphicon glyphicon-ban-circle"></li> Rejected</span>';								
								  }
							?>
                            </td>	
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
		<input type="submit" name="print_excel" id="print_excel"  class="btn btn-info" value="Download File Excel">
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