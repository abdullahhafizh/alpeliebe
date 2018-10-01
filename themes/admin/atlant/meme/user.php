        <?php // getFormSearch();?>
<div class="panel panel-default" style="margin-top:-10px;">
    <div class="panel-body panel-body-table">

        <div class="table-responsive">
            <table class="table datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Nama Lengkap</th>
                    <th>Nama Pengusul</th>
                    <th>Domisili</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Koor. Data</th>
					<?php if($this->jCfg['user']['userrole'] == 1 ){ ?>
                    <th>Limit</th>
					<?php } ?>
                    <th>Status</th>
                    <th width="50">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
                if(count($data) > 0){
                    foreach($data as $r){
                            $role = array();
                            $get_role = get_role($r->user_id);
                            foreach ((array)$get_role as $key => $value) {
                                $role[] = $value->ag_group_name;
                            }
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r->user_fullname;?></td>
							<td><?php echo $r->nama_pengguna;?></td>
							<td><?php echo $r->propinsi_nama;?></td>
                            <td><?php echo $r->user_name;?></td>
                            <td><?php echo count($role)>0?implode(",",$role):'';?></td>
							<?php if(empty($r->col1)){ ?>
                            <td></td>
							<?php }else{ ?>
							<?php foreach ((array)get_detail_koor($r->col1) as $k => $v) { ?>                                
                            <td><?php echo $v->nama;?></td>
							<?php } } ?>
							<?php if($this->jCfg['user']['userrole'] == 1 ){ ?>
                            <td><?php echo $r->user_limit;?></td>
							<?php } ?>
                            <td><?php echo ($r->user_status==1)?'<span class="label label-info">Aktif</span>':'<span class="label label-warning">Non Aktif</span>';?></td>
                            <td align="right">
                                <?php 
                                $except = array();
                                if($r->user_id==1)
                                    $except = array('delete','edit');
                                link_action($links_table_item,"?_id="._encrypt($r->user_id),$except);?>
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
            <?php //echo isset($paging)?$paging:'';?>
</div>
