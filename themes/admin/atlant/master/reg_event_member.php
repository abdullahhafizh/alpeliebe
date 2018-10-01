<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Peserta Event/Kegiatan <?php echo $val->event_name;?></h3>
            <span>Data Event/Kegiatan dari <?php echo $val->event_name;?> berjumlah (<?php echo count($list);?>)</span>
        </div>                                    
        <ul class="panel-controls" style="margin-top: 2px;">
            <div class="col-md-1">
                  <a href="<?php echo $own_links."/edit?_id="._encrypt($val->event_id);?>" class="btn btn-primary btn-cons"><i class="fa fa-users"></i> Register</a>
            </div>                                       
        </ul>
    </div>
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Nomor KTA</th>
					<th>Nama</th>
					<th>Tipe</th>
					<th>Gender</th>
					<th>Tanggal Lahir</th>
					<th>Propinsi</th>
					<th>Kabupaten</th>
					<th>Tanggal Daftar</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                $tipe = cfg('tipe_kta');
                $jenkel = cfg('jenkel');
                if(count($list) > 0){ $no = 0;
                    foreach($list as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->kta_nomor;?></td>
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $tipe[$r->kta_tipe];?></td>
                            <td><?php echo $jenkel[$r->kta_jenkel];?></td>
                            <td><?php echo myDate($r->kta_tgl_lahir,"d M Y",false);?></td>
                            <td><?php echo $r->propinsi_nama;?></td>
                            <td><?php echo $r->kab_nama;?></td>
                            <td><?php echo myDate($r->subs_date,"d M Y H:i:s",false);?></td>
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

    