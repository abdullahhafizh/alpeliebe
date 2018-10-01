        <script type="text/javascript" src="<?php echo themeUrl();?>js/highmaps.js"></script>        
        <script type="text/javascript" src="<?php echo themeUrl();?>js/id-all.js"></script>        
        <script type="text/javascript" src="<?php echo themeUrl();?>js/exporting.js"></script>  
		<?php $id_prop = '32';?>
	<script>		
	$(function() {    
    var data = [
        {
            "hc-key": "id-3700",
            "value": <?php echo myNum(get_total_by_prop());?>,
			url: '<?php echo $own_links;?>/detail/?_id=id-3700'

        },
		<?php 
			foreach ((array)get_hc_key() as $k => $v) {
                $koma = $k<count(get_hc_key())-1?",":"";
				echo "{";
				echo '"hc-key":"'.$v->hc_key.'",';				
				echo '"value":"'.myNum(get_pengusul_prop($v->propinsi_id)).'",';				
				echo "url:'".$own_links."/detail/?_id=".$v->hc_key."'";				
				echo "}".$koma;				
			}?>						
    ];

    // Initiate the chart
    $('#container').highcharts('Map', {
                 tooltip: {
                     formatter: function(){
                         var s = this.key + '<br/>';
                         s += 'Jumlah Pengusul : ' + this.point.value+ '<br/>';
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
        series : [{
            data : data,
            mapData: Highcharts.maps['countries/id/id-all'],
            joinBy: 'hc-key',
			allowPointSelect: false,
            cursor: 'pointer',
			name: 'value',
            color: '#fcce16',
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            },
			tooltip: {
                        formatter: function(){
                          console.log(this);  
                        },
						valueSuffix: ' Anggota'
                }
        }]
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

?>
                            
    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/detail" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />

        <div class="panel-body">                                                                        
            <div class="row">
             <div class="col-md-6">
				<div id ="container"></div>
			 </div>                
                <div class="col-md-6">
                    <h3>INFORMASI TOP UP KUOTA CETAK KARTU</h3>
    <div class="panel" style="height:350px;padding:10px;">
        <div class="panel-body panel-body-table" style="height: 330px; overflow-y: scroll;">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                   <tbody> 
					<?php 
						foreach ((array)get_topup_all() as $k => $v) {
					?>
 				   <tr>
                        <td><?php echo $v->topup_date;?></td>
                        <td>Kuota cetak kartu pengusul <?php echo $v->nama_pengguna;?> telah di topup sebanyak <?php echo myNum($v->topup_amount);?> kartu</td>
                    </tr>
					<?php
					}?>						
                    </tbody>
                </table>
                
            </div>
        </div>
		
    </div>
                </div>
			 </div>
			 
            <div class="row">
                <div class="col-md-12">
						<div class="panel" style="height:370px;padding:10px;" id="cart_line_anggota">            
					</div>
                </div>
				<div class="col-md-6">
				<div class="panel panel-default" style="margin-top:-10px;">
					<div class="panel-heading">
						<div class="panel-title-box">
							<h3>Daftar Nama Pengusul</h3>
						</div>                                    
						<ul class="panel-controls" style="margin-top: 2px;">
							<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
							<li><a href="<?php echo current_url();?>" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>                                       
						</ul>
					</div>
					<div class="panel-body panel-body-table" style="height: 250px; overflow-y: scroll;">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped">
							   <thead>
								<tr>
									<th>Nama</th>
									<th>Domisili</th>
									<th>Kuota Kartu</th>
								</tr>
								</thead>
							   <tbody> 
									<?php
									  foreach ((array)get_list_pengusul() as $p => $q) {
									?>
									<tr>
										<td><?php echo $q->nama_pengguna ;?></td>
										<td><?php echo $q->propinsi_nama ;?></td>
										<td><?php echo $q->saldo_pengguna ;?></td>
									</tr>
									<?php
									  }
									?>
								</tbody>
							</table>
							
						</div>
					</div>
					
				</div>
				</div>
				<div class="col-md-6">
				<div class="panel panel-default" style="margin-top:-10px;">
					<div class="panel-heading">
						<div class="panel-title-box">
							<h3>Tabel List Topup Kuota Kartu</h3>
						</div>                                    
						<ul class="panel-controls" style="margin-top: 2px;">
							<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
							<li><a href="<?php echo current_url();?>" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>                                       
						</ul>
					</div>
					<div class="panel-body panel-body-table" style="height: 250px; overflow-y: scroll;">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped">
							   <thead>
								<tr>
									<th>Tgl. Topup Kuota</th>
									<th>Nama Pengusul</th>
									<th>Domisili</th>
									<th>Jumlah</th>
								</tr>
								</thead>
							   <tbody> 
									<?php
									  foreach ((array)get_list_topup() as $p => $q) {
									?>
									<tr>
										<td><?php echo $q->topup_date ;?></td>
										<td><?php echo $q->nama_pengguna ;?></td>
										<td><?php echo $q->propinsi_nama ;?></td>
										<td><?php echo myNum($q->topup_amount)." Kartu" ;?></td>
									</tr>
									<?php
									  }
									?>
								</tbody>
							</table>
							
						</div>
					</div>
					
				</div>
				</div>
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
            text: '<b>Grafik Topup Kuota Kartu 30 Hari Terakhir</b>'
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
            name: 'Topup',
            data: [
			<?php
              foreach ((array)get_topup_baru() as $p => $q) {
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
            data: [<?php
              foreach ((array)get_cart_kab(1,$id_prop) as $p => $q) {
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
        },
		{
            name: 'Perempuan',
            data: [<?php
              foreach ((array)get_cart_kab(0,$id_prop) as $p => $q) {
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
            color:'#000'
        },
		{
            name: 'Status Data Terverifikasi',
            data: [<?php
              foreach ((array)get_ver_kab(1,$id_prop) as $p => $q) {
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
            color:'#007c2d'
        },
		{
            name: 'Status Data Belum Terverifikasi',
            data: [<?php
              foreach ((array)get_ver_kab(0,$id_prop) as $p => $q) {
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
            color:'#f3ff11'
        }						
		]
    });
});

</script>
                            