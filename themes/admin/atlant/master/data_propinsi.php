<?php// getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">    
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-striped datatable">
               <thead>
                <tr>
                    <th width="50px">Kode</th>
                    <th width="450px">Nama</th>
                    <th>Attachment Depdagri</th>
                    <th>Attachment KPU</th>
                    <th width="80">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo $r->propinsi_id;?></td>
                            <td><?php echo $r->propinsi_nama;?></td>
                            <td><a href="<?php echo base_url().'assets/datawilayah/depdagri/'.$r->att_depdagri;?>" target="_blank"><?php echo $r->att_depdagri;?></a></td>
                            <td><a href="<?php echo base_url().'assets/datawilayah/kpu/'.$r->att_kpu;?>" target="_blank"><?php echo $r->att_kpu;?></a></td>
                            <td align="right">
                                <?php link_action($links_table_item,"?_id="._encrypt($r->propinsi_id));?>
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
    <?php // echo isset($paging)?$paging:'';?>
</div>

    