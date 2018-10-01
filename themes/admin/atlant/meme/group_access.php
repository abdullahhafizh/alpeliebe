<div class="table-responsive">
<form action="" method="post" id="myform" class="input">
    <table class="table table-hover table-bordered table-striped">
      <thead>
      <tr height="20px">
        <th width="30" rowspan="2" style="">No</th>
        <th width="439" rowspan="2">Nama Module</th>
        <th colspan="<?php echo count($actions);?>">Action</th>
      </tr>
      <tr style="font-size:11px; font-weight:normal;">
        <?php if(count($actions)>0){
        foreach($actions as $m){
      ?>
          <th width="10px" style="padding:5px;text-align:center;"><a href="#" class="south ttip_t" style="text-decoration:none;" title="<?php echo $m->ac_action_name;?>"><?php echo $m->ac_action_name;?></a><br />
          <input type="checkbox" id="select_all_<?php echo $m->ac_action;?>" value="1">
          </th>
      <?php } 
        }
      ?>
      </tr> 
      </thead>
      <tbody>  
      <?php if(count($access) > 0){
          $no=1;
          foreach($access as $r){//
      ?>
            <tr>
            <td align="center"><?php echo $no++;?>.</td>
            <td><?php echo $r['module_name'];?></td>
            <?php 
              if(count($r['action'])>0){
                foreach($r['action'] as $acc){

                  if($acc['show']==1){
                    $chk = ($acc['value']==1)?'checked="checked"':'';
                    $name_chk = "acc_name[".$r['id_module']."][".$acc['id']."]";
                    echo "<td align='center'><input type='checkbox' class='ttip_t chk_".strtolower($acc['name'])."' title='".$acc['name']."' $chk name='$name_chk' value='".$acc['id']."' style='cursor:pointer;' class='south' title='".$acc['name']."'></td>";
                  }else{
                    echo "<td align='center'>-</td>";
                  }
                } 
              }
            ?>
          </tr> 
      <?php } 
        }     
      ?>
      
    </tbody>
    </table>

    <div class="panel-footer">
      <div class="pull-left">
        <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button>
      </div>
      <div class="pull-right">
        <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="fa fa-check"></i> Save</button>
      </div>
    </div>

    </form>

    <script>

    $(document).ready(function() {
       <?php foreach($actions as $m){?>
       $("#select_all_<?php echo strtolower($m->ac_action);?>").change(function(){
               if(this.checked){
              $(".chk_<?php echo strtolower($m->ac_action);?>").each(function(){
                  this.checked=true;
              })              
          }else{
              $(".chk_<?php echo strtolower($m->ac_action);?>").each(function(){
                  this.checked=false;
              })              
          }
      });

      $(".chk_<?php echo strtolower($m->ac_action);?>").click(function () {
          if (!$(this).is(":checked")){
              $("#select_all_<?php echo strtolower($m->ac_action);?>").prop("checked", false);
          }else{
              var flag = 0;
              $(".chk_<?php echo strtolower($m->ac_action);?>").each(function(){
                  if(!this.checked)
                  flag=1;
              })              
              if(flag == 0){ $("#select_all_<?php echo strtolower($m->ac_action);?>").prop("checked", true);}
          }
      });

      <?php } ?>
    });

        </script>