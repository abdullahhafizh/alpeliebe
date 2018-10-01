<?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Anggota KTA-PG</h3>
            <span>Data Anggota dari KTA-PG berjumlah (<?php echo $cRec;?>)</span>
        </div>                                    
        <ul class="panel-controls" style="margin-top: 2px;">
            <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
            <li><a href="<?php echo current_url();?>" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>                                       
        </ul>
    </div>
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>NPAPG</th>
                    <th>Nama Lengkap</th>
                    <th>Domisili</th>
                    <th width="50">Action</th>
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
                            <td><?php echo $r->kta_nomor_kartu;?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $r->kab_nama." - ".$r->propinsi_nama;?></td>							
                            <td align="right">
                                <?php link_action($links_table_item,"?_id="._encrypt($r->kta_id));?>
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

    