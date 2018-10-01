<?php js_validate(); ?>
<form action="<?php echo $own_links;?>/search" method="post" id="form-validated" >
	  <div class="well">
	  		<div class="row">	  			
	  			<div class="col-md-3">
                                <select class="form-control" id="koordinator" name="koordinator">
                                    <option value=""> - pilih koordinator data - </option>
                                    <?php foreach ((array)get_manager() as $m) {
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
</form>
		<?php if(isset($param)){
		?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th width="">Username</th>
                    <th width="">Nama Lengkap</th>
					<th width="">Role</th>
                    <th>Tanggal</th>
                    <th>Jumlah Entry</th>
                </tr>
                </thead>
               <tbody> 
									<?php
									  $st = "";
									  $operator 	 = $this->jCfg['user']['id'];
									  $date_from 	 = date("Y-m-d");
									  $date_to		 = $param['date_to'];
									  foreach ((array)get_rekap_entry($operator,$date_from,$date_to) as $p => $q) {
									?>
									<?php
									  $st = "";
									  foreach ((array)get_user($operator) as $p => $x) {
										  $no++;
									?>
									<tr>
									<td><?php echo $no;?></td>
									<td><?php echo $x->user_name;?></td>									
									<td><?php echo $x->user_fullname;?></td>									
									<?php foreach ((array)get_role_list($x->ug_group_id) as $p => $s) { ?>
                                        <td><?php echo $s->ag_group_name ;?></td>                                                  
									<?php } ?>	
									<td><?php echo $q->tgl;?></td>									
									<td><?php echo $q->jumlah_entry;?></td>																		
									<?php } ?>
									</tr>									
                <?php } 
                ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
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