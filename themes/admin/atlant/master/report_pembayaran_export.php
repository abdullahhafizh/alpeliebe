<?php 
$type = isset($_GET['type'])?$_GET['type']:'html';
if(trim($type)=="xls"){
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=export_pembayaran_kta".date("dmyhis").".xls");  //File name extension was wrong
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>EXPORT PEMBAYARAN</title>
	<style type="text/css">
	*{
		padding: 0px; margin: 0px;
		font-family: Tahoma; font-size: 13px;
	}
	table.table{
		border-collapse: collapse;
		width: 95%;
		margin: 5px;
	}
	table.table tr th{
		padding: 5px;
	}
	table.table tr td{
		padding: 5px;
	}
	h4{
		margin: 5px;
	}
	</style>
</head>
<body>

<h4>DATA PEMBAYARAN KTA PBSI</h4>
<table class="table" border="1">
   <thead>
    <tr>
        <th width="30px">No</th>
        <th colspan="4" align="left">Tanggal</th>
        <th width="180" align="right">Jumlah</th>
    </tr>
    </thead>
   <tbody> 
    <?php 
    $total_bayar = 0;
    if(count($data) > 0){
        foreach($data as $r){
            ?>
            <tr>
                <td align="center"><?php echo ++$no;?></td>
                <td colspan="4"><?php echo myDate($r->nama, "d M Y",false);?></td>
                <td align="right">
                    Rp. <?php echo myNum($r->jumlah);?>
                </td>
            </tr>
            <?php 
            if($this->jCfg['search']['type']=="detail"){ ?>
                <tr>
                    <td></td>
                    <td colspan="5"><b>DETAIL PEMBAYARAN</b></td>
                </tr>
            <?php
                foreach ((array)get_rincian_pembayaran($r->nama) as $rp => $rv) {
                    if($rp==0){
                        echo "<tr style='background-color:#eee;font-weight:bold;'>";
                        echo "<td></td>";
                        echo "<td>Nomor KTA</td>";
                        echo "<td>Nama Lengkap</td>";
                        echo "<td>Provinsi</td>";
                        echo "<td>Kabupaten</td>";
                        echo "<td align='right'>Jumlah Bayar</td>";
                        echo "</tr>";
                    }
                    echo "<tr>";
                    echo "<td></td>";
                    echo "<td>".$rv->kta_nomor."</td>";
                    echo "<td>".$rv->kta_nama_lengkap."</td>";
                    echo "<td>".$rv->propinsi_nama."</td>";
                    echo "<td>".$rv->kab_nama."</td>";
                    echo "<td align='right'>Rp. ".(myNum($rv->kta_jumlah_bayar))."</td>";
                    echo "</tr>";

                    $total_bayar += $rv->kta_jumlah_bayar;
                }
            }else{
                $total_bayar += $r->jumlah;
            }

            if($this->jCfg['search']['type']=="detail"){
                echo '<tr><td colspan="6">&nbsp;</td></tr>';
            }
            ?>
            
    <?php } 
    }
    ?>
    <tr>
        <td colspan="5" align="right"><b>SUB TOTAL</b></td>
        <td align="right"><b>Rp. <?php echo myNum($total_bayar);?></b></td>
    </tr>
    
    </tbody>

</table>


</body>
</html>