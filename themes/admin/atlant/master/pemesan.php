
        <?php getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Pengusul</h3>
            <span>Data Pengusul dari <?php echo cfg('app_name');?> (<?php echo $cRec;?>)</span>
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
                    <th>Tingkat</th>
                    <th>Nama</th>
                    <th>Provinsi Domisili</th>
                    <th>No. Telp / Hp</th>
                    <th>Email</th>
                    <th>Kuota Cetak Kartu</th>
                    <th>Status</th>
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
                            <td><?php echo $r->tingkat_pengguna;?></td>
                            <td><?php echo $r->nama_pengguna;?></td>
                            <td><?php echo $r->propinsi_nama;?></td>
                            <td><?php echo $r->notelp_pengguna;?></td>
                            <td><?php echo $r->email_pengguna;?></td>
                            <td><?php echo myNum($r->saldo_pengguna)." Kartu";?></td>
                            <td><?php echo ($r->status_pengguna==1)?'<span class="label label-info">Aktif</span>':'<span class="label label-warning">Non Aktif</span>';?></td>
                            <td align="right">
                                <?php 
                                link_action($links_table_item,"?_id="._encrypt($r->penggunaID));?>
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
