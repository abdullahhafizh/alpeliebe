        <script type="text/javascript" src="<?php echo themeUrl();?>js/highmaps.js"></script>        
        <script type="text/javascript" src="<?php echo themeUrl();?>js/id-all.js"></script>        
        <script type="text/javascript" src="<?php echo themeUrl();?>js/exporting.js"></script>        
	<script type="text/javascript">
		$(function () {
		    // Initiate the chart
		    $('#container').highcharts('Map', {
                 tooltip: {
                     formatter: function(){
                         var s = this.key + '<br/>';
                         s += 'Jumlah Kecamatan : ' + this.point.value+ '<br/>';
                         return s;
                     },
                 },
		
				legend: {
					enabled: false
				  },
				title : {
					text : 'Peta Distribusi'
				},
				subtitle : {
					text : 'Jumlah Kecamatan'
				},

				mapNavigation: {
					enabled: true,
					buttonOptions: {
						verticalAlign: 'top'
					}
				},
					colorAxis: {
						min: 0,
						stops: [
							[0, '#dce8df'],
							[0.5, Highcharts.getOptions().colors[0]],
							[1, Highcharts.Color(Highcharts.getOptions().colors[0]).brighten(-0.5).get()]
						]
					},
		    	series:
		      	[				
		          {
					color: '#efef02',
					states: {
						select: {
							color: '#a4edba',
							borderColor: 'black',
							dashStyle: 'shortdot'
								}
							},
					dataLabels: {
						enabled: true,
						format: '{point.name}'
					},
		          	"name": "PROVINSI",
		            "type": "map",
		            "data": [
							<?php 
							foreach ((array)get_path($id_prop) as $k => $v) {
								$koma = $k<count(get_path($id_prop))-1?",":"";
								echo "{";
								echo '"name":"'.$v->kab_nama.'",';				
								echo '"path":"'.$v->path.'",';				
								echo '"value":'.get_kec($v->kab_kode);				
								echo "}".$koma;				
							}?>						

		            ]
		          }
		        ]
		    });
		});
	</script>
<?php js_hight_chart();
$tipe_kta = cfg('tipe_kta');
$jenkel = cfg('jenkel');
$status = cfg('status_anggota');
$asuransi = cfg('status_asuransi');
$tipe_kta = cfg('tipe_kta');
$jenkel = cfg('jenkel');
$jenis_bayar = cfg('jenis_bayar');
$status_nikah = cfg('status_nikah');
$pendidikan = cfg('pendidikan');
$pekerjaan = cfg('pekerjaan');
$tingkat = cfg('tingkatan');
$jabatan = cfg('jabatan');
$hastakarya = cfg('hasta_karya');
//$pengusul = get_pengusul_prop($id_prop);
foreach ((array)get_pengusul_prop($id_prop) as $k => $v) {
	$pengusul = $v->penggunaID;
}
?>
        <div class="panel-body">                                                                        
            <div class="row">
             <div class="col-md-4"  align="center">
					<div id ="container"></div>
			 </div>                
                <div class="col-md-8">
                    <h3>INFORMASI DATA DAERAH PROVINSI <?php echo $prop_nama;?></h3>
						<div class="panel" style="height:370px;padding:10px;" id="cart_bar_by_prov">            
						</div>
                </div>
			 </div>
            <div class="row">
    <div class="col-md-12">
    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-body panel-body-table">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                   <tbody> 
                    <tr>
                        <td><b>Kode Provinsi <?php echo $prop_nama;?></b></td>
                        <td align="right"><b><?php echo $id_prop;?></b></td>
                        <td><b>Jumlah Kabupaten</b></td>
                        <td align="right"><b><?php echo myNum(get_total_kabupaten($id_prop));?></b></td>
                        <td><b>Jumlah Kecamatan</b></td>
                        <td align="right"><b><b><?php echo myNum(get_total_kecamatan($id_prop));?></b></td>
                        <td><b>Jumlah Kelurahan</b></td>
                        <td align="right"><b><?php echo myNum(get_total_kelurahan($id_prop));?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
		
    </div>
	</div>
			 </div> 
            <div class="row">
             <div class="col-md-12"  align="center">
    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-heading">
            <div class="panel-title-box">
                <h3>Tabel Data Kelurahan dan Kecamatan Per Kabupaten Provinsi <?php echo $prop_nama;?></h3>
            </div>                                    
        </div>
        <div class="panel-body panel-body-table scroll" style="height:350px;">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                   <thead>
                    <tr>
                        <th>Kode Kabupaten</th>
                        <th width="900px">Nama Kabupaten</th>
                        <th width="80">Jumlah Kecamatan</th>
                        <th width="80">Jumlah Kelurahan</th>
                    </tr>
                    </thead>
                   <tbody> 
							<?php 
							foreach ((array)get_path($id_prop) as $k => $v) { ?>
                    <tr>
                        <td><?php echo substr($v->kab_kode,0,2).".".substr($v->kab_kode,2,2);?></td>
                        <td><?php echo $v->kab_nama;?></td>
                        <td><?php echo get_kec($v->kab_kode);?></td>
                        <td><?php echo get_kel($v->kab_kode);?></td>
                    </tr>
							<?php }?>						
                    </tbody>
                </table>
                
            </div>
        </div>
		
    </div>        </div>
        </div>
			 
        </div>
        </div>
    </form>
<script type="text/javascript">

$(function () {
    //line pertumbuhan anggota
    $('#cart_line_anggota').highcharts({
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
            text: '<b>Grafik Pendaftaran Anggota 30 Hari Terakhir Provinsi <?php echo $prop_nama;?></b>'
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
            pointFormat: '{series.name} : <b>{point.y:f}</b>'
        },
        series: [{
            name: 'Anggota',
            data: [
			<?php
              foreach ((array)get_anggota_baru($id_prop) as $p => $q) {
                echo $p>0?',':'';
                echo "['".$q->tgl."',".$q->jumlah."]";
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
        }
		]
    });
    $('#cart_line_order').highcharts({
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
            text: '<b>Grafik Order Kartu 30 Hari Terakhir Provinsi <?php echo $prop_nama;?></b>'
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
            pointFormat: '{series.name} : <b>{point.y:f}</b>'
        },
        series: [{
            name: 'Order Kartu',
            data: [<?php
              foreach ((array)get_order_baru($id_prop) as $p => $q) {
                echo $p>0?',':'';
                echo "['".$q->tgl."',".$q->jumlah."]";
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
        }
		]
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
            text: '<b>Jumlah Kelurahan Per Kabupaten</b>'
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
            pointFormat: '{series.name} : <b>{point.y:f}</b>'
        },
        series: [{
            name: 'Kelurahan',
            data: [<?php
              foreach ((array)get_kel_chart($id_prop) as $p => $q) {
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
            color:'#88f237'
        }
		]
    });
});

</script>
                            