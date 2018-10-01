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
    h5{
        font-size: 12px;
        margin: 5px;
    }
	</style>
</head>
<body>

<h4>DATA ANGGOTA KTA KAKRI DEKOPIN</h4>
<?php
$status_kta = array(
        0 => "PENDING",
        1 => "APPROVE"
    );

$jenkel_kta = cfg('jenkel');
$tipe_kta = cfg('tipe_kta');
?>
<table class="table" border="1">
    <thead>
        <tr>
            <th colspan="3" align="left" style="font-size:12px;background-color:#eee;">DATA BERDASARKAN STATUS</th>
        </tr>
        <tr>
            <th width="30px">No</th>
            <th align="left">Status</th>
            <th width="80">Jumlah</th>
        </tr>
    </thead>
    <tbody> 
        <?php 
        $no=1;$jumlah=0;
        foreach ((array)$status as $key => $value) {
            echo "<tr>";
            echo "<td align='center'>".($no++)."</td>";
            echo "<td>".$status_kta[$value->name]."</td>";
            echo "<td align='right'>".$value->jumlah."</td>";
            echo "</tr>";
            $jumlah += $value->jumlah;
        }?>
        <tr>
            <td colspan="2"><b>JUMLAH</b></td>
            <td align="right"><b><?php echo myNum($jumlah);?></b></td>
        </tr>
    </tbody>
</table>

<table class="table" border="1">
    <thead>
        <tr>
            <th colspan="3" align="left" style="font-size:12px;background-color:#eee;">DATA BERDASARKAN JENIS KELAMIN</th>
        </tr>
        <tr>
            <th width="30px">No</th>
            <th align="left">Jenis Kelamin</th>
            <th width="80">Jumlah</th>
        </tr>
    </thead>
    <tbody> 
        <?php 
        $no=1;$jumlah=0;
        foreach ((array)$jenkel as $key => $value) {
            echo "<tr>";
            echo "<td align='center'>".($no++)."</td>";
            echo "<td>".$jenkel_kta[$value->name]."</td>";
            echo "<td align='right'>".$value->jumlah."</td>";
            echo "</tr>";
            $jumlah += $value->jumlah;
        }?>
        <tr>
            <td colspan="2"><b>JUMLAH</b></td>
            <td align="right"><b><?php echo myNum($jumlah);?></b></td>
        </tr>
    </tbody>
</table>

<table class="table" border="1">
    <thead>
        <tr>
            <th colspan="3" align="left" style="font-size:12px;background-color:#eee;">DATA BERDASARKAN JENIS TIPE</th>
        </tr>
        <tr>
            <th width="30px">No</th>
            <th align="left">Jenis Kelamin</th>
            <th width="80">Jumlah</th>
        </tr>
    </thead>
    <tbody> 
        <?php 
        $no=1;$jumlah=0;
        foreach ((array)$tipe as $key => $value) {
            echo "<tr>";
            echo "<td align='center'>".($no++)."</td>";
            echo "<td>".$tipe_kta[$value->name]."</td>";
            echo "<td align='right'>".$value->jumlah."</td>";
            echo "</tr>";
            $jumlah += $value->jumlah;
        }?>
        <tr>
            <td colspan="2"><b>JUMLAH</b></td>
            <td align="right"><b><?php echo myNum($jumlah);?></b></td>
        </tr>
    </tbody>
</table>

<table class="table" border="1">
    <thead>
        <tr>
            <th colspan="3" align="left" style="font-size:12px;background-color:#eee;">DATA BERDASARKAN WILAYAH</th>
        </tr>
        <tr>
            <th width="30px">No</th>
            <th align="left">Wilayah</th>
            <th width="80">Jumlah</th>
        </tr>
    </thead>
    <tbody> 
    <?php 
    $no=1;$jumlah=0;
    foreach ((array)$wilayah as $key => $value) {
        echo "<tr>";
        echo "<td>".($no++)."</td>";
        echo "<td>".$value->name."</td>";
        echo "<td align='right'>".$value->jumlah."</td>";
        echo "</tr>";
        if(trim($this->jCfg['search']['type'])=="detail"){
            foreach ((array)get_rincian_kta_by_prov($value->propinsi_id) as $kp => $vp) {
               echo "<tr>
                <td></td>
                <td>".$vp->nama."</td>
                <td align='right'>".$vp->jumlah."</td>
               </tr>";
               $jumlah += $vp->jumlah;
            }
        }else{
            $jumlah += $value->jumlah;
        }
    }?>
    <tr>
        <td colspan="2"><b>JUMLAH</b></td>
        <td align="right"><b><?php echo myNum($jumlah);?></b></td>
    </tr>
    </tbody>
</table>


</body>
</html>