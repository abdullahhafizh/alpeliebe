<html>
 <body>
    <table align="center" width="100%" >
      <tr>
        <td>Nama Lengkap</td>
        <td>Message</td>
        <td>Certificate Number</td>
      </tr>
<?php
	  mysql_connect("188.166.222.99","upoint","upoint123mysql");
	  mysql_select_db("kakri");
	  
	  $tambah = 0;
	  $sql = "select * from app_kta WHERE kta_status_asuransi = '0'";
	  $query = mysql_query($sql);
	  while($r=mysql_fetch_array($query)){
		  $nama = urlencode($r['kta_nama_lengkap']);
		  $certi = $r['kta_certificateNumber'];		  
		  $app_info = file_get_contents("http://180.250.71.209:8011/?mod=CHK&full_name=".$nama."&certificateNumber=".$certi);
		  $app_info = json_decode($app_info, true);
		  
		  if($app_info["message"] == "Data ditemukan dengan status : Accepted"){
			  $update = "UPDATE app_kta SET kta_status_asuransi = '1',
											kta_nomorpolis = '$app_info[NomorPolis]',
											kta_pemegangpolis = '$app_info[PemegangPolis]',
											kta_masaasuransi = '$app_info[MasaAsuransi]',
											kta_macamasuransi = '$app_info[MacamAsuransi]',
											kta_uangasuransi = '$app_info[UangAsuransi]',
											kta_premiasuransi = '$app_info[PremiSekaligus]',
											kta_approval_date = '$app_info[acceptedTime]'
										WHERE kta_id = '$r[kta_id]'";
			   $update_sql = mysql_query($update) or die (mysql_error());
			   $tambah = $tambah +1;
			   $color = "#999";
		  }else{
			   $color = "#fff";			  
		  }			   
  ?>
      <tr bgcolor="<?php echo $color;?>">
		<td> <?php echo $r['kta_nama_lengkap'] ?></td>
        <td> <?php echo $app_info["message"] ?></td>
        <td> <?php echo $app_info["certificateNumber"] ?></td>
      </tr>
  <?php } 
  			   echo "Data Asuransi Update! Asuransi Accepted :".$tambah;
?>
    </table>
    <br />
  </body>
</html>