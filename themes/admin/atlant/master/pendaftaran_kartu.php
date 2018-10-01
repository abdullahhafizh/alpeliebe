<?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Anggota KTA-PG</h3>
            <span>Data Anggota dari KTA-PG berjumlah (<?php echo $cRec;?>)</span>
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
                    <th>Tingkat</th>
                    <th>NPAPG</th>
                    <th>Nama Lengkap</th>
                    <th>Domisili</th>
                    <th>Pengusul</th>
                    <th>Entry</th>
                    <th>Status</th>
                    <th width="50">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $tingkatan 	= cfg('tingkatan');
                    $jabatan 	= cfg('jabatan');
                    $jk			= cfg('jenkel');
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $tingkatan[$r->kta_tingkatan];?></td>
                            <td><?php echo $r->kta_nomor_kartu;?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $r->kab_nama." - ".$r->propinsi_nama;?></td>							
                            <td><?php echo $r->nama_pengguna;?></td>
                            <td><?php echo $r->nama_user;?></td>
                            <td>
							<?php if($r->kta_status_data == 0 ){
									echo '<span class="label label-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Pending"><li class="fa fa fa-spinner"></li> Pending</span>';								
								  }elseif($r->kta_status_data == 1 ){
									echo '<span class="label label-success" data-toggle="tooltip" data-placement="top" title data-original-title="Accepted"><li class="fa fa-check-circle"></li> Accepted</span>';								
								  }elseif($r->kta_status_data == 2 ){
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Uploaded"><li class="fa fa fa-spinner"></li> Uploaded</span>';								
								  }else{
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected"><li class="glyphicon glyphicon-ban-circle"></li> Rejected</span>';								
								  }
							?>
							</td>							
                            <td align="right">
                                <?php link_action($links_table_item,"?_id="._encrypt($r->kta_id));?>
                            </td>
                        </tr>
                <?php } 
                }
                ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<div class="pull-right">
            <?php echo isset($paging)?$paging:'';?>
</div>

    