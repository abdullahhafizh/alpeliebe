<form action="<?php echo $own_links;?>/search" method="post" >
	<div class="well">
		<div class="row">
			<div class="col-md-3">
				<select class="form-control select" id="propinsi" name="propinsi" data-live-search="true">
					<option value=""> - provinsi - </option>
					<?php
						foreach ((array)get_propinsi() as $m) {
							$s = isset($param['propinsi'])?($param['propinsi']==$m->propinsi_kode?'selected="selected"':''):'';
							echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama."</option>";
						}?>
				</select>
			</div>

			<div class="col-md-3">
				<select class="form-control" id="kabupaten" name="kabupaten" data-live-search="true">
					<option value=""> - kabupaten/kota - </option>
				</select>
			</div>

			<div class="col-md-3">
				<select class="form-control" id="kecamatan" name="kecamatan" data-live-search="true">
					<option value=""> - kecamatan - </option>
				</select>
			</div>

			<div class="col-md-3">
				<select class="form-control" id="kelurahan" name="kelurahan" data-live-search="true">
					<option value=""> - kelurahan - </option>
				</select>
			</div>
		</div><br />

		<div class="row">
			<div class="col-md-3">
				<input id="nama" name="nama" class="form-control" value="<?php echo isset($param['nama'])?$param['nama']:'';?>" placeholder="cari berdasarkan nama"/>
			</div>

			<div class="col-md-3">
				<select class="form-control select" id="status" name="status" data-live-search="true">
					<option value=""> - status cetak - </option>
					<option value="0"<?php echo isset($param['status'])?($param['status']==0?' selected="selected"':''):''?>> Belum Cetak </option>
					<option value="1"<?php echo isset($param['status'])?($param['status']==1?' selected="selected"':''):''?>> Sudah Cetak </option>
					<option value="2"<?php echo isset($param['status'])?($param['status']==2?' selected="selected"':''):''?>> Sedang Cetak </option>
					<option value="3"<?php echo isset($param['status'])?($param['status']==3?' selected="selected"':''):''?>> Rejected </option>
				</select>
			</div>

			<div class="col-md-3" style="margin-top:0px;">
				<input type="submit" value="Search!" style="margin-right:5px;" name="btn_search" id="btn_search"  class="btn btn-primary col-md-5" />
				<input type="submit" value="Reset!" name="btn_reset" id="btn_reset" class="btn btn-warning col-md-5" />
			</div>
		</div>
	</div>
</form>

<?php
	if(isset($param)){ ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive">
					<table id="costumers2" class="table datatable">
						<thead>
							<tr>
								<th width="30px">No</th>
								<th>NPAKKSS</th>
								<th>Nama Lengkap</th>
								<th>Domisili</th>
								<th>Jabatan</th>
								<th>Status</th>
								<th>Detail</th>
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
											<td><?php echo $r->kta_nomor_kartu;?></td>
											<td><?php echo $r->kta_nama_lengkap;?></td>
											<td><?php echo $r->propinsi_nama." - ".$r->negara_nama;?></td>
											<td><?php echo $r->jabatan_nama." ".$r->kta_divisi." BPP KKSS";?></td>
											<td align="center">
												<?php
													if($r->is_cetak == 0 ){
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
											<td>
												<a href="<?php echo $own_links."/edit/?_id="._encrypt($r->kta_id);?>">
													<span class="label label-default label-form" data-toggle="tooltip" data-placement="top" title data-original-title="See Detail">
														<li class="fa fa-list-alt"></li>
													</span>
												</a>
											</td>
										</tr>
										<?php } }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div class="pull-right">
            <?php // echo isset($paging)?$paging:'';?>
					</div>
				<?php }?>
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
	<?php } ?>

      $('#propinsi').change(function(){
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
