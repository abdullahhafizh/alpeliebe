<?php js_validate();?>
<style type="text/css">
div.tabs {
  display: none;
}
</style>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/set_password" class="form-horizontal" method="post">  
  <div class="row">
    <div class="col-md-5 col-md-offset-3">
      <?php
      foreach($member['data'] as $r){
        ?>
        <center><h6 class="well">Nama User : <?php echo $r['full_name'];?></h6></center>
        <input type="hidden" name="member_id" value="<?php echo $r['id'];?>">
        <?php
      }
      ?>
    </div>
    <div class="col-md-6 col-md-offset-2">
      <div class="row form-group">
        <div class="col-md-5 control-label">New Password</div>
        <div class="col-md-7">
         <input type="password" id="new_password" name="new_password" class="form-control" required placeholder="Masukkan Password Baru" autofocus />
       </div> 
     </div>       
   </div>       
 </div>
 <br>
 <div class="panel-footer">
  <div class="pull-left">
    <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons">Cancel</button>
  </div>
  <div class="pull-right">
    <button type="submit" name="simpan" id="simpan" class="btn btn-primary btn-cons"><i class="icon-ok" disabled></i> Save</button>
  </div>
</div>
</form>