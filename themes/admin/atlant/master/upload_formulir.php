<?php // getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table" id="datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>KTP / SUKET</th>
                    <th>Pengusul</th>
                    <th>NIK / No. SUKET</th>		
                    <th>Tanggal Upload</th>
                    <th>Op. Scan</th>
                    <th>Status</th>
                    <th width="250">Keterangan Reject</th>
                    <th width="50">Action</th>
                </tr>
                </thead>
               <tbody> 
                </tbody>
            </table>
            
        </div>
    </div>
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
});
</script>    