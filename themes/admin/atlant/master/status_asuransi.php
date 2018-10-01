<?php getFormSearch();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/collective" class="form-horizontal" method="post"> 
<div class="panel panel-default tabs" style="margin-top:25px;">
    <ul class="nav nav-tabs" role="tablist" style="border-bottom:2px solid #F5F5F5;">
        <li <?php echo isset($this->jCfg['page_tab'])&&$this->jCfg['page_tab']==1?'class="active"':'';?> ><a href="<?php echo $own_links."/set_tab?tab=1&next=".current_url();?>"><i class="fa fa-credit-card"></i> Asuransi Aktif</a></li>
        <li <?php echo isset($this->jCfg['page_tab'])&&$this->jCfg['page_tab']==2?'class="active"':'';?>><a href="<?php echo $own_links."/set_tab?tab=2&next=".current_url();?>"><i class="fa fa-credit-card"></i> Asuransi Pending</a></li>
        <li <?php echo isset($this->jCfg['page_tab'])&&$this->jCfg['page_tab']==3?'class="active"':'';?>><a href="<?php echo $own_links."/set_tab?tab=3&next=".current_url();?>"><i class="fa fa-credit-card"></i> Asuransi Expired</a></li>
    </ul>
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <?php echo get_header_table($this->cat_search);?>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $tipe = cfg('tipe_kta');
                    $jenkel = cfg('jenkel');
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $tipe[$r->kta_tipe];?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $jenkel[$r->kta_jenkel];?></td>
                            <td><?php echo $r->kta_tempat_lahir.", ".myDate($r->kta_tgl_lahir,"d M Y",false);?></td>
                            <td><?php echo $r->kta_email;?></td>
                            <td><?php echo $r->propinsi_nama;?></td>
                            <td><?php echo $r->coop_name;?></td>                            
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
    