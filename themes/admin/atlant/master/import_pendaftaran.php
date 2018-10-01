<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post"> 
        <div class="row">
          <div class="col-md-8">
            
            <div class="row form-group">  
              <div class="col-md-5 control-label">Pilih File</div>
              <div class="col-md-5">
                  <input type="file" class="validate[required] form-control select" name="file" id="import" />
				  <span>Pilih dokumen berformat .xls</span>
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
            <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Import</button>
          </div>
        </div>

</form>
