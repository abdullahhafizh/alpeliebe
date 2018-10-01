<?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-striped">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Trayek</th>
                    <th>Biaya Kirim</th>
                    <th>Kurir</th>
                    <th width="80">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $prov = "";
                    foreach($data as $r){
                        
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td>Jakarta - <?php echo $r->propinsi_nama;?></td>
                            <td><?php echo number_format($r->bk_biaya,0);?></td>
                            <td><?php echo $r->bk_kurir;?></td>
                            <td align="right">
                                <?php link_action($links_table_item,"?_id="._encrypt($r->bk_id));?>
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
    <?php  echo isset($paging)?$paging:'';?>
</div>