<?php 
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=Surat-Tanda-Terima-KTA".date("d-M-Y").".xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
?>
<!DOCTYPE html>
<html>
            <table class="table">
               <thead>
                        <tr>
                            <td colspan="4" align="center"><h3><b>SURAT TANDA TERIMA KTA</b></h3></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left">Telah diterima dari DPP Partai Golkar</td>
						</tr>
                        <tr>
                            <td colspan="4" align="left">Berupa Kartu Tanda Anggota (KTA) Sebanyak <?php echo count($data);?> Kartu</td>
						</tr>
                        <tr>
                            <td colspan="4" align="left">pada acara Pelatihan "Sistem Aplikasi Database Keanggotaan KTA-PG" </td>
						</tr>
                        <tr>
                            <td colspan="4" align="left">10 - 11 Juni 2017 - Sofyan Saka Hotel, Medan - Sumatera Utara</td>
						</tr>
									<?php 
									foreach ((array)get_kab($param['kabupaten']) as $k => $v) {  ?>
                        <tr>
                            <td colspan="2" align="left">Provinsi : <?php echo $v->propinsi_nama;?></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left">Kabupaten : <?php echo $v->kab_nama;?></td>
						</tr>
									<?php }
									?>														
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                <tr>
                    <th width="30px">No</th>
                    <th>Tanggal Registrasi</th>
                    <th>NPAKKSS</th>
                    <th>Nama Lengkap</th>
                    <th>Domisili</th>
                    <th>Paraf</th>
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
                            <td border="1px"><?php echo ++$no;?></td>
                            <td border="1px"><?php echo $r->time_add;?></td>
                            <td border="1px"><?php echo "'".$r->kta_nomor_kartu;?></td>
                            <td border="1px"><?php echo $r->kta_nama_lengkap;?></td>
                            <td border="1px"><?php echo $r->propinsi_nama." - ".$r->negara_nama;?></td>		
                            <td border="1px"></td>
						</tr>
                <?php } }?>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="2" align="center">Yang Menyerahkan</td>
                            <td colspan="2" align="center">Yang Menerima</td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="2" align="center">(_______________________________________)</td>
                            <td colspan="2" align="center">(_______________________________________)</td>
						</tr>
                        <tr>
                            <td colspan="2" align="center"></td>
                            <td colspan="2" align="left">No. HP : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						</tr>
                        <tr>
                            <td colspan="4" align="center">Mengetahui,</td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="left"></td>
						</tr>
                        <tr>
                            <td colspan="4" align="center">(________________________________)</td>
						</tr>
                </tbody>
            </table>
            