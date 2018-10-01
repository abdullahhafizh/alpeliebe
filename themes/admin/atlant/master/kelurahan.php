<form action="<?php echo $own_links;?>/search" method="post" >
	  <div class="well">
	  		<div class="row">	  			
	  			<div class="col-md-3">
                                <select class="form-control" id="propinsi" name="propinsi">
                                    <option value=""> - pilih provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
									  $s = isset($param)&&$param['propinsi']==$m->propinsi_id?'selected="selected"':'';
                                      echo "<option value='".$m->propinsi_kode."' $s >".$m->propinsi_nama." (".$m->propinsi_kode.")</option>";
                                    }?>
                                </select> 
		  		</div>
	  			<div class="col-md-3">
                                <select class="form-control" id="kta_kabupaten" name="kta_kabupaten">
                                </select> 
		  		</div>
	  			<div class="col-md-3">
                                <select class="form-control" id="kta_kecamatan" name="kta_kecamatan">
                                </select> 
		  		</div>
				<div class="col-md-2" style="margin-top:0px;">
					<button style="margin-right:5px;" name="btn_search" id="btn_search"  class="btn btn-primary col-md-5" type="submit">Lanjut</button>
		  			<input type="submit" value="Reset!" name="btn_reset" id="btn_reset" class="btn btn-warning col-md-5" />	
	  			</div>
	  			<!--<div class="col-md-2 pull-right" style="margin-top:-16px;">
	  			  <div class="btn-group pull-right"> <a href="#" data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-demo-space"> <span class="fa fa-download"></span>Download <span class="caret"></span> </a>
                    <ul class="dropdown-menu"> 
                      <li><a href="<?php echo $this->own_link;?>/export_data?type=html" target="_blank"><span class="fa fa-html5"></span> Html</a></li>
                      <li><a href="<?php echo $this->own_link;?>/export_data?type=excel"><span class="fa fa-table"></span> Excel</a></li>
                    </ul>
                  </div>
				</div>-->
	  		</div>	  	
	  </div>
</form>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th width="">Propinsi</th>
                    <th width="">Kabupaten</th>
					<th width="">Kecamatan</th>
                    <th width="50px">Kode</th>
                    <th>Nama Kelurahan</th>
                    <th width="80">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $prov = "";
                    foreach($data as $r){
                        
                        ?>
                        <?php if($prov != $r->kel_kec_id){?>
<!--                        <tr>
                            <td colspan="3"><b><?php echo $r->kel_kec_id." - ".$r->propinsi_nama." - ".$r->kab_nama." - ".$r->kec_nama;?></b></td>
                        </tr>-->
                        <?php }  $prov = $r->kel_kec_id; ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->kab_propinsi_id." - ".$r->propinsi_nama;?></td>
                            <td><?php echo substr($r->kab_kode,2,2)." - ".$r->kab_nama;?></td>
                            <td><?php echo substr($r->kel_kec_id,4,2)." - ".$r->kec_nama;?></td>
                            <td><?php echo $r->kel_kode;?></td>
                            <td><?php echo $r->kel_nama;?></td>
                            <td align="right">
                                <?php link_action($links_table_item,"?_id="._encrypt($r->kel_id));?>
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
    <?php // echo isset($paging)?$paging:'';?>
</div>
<script>
    var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';

    $(document).ready(function(){
	<?php if(isset($param) && !empty($param['propinsi'])){?>
		get_kabupaten('<?php echo $param['propinsi'];?>','<?php echo isset($param['kabupaten'])?$param['kabupaten']:'';?>');
	<?php }
		if(isset($param) && !empty($param['kabupaten'])){?>
		get_kecamatan('<?php echo $param['kabupaten'];?>','<?php echo isset($param['kecamatan'])?$param['kecamatan']:'';?>');
	<?php }?>
	
      $('#propinsi').change(function(){
          get_kabupaten($(this).val(),"");
      });

      $('#kta_kabupaten').change(function(){
          get_kecamatan($(this).val(),"");
      });
	  
    });

	  function get_kabupaten(prov,kab){
      $.post(URL_AJAX+"/kabupaten",{prov:prov,kab:kab},function(o){
        $('#kta_kabupaten').html(o);
      });
    }

    function get_kecamatan(prov,kab){
      $.post(URL_AJAX+"/kecamatan",{prov:prov,kab:kab},function(o){
        $('#kta_kecamatan').html(o);
      });
    }
</script>    