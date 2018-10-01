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
                         s += 'Jumlah Anggota : ' + this.point.value+ '<br/>';
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
					text : 'Anggota Partai Golkar'
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
		          	"name": "Jakarta",
		            "type": "map",
		            "data": [
							<?php 
							foreach ((array)get_path($id_prop) as $k => $v) {
								$koma = $k<count(get_path($id_prop))-1?",":"";
								echo "{";
								echo '"name":"'.$v->kab_nama.'",';				
								echo '"path":"'.$v->path.'",';				
								echo '"value":'.get_pengusul_value($v->kab_kode,$this->jCfg['user']['penggunaid']);				
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
foreach ((array)get_pengusul_prop($id_prop) as $k => $v) {
	$pengusul = $v->nama_pengguna;
}
			foreach ((array)get_cart_kab($id_prop) as $p => $q) {
				$koma = $p>0?',':'';
				$laki 		 = $laki.$koma."['".$q->kab_nama."',".$q->laki."]";
				$perempuan	 = $perempuan.$koma."['".$q->kab_nama."',".$q->perempuan."]";
			}			
?>
                            
    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/detail" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
						<?php
						  foreach ((array)get_maintenance() as $p => $q) {
						?>
                            <div class="alert alert-danger" role="alert">
                                <strong>MAINTENANCE ALERT! </strong> <?php echo $q->news_body;?><br>
								maintenance berlangsung pada tanggal <?php echo date("d F Y H:i", strtotime($q->news_from));?> WIB sampai <?php echo date("d F Y  H:i", strtotime($q->news_to));?> WIB
                            </div>                        
						  <?php } ?>

        <div class="panel-body">                                                                        
            <div class="row">
<!--             <div class="col-md-4"  align="center">
					<div id ="container"></div>
			 </div>  
-->
                <div class="col-md-8">
                    <h3>INFORMASI KEANGGOTAAN GOLKAR DPD <?php echo $prop_nama;?>  </h3>
						<div class="panel" style="height:370px;padding:10px;" id="cart_bar_by_prov">            
						</div>
                </div>
                <div class="col-md-4">
                            <!-- NEWS WIDGET -->
                            <div class="panel panel-danger" >
                                <div class="panel-heading">
                                    <h3 class="panel-title">System Update Notification</h3>         
                                    <ul class="panel-controls">
                                    </ul>
                                </div>
                                <div class="panel-body scroll" style="height:345px;">                               
									<?php
									  foreach ((array)get_news() as $p => $q) {
									?>
                                    <h6><?php echo $q->news_title ;?></h6>
                                    <p>
                                        <?php echo $q->news_body ;?>
                                        <span class="text-danger"><i class="fa fa-clock-o"></i> <?php echo myDate($q->time_add,"d F Y H:i:s") ;?></span>
                                    </p>
									<?php
									  }
									?>
                                </div>
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
                        <td align="right"><b><?php echo myNum(get_sum_kab($id_prop));?></b></td>
                        <td><b>Total Anggota</b></td>
                        <td align="right"><b><b><?php echo myNum(get_total_pengusul($this->jCfg['user']['penggunaid']));?></b></td>
                        <td><b>Total Pengusul</b></td>
                        <td align="right"><b><?php echo myNum(get_sum_pengusul($id_prop));?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
		
    </div>
	</div>
			 </div>                            
            <div class="row">
                <div class="col-md-8">
						<div class="panel" style="height:370px;padding:10px;" id="cart_line_anggota">            
					</div>
                </div>
				<div class="col-md-4">
				<div class="panel panel-default" style="height:370px;padding:10px;">
					<div class="panel-heading">
						<div class="panel-title-box">
							<h3>Tabel Status Data & Kartu</h3>
							<span>DPD <?php echo $prop_nama;?></span>
						</div>                                    
						<ul class="panel-controls" style="margin-top: 2px;">
							<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
						</ul>
					</div>
					<div class="panel-body panel-body-table" style="height: 300px; overflow-y:">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped">
							   <thead>
								<?php
								  foreach ((array)get_total_peng($this->jCfg['user']['penggunaid']) as $p => $q) {
								?>
								<tr>
									<td>Jumlah Data Ter-upload (Scan)</td>
									<td><?php echo $q->data_upload;?></td>
								</tr>
								<tr>
									<td>Jumlah Data Ter-entry (Entry)</td>
									<td><?php echo $q->data_entry;?></td>
								</tr>
								<tr>
									<td>Jumlah Data Reject</td>
									<td><?php echo $q->data_reject_entry+$q->data_reject_scan;?></td>
								</tr>
								<tr>
									<td>Jumlah Data Approve (Siap Cetak)</td>
									<td><?php echo $q->data_approve;?></td>
								</tr>
								<tr>
									<th>TOTAL DATA</th>
									<td><b><?php echo $q->data_total;?></b></td>
								</tr>
								<tr>
									<td>Jumlah Kartu Belum Tercetak</td>
									<td><?php echo $q->belum_cetak;?></td>
								</tr>
								<tr>
									<td>Jumlah Kartu Tercetak</td>
									<td><?php echo $q->tercetak;?></td>
								</tr>
								<tr>
									<th>TOTAL DATA</th>
									<td><b><?php echo $q->data_total;?></b></td>
								</tr>
								  <?php } ?>
								</thead>
							   <tbody> 
								</tbody>
							</table>
							
						</div>
					</div>
					
				</div>
				</div>
                </div>        </div>
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
            text: '<b>Grafik Upload Data KTA 30 Hari Terakhir DPD <?php echo $prop_nama;?></b>'
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
              foreach ((array)get_anggota_pengusul($this->jCfg['user']['penggunaid']) as $p => $q) {
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
            text: '<b>Grafik Order Kartu 30 Hari Terakhir DPD <?php echo $prop_nama;?></b>'
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
            pointFormat: '{series.name} : <b>{point.y:f}</b>'
        },
        series: [{
            name: 'Laki-Laki',
            data: [<?php echo $laki;?>],
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
        },
		{
            name: 'Perempuan',
            data: [<?php echo $perempuan;?>],
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
            color:'#000'
        }					
		]
    });
});

</script>
                            