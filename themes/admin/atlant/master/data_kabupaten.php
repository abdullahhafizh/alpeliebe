<?php // getFormSearch();?>
 <form action="<?php echo $own_links;?>/search" method="post" >
	  <div class="well">
	  		<div class="row">	  			
	  			<div class="col-md-4">
                                <select class="form-control" id="propinsi" name="propinsi">
                                    <option value=""> - pilih provinsi - </option>
                                    <?php foreach ((array)get_propinsi() as $m) {
    									  $s = isset($param)&&$param['propinsi']==$m->propinsi_id?'selected="selected"':'';
										  echo "<option value='".$m->propinsi_kode."' $s >(".$m->propinsi_kode.") ".$m->propinsi_nama."</option>";
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
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-body panel-body-table">
        <div class="table-responsive">
            <table class="table table-striped datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th width="400px">Propinsi</th>
                    <th width="100px">Kode</th>
                    <th>Nama</th>
                    <th width="50">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    $prov = "";
                    foreach($data as $r){
                        
                        ?>
                        <?php if($prov != $r->kab_propinsi_id){?>
<!--                        <tr>
                            <td></td>
                            <td></td>
                            <td ><b><?php echo $r->kab_propinsi_id;?> - <?php echo $r->propinsi_nama;?></b></td>
                            <td></td>
                        </tr>
-->
                        <?php }  $prov = $r->kab_propinsi_id; ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td ><b><?php echo $r->kab_propinsi_id;?> - <?php echo $r->propinsi_nama;?></b></td>
                            <td><?php echo substr($r->kab_kode,2,2);?></td>
                            <td><?php echo $r->kab_nama;?></td>
							<td>
                                <?php link_action($links_table_item,"?_id="._encrypt($r->kab_id));?>
							</td>							
<!--                            <td align="right">
                                <?php link_action($links_table_item,"?_id="._encrypt($r->kab_id));?>
                            </td>
-->							
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
    <?php// echo isset($paging)?$paging:'';?>
</div>

    