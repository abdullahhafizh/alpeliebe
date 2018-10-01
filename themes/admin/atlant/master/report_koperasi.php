 <form action="" method="post" >
      <div class="well">
            <div class="row">
                
                <div class="col-md-2" style="margin-top:0px;">
                    <select class="form-control" id="colum" name="colum">
                        <option value=""> - pilih provinsi - </option>
                        <?php foreach ((array)get_propinsi() as $m) {
                          $s = isset($this->jCfg['search']['colum'])&&$this->jCfg['search']['colum']==$m->propinsi_id?'selected="selected"':'';
                          echo "<option value='".$m->propinsi_id."' $s >".$m->propinsi_nama."</option>";
                        }?>
                    </select>
                </div>

                <div class="col-md-2" style="margin-top:0px;">
                    <input type="submit" value="Search!" style="margin-right:5px;" name="btn_search" id="btn_search"  class="btn btn-primary col-md-5" />
                    <input type="submit" value="Reset!" name="btn_reset" id="btn_reset" class="btn btn-warning col-md-5" /> 
                </div>
                
                <div class="col-md-1" style="margin-top:0px;">
                    <div class="btn-group">
                        <button class="btn btn-info dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $own_links."/export?type=html";?>" target="_blank">Html</a></li>
                            <li><a href="<?php echo $own_links."/export?type=xls";?>" target="_blank">Excel</a></li>
                        </ul>
                    </div>
                </div>


            </div>
        
      </div>

</form>

<?php
$status_asuransi_kta = array(
        0 => "PENDING",
        1 => "ACTIVE",
        2 => "EXPIRED"		
    );
$status_kta = array(
        0 => "Non-Aktif",
        1 => "Aktif",
    );


$jenkel_kta = cfg('jenkel');
$tipe_kta = cfg('tipe_kta');
$koperasi_kta = cfg('jenis_koperasi');
$pekerjaan_kta = cfg('pekerjaan');
?>
<div class="col-md-6">
    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-heading">
            <div class="panel-title-box">
                <h3>Tabel Jumlah Anggota Koperasi</h3>
                <span>Summary Jumlah Anggota Koperasi Per Kabupaten</span>
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
                        <th>Kabupaten</th>
                        <th width="80">Jumlah</th>
                    </tr>
                    </thead>
                   <tbody> 
                    <?php 
                    $no=1;$jumlah=0;
                    foreach ((array)$wilayah as $key => $value) {
                        echo "<tr>";
                        echo "<td><b>".($no++)."</b></td>";
                        echo "<td><b>".$value->name."</b></td>";
                        echo "<td align='right'><b>".$value->jumlah."</b></td>";
                        echo "</tr>";
                        if(trim($this->jCfg['search']['type'])=="detail"){
                            foreach ((array)get_rincian_kta_by_prov($value->propinsi_id) as $kp => $vp) {
                               echo "<tr>
                                <td></td>
                                <td>".$vp->nama."</td>
                                <td align='right'>".$vp->jumlah."</td>
                               </tr>";
                               $jumlah += $vp->jumlah;
                            }
                        }else{
                            $jumlah += $value->jumlah;
                        }
                    }?>
                    <tr>
                        <td colspan="2"><b>JUMLAH</b></td>
                        <td align="right"><b><?php echo myNum($jumlah);?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div></div>
<div class="col-md-6">
    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-heading">
            <div class="panel-title-box">
                <h3>Tabel Data Keanggotaan [<a href="status_kartu" data-box=''>Lihat Detail</a>]</h3>
                <span>Summary Jumlah Per Status Keaktifan</span>
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
                        <th>Status</th>
                        <th width="80">Jumlah</th>
                    </tr>
                    </thead>
                   <tbody> 
                    <?php 
                    $no=1;$jumlah=0;
                    foreach ((array)$status as $key => $value) {
                        echo "<tr>";
                        echo "<td>".($no++)."</td>";
                        echo "<td>".$status_kta[$value->name]."</td>";
                        echo "<td>".$value->jumlah."</td>";
                        echo "</tr>";
                        $jumlah += $value->jumlah;
                    }?>
                    <tr>
                        <td colspan="2"><b>JUMLAH</b></td>
                        <td><b><?php echo myNum($jumlah);?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-heading">
            <div class="panel-title-box">
                <h3>Tabel Data Keanggotaan</h3>
                <span>Summary Jumlah Per Status Asuransi</span>
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
                        <th>Status</th>
                        <th width="80">Jumlah</th>
                    </tr>
                    </thead>
                   <tbody> 
                    <?php 
                    $no=1;$jumlah=0;
                    foreach ((array)$status_asuransi as $key => $value) {
                        echo "<tr>";
                        echo "<td>".($no++)."</td>";
                        echo "<td>".$status_asuransi_kta[$value->name]."</td>";
                        echo "<td>".$value->jumlah."</td>";
                        echo "</tr>";
                        $jumlah += $value->jumlah;
                    }?>
                    <tr>
                        <td colspan="2"><b>JUMLAH</b></td>
                        <td><b><?php echo myNum($jumlah);?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-heading">
            <div class="panel-title-box">
                <h3>Tabel Data Keanggotaan</h3>
                <span>Summary Jumlah Per Gender</span>
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
                        <th>Gender</th>
                        <th width="80">Jumlah</th>
                    </tr>
                    </thead>
                   <tbody> 
                    <?php 
                    $no=1;$jumlah=0;
                    foreach ((array)$jenkel as $key => $value) {
                        echo "<tr>";
                        echo "<td>".($no++)."</td>";
                        echo "<td>".$jenkel_kta[$value->name]."</td>";
                        echo "<td>".$value->jumlah."</td>";
                        echo "</tr>";
                        $jumlah += $value->jumlah;
                    }?>
                    <tr>
                        <td colspan="2"><b>JUMLAH</b></td>
                        <td><b><?php echo myNum($jumlah);?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>

    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-heading">
            <div class="panel-title-box">
                <h3>Tabel Jumlah Koperasi Per Kabupaten</h3>
                <span>Summary Jumlah Per Tipe</span>
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
                        <th>Tipe</th>
                        <th width="80">Jumlah</th>
                    </tr>
                    </thead>
                   <tbody> 
                    <?php 
                    $no=1;$jumlah=0;
                    foreach ((array)$tipe as $key => $value) {
                        echo "<tr>";
                        echo "<td>".($no++)."</td>";
                        echo "<td>".$tipe_kta[$value->name]."</td>";
                        echo "<td>".$value->jumlah."</td>";
                        echo "</tr>";
                        $jumlah += $value->jumlah;
                    }?>
                    <tr>
                        <td colspan="2"><b>JUMLAH</b></td>
                        <td><b><?php echo myNum($jumlah);?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    <div class="panel panel-default" style="margin-top:-10px;">
        <div class="panel-heading">
            <div class="panel-title-box">
                <h3>Tabel Data KTA</h3>
                <span>Summary Jumlah Per Jenis Pekerjaan</span>
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
                        <th>Status</th>
                        <th width="80">Jumlah</th>
                    </tr>
                    </thead>
                   <tbody> 
                    <?php 
                    $no=1;$jumlah=0;
                    foreach ((array)$pekerjaan as $key => $value) {
                        echo "<tr>";
                        echo "<td>".($no++)."</td>";
                        echo "<td>".$pekerjaan_kta[$value->name]."</td>";
                        echo "<td>".$value->jumlah."</td>";
                        echo "</tr>";
                        $jumlah += $value->jumlah;
                    }?>
                    <tr>
                        <td colspan="2"><b>JUMLAH</b></td>
                        <td><b><?php echo myNum($jumlah);?></b></td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var URL_AJAX = '<?php echo base_url();?>ajax/data';

$(document).ready(function(){

  $('#colum').change(function(){
      get_kabupaten($(this).val(),"");
  });
  <?php if(isset($this->jCfg['search']['colum'])){?>
  get_kabupaten('<?php echo $this->jCfg["search"]["colum"];?>','<?php echo $this->jCfg["search"]["keyword"];?>');
  <?php } ?>

});



function get_kabupaten(prov,kab){
  $.post(URL_AJAX+"/kabupaten",{prov:prov,kab:kab},function(o){
    $('#keyword').html(o);
  });
}

</script>

    