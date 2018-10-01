<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Group</h3>
            <span>Data Group dari <?php echo cfg('app_name');?></span>
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
                    <th width="40">No</th>
                    <th>Group Name</th>
                    <th>Group Desc</th>
                    <th width="70">Status</th>
                    <th width="100">#</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    if(count($data) > 0){
                      $no=1;
                      foreach($data as $r){?>
                        <tr >
                          <td><?php echo $no++;?></td>
                          <td><?php echo $r->ag_group_name;?></td>
                          <td><?php echo $r->ag_group_desc;?></td>
                          <td><?php echo ($r->ag_group_status==1)?'<span class="label label-info">Aktif</span>':'<span class="label label-warning">Non Aktif</span>';?></td>
                          <td align="right">
                              <?php 
                              $except = array();
                              if($r->ag_id==1)
                                $except = array('delete','edit');
                            
                              link_action($links_table_item,"?_id="._encrypt($r->ag_id),$except);?>
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
