<?php 
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=FileExcel".date("d-M-Y").".xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
?>
<!DOCTYPE html>
<html>
<?php
$status_kta = array(
        0 => "PENDING",
        1 => "APPROVE"
    );

$jenkel_kta = cfg('jenkel');
$tipe_kta = cfg('tipe_kta');
?>
                                <table class="table table-hover table-bordered table-striped">
                                   <thead>
                                    <tr>
                                        <th width="30px">No.</th>
                                        <th>NPAPG</th>
                                        <th>NAMA ANGGOTA</th>
                                        <th>DOMISILI</th>
                                        <th>TANGGAL DISTRIBUSI</th>
                                    </tr>
                                    </thead>
                                   <tbody> 
                                    <?php 
                                    $no=0;
                                    if(count($data) > 0){
                                        $tipe = cfg('tipe_kta');
                                        $jenkel = cfg('jenkel');
                                        foreach($data as $r){
											$no++;
                                            ?>
                                            <tr>
                                                <td><?php echo $no;?></td>
                                                <td><?php echo " '".$r->kta_nomor_kartu;?></td>
                                                <td><?php echo $r->kta_nama_lengkap;?></td>
                                                <td><?php echo $r->kab_nama."-".$r->propinsi_nama;?></td>
                                                <td><?php echo "'".date('m/Y',strtotime($r->time_add));?></td>
												<?php if(empty($r->kta_foto_wajah)){ ?>
												<td>TIDAK ADA FOTO</td>		
												<?php }else{ ?>
												<td></td>		
												<?php } ?>
                                            </tr>
                                    <?php } 
                                    }
                                    ?>
                                    </tbody>
                                </table>