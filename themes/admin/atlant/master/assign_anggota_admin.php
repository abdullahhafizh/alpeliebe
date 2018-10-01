<?php //getFormSearch();?>
 <form action="<?php echo $own_links;?>/search" method="post" >
	  <div class="well">
	  		<div class="row">	  			
	  			<div class="col-md-4">
                                <select class="form-control" id="koordata" name="koordata">
                                    <option value=""> - pilih Koordinator Data - </option>
                                    <?php foreach ((array)get_manager() as $m) {
									  $s = isset($param)&&$param['koordata']==$m->user_id?'selected="selected"':'';
										  echo "<option value='".$m->user_id."' $s >".$m->user_fullname."</option>";
										}
									?>
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
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/assign" class="form-horizontal" method="post"> 
<div class="panel panel-default" style="margin-top:25px;">
    <div class="panel-body panel-body-table ">
        <div class="table-responsive">
            <table id="costumers2" class="table datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Status</th>
                    <th>Di Assign Oleh</th>
                    <th>Tanggal Assign</th>
                    <th>NIK / No. KTP</th>
                    <th>Pengusul</th>					
                    <th>Dari (Op. Scan)</th>
                    <th>Ke (Op. Entry)</th>
				   <?php if($this->jCfg['user']['userrole'] == 32){ ?>
                    <th>Koor. Data</th>
				   <?php } ?>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $tingkatan 	= cfg('tingkatan');
                    $jabatan 	= cfg('jabatan');
                    $jk			= cfg('jenkel');
                    foreach($data as $r){
						$idm = $r->col10;
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td>
							<?php if($r->kta_status_assign == "1"){
									echo '<span class="label label-success label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Assigned">Assigned</span>';								
								  }else{
									echo '<span class="label label-danger label-form" data-toggle="tooltip" data-placement="top" title data-original-title="Unassigned">Unassigned</span>';								  }
							?>                            
                            </td>
                            <td><small>
							<?php foreach ((array)get_user($r->col9) as $k => $v) {
											echo $v->user_fullname;
							}?></small>
							</td>							
                            <td><small><?php echo $r->time_assign;?></small></td>
                            <td><small><?php echo $r->kta_no_id;?></small></td>
                            <td><small><?php echo $r->nama_pengguna;?></small></td>
                            <td><small><?php echo $r->col3;?></small></td>							
                            <td><small>
							<?php foreach ((array)get_user($r->col8) as $k => $v) {
											echo $v->user_fullname;
							}?></small>
							</td>							
                        </tr>
						<?php } }?>						
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<div class="pull-right">
            <?php // echo isset($paging)?$paging:'';?>
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
    