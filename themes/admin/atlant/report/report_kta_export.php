<?php 
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=LaporanEntry".date("d-M-Y").".xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
?>
<!DOCTYPE html>
<html>
            <table class="table datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th width="">Tanggal Input</th>
                    <th width="">Petugas Entry</th>
					<th width="">NIK Anggota</th>
					<th width="">NPAPG Anggota</th>
					<th width="">Nama Anggota KTA</th>
                    <th>Domisili</th>
                    <th>Status</th>
                    <th>Keterangan</th>
          </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
					$no=0;
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
							<td><?php echo myDate($r->time_entry,"d M Y",false);?></td>
                            <td>
							<?php foreach ((array)get_user($r->col8) as $k => $v) {
											echo $v->user_fullname;
							}?>
							</td>
                            <td><?php echo "'".$r->kta_no_id;?></td>
                            <td><?php echo substr($r->kta_nomor_kartu,0,6)." ".substr($r->kta_nomor_kartu,6,6)." ".substr($r->kta_nomor_kartu,12,4);?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $r->kab_nama." - ".$r->propinsi_nama;?></td>		
                            <td>
							<?php if($r->kta_status_data == 0 ){
									echo 'Pending';								
								  }elseif($r->kta_status_data == 1 ){
									echo 'Approved';								
								  }elseif($r->kta_status_data == 2 ){
									echo 'Uploaded';								
								  }elseif($r->kta_status_data == 3){
									echo 'Rejected';								
								  }elseif($r->kta_status_data == 4){
									echo 'Rejected';								
								  }elseif($r->kta_status_data == 9){
									echo 'Event';								
								  }else{
									echo 'Rejected';								
								  }
							?>
                            </td>							
                            <td><?php echo $r->col6;?></td>
                        </tr>
                <?php } }?>

                </tbody>
            </table>