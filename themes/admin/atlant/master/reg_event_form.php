<?php js_validate();?>
<style type="text/css">
.ctn_hide{
  display: none;
}
</style>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <input type="hidden" name="event_id" id="event_id" value="<?php echo isset($val->event_id)?$val->event_id:'';?>" />

        <div class="row">

          <div class="form-group">
              <div class="col-md-10">                                            
                  
                  <div class="input-group input-group-lg">                                         
                      <span class="input-group-addon"><i class="fa fa-barcode"></i> </span>
                      <input type="text" name="kta_nomor" id="kta_nomor" value="" class="form-control" placeholder="Masukan No Anggota"/>
                  </div>
                  <span class="help-block">Masukan No Anggota KTA dan Tekan Tombol Cari</span>
              </div>
              <div class="col-md-1">
                  <a href="javascript:void(true);" onclick="_showAnggota();" class="btn btn-primary btn-cons btn-lg"><i class="fa fa-search"></i> Cari</a>
              </div>
              <div class="col-md-1">
                  <a href="<?php echo $own_links."/member?_id="._encrypt($val->event_id);?>" class="btn btn-primary btn-cons btn-lg"><i class="fa fa-users"></i></a>
              </div>
          </div>

        </div>
        <div class="row ctn_hide" style="margin-top:20px;" style="display:none;">
            <div class="col-md-12">
            
              <h3 class="heading-form">Data Anggota</h3>
              <div class="table-responsive">
                  <table class="table table-bordered">
                      <tbody id='item_data'>
                          
                      </tbody>
                  </table>
              </div>

            </div>

        </div>
        <br />
        <div class="panel-footer ctn_hide_btn" style="display:none;">
          <div class="pull-left">
            <button type="button" onclick="document.location='<?php echo $own_links;?>'" class="btn btn-white btn-cons btn-large">Cancel</button>
          </div>
          <div class="pull-right">
            <button type="submit" name="simpan" class="btn btn-primary btn-cons btn-large"><i class="icon-ok"></i> DAFTAR!</button>
          </div>
        </div>

</form>
<script type="text/javascript">
var URL_GET_KTA = '<?php echo $own_links;?>/get_kta';
$(document).ready(function(){
  
});
function _showAnggota(){
  m = $('#kta_nomor').val();
  $.post(URL_GET_KTA,{nomor_kta:m,event_id:$('#event_id').val()},function(o){
    obj = eval('('+o+')');
    if( obj.status == 1 ){
      $('.ctn_hide').fadeIn();
      $('.ctn_hide_btn').fadeIn();
    }else{
      $('.ctn_hide').fadeIn();
      $('.ctn_hide_btn').fadeOut();
    }
    $('#item_data').html(obj.html);
  });
}
</script>

