
        <?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Top Up Kuota</h3>
            <span>Data Top Up Kuota dari <?php echo cfg('app_name');?> (<?php echo $cRec;?>)</span>
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
                    <th width="50">Bukti</th>
                    <th>Tanggal Top Up</th>
                    <th>Nama Pengusul</th>
                    <th>Domisili</th>
                    <th>Jumlah Top Up</th>
                    <th>Status</th>
                    <th width="50">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td>
                                <a href="<?php echo get_image(base_url()."assets/collections/photo/medium/".$r->topup_foto);?>" title="Photo <?php echo $r->topup_foto;?>" class="act_modal" rel="600|350">
                                    <img alt="" src="<?php echo get_image(base_url()."assets/collections/photo/thumb/".$r->topup_foto);?>" class="img-polaroid" style="height:30px;width:30px">
                                </a>
                            </td>
                            <td><?php echo $r->topup_date;?></td>
                            <td><?php echo $r->nama_pengguna;?></td>
                            <td><?php echo $r->propinsi_nama;?></td>
                            <td><?php echo myNum($r->topup_amount)." Kartu";?></td>
                            <td><?php echo ($r->topup_status==1)?'<span class="label label-info">Confirmed</span>':'<span class="label label-warning">Pending</span>';?></td>
                            <td align="right">
                                <?php 
                                link_action($links_table_item,"?_id="._encrypt($r->topup_id));?>
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
