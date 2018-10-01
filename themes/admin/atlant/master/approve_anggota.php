<?php //getFormSearch();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/collective" class="form-horizontal" method="post"> 
<div class="panel panel-default" style="margin-top:25px;">
    <ul class="nav nav-tabs" role="tablist" style="border-bottom:2px solid #F5F5F5;">
        <li class="pull-right"><input type="submit" name="approve" value="Approve Data" class="btn btn-success" >&nbsp;&nbsp;&nbsp;</li>		
        <li class="pull-right"><input type="submit" name="reject" value="Reject Data" class="btn btn-danger" >&nbsp;&nbsp;&nbsp;</li>
    </ul>
	<br>
    <div class="panel-body panel-body-table ">
        <div class="table-responsive">
            <table id="costumers2" class="table datatable">
               <thead>
                    <th><input type="checkbox" name="select_all" id="select_all" /></th>
                    <th width="30px">No</th>
                    <th>Tanggal Entry</th>
                    <th>NPAPG</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Op. Scan</th>
                    <th>Op. Entry</th>
                    <th width="30px">Action</th>
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
                            <td><input type="checkbox" class="chk_item" value="<?php echo $r->kta_id;?>" name="item[]" /></td>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->time_entry;?></td>
                            <td><?php echo $r->kta_nomor_kartu;?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $r->kab_nama." - ".$r->propinsi_nama;?></td>							
                            <td><?php echo $r->col3;?></td>							
                            <td><?php echo $r->nama_user;?></td>							
                            <td align="right">
							<a href="<?php echo $own_links."/edit/?_id="._encrypt($r->kta_id);?>"><span class="label label-default label-form" data-toggle="tooltip" data-placement="top" title data-original-title="See Detail"><li class="fa fa-edit"></li></span></a>														
                            </td>							
                        </tr>
                <?php } }?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<div class="pull-right">
            <?php // echo isset($paging)?$paging:'';?>
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
    