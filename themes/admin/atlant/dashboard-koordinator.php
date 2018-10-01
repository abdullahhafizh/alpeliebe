<?php
    foreach ((array)get_grafik_koor($this->jCfg['user']['id']) as $p => $q) {
		$koma = $p>0?',':'';
        $approve = $approve.$koma."['".$q->tgl."',".$q->approve."]";
        $entry	 = $entry.$koma."['".$q->tgl."',".$q->entry."]";
		$upload	 = $upload.$koma."['".$q->tgl."',".$q->upload."]";
    }
//debugCode($upload);
js_hight_chart();
$jenkel = cfg('jenkel');
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
						<?php
						  foreach ((array)get_total_koor($this->jCfg['user']['id']) as $p => $q) {
						?>
                        <div class="col-md-3">
                            <div class="widget widget-primary widget-padding-sm">
                                <div class="widget-title">DATA UPLOAD</div>
                                <div class="widget-subtitle">Total Keseluruhan Data Upload</div>
                                <div class="widget-int"><span data-toggle="counter" data-to="<?php echo $q->data_upload;?>"><?php echo $q->data_upload;?></span></div>
                            </div>                        
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-success widget-padding-sm">
                                <div class="widget-title">DATA ENTRY</div>
                                <div class="widget-subtitle">Total Keseluruhan Data Entry</div>
                                <div class="widget-int"><span data-toggle="counter" data-to="<?php echo $q->data_entry ;?>"><?php echo $q->data_entry ;?></span></div>
                            </div>                        
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-danger widget-padding-sm">
                                <div class="widget-title">DATA REJECT</div>
                                <div class="widget-subtitle">Total Keseluruhan Data Reject</div>
                                <div class="widget-int"><span data-toggle="counter" data-to="<?php echo $q->data_reject_entry+$q->data_reject_scan ;?>"><?php echo $q->data_reject_entry+$q->data_reject_scan ;?></span></div>
                            </div>                        
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-info widget-padding-sm">
                                <div class="widget-title">TOTAL DATA APPROVED</div>
                                <div class="widget-subtitle">Total Keseluruhan Data Approved</div>
                                <div class="widget-int"><span data-toggle="counter" data-to="<?php echo $q->data_approve ;?>"><?php echo $q->data_approve ;?></span></div>
                            </div>                        
                        </div>
						<?php
						  }
						?>
            </div>	
            <div class="row">
                <div class="col-md-9">
						<div class="panel" style="height:490px;padding:10px;" id="cart_line_anggota">            
						</div>
                </div>
                <div class="col-md-3">
                            <!-- NEWS WIDGET -->
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title">System Update Notification</h3>         
                                    <ul class="panel-controls">
                                    </ul>
                                </div>
                                <div class="panel-body scroll" style="height: 115px;">                               
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
                            <!-- CONTACT LIST WIDGET -->
                            <div class="panel panel-default">
                                <div class="panel-body scroll list-group list-group-contacts" style="height:250px;">                                
									<?php
									  $st = "";
									  foreach ((array)get_user_list($this->jCfg['user']['id']) as $p => $q) {
									   $status = $q->col2==1?'status-online':'status-offline';
									?>
                                    <a href="#" class="list-group-item">                                 
                                        <div class="list-group-status <?php echo $status;?>"></div>
                                        <img src="<?php echo base_url().'assets/images/no_image.jpg';?>" class="pull-left" alt="Brad Pitt"/>
                                        <span class="contacts-title"><?php echo $q->user_fullname ;?></span>
										<?php foreach ((array)get_role_list($q->ug_group_id) as $p => $q) { ?>
                                        <p><?php echo $q->ag_group_name ;?></p>                                                  
										<?php } ?>
                                    </a>
									<?php
									  }
									?>
                                </div>
                                <div class="panel-footer"> 
                                        <span class="contacts-title"><?php echo myNum(get_user_online_koor(1,$this->jCfg['user']['id']));?> User Online</span>
                                </div>
                            </div>
                            <!-- END CONTACT LIST WIDGET -->

                        </div>
                            <!-- END NEWS WIDGET -->
       </div>
        </div>
    </form>
<script type="text/javascript">

    $(document).ready(function(){
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
            text: '<b>Grafik Penambahan Data KTA 30 Hari Terakhir</b>'
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
                text: 'Jumlah Data Upload KTA'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{series.name} : <b>{point.y:f}</b>'
        },
        series: [
		{
            name: 'Data Upload',
            data: [
			<?php echo $upload; ?>
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
            color:'#07f9ed'
        }
		]
    });
	
    $('#cart_approve').highcharts({
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
            text: '<b>Grafik Data KTA 30 Hari Terakhir</b>'
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
        series: [		
		{
            name: 'Total Data Approve',
            data: [
			<?php echo $approve; ?>
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
            color:'#05af05'
        }				
		]
    });	
});

</script>
                            