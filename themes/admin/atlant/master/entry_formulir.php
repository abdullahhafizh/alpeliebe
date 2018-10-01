<?php // getFormSearch();?>
<div class="panel panel-default" style="padding-top:10px;">
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table" id="datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Tanggal Registrasi</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No. HP</th>		
                    <th>Status</th>
                    <th width="50">Action</th>
                </tr>
                </thead>
               <tbody> 
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<div class="pull-right">
            <?php //echo isset($paging)?$paging:'';?>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable').DataTable({
        //"processing": true, //Feature control the processing indicator.
		//"serverSide": true,
        "pageLength" : 10,
        "ajax": {
            url : "<?php echo $own_links;?>/show_table",
            type : 'GET'
        },
    }); 	
});</script>    
    