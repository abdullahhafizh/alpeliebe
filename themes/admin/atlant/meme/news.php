
        <?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-body panel-body-table">

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Notification Date</th>
                    <th>Title</th>
                    <th>Notification</th>
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
                            <td><?php echo $r->time_add;?></td>
							<td><?php echo $r->news_title;?></td>
							<td><?php echo $r->news_body;?></td>
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
