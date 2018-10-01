<form id="form-validated" action="<?php echo $own_links;?>/save" class="form-no-horizontal-spacing" method="post"> 

    <div class="panel-body">                                                                        
        
       <?php if(isset($data) && count($data) > 0){
            foreach($data as $v){
        ?>

        <div class="row form-group">  
            <div class="col-md-3 label_form"><?php echo $v->config_label;?></div>
            <div class="col-md-5">
              <?php
                if($v->config_obj == 'select'){
                  echo "<select id='$v->config_name' name='$v->config_name' class='validate[required] form-control'>";
                  echo "<option value=''> - pilih $v->config_label - </option>";
                  foreach(explode(",",$v->config_obj_value) as $vobj){
                    if(trim($vobj) != ''){
                      $s =($vobj==$v->config_value)?"selected=selected":"";
                      echo "<option value='$vobj' $s>$vobj</option>";
                    }
                  }
                  echo "</select>";
                }elseif($v->config_obj == 'textarea'){
                  echo "<textarea  class='validate[required]' $v->config_obj_attr id='$v->config_name' name='$v->config_name'>$v->config_value</textarea>";
                }elseif($v->config_obj == 'tinymce'){
                  echo "<textarea cols='35' class='validate[required] form-control' rows='3' id='$v->config_name' name='$v->config_name'>$v->config_value</textarea>";
                }else{
                  echo "<input type='text' class='validate[required] form-control' $v->config_obj_attr id='$v->config_name' name='$v->config_name' value='$v->config_value' />";
                }
              ?>
            </div>
          </div> 

        <?php
          }
        }else{echo "<center>- Tidak ada konfigurasi -</center>";} 
        ?>

    </div>
    <div class="panel-footer">
        <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-default">Batal</button>                                    
        <button class="btn btn-primary pull-right" type="submit" name="submit"><i class="icon-ok"></i> Simpan</button>
    </div>
</form>
                            
                       