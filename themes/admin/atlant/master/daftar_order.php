<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Order Kartu</h3>
            <span>Data Order Kartu dari <?php echo cfg('app_name');?> (<?php echo $cRec;?>)</span>
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
                    <th width="50">Nomor Order</th>
                    <th>Jumlah Kartu</th>
                    <th>Tanggal Order</th>
                    <th>Tanggal Accepted</th>
                    <th>Tanggal Kirim Order</th>
                    <th>Nomor Resi Order</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->order_id;?></td>
                            <td><?php echo get_kta_order($r->order_id)." Kartu";?></td>							
                            <td><?php echo $r->order_date;?></td>
                            <td><?php echo $r->order_acc_date;?></td>
                            <td><?php echo $r->order_send_date;?></td>
                            <td><?php echo $r->order_resi;?></td>
                            <td><?php if($r->order_status == 0 ){
										echo '<span class="label label-warning">Pending</span>';
									  }elseif($r->order_status == 1 ){
										echo '<span class="label label-success">Accepted</span>';								
									  }else{
										echo '<span class="label label-default">Sent</span>';																		  
									  }
							?></td>							
                            <td align="right">
                                <?php link_action($links_table_item,"?_id="._encrypt($r->order_id));?>
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
