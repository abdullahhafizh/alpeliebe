<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/collective" class="form-horizontal" method="post"> 
<div class="panel panel-default tabs" style="margin-top:25px;">
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Nomor Order</th>
                    <th>Nama Pemesan</th>
                    <th width="50">Nomor Telp Pemesan</th>
                    <th>Email Pemesan</th>
                    <th>Alamat</th>
                    <th>Domisili</th>
                    <th>Jumlah Kartu</th>
                    <th>Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $tingkatan 	= cfg('tingkatan');
                    $jabatan 	= cfg('jabatan');
                    $jk			= cfg('jenkel');
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->order_id;?></td>
                            <td><?php echo $r->nama_pengguna;?></td>
                            <td><?php echo $r->notelp_pengguna;?></td>
                            <td><?php echo $r->email_pengguna;?></td>
                            <td><?php echo $r->alamat_pengguna;?></td>
                            <td><?php echo $r->propinsi_nama;?></td>							
                            <td><?php echo get_kta_order($r->order_id)." Kartu";?></td>							
                            <td align="right">
                                <?php link_action($links_table_item,"?_id="._encrypt($r->order_id));?>
                            </td>							
                        </tr>
                <?php } }?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<div class="pull-right">
            <?php echo isset($paging)?$paging:'';?>
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
    $('#select_all').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.chk_item').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.chk_item').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});
</script>
    