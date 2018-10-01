<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo $own_links;?>/save" class="form-horizontal" method="post">
  <input type="hidden" name="id_maintenance" id="id_maintenance" value="1" />
  <div class="row">
    <div class="col-md-12">
      <div class="row form-group">
        <div class="col-md-3 control-label">Maintenance Status</div>
        <div class="col-md-7">
          <label class="check">
            <input name="status" type="checkbox" class="icheckbox" value="1" />
              Aktifkan Maintenance Mode
            </label>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-3 control-label">Maintenance Date</div>
        </div>

        <div class="row form-group">
          <div class="col-md-3 control-label">Maintenance Date From</div>
          <div class="col-md-2">
            <input type="text" id="date_from" name="date_from" class="form-control datepicker" placeholder = "choose date"/>
          </div>

          <div class="col-md-2">
            <input type="text" class="form-control timepicker24" name="time_from"/>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-3 control-label">Maintenance Date To</div>
          <div class="col-md-2">
            <input type="text" id="date_to" name="date_to" class="form-control datepicker" placeholder = "choose date"/>
          </div>

          <div class="col-md-2">
            <input type="text" class="form-control timepicker24" name="time_to"/>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-3 control-label">Update Version to</div>
          <div class="col-md-2">
            <?php
              foreach ((array)get_version() as $k => $v) { ?>
                <input type="text" id="version" name="version" class="form-control" value="<?php echo $v->changelog_version; ?>"/>
                <?php } ?>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-3 control-label">Update List</div>
          <div class="col-md-9">
            <textarea class="summernote" name="update_list"></textarea>
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
        <button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Set Maintenance Mode</button>
      </div>
    </div>
  </form>
