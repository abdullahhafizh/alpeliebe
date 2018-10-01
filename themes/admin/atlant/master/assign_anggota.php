<?php //getFormSearch();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/assign" class="form-horizontal" method="post"> 
<div class="panel panel-default" style="margin-top:25px;">
    <ul class="nav nav-tabs" role="tablist" style="border-bottom:2px solid #F5F5F5;">
 	    <?php if($this->jCfg['user']['userrole'] == 32){ ?>
        <li <?php echo isset($this->jCfg['page_tab'])&&$this->jCfg['page_tab']==4?'class="active"':'';?> ><a href="<?php echo $own_links."/set_tab?tab=4&next=".current_url();?>"><i class="fa fa-credit-card"></i> Penugasan Data ke Koordinator Data</a></li>	
		<?php }else{ ?>
        <li <?php echo isset($this->jCfg['page_tab'])&&$this->jCfg['page_tab']==4?'class="active"':'';?> ><a href="<?php echo $own_links."/set_tab?tab=4&next=".current_url();?>"><i class="fa fa-credit-card"></i> Penugasan Data ke Operator Data</a></li>	
        <li <?php echo isset($this->jCfg['page_tab'])&&$this->jCfg['page_tab']==5?'class="active"':'';?> ><a href="<?php echo $own_links."/set_tab?tab=5&next=".current_url();?>"><i class="fa fa-credit-card"></i> Penugasan Data dari Pusat</a></li>	
        <li <?php echo isset($this->jCfg['page_tab'])&&$this->jCfg['page_tab']==6?'class="active"':'';?> ><a href="<?php echo $own_links."/set_tab?tab=6&next=".current_url();?>"><i class="fa fa-credit-card"></i> Pindahkan Penugasan Data</a></li>	
		<?php }?>		
        <?php if($this->jCfg['page_tab']==4){?>
        <li class="pull-right"><input type="submit" name="assign_pusat" value="Assign Data Upload" class="btn btn-success" style="margin-left:5px">&nbsp;&nbsp;&nbsp;</li>		
		<?php }else{ ?>
        <li class="pull-right"><input type="submit" name="assign" value="Assign Data Upload" class="btn btn-success" style="margin-left:5px">&nbsp;&nbsp;&nbsp;</li>		
		<?php }?>		
        <li class="pull-right">
			<select class="validate[required] form-control" name="assign-data" id="assign-data">
				   <option value=""> - Assign Data Upload - </option>
				   <?php if($this->jCfg['user']['userrole'] == 32){
							   foreach ((array)get_manager() as $m) {
									 echo "<option value='".$m->user_id."' >(Data Manager) ".$m->user_fullname." (".$m->user_name.")</option>";
							   } 					   
						 }else{
  							   if($this->jCfg['page_tab']==4 || $this->jCfg['page_tab']==6 ){
								   foreach ((array)get_card_admin() as $m) {
										 echo "<option value='".$m->user_id."' >".$m->user_fullname." (Pusat)</option>";
								   } 
								   foreach ((array)get_data_entry($this->jCfg['user']['id']) as $m) {
										 echo "<option value='".$m->user_id."' >".$m->user_fullname." (".$m->user_name.")</option>";
								   }							 
							   }else{
								   foreach ((array)get_data_entry($this->jCfg['user']['id']) as $m) {
										 echo "<option value='".$m->user_id."' >".$m->user_fullname." (".$m->user_name.")</option>";
								   }							 								   
							   }
						 }
				   ?>
			</select>
		</li>
    </ul>
	<br>
    <div class="panel-body panel-body-table ">
        <div class="table-responsive">
            <table id="costumers2" class="table datatable">
               <thead>
                <?php if($this->jCfg['page_tab']==4){?>
                <tr>
                    <th><input type="checkbox" name="select_all" id="select_all" /></th>
                    <th width="30px">No</th>
                    <th>Tanggal Scan</th>
				   <?php if($this->jCfg['user']['userrole'] == 32){ ?>
                    <th>Tanggal Assign</th>
				   <?php } ?>
                    <th>NIK / No. KTP</th>
                    <th>Pengusul</th>					
                    <th>Op. Scan</th>
				   <?php if($this->jCfg['user']['userrole'] == 32){ ?>
                    <th>Koor. Data</th>
				   <?php } ?>
                </tr>
                <?php }elseif($this->jCfg['page_tab']==6){ ?>
                <tr>
                    <th><input type="checkbox" name="select_all" id="select_all" /></th>
                    <th width="30px">No</th>
                    <th>Tanggal Scan</th>
                    <th>Tanggal Assign</th>
                    <th>NIK / No. KTP</th>
                    <th>Pengusul</th>					
                    <th>Op. Scan</th>
                    <th>Di Assign Ke</th>
                </tr>
                <?php }else{ ?>
                <tr>
                    <th><input type="checkbox" name="select_all" id="select_all" /></th>
                    <th width="30px">No</th>
                    <th>Tanggal Assign</th>
                    <th>NIK / No. KTP</th>
                    <th>Pengusul</th>					
                    <th>Petugas Assign</th>
                    <th>Operator Scan</th>
                </tr>
                <?php }?>
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
						<?php if($this->jCfg['page_tab']==4){?>
                        <tr>
                            <td><input type="checkbox" class="chk_item" value="<?php echo $r->kta_id;?>" name="item[]" /></td>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->time_scan;?></td>
						   <?php if($this->jCfg['user']['userrole'] == 32){ ?>
                            <td><?php echo $r->time_assign;?></td>
						   <?php } ?>
                            <td><?php echo $r->kta_no_id;?></td>
                            <td><?php echo $r->nama_pengguna;?></td>
                            <td>
							<?php foreach ((array)get_user($r->col4) as $k => $v) {
											echo $v->user_fullname."(".$v->user_name.")";
							}?>
						   <?php if($this->jCfg['user']['userrole'] == 32){ ?>
                            <td>
							<?php foreach ((array)get_user($r->col10) as $k => $v) {
											echo $v->user_fullname."(".$v->user_name.")";
							}?>
							</td>							
						   <?php } ?>
                        </tr>
						<?php }elseif($this->jCfg['page_tab']==6){ ?>
                        <tr>
                            <td><input type="checkbox" class="chk_item" value="<?php echo $r->kta_id;?>" name="item[]" /></td>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->time_scan;?></td>
                            <td><?php echo $r->time_assign;?></td>
                            <td><?php echo $r->kta_no_id;?></td>
                            <td><?php echo $r->nama_pengguna;?></td>
                            <td><?php echo $r->col3;?></td>							
                            <td>
							<?php foreach ((array)get_user($r->col8) as $k => $v) {
											echo $v->user_fullname."(".$v->user_name.")";
							}?>
							</td>							
                        </tr>
						<?php }else{ ?>
                        <tr>
                            <td><input type="checkbox" class="chk_item" value="<?php echo $r->kta_id;?>" name="item[]" /></td>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->time_assign;?></td>
                            <td><?php echo $r->kta_no_id;?></td>
                            <td><?php echo $r->nama_pengguna;?></td>
                            <td>
							<?php foreach ((array)get_user($r->col9) as $k => $v) {
											echo $v->user_fullname."(".$v->user_name.")";
							}?>
							</td>							
                            <td><?php echo $r->col3;?></td>							
                        </tr>
						<?php }?>						
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
    