
        <?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-body panel-body-table">

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Maintenance Date</th>
                    <th>Update Version</th>
                    <th>Update List</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->maintenance_from." to ".$r->maintenance_to;?></td>
							<td><?php echo $r->changelog_version;?></td>
							<td><?php echo $r->changelog_text;?></td>
                            <td align="right">
                                <?php 
                                link_action($links_table_item,"?_id="._encrypt($r->news_id));?>
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
