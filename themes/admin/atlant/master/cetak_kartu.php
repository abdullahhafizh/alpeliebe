<?php //  getFormSearch();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/collective" class="form-horizontal" method="post"> 
<div class="panel panel-default" style="margin-top:25px;">
    <ul class="nav nav-tabs" role="tablist" >
        <li class="pull-right"><input type="submit" name="cetak_kartu" value="Cetak Kartu KTA" class="btn btn-success" >&nbsp;&nbsp;&nbsp;</li>		
    </ul>
    <div class="panel-body">
        <div class="table-responsive">
            <table id="costumers2" class="table datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>NPAPG</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Pengusul</th>
                    <th>Koor. Data</th>
                    <th>Detail</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $tingkat 	= cfg('tingkatan');
                    $jabatan 	= cfg('jabatan');
                    $jk			= cfg('jenkel');
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo substr($r->kta_nomor_kartu,0,6)." ".substr($r->kta_nomor_kartu,6,4)." ".substr($r->kta_nomor_kartu,10,6);?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
<!--                        <td><?php echo $r->kta_tempat_lahir.", ".myDate($r->kta_tgl_lahir,"d M Y",false);;?></td> -->
                            <td><?php echo $r->kab_nama." - ".$r->propinsi_nama;?></td>		
							<td><?php echo $r->nama_pengguna;?></td>
							<td><?php echo $r->user_fullname;?></td>
                            <td>
							<a href="<?php echo $own_links."/edit/?_id="._encrypt($r->kta_id);?>"><span class="label label-default label-form" data-toggle="tooltip" data-placement="top" title data-original-title="See Detail"><li class="fa fa-list-alt"></li></span></a>														
                            </td>							
                        </tr>
                <?php } }?>
                </tbody>
                </tbody>
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
    