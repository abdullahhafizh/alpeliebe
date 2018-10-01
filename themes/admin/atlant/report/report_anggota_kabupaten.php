<?php
 js_hight_chart();
 $status_asuransi_kta = array(
        0 => "PENDING",
        1 => "ACTIVE",
        2 => "EXPIRED"		
    );
$status_kta = array(
        0 => "Non-Aktif",
        1 => "Aktif",
    );


$jenkel = cfg('jenkel');
$tipe_kta = cfg('tipe_kta');
$koperasi_kta = cfg('jenis_koperasi');
$pekerjaan_kta = cfg('pekerjaan');
?>
<div class="col-md-4">
    	<div class="panel" style="height:300px;padding:10px;" id="cart_pie_gender">
</div>
</div>
<div class="col-md-4">
    	<div class="panel" style="height:300px;padding:10px;" id="cart_pie_status">
</div>
</div>
<div class="col-md-4">
    	<div class="panel" style="height:300px;padding:10px;" id="cart_pie_usia">
</div>
</div>
<div class="col-md-12">
    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-heading">
            <div class="panel-title-box">
                <h3>Tabel Data Anggota</h3>
                <span>Summary Jumlah Per Wilayah Provinsi</span>
            </div>                                    
            <ul class="panel-controls" style="margin-top: 2px;">
                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                <li><a href="<?php echo current_url();?>" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>                                       
            </ul>
        </div>
        <div class="panel-body panel-body-table">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                   <thead>
                    <tr>
                        <th width="30px">No</th>
                        <th>Wilayah</th>
                        <td align="center"  colspan="2">Data Anggota</td>
                        <td align="center"  colspan="9">Jenis Pekerjaan</td>
                        <td align="center"  colspan="3">Usia</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th width="50">Pria</th>
                        <th width="50">Wanita</th>
                        <th width="50">PNS</th>
                        <th width="50">Swasta</th>
                        <th width="50">Wirausaha</th>
                        <th width="50">Petani</th>
                        <th width="50">Nelayan</th>
                        <th width="50">IRT</th>
                        <th width="50">Konsultan</th>
                        <th width="50">Pelajar</th>
                        <th width="50">Lainnya</th>
                        <th width="50">< 30th </th>
                        <th width="50">30 - 50 th</th>
                        <th width="50">> 50th</th>
                    </tr>
                    </thead>
                   <tbody> 
                    <?php 
                    $no=1;$jumlah=0;
                    foreach ((array)$wilayah as $key => $value) {
                        echo "<tr>";
                        echo "<td><b>".($no++)."</b></td>";
                        echo "<td><b>".$value->name."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_gender(0,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_gender(1,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_pekerjaan(1,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_pekerjaan(2,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_pekerjaan(3,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_pekerjaan(4,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_pekerjaan(5,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_pekerjaan(6,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_pekerjaan(7,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_pekerjaan(8,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_pekerjaan(9,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_umur(1,30,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_umur(30,50,$value->propinsi_id))."</b></td>";
                        echo "<td align='right'><b>".myNum(get_total_umur(50,100,$value->propinsi_id))."</b></td>";
                        echo "</tr>";
                        if(trim($this->jCfg['search']['type'])=="detail"){
                            foreach ((array)get_r_by_prov($value->propinsi_id) as $kp => $vp) {
                               echo "<tr>
                                <td></td>
                                <td>".$vp->nama."</td>
                                <td align='right'>".$vp->jumlah."</td>
                               </tr>";
                               $jumlah += $vp->jumlah;
                            }
                        }else{
                            $jumlah_pria += myNum(get_total_gender(0,$value->propinsi_id));
                            $jumlah_wanita += myNum(get_total_gender(1,$value->propinsi_id));							
                            $jumlah_pns += myNum(get_total_pekerjaan(1,$value->propinsi_id));							
                            $jumlah_kerja_2 += myNum(get_total_pekerjaan(2,$value->propinsi_id));							
                            $jumlah_kerja_3 += myNum(get_total_pekerjaan(3,$value->propinsi_id));							
                            $jumlah_kerja_4 += myNum(get_total_pekerjaan(4,$value->propinsi_id));							
                            $jumlah_kerja_5 += myNum(get_total_pekerjaan(5,$value->propinsi_id));							
                            $jumlah_kerja_6 += myNum(get_total_pekerjaan(6,$value->propinsi_id));							
                            $jumlah_kerja_7 += myNum(get_total_pekerjaan(7,$value->propinsi_id));							
                            $jumlah_kerja_8 += myNum(get_total_pekerjaan(8,$value->propinsi_id));							
                            $jumlah_kerja_9 += myNum(get_total_pekerjaan(9,$value->propinsi_id));							
                            $jumlah_umur_1 += myNum(get_total_umur(1,30,$value->propinsi_id));							
                            $jumlah_umur_2 += myNum(get_total_umur(30,50,$value->propinsi_id));							
                            $jumlah_umur_3 += myNum(get_total_umur(50,100,$value->propinsi_id));							
                        }
                    }?>
                    <tr>
                        <td colspan="2"><b>JUMLAH</b></td>
                        <td align="right"><b><?php echo myNum($jumlah_pria);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_wanita);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_pns);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_kerja_2);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_kerja_3);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_kerja_4);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_kerja_5);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_kerja_6);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_kerja_7);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_kerja_8);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_kerja_9);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_umur_1);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_umur_2);?></b></td>
                        <td align="right"><b><?php echo myNum($jumlah_umur_3);?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#panel-content-wrap').removeClass('panel');
	$('#border-header').css('border','none');
});	

$(function () {
    // Build the chart
    $('#cart_pie_status').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        colors:['#38B8E3','#FE9B13','#FE9B16','#260e07','#63524d','#150c8e','#8e0c5f','#8c8748','#161614'],
        title: {
            text: ''
        },
        subtitle: {
            text: '<b>Anggota Berdasarkan Status</b>'
        },
        tooltip: {
            pointFormat: '{point.y:.f}'
        },
        credits: {
            enabled:false
        },
        exporting:{
            enabled:false
        },
        plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
        series: [{
            type: 'pie',
            name: 'Status Anggota',
            data: [
                <?php foreach ((array)get_pie_pekerjaan() as $k => $v) {
                   echo $k==0?"":",";
                   echo "['".$pekerjaan_kta[$v->nama]."',".$v->jumlah."]";
                }?>
            ]
        }]
    });

    $('#cart_pie_usia').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        colors:['#38B8E3','#FE9B13','#000892'],
        title: {
            text: ''
        },
        subtitle: {
            text: '<b>Anggota Berdasarkan Usia</b>'
        },
        tooltip: {
            pointFormat: '{point.y:.f}'
        },
        credits: {
            enabled:false
        },
        exporting:{
            enabled:false
        },
        plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
        series: [{
            type: 'pie',
            name: 'Status Anggota',
            data: [
				['< 30 th',<?php echo myNum(get_pie_umur(1,30));?> ],['30 - 50th',<?php echo myNum(get_pie_umur(30,50));?>],['> 50th',<?php echo myNum(get_pie_umur(50,100));?>]			
            ]
        }]
    });
    //gender...
    $('#cart_pie_gender').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
        },
        colors:['#009F9A','#38B8E3','#90B356'],
        title: {
            text: ''
        },
        subtitle: {
            text: '<b>Anggota Berdasarkan Jenis Kelamin</b>'
        },
        tooltip: {
            pointFormat: '{point.y:.f}'
        },
        credits: {
            enabled:false
        },
        exporting:{
            enabled:false
        },
        plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
        series: [{
            type: 'pie',
            name: 'Jenis Kelamin',
            data: [
                <?php 
                foreach ((array)get_pie_gender() as $k => $v) {
                   echo $k==0?"":",";
                   echo "['".$jenkel[$v->nama]."',".$v->jumlah."]";
                }?>
            ]
        }]
    });


    //line pertumbuhan anggota
    $('#cart_line_anggota').highcharts({
        chart: {
            type: 'area'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: '<b>Data Pendaftaran Anggota 30 Hari Terakhir</b>'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: ''
            }
        },
        credits: {
            enabled:false
        },
        exporting:{
            enabled:false
        },
        yAxis: {
            title: {
                text: 'Jumlah'
            },
            min: 0
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%e. %b}: {point.y:.f}'
        },

        plotOptions: {
            area: {
                marker: {
                    enabled: true
                },
                fillOpacity:0.3
            },
            enableMouseTracking: false
        },
        legend:{
            enabled:false
        },
        series: [{
            name:'Anggota Baru',
            data: [
                <?php 
                foreach ((array)get_line_byday() as $k => $v) {
                   $koma = $k<count(get_line_byday())-1?",":"";
                   $dm = explode("-", $v->tgl);
                   echo "[Date.UTC(".$dm[0].",".((int)$dm[1]-1).",".((int)$dm[2])."),".$v->jumlah."]".$koma."
                   ";
                }?>
            ]
        }]
    });

    $('#cart_bar_by_prov').highcharts({
        chart: {
            type: 'column',
            marginLeft:60,
            marginRight:10,
            reflow: true
        },
        title: {
            text: ''
        },
        credits: {
          enabled:false
        },
        exporting:{
          enabled:false
        },
        subtitle: {
            text: '<b>Jumlah Anggota Setiap Provinsi</b>'
        },
        plotOptions: {
            column : {
                pointWidth:23
            }
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -35,
                style: {
                    fontSize: '9px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<b>{point.y:.1f}</b>'
        },
        series: [{
            name: 'Anggota',
            data: [<?php
              foreach ((array)get_cart_badko() as $p => $q) {
                echo $p>0?',':'';
                echo "['".$q->nama."',".$q->jumlah."]";
              }
            ?>
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#111',
                align: 'right',
                x: 4,
                y: -20,
                style: {
                    fontSize: '9px',
                    fontFamily: 'Verdana, sans-serif'
                }
            },
            color:'#009F9A'
        }]
    });

});

</script>
    