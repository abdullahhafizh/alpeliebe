<?php header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=tutorialweb-export.xls");
header("Pragma: no-cache");

header("Expires: 0");
?>

<table>
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
			<th>Status Cetak</th>			
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
					<td>Alumni</td>								
					<td>Tingkat</td>
					<td>Angkatan</td>
					<td><?php echo $value['address']['country']['name'];?></td>
					<td><?php echo $value['address']['province']['name'];?></td>
					<td><?php echo $value['address']['kabupaten']['name'];?></td>
					<td><?php echo $value['address']['street']." Rt.".$value['address']['rt']."/".$value['address']['rw'].".".$value['address']['postal_code'];?></td>
					<td><?php echo $value['birth_place'].", ".$value['birth_date'];?></td>
					<td><?php echo $value['card_printed']?></td>					
				</tr>

				<?php
				$i++;
			}
			$_SESSION['no'] = $i;
			$test = $_SESSION['no'];
		}		
		?>
	</tbody>						
</table>