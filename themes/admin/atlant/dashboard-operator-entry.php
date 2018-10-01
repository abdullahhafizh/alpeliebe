<?php js_hight_chart();?>
    <form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/detail" class="form-horizontal" method="post"> 
        <input type="hidden" name="kta_id" id="kta_id" value="<?php echo isset($val->kta_id)?$val->kta_id:'';?>" />
        <div class="panel-body">                                                                        
            <div class="row">
                <div class="col-md-9">
						<div class="panel" style="height:410px;padding:10px;" id="cart_line_anggota">            
						</div>
                </div>
                <div class="col-md-3">
					<div class="panel panel-default" style="margin-top:-10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Daftar Jumlah Entry</h3>         
                                    <ul class="panel-controls">
                                    </ul>
                                </div>
						<div class="panel-body panel-body-table scroll" style="height:320px;">
							<div class="table-responsive">
								<table class="table">
								   <thead>
									<tr>
										<th width="30px">No</th>
										<th>Tanggal</th>
										<th>Jumlah Entry</th>
									</tr>
									</thead>
								   <tbody> 
														<?php
														  $st = "";
														  $operator 	 = $this->jCfg['user']['id'];
														  $type 	 	 = 'time_entry';
														  $column		 = 'col5';
														  $sort		 	 = 'desc';
														  $gsort		 = 'asc';
														  $total 		 = 0;
														  foreach ((array)get_rekap_dashboard($operator,$type,$column,$sort) as $p => $q) {
															$total = $total + $q->jumlah;
														?>
														<?php
														  $st = "";
														  $no++;
														?>
														<tr>
														<td><?php echo $no;?></td>
														<td><?php echo $q->tgl;?></td>									
														<td><?php echo $q->jumlah;?></td>																		
														</tr>									
									<?php } 
									?>
									</tbody>
								</table>
								
							</div>
						</div>
                                <div class="panel-footer"> 
                                        <span class="contacts-title"> Total Data Entry : <?php echo myNum($total);?></span>
                                </div>
					</div>
				</div>			 </div>
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
            text: '<b>GRAFIK DATA ENTRY</b>'
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
            name: 'Jumlah Entry',
            data: [
			<?php
              foreach ((array)get_rekap_dashboard($operator,$type,$column,$gsort) as $p => $q) {
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
});

</script>
                            