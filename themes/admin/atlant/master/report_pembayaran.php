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
                    <select class="form-control" id="keyword" name="keyword">
                        <option value=""> - pilih kabupaten - </option>
                    </select>
                </div>


                <div class="col-md-2" style="margin-top:0px;">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        <input type="text" id="date_start" name="date_start" class="form-control datepicker" placeholder="Tanggal Awal"  value="<?php echo $this->jCfg['search']['date_start'];?>" />                                            
                    </div>
                </div>

                <div class="col-md-2" style="margin-top:0px;">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        <input type="text" id="date_end" name="date_end" class="form-control datepicker" placeholder="Tanggal Akhir" value="<?php echo $this->jCfg['search']['date_end'];?>" />                                            
                    </div>
                </div>

                <div class="col-md-1" style="margin-top:0px;">
                    <select class="form-control select" id="type_search" name="type_search">
                        <option value="summary" <?php echo $this->jCfg['search']['type']=="summary"?'selected="selected"':'';?> > Summary </option>
                        <option value="detail" <?php echo $this->jCfg['search']['type']=="detail"?'selected="selected"':'';?> > Detail </option>
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

<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-heading">
        <div class="panel-title-box">
            <h3>Tabel Data Pembayaran KTA</h3>
            <span>Data Pembayaran KTA </span>
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
                    <th>Tanggal</th>
                    <th colspan="2">Provinsi</th>
                    <th>Kabupaten</th>
                    <th width="180">Jumlah</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                $total_bayar = 0;
                if(count($data) > 0){
                    foreach($data as $r){
                        ?>
                        <tr style="font-weight:bold;">
                            <td><?php echo ++$no;?></td>
                            <td colspan="4"><?php echo myDate($r->nama, "d M Y",false);?></td>
                            <td align="right">
                                Rp. <?php echo myNum($r->jumlah);?>
                            </td>
                        </tr>
                        <?php 
                        if($this->jCfg['search']['type']=="detail"){ ?>
                            <tr>
                                <td></td>
                                <td colspan="5"><b>DETAIL PEMBAYARAN</b></td>
                            </tr>
                        <?php
                            foreach ((array)get_rincian_pembayaran($r->nama) as $rp => $rv) {
                                if($rp==0){
                                    echo "<tr style='background-color:#eee;font-weight:bold;'>";
                                    echo "<td></td>";
                                    echo "<td>Nomor KTA</td>";
                                    echo "<td>Nama Lengkap</td>";
                                    echo "<td>Provinsi</td>";
                                    echo "<td>Kabupaten</td>";
                                    echo "<td align='right'>Jumlah Bayar</td>";
                                    echo "</tr>";
                                }
                                echo "<tr>";
                                echo "<td></td>";
                                echo "<td>".$rv->kta_nomor."</td>";
                                echo "<td>".$rv->kta_nama_lengkap."</td>";
                                echo "<td>".$rv->propinsi_nama."</td>";
                                echo "<td>".$rv->kab_nama."</td>";
                                echo "<td align='right'>Rp. ".(myNum($rv->kta_jumlah_bayar))."</td>";
                                echo "</tr>";

                                $total_bayar += $rv->kta_jumlah_bayar;
                            }
                        }else{
                            $total_bayar += $r->jumlah;
                        }

                        if($this->jCfg['search']['type']=="detail"){
                            echo '<tr><td colspan="6">&nbsp;</td></tr>';
                        }
                        ?>
                        
                <?php } 
                }
                ?>
                <tr>
                    <td colspan="5" align="right"><b>SUB TOTAL</b></td>
                    <td align="right"><b>Rp. <?php echo myNum($total_bayar);?></b></td>
                </tr>
                
                </tbody>

            </table>
            
        </div>
    </div>
</div>

<div class="pull-right">
            <?php echo isset($paging)?$paging:'';?>
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


    