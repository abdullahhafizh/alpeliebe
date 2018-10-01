<style type="text/css">
div.tabs {
  display: none;
}
</style>
<?php js_validate();?>
<?php

if(isset($_GET['_id'])) {
  $card_no =  _decrypt(dbClean(trim($_GET['_id'])));    
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "2206",
  CURLOPT_URL => "http://116.90.165.246:2206/kj_member/hnsi/get_bycardno",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"card_no\":\"".$card_no."\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
    "postman-token: 6457476e-9f29-8479-728f-b9ec6a2e32a9",
    "sessionid: ".$_SESSION['sesiLogin']."",
    "versioncode: ".cfg('version_code').""
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  // echo $response;  
  $member = json_decode($response, true);
  $member_id = $member['data']['0']['member_id'];
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "2206",
  CURLOPT_URL => "http://116.90.165.246:2206/kj_member/hnsi/get",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"member_id\":\"".$member_id."\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
    "postman-token: e14c5205-f7d1-91cd-40ea-21c1303f0feb",
    "sessionid: ".$_SESSION['sesiLogin']."",
    "versioncode: ".cfg('version_code').""
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  // echo $response;
  $data = json_decode($response, true);
}
foreach ($data['data'] as $array) {
  $value = $array;
}
?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
  <input type="hidden" name="user_id" id="user_id" value="<?php echo isset($val->user_id)?$val->user_id:'';?>" />
  <div class="row">
    <div class="col-md-5">
      <div class="row form-group">
       <?php 
       if($this->jCfg['user']['userrole'] == 1 ){ ?>
        <div class="col-md-5 control-label">Role</div>
      <?php }else{ ?> 
        <div class="col-md-5 control-label">Tipe Operator</div>
      <?php } ?>
      <div class="col-md-7" style="margin-left:0px;">
        <select name="user_group" class=" validate[required] form-control select" id="user_group">
         <?php 
         if($this->jCfg['user']['userrole'] == 32 ){
          echo "<option> - pilih tipe operator -</option>";
          foreach ((array)get_user_role(2) as $m) {
            $tmp = isset($role)&&count($role)>0?$role:array(0);
            $s = in_array($m->ag_id, $tmp)?"selected='selected'":'';
            echo "<option value='".$m->ag_id."' $s >".$m->ag_group_name."</option>";
          }
        }elseif($this->jCfg['user']['userrole'] == 33 ){
          echo "<option> - pilih tipe operator -</option>";
          foreach ((array)get_user_role(3) as $m) {
            $tmp = isset($role)&&count($role)>0?$role:array(0);
            $s = in_array($m->ag_id, $tmp)?"selected='selected'":'';
            echo "<option value='".$m->ag_id."' $s >".$m->ag_group_name."</option>";
          }
        }else{
          echo "<option> - pilih Group User -</option>";
          foreach($group as $r){
            $tmp = isset($role)&&count($role)>0?$role:array(0);
            $s = in_array($r->ag_id, $tmp)?"selected='selected'":'';
            echo "<option value='".$r->ag_id."' $s >".$r->ag_group_name."</option>";
          }						
        }
        ?>
      </select>
    </div> 
  </div> 
  <div class="row form-group">
    <div class="col-md-5 control-label">Tingkat</div>
    <div class="col-md-7" style="margin-left:0px;">

      <select name="tingkat" class="form-control" id="tingkat">
        <option value="" class=""> - pilih -</option>
        <option value="DPP">DPP</option>
        <option value="DPD">DPD</option>
      </select>

    </div> 
  </div> 
  <div class="row form-group">
    <div class="col-md-5 control-label">Koordinator Data</div>
    <div class="col-md-7" style="margin-left:0px;">

      <select class="form-control" id="data_manager" name="data_manager">
        <?php 
        if($this->jCfg['user']['userrole'] == 33 ){
          foreach ((array)get_user($this->jCfg['user']['id']) as $m) {
            $s = isset($val)&&$val->user_id==$m->user_id?'selected="selected"':'';
            echo "<option value='".$m->user_id."' $s >".$m->user_fullname."</option>";
          }
        }else{
         ?>
         <option> - pilih nama manager - </option>
         <?php
         foreach ((array)get_manager() as $m) {
          $s = isset($val)&&$val->col1==$m->user_id?'selected="selected"':'';
          echo "<option value='".$m->user_id."' $s >".$m->user_fullname."</option>";
        }
      }
      ?>
    </select> 

  </div> 
</div> 

<div class="row form-group">
  <div class="col-md-5 control-label"> Pengusul / CQ</div>
  <div class="col-md-7" style="margin-left:0px;">
    <select class="form-control" id="kta_pemesan" name="kta_pemesan">
    </select> 

  </div> 
</div> 
<div class="row form-group">
  <div class="col-md-5 control-label">Provinsi</div>
  <div class="col-md-7" style="margin-left:0px;">
    <select class="form-control" id="kta_propinsi" name="kta_propinsi">
      <option value="0"> - pilih nama propinsi - </option>
      <?php 
      foreach ((array)get_propinsi() as $m) {
        $s = isset($val)&&$val->user_province==$m->propinsi_id?'selected="selected"':'';
        echo "<option value='".$m->propinsi_id."' $s >".$m->propinsi_nama."</option>";
      }
      ?>
    </select> 

  </div> 
</div> 


</div> 

<div class="col-md-6">
  <div class="row form-group">  
    <div class="col-md-5 control-label">Full Name</div>
    <div class="col-md-7">
     <input type="text" id="user_fullname" readonly name="user_fullname" class="form-control" value="<?php echo $value['full_name'];?>" />
   </div>
 </div> 

 <div class="row form-group">
  <div class="col-md-5 control-label">Email</div>
  <div class="col-md-7">
    <input type="text" id="user_email" readonly name="user_email" class="form-control" value="<?php echo $value['email_address'];?>" />
  </div> 
</div> 


<div class="row form-group">
  <div class="col-md-5 control-label">Username</div>
  <div class="col-md-7">
    <input type="text" readonly class="form-control" id="user_name" value="<?php echo $value['username'];?>" name="user_name"/>
    <div id="status"></div>
  </div> 
</div> 
<div class="row form-group">
  <div class="col-md-5 control-label">Password</div>
  <div class="col-md-7">

   <input type="password" id="user_password" name="user_password" class="form-control" readonly value="<?php echo $value['pwd'];?>" />
   <input type="hidden" name="mobile" readonly>

 </div> 
</div> 
<div class="row form-group">
  <div class="col-md-5 control-label">Confirm Password</div> 
  <div class="col-md-7">

   <input type="password" id="user_password2" name="user_password2" readonly class="form-control"  value="<?php echo $value['pwd'];?>" />
   <div id="status_p"></div>
 </div> 
</div> 
<?php if($this->jCfg['user']['userrole'] == 1 ){ ?>
  <div class="row form-group">
    <div class="col-md-5 control-label">Koor. Data User Limit</div>
    <div class="col-md-7">
     <input type="text" id="user_limit" name="user_limit" class="form-control" value="" />
   </div>
 </div> 
<?php } ?>

<!--
-->
<div class="row form-group">
  <div class="col-md-5 control-label">Photo</div>
  <div class="col-md-7">
    <input type="file" id="user_photo" class="fileinput btn-primary" name="user_photo" />
    <?php if( isset($val->user_photo) && trim($val->user_photo)!="" ){?>
      <a href="<?php echo get_image(base_url()."assets/collections/photo/medium/".$val->user_photo);?>" title="Image Photo" class="act_modal" rel="700|400">
        <img alt="" src="<?php echo get_image(base_url()."assets/collections/photo/thumb/".$val->user_photo);?>" style="height:25px;width:25px" class="img-polaroid">
      </a>
    <?php } ?>
  </div> 
</div> 


<div class="row form-group">
  <div class="col-md-5 control-label">Status</div>
  <div class="col-md-7">
    <label class="check"><input name="user_status" checked="checked" type="checkbox" <?php echo isset($val) && $val->user_status=="1"?'checked="checked"':'';?> class="icheckbox" /> Aktif</label>

  </div> 
</div>


</div>       
</div>
<br />

<div class="panel-footer">
  <div class="pull-left">
    <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button>
  </div>
  <div class="pull-right">
    <button type="submit" name="simpan" id="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
  </div>
</div>

</form>
<script type="text/javascript">
  var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';
  $(document).ready(function(){
    $("#user_name").change(function() { 
     var usr = $("#user_name").val();
     $("#status").html('<img src="<?php echo themeUrl();?>img/loader.gif" />&nbsp;Cek Ketersediaan Username');
     $.ajax({  
      type: "POST",  
      url: URL_AJAX + "/username",
      data: {ktp: usr},
      success: function(msg){  
        if(msg == 1) { 
          $("#status").html('&nbsp;<img src="<?php echo base_url();?>assets/images/tick.gif" align="absmiddle"> Username dapat digunakan');
    									$("#user_name").removeClass('object_error'); // if necessary
    									$("#user_name").addClass("object_ok");
                      $("#simpan").removeAttr('disabled');
                    }else {
                      $("#status").html(msg);
    									$("#user_name").removeClass('object_ok'); // if necessary
    									$("#user_name").addClass("object_error");
                      $("#simpan").attr('disabled','disabled');

                    }  
                  } 
                }); 
   });
    $("#user_password2").change(function() { 
     var p1 = $("#user_password").val();
     var p2 = $("#user_password2").val();
     $("#status_p").html('<img src="<?php echo themeUrl();?>img/loader.gif" />&nbsp;Cek Password');
     if(p1 == p2) { 
      $("#status_p").html('&nbsp;<img src="<?php echo base_url();?>assets/images/tick.gif" align="absmiddle"> Password benar');
    									$("#user_name").removeClass('object_error'); // if necessary
    									$("#user_name").addClass("object_ok");
                      $("#simpan").removeAttr('disabled');
                    }else {
                      $("#status_p").html('&nbsp;Password tidak cocok');
    									$("#user_name").removeClass('object_ok'); // if necessary
    									$("#user_name").addClass("object_error");
                      $("#simpan").attr('disabled','disabled');

                    }  
                  });

    $("#data_manager").attr('disabled','disabled');
    $("#tingkat").attr('disabled','disabled');
    $("#kta_pemesan").attr('disabled','disabled');
    $("#kta_propinsi").attr('disabled','disabled');
    $("#user_group").change(function() { 
     var role = $("#user_group").val();
     if(role == 30){
      $("#tingkat").removeAttr('disabled'); 
      $("#data_manager").attr('disabled','disabled');
      $("#kta_pemesan").removeAttr('disabled'); 
      $("#kta_propinsi").removeAttr('disabled'); 
    }else if(role == 34){
      $("#tingkat").attr('disabled','disabled');
      $("#data_manager").removeAttr('disabled'); 
      $("#kta_pemesan").attr('disabled','disabled');
      $("#kta_propinsi").attr('disabled','disabled');
    }else if(role == 35){
      $("#tingkat").attr('disabled','disabled');
      $("#data_manager").removeAttr('disabled'); 
      $("#kta_pemesan").attr('disabled','disabled');
      $("#kta_propinsi").attr('disabled','disabled');
    }else if(role == 33){
      $("#tingkat").attr('disabled','disabled');
      $("#data_manager").attr('disabled','disabled');
      $("#kta_pemesan").removeAttr('disabled'); 
      $("#kta_propinsi").removeAttr('disabled');
      get_pengusul("","DPD");					   
    }else{
      $("#data_manager").attr('disabled','disabled');
      $("#tingkat").attr('disabled','disabled');
      $("#kta_pemesan").attr('disabled','disabled');
      $("#kta_propinsi").attr('disabled','disabled');						
    }		
  });
    $("#tingkat").change(function() { 
     var tingkat = $("#tingkat").val();
     if(tingkat == "DPP"){
      $("#kta_propinsi").attr('disabled','disabled');						
    }else{
      $("#kta_propinsi").removeAttr('disabled'); 
    }		
  });

    <?php if(isset($val)){?>
      get_pengusul('<?php echo $val->penggunaID;?>','<?php echo $val->user_tingkat;?>');
      var role = $("#user_group").val();
      if(role == 30){
        $("#tingkat").removeAttr('disabled'); 
        $("#data_manager").attr('disabled','disabled');
        $("#kta_pemesan").removeAttr('disabled'); 
        $("#kta_propinsi").removeAttr('disabled'); 
      }else if(role == 34){
        $("#tingkat").attr('disabled','disabled');
        $("#data_manager").removeAttr('disabled'); 
        $("#kta_pemesan").attr('disabled','disabled');
        $("#kta_propinsi").attr('disabled','disabled');
      }else if(role == 35){
        $("#tingkat").attr('disabled','disabled');
        $("#data_manager").removeAttr('disabled'); 
        $("#kta_pemesan").attr('disabled','disabled');
        $("#kta_propinsi").attr('disabled','disabled');
      }else if(role == 33){
        $("#tingkat").attr('disabled','disabled');
        $("#data_manager").attr('disabled','disabled');
        $("#kta_pemesan").removeAttr('disabled'); 
        $("#kta_propinsi").removeAttr('disabled');
        get_pengusul('<?php echo $val->penggunaID;?>','DPD');
      }else{
        $("#data_manager").attr('disabled','disabled');
        $("#tingkat").attr('disabled','disabled');
        $("#kta_pemesan").attr('disabled','disabled');
        $("#kta_propinsi").attr('disabled','disabled');						
      }		
    <?php } ?>

    $('#kta_pemesan').change(function(){
      var t = document.getElementById("kta_pemesan");
      var selectedPengusul = t.options[t.selectedIndex].text;
      var e = document.getElementById("tingkat");
      var selectedTingkat = e.options[e.selectedIndex].text;
      if(selectedTingkat == "DPP"){
        $("#user_fullname").val(selectedPengusul);			  
      }else{
        $("#user_fullname").val(selectedPengusul);			  
      }
    });

    $('#tingkat').change(function(){
      get_pengusul("",$(this).val());
    });

  });

function get_pengusul(pengusul,tingkat){
  $.post(URL_AJAX+"/pengusul",{pengusul:pengusul,tingkat:tingkat},function(o){
    $('#kta_pemesan').html(o);
  });	  
}
</script>