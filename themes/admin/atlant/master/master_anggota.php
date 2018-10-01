<form action="<?php echo $own_links;?>/search" method="post">
	<div class="well">
		<div class="row">			
			<div class="col-md-2">				
				<select class="form-control" id="tingkat" name="tingkat" data-live-search="true" required>
					<option selected disabled> - Tingkat - </option>
					<option value="1" <?php if (isset($_SESSION['tingkat_kta'])){if ($_SESSION['tingkat_kta'] == 1) {echo "selected";}} ?>>SMA</option>
					<!-- <option value="2">SMP</option>
					<option value="3">SD</option>
					<option value="4">TK</option>
					<option value="5">STAFF</option> -->
				</select>				
			</div>			
			<div class="col-md-3">
				<select class="form-control" id="nama" name="nama" data-live-search="true">
					<option selected disabled> - Nama Sekolah - </option>
				</select>
			</div>
			<div class="col-md-2">
				<?php if(isset($_SESSION['angkatan'])){$angkatan = $_SESSION['angkatan'];}else{$angkatan = null;} ?>
				<input type="number" name="angkatan" value="<?php echo $angkatan; ?>" placeholder="Tahun Masuk" class="form-control"/>
			</div>
			<div class="col-md-3">
				<?php if(isset($_SESSION['keyword'])){$value = $_SESSION['keyword'];}else{$value = null;} ?>
				<input type="text" name="keyword" value="<?php echo $value; ?>" placeholder="masukkan kata kunci" class="form-control"/>
			</div>
			<div class="col-md-2">
				<button type="submit"  class="btn btn-primary">Search!</button>
				<a class="btn btn-warning" href="<?php echo base_url('master/master_anggota/reset');?>">Reset!</a>
			</div>			
		</div>
		<br>
	</div>
</form>
<?php
if (isset($_SESSION['tingkat_kta'])) {	
	if ($_SESSION['tingkat_kta'] == 1 || $_SESSION['tingkat_kta'] == 2 || $_SESSION['tingkat_kta'] == 3 || $_SESSION['tingkat_kta'] == 4 || $_SESSION['tingkat_kta'] == 5) {
		?>
		<div class="panel panel-default">
			<div class="panel-body">			
				<p><a href="<?php echo base_url('master/master_anggota/export');?>"><button class="btn btn-success"><i class="fa fa-download fa-fw"></i> Download Data Format Excel</button></a></p>
				<div class="table-responsive">			
					<table id="costumers2" class="table datatable">
						<thead>
							<tr>
								<th>No</th>
								<th>Name Lengkap</th>
								<th>Nomor Kartu</th>
								<th>Alumni</th>
								<th>Tingkat</th>
								<th>Angkatan</th>
								<th>Negara</th>
								<th>Provinsi</th>
								<th>Kab/Kota</th>
								<th>Alamat</th>
								<th>TTL</th>
								<th>Profile Pic</th>						
								<th>Status Cetak</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php					
							$i = 1;					
							if (!empty($json_decoded['data'])) {
								foreach ($json_decoded['data'] as $value) {
									?>							
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $value['full_name'];?></td>
										<td><?php echo $value['card_no'];?></td>
										<?php
										if (isset($_SESSION['tingkat_kta'])) {
											if ($_SESSION['tingkat_kta'] == 1) {
												$tingkat = "sma";
											}
											if ($_SESSION['tingkat_kta'] == 2) {
												$tingkat = "smp";
											}
											if ($_SESSION['tingkat_kta'] == 3) {
												$tingkat = "sd";
											}
											if ($_SESSION['tingkat_kta'] == 4) {
												$tingkat = "tk";
											}
											if ($_SESSION['tingkat_kta'] == 5) {
												$tingkat = "staff";
											}
										}
										?>
										<td><?php echo $value['school_and_staff'][''.$tingkat.'']['school']['name'];?></td>
										<td><?php echo strtoupper($tingkat); ?></td>
										<td><?php echo $value['school_and_staff'][''.$tingkat.'']['year_in'];?></td>
										<td><?php echo $value['address']['country']['name'];?></td>
										<td><?php echo $value['address']['province']['name'];?></td>
										<td><?php echo $value['address']['kabupaten']['name'];?></td>
										<td><?php echo $value['address']['street']." Rt.".$value['address']['rt']."/".$value['address']['rw'].".".$value['address']['postal_code'];?></td>
										<td><?php echo $value['birth_place'].", ".date("j F Y", strtotime($value['birth_date']));?>
										</td>
										<td><?php echo '<img src="'.$value['profile_pic'].'" height="100">';?></td>	<td><?php echo $value['card_printed']?></td>
										<?php $address =  $value['address']['street']." Rt.".$value['address']['rt']."/".$value['address']['rw'].".".$value['address']['postal_code'];?>
										<td>
											<a class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Delete User" style="text-decoration: none;" href="<?php echo base_url();?>meme/user/delete_user/?member=<?php echo _encrypt($value['id']); ?>&group=<?php echo _encrypt($value['group_id']); ?>">
												<i class="fa fa-trash fa-fw"></i>
											</a>
											<button type="button" onclick="print_card('<?php echo $value['full_name'];?>','<?php echo $value['card_no'];?>','<?php echo $value['birth_place'];?>','<?php echo $value['birth_date'];?>','<?php echo $value['profile_pic']?>')" class="btn btn-info"> Cetak Kartu </button>
										</td>
									</tr>

									<?php
									$i++;
								}
								$_SESSION['no'] = $i;
								$test = $_SESSION['no'];
							}
							if (empty($json_decoded['data'])) {
								echo "<h1>DATA TIDAK DITEMUKAN!</h1>";
							}
							?>
						</tbody>						
					</table>
					<div id = "dataBaru"></div>
				</div>
			</div>
		</div>
		<?php
	}
}
?>
<script type="text/javascript">
	$(document).ready(function(){        
		$('#tingkat').on('click', function(){
			var tingkat = $(this).val();
			if (tingkat == '' || tingkat == '0' || tingkat == null)
			{
				$('#nama').prop('disabled', true);
			}
			else
			{
				$('#nama').prop('disabled', false);
				$.ajax({
					url:"<?php echo base_url();?>index.php/ajax/data/get_group_per_tingkat",
					type: "POST",
					data: {'tingkat' : tingkat},
					dataType: 'json',
					success: function(data){
						$('#nama').html(data);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

						$('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
						console.log('jqXHR:');
						console.log(jqXHR);
						console.log('textStatus:');
						console.log(textStatus);
						console.log('errorThrown:');
						console.log(errorThrown);
					},
				});
			}
		});
		$('#tingkat').click();
	});
	var URL_AJAX = '<?php echo base_url();?>ajax/data';
	var URL_PREVIEW = '<?php echo $own_links;?>/print_preview/';
	function print_card(namaLengkap,noKartu,tempatLahir,tanggalLahir,profPic){
		if (typeof win != "undefined") win.close();
		var h = screen.height,
		w = screen.width;

		win = window.open(URL_PREVIEW+'?namaLengkap='+namaLengkap+'&noKartu='+noKartu+'&tempatLahir='+tempatLahir+'&tanggalLahir='+tanggalLahir+'&profPic='+profPic, "Print Preview", "width=1063,height=650,left="+((w-1063)/2)+",top="+((h-650)/2));
	}	
</script>