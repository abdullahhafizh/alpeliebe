<?php js_hight_chart();
$tipe_kta = cfg('tipe_kta');
$jenkel = cfg('jenkel');
//comment
?>
<div class="row">
    <div class="col-md-12">
    	<div class="panel" style="height:300px;padding:10px;" id="cart_bar_by_prov">            
        </div>
    </div>
    
    <div class="col-md-3">
    	<div class="panel" style="height:300px;padding:10px;" id="cart_pie_gender">

    	</div>
    </div>
    <div class="col-md-6">
        <div class="panel" style="height:300px;padding:10px;" id="cart_bar_by_kop">
    	</div>
    </div>

    <div class="col-md-3">
        <div class="panel" style="height:300px;padding:10px;" id="cart_pie_status">

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
        colors:['#38B8E3','#FE9B13'],
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
                <?php foreach ((array)get_pie_status() as $k => $v) {
                   echo $k==0?"":",";
                   echo "['".$tipe_kta[$v->nama]."',".$v->jumlah."]";
                }?>
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