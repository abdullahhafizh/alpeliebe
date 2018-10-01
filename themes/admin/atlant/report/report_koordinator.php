<form action="<?php echo $own_links;?>/search" method="post" >
	  <div class="well">
	  		<div class="row">	  			
	  			<div class="col-md-3">
                                <select class="form-control" id="koordinator" name="koordinator">
                                    <?php 
									if($this->jCfg['user']['userrole'] == 33 ){
										foreach ((array)get_user($this->jCfg['user']['id']) as $m) {
										  $s = isset($val)&&$val->user_id==$m->user_id?'selected="selected"':'';
										  echo "<option value='".$m->user_id."' $s >".$m->user_fullname."</option>";
										}
									}else{
									?>
                                    <option> - pilih nama koordinator - </option>
									<?php
										foreach ((array)get_manager() as $m) {
										  $s = isset($val)&&$val->col1==$m->user_id?'selected="selected"':'';
										  echo "<option value='".$m->user_id."' $s >".$m->user_fullname."</option>";
										}
									}
									?>
                                </select> 
		  		</div>
				<div class="col-md-2" style="margin-top:0px;">
					<button style="margin-right:5px;" name="btn_search" id="btn_search"  class="btn btn-primary col-md-5" type="submit">Lanjut</button>
		  			<input type="submit" value="Reset!" name="btn_reset" id="btn_reset" class="btn btn-warning col-md-5" />	
	  			</div>
	  			<!--<div class="col-md-2 pull-right" style="margin-top:-16px;">
	  			  <div class="btn-group pull-right"> <a href="#" data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-demo-space"> <span class="fa fa-download"></span>Download <span class="caret"></span> </a>
                    <ul class="dropdown-menu"> 
                      <li><a href="<?php echo $this->own_link;?>/export_data?type=html" target="_blank"><span class="fa fa-html5"></span> Html</a></li>
                      <li><a href="<?php echo $this->own_link;?>/export_data?type=excel"><span class="fa fa-table"></span> Excel</a></li>
                    </ul>
                  </div>
				</div>-->
	  		</div>	  	
	  </div>
</form>
		<?php if(isset($param)){
			js_hight_chart();
			$koordata = $param['koordata'];
		?>
        <div class="panel-body">                                                                        
            <div class="row">
				<div class="col-md-12">
				<div class="panel panel-default" style="margin-top:-10px;">
					<div class="panel-body panel-body-table">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped">
							   <tbody> 
								<tr>
									<?php
									  foreach ((array)get_user($koordata) as $p => $q) {
									?>
									<td width="300px"><b>Nama Koordinator Data</b></td>
									<td width="300px" align="left"><?php echo $q->user_fullname;?></td>
 								    <?php } ?>
									<td><b>Kode Koordinator Data </b></td>
									<td align="right"><?php echo $koordata;?></td>
									<td><b>Jumlah Operator</b></td>
									<td align="right"><?php echo get_user_koor($koordata);?></td>
								</tr>
								</tbody>
							</table>
							
						</div>
					</div>
					
				</div>
				</div>
            <div class="row">
						<?php
						  foreach ((array)get_total_koor($koordata) as $p => $q) {
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
                                <div class="widget-title">TOTAL DATA KTA</div>
                                <div class="widget-subtitle">Total Keseluruhan Data</div>
                                <div class="widget-int"><span data-toggle="counter" data-to="<?php echo $q->data_total ;?>"><?php echo $q->data_total ;?></span></div>
                            </div>                        
                        </div>
						<?php
						  }
						?>
            </div>	
            <div class="row">
                <div class="col-md-4">
				<div class="panel panel-default" style="height:400px;padding:10px;">
					<div class="panel-heading">
						<div class="panel-title-box">
							<h3>Tabel Status Data & Kartu</h3>
							<span>Koordinator Data</span>
						</div>                                    
						<ul class="panel-controls" style="margin-top: 2px;">
							<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
						</ul>
					</div>
					<div class="panel-body panel-body-table" style="height: 340px; overflow-y:">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped">
							   <thead>
								<?php
								  foreach ((array)get_total_koordata($koordata) as $p => $q) {
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
                <div class="col-md-8">
						<div class="panel" style="height:400px;padding:10px;" id="cart_line_anggota"></div>
                </div>
            </div>	
            <div class="row">
             <div class="col-md-12"  align="center">
				<div class="panel panel-default" style="margin-top:-10px;">
					<div class="panel-heading">
						<div class="panel-title-box">
							<h3>Tabel Data Upload & Entry Operator Data</h3>
						</div>                                    
					</div>
					<div class="panel-body panel-body-table scroll" style="height:350px;">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped">
							   <thead>
								<tr>
									<th width="50px">No</th>
									<th width="">Nama User</th>
									<th width="">Username</th>
									<th width="">Last Login</th>
									<th width="">Role</th>
									<th width="">Total Upload Data</th>
									<th width="">Total Reject Upload</th>
									<th width="">Total Entry Data</th>
									<th width="">Total Reject Entry</th>
								</tr>
								</thead>
							   <tbody>							   
									<?php
									  $st = "";
									  foreach ((array)get_user($koordata) as $p => $x) {
										  $no++;
									?>
									<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $x->user_id." - ".$x->user_fullname;?></td>									
									<td><?php echo $x->user_name;?></td>									
									<td><?php echo $x->col5;?></td>									
									<?php foreach ((array)get_role_list($x->ug_group_id) as $p => $s) { ?>
                                        <td><?php echo $s->ag_group_name ;?></td>                                                  
									<?php foreach ((array)get_total_koor_data($x->user_id) as $k => $v) { ?>
                                        <td><?php echo $v->data_upload ;?></td>                                                  
                                        <td><?php echo $v->data_reject ;?></td>                                                  
                                        <td><?php echo $v->data_entry ;?></td>                                                  
                                        <td><?php echo $v->data_reject_entry ;?></td>                                                  
									<?php } ?>
									<?php } ?>									
									<?php } ?>
									</tr>									
									<?php
									  $st = "";
									  foreach ((array)get_user_list($koordata) as $p => $q) {
										  $no++;
									?>
									<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $q->user_id." - ".$q->user_fullname;?></td>									
									<td><?php echo $q->user_name;?></td>									
									<td><?php echo $q->col5;?></td>									
									<?php foreach ((array)get_role_list($q->ug_group_id) as $p => $s) { ?>
                                        <td><?php echo $s->ag_group_name ;?></td>                                                  
									<?php if($s->ag_group_name == 'Operator Data Scan'){ ?>
									<?php foreach ((array)get_total_data($q->user_id) as $k => $v) { ?>
                                        <td><?php echo $v->data_upload ;?></td>                                                  
                                        <td><?php echo $v->data_reject ;?></td>                                                  
                                        <td><?php echo $v->data_entry ;?></td>                                                  
                                        <td><?php echo $v->data_reject_entry ;?></td>                                                  
									<?php } ?>											
									<?php }else{ ?>
									<?php foreach ((array)get_total_entry_data($q->user_id) as $k => $v) { ?>
                                        <td><?php echo $v->data_upload ;?></td>                                                  
                                        <td><?php echo $v->data_reject ;?></td>                                                  
                                        <td><?php echo $v->data_entry ;?></td>                                                  
                                        <td><?php echo $v->data_reject_entry ;?></td>                                                  
									<?php } ?>
									<?php } ?>									
									<?php } ?>
									</tr>
								  <?php } ?>
								</tbody>
							</table>
							
						</div>
					</div>
					
				</div>        
				</div>
            </div>	
             <!-- END NEWS WIDGET -->
       </div>
        </div>
		<?php } ?>
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
            text: '<b>GRAFIK TOTAL DATA KTA</b>'
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
            name: 'Total Data KTA',
            data: [
			<?php
              foreach ((array)get_anggota_koor($koordata) as $p => $q) {
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
            color:'#e6ff0a'
        }				
		]
    });
});

</script>
                            