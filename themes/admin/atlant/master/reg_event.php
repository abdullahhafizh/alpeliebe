<?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Event/Kegiatan</h3>
            <span>Data Event/Kegiatan dari <?php echo cfg('app_name');?> berjumlah (<?php echo $cRec;?>)</span>
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
                    <?php echo get_header_table($this->cat_search);?>
                    <th width="80">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->event_name;?></td>
                            <td><?php echo myDate($r->event_start_date,"d M Y",false);?></td>
                            <td><?php echo myDate($r->event_end_date,"d M Y",false);?></td>
                            <td><?php echo $r->propinsi_nama;?></td>
                            <td><?php echo $r->kab_nama;?></td>
                            <td><?php echo $r->event_alamat;?></td>
                            <td align="right">
                                <?php link_action($links_table_item,"?_id="._encrypt($r->event_id));?>
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

    