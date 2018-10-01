
        <?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Log</h3>
            <span>Data Log dari <?php echo cfg('app_name');?> (<?php echo $cRec;?>)</span>
        </div>                                    
        <ul class="panel-controls" style="margin-top: 2px;">
            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
            <li><a href="<?php echo current_url();?>" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>                                       
        </ul>
    </div>
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
               <thead>
                <tr>
                    <th width="10px">No</th>
                    <?php echo get_header_table($this->cat_search);?>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    foreach($data as $r){?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo myDate($r->log_date,"d/m/Y H:i:s");?></td>
                            <td><?php echo $r->log_user_name;?></td>
                            <td><?php echo $r->log_class;?></td>
                            <td><?php echo $r->log_function;?></td>
                            <td><?php echo $r->log_ip;?></td>
                            <td><?php echo $r->log_user_agent;?></td>
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

    