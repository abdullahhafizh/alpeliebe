<?php js_validate(); ?>
<form action="<?php echo $own_links;?>/search" method="post" id="form-validated" >
	  <div class="well">
	  		<div class="row">	  			
	  			<div class="col-md-3">
                                <select class="form-control" id="koordinator" name="koordinator">
                                    <option value=""> - pilih koordinator data - </option>
                                    <?php 
										foreach ((array)get_manager() as $m) {
									      $s = isset($param)&&$param['koordata']==$m->user_id?'selected="selected"':'';
										  echo "<option value='".$m->user_id."' $s >".$m->user_fullname."</option>";
										}
									?>
                                </select> 
		  		</div>
	  			<div class="col-md-3">
                                <select class="form-control" id="operator" name="operator">
                                </select> 
		  		</div>
	  			<div class="col-md-2">
                    <input type="text" name="date_from" id="date_from"  value="<?php echo isset($param['date_from'])?$param['date_from']:'';?>" class="validate[required] form-control datepicker" placeholder="Tanggal Awal" maxlength="16"/>
		  		</div>
	  			<div class="col-md-2">
                    <input type="text" name="date_to" id="date_to"  value="<?php echo isset($param['date_to'])?$param['date_to']:'';?>" class="validate[required] form-control datepicker" placeholder="Tanggal Akhir" maxlength="16"/>
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
		<?php if(isset($param)){
		?>
<div class="panel panel-default" style="margin-top:-10px;">
<div class="pull-right" style="margin-bottom:10px;">
		<input type="submit" name="print_excel" id="print_excel"  class="btn btn-info" value="Print File Excel">
</div>
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th width="">Tanggal Input</th>
                    <th width="">Petugas Entry</th>
					<th width="">NIK Anggota</th>
					<th width="">Nama Anggota KTA</th>
                    <th>Domisili</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    foreach($data as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
							<td><?php echo myDate($r->time_entry,"d M Y",false);?></td>
                            <td>
							<?php foreach ((array)get_user($r->col8) as $k => $v) {
											echo $v->user_fullname;
							}?>
							</td>
                            <td><?php echo $r->kta_no_id;?></td>
<!--                            <td><?php echo substr($r->kta_nomor_kartu,0,6)." ".substr($r->kta_nomor_kartu,6,4)." ".substr($r->kta_nomor_kartu,10,6);?></td>-->
                            <td><?php echo $r->kta_nama_lengkap;?></td>
                            <td><?php echo $r->kab_nama." - ".$r->propinsi_nama;?></td>		
                            <td>
							<?php if($r->kta_status_data == 0 ){
									echo '<span class="label label-warning" data-toggle="tooltip" data-placement="top" title data-original-title="Waiting to Approve"><li class="fa fa fa-spinner"></li> Pending</span>';								
								  }elseif($r->kta_status_data == 1 ){
									echo '<span class="label label-success" data-toggle="tooltip" data-placement="top" title data-original-title="Approved"><li class="fa fa-check-circle"></li> Approved</span>';								
								  }elseif($r->kta_status_data == 2 ){
									echo '<span class="label label-info" data-toggle="tooltip" data-placement="top" title data-original-title="Waiting to Entry"><li class="fa fa fa-spinner"></li> Uploaded</span>';								
								  }elseif($r->kta_status_data == 3){
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected by Operator Entry"><li class="glyphicon glyphicon-ban-circle"></li> Rejected</span>';								
								  }elseif($r->kta_status_data == 4){
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected by Koordinator Data"><li class="glyphicon glyphicon-ban-circle"></li> Rejected</span>';								
								  }elseif($r->kta_status_data == 9){
									echo '<span class="label label-info" data-toggle="tooltip" data-placement="top" title data-original-title="Data Event"><li class="glyphicon glyphicon-ban-circle"></li> Event</span>';								
								  }else{
									echo '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="Rejected"><li class="glyphicon glyphicon-ban-circle"></li></span>';								
								  }
							?>
                            </td>							
                            <td><?php echo $r->col6;?></td>
                        </tr>
                <?php } }?>

                </tbody>
            </table>
            
        </div>
    </div>
</div>
</form>
		<?php } ?>
<div class="pull-right">
    <?php // echo isset($paging)?$paging:'';?>
</div>
<script>
    var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';

    $(document).ready(function(){
	<?php if(isset($param) && !empty($param['koordata'])){?>
		get_koordinator('<?php echo $param['koordata'];?>','<?php echo isset($param['operator'])?$param['operator']:'';?>');
	<?php }?>

      $('#koordinator').change(function(){
          get_koordinator($(this).val(),"");
      });	  
    });

	  function get_koordinator(prov,kab){
      $.post(URL_AJAX+"/user_koordinator",{prov:prov,kab:kab},function(o){
        $('#operator').html(o);
      });
    }
</script>    