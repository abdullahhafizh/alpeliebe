<style type="text/css">
div.tabs {
	display: none;
}
</style>
<div class="well">
	<form autocomplete="off" class="form-inline" method="POST" action="<?php echo site_url('meme/me/group'); ?>">
		<div class="row">            
			<div class="col-md-6">
				<select class="form-control" name="group" id="group" style="width: 100%;">
					<option disabled selected> - Group - </option>
					<?php                    
					if (isset($_SESSION['group_group'])) {
						$old_group = $_SESSION['group_group'];
					}            
					foreach ($groups['data']['groups'] as $group) {
						?>
						<option value="<?php echo $group['group_id'];?>" <?php if (isset($old_group)){if ($old_group == $group['group_id']) {echo "selected";}} ?>><?php echo $group['name'];?></option>
					<?php }?>
				</select>
			</div>
			<div class="col-md-6">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary" style="width: 100%;">Search!</button>
				</div>
				<div class="col-md-6">
					<a class="btn btn-warning" href="<?php echo site_url('meme/me/group_reset'); ?>" style="width: 100%;">Reset!</a>
				</div>
			</div>
		</div>
	</form>
</div>
<?php if (count($json_decoded4['data']['groups']) >= 1) { ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="table-responsive">				
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>Profile Pic</th>
							<th>Cover</th>
							<th>Slider</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center"><img style="max-width: 100px;" src="<?php echo $json_decoded4['data']['groups']['0']['profile_pic'];?>">
							</td>
							<td class="text-center"><img style="max-width: 100px;" src="<?php echo $json_decoded4['data']['groups']['0']['cover'];?>"></td>
							<td>
								<?php
								foreach ($json_decoded4['data']['groups']['0']['images_slider'] as $key) { ?>
									<img style="max-width: 100px;" src="<?php echo $key['images_url'];?>">
								<?php } ?>
							</td>
							<td align="center">
								<?php 
								$eid = _encrypt($r['card_no']);
								?>
								<div class="row" style="display: inline-flex;">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Upload Icon</button>

									<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
										<div class="modal-dialog modal-sm" role="document">
											<form method="POST" enctype="multipart/form-data" action="<?php echo site_url('meme/me/update_group'); ?>">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">Upload Icon</h4>
													</div>
													<div class="modal-body">
														<input type="file" name="icon">		
														<input type="hidden" name="group" value="<?php echo $json_decoded4['data']['groups']['0']['group_id']; ?>">
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
														<button type="submit" class="btn btn-primary">Upload</button>
													</div>													
												</div>
											</form>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>        
		</div>            
	</div>
	<!-- <script type="text/javascript">
		$(document).ready( function () { 
			var table = $('#example').DataTable( {
            // "language": {
            //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
            // },            
            "pageLength": 100,
            // "lengthChange": false,
            // "paging": false,
            "order": [[ 1, "asc" ]]
        } );
                // table.search("<?php if(isset($_SESSION['keyword'])) { echo $_SESSION['keyword']; }?>").draw();
                // table.on( 'order.dt search.dt', function () {
                //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                //         cell.innerHTML = i+1;
                //     } );
                // } ).draw();
            } );    
        </script> -->
        <?php } ?>