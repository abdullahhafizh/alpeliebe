<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/collective" class="form-horizontal" method="post"> 
<div class="panel panel-default tabs" style="margin-top:25px;">
    <ul class="nav nav-tabs" role="tablist" style="border-bottom:2px solid #F5F5F5;">
        <li class="pull-right"><input type="submit" name="bayar_collective" value="Upload Data ke Jiwasraya" class="btn btn-success" ></li>
    </ul>
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
               <thead>
                <?php if($this->jCfg['page_tab']==3){?>
                <tr>
                    <th>No</th>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah Bayar</th>
                    <th>Tipe Bayar</th>
                    <th>Catatan</th>
                    <th width="30">Bukti Bayar</th>
                    <th width="60">Cetak Bukti</th>
                </tr>
                <?php }else{ ?>
                <tr>
                    <th width="30px">No</th>
                    <th><input type="checkbox" name="select_all" id="select_all" /></th>
                    <th>Tipe</th>
                    <th>ID Keanggotaan</th>
                    <th  width="150">Nomor Kartu</th>
                    <?php echo get_header_table($this->cat_search);?>
                    <th>Status Asuransi</th>
                    <th>Tanggal Akseptasi</th>
                </tr>
                <?php } ?>
                </thead>
               <tbody> 
                <?php if($this->jCfg['page_tab']==3){?>

                <?php 
                if(count($data) > 0){
                    $tipe = cfg('tipe_kta');
                    $jenkel = cfg('jenkel');
                    $jenis_bayar = cfg('jenis_bayar');
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo myDate($r->kol_date,"d M Y H:i:s");?></td>
                            <td>Rp. <?php echo myNum($r->kol_nominal);?></td>
                            <td><?php echo $jenis_bayar[$r->kol_pay_type];?></td>
                            <td><?php echo $r->kol_note;?></td>
                            <td>
                                  <?php if( isset($r->kol_bukti) && trim($r->kol_bukti)!="" ){?>
                                  <a href="<?php echo get_image(base_url()."assets/collections/salesdraft/files/".$r->kol_bukti);?>" title="Image Photo" class="act_modal" rel="700|400">
                                    <img alt="" src="<?php echo get_image(base_url()."assets/collections/salesdraft/files/".$r->kol_bukti);?>" style="height:25px;width:25px" class="img-polaroid">
                                  </a>
                                  <?php } ?>
                            </td>
                            <td><a href="<?php echo $own_links."/cetak_bayar_collective?_id="._encrypt($r->kol_id);?>" class="tip" data-original-title="Cetak Bukti Bayar" target="_blank" data-toggle="tooltip" title="Cetak BuKti Bayar"><i class="fa fa-print" style="font-size:20px;"></i></a></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="5">
                                <b>NOMOR KARTU : </b>
                                <?php foreach ((array)get_kartu_kolektif($r->kol_id) as $p => $q) {
                                    echo "<a href='".$own_links."/edit?_id="._encrypt($q->ki_kartu_id)."'>".$q->ki_nomor_kartu."</a>, ";
                                }?>
                            </td>
                        </tr>
                    <?php } 
                }
                ?>
                <?php }else{  ?>
                <?php 
                if(count($data) > 0){
                    $tipe = cfg('tipe_kta');
                    $jenkel = cfg('jenkel');
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><input type="checkbox" class="chk_item" value="<?php echo $r->kta_id;?>" name="item[]" /></td>
                            <td align="center">
								<?php
									if($r->kta_tipe == 1){
										echo '<span class="label label-success">Koperasi</span>';
									}else{
										echo '<span class="label label-warning">Non-Koperasi</span>';
									}
								?>							
							</td>
                            <td><?php echo $r->kta_no_anggota." - ".$r->coop_name;?></td>
                            <td><?php echo substr($r->kta_nomor_kartu,0,4)." ".substr($r->kta_nomor_kartu,4,4)." ".substr($r->kta_nomor_kartu,8,4)." ".substr($r->kta_nomor_kartu,12,4)." ";?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $jenkel[$r->kta_jenkel];?></td>
                            <td><?php echo $r->kta_tempat_lahir.", ".myDate($r->kta_tgl_lahir,"d M Y",false);?></td>
                            <td align="center">
								<?php
									if($r->kta_status_asuransi == 2){
										echo '<span class="label label-danger">Expired</span>';
									}elseif($r->kta_status_asuransi == 1){
										echo '<span class="label label-success">Active</span>';
									}elseif($r->kta_status_asuransi == 3){
										echo '<span class="label label-danger">Belum Sinkron</span>';
									}else{
										echo '<span class="label label-warning">Pending</span>';
									}
								?>							
							</td>
                            <td><?php echo myDate($r->kta_send_js_date,"d M Y H:i:s",false);?></td>
                        </tr>
                <?php } 
                }
                ?>
                <?php } ?>
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
    