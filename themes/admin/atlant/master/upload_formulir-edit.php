<?php // getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table" id="table">
               <thead>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Country</th>
                </tr>
                </thead>
               <tbody> 
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<script type="text/javascript">
/*
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
*/

var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url" : "<?php echo $own_links;?>/show_table",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": true, //set not orderable
        },
        ],

    });

});
</script>    