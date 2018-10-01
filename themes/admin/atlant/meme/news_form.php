<?php js_validate();?>
<form id="form-validated" enctype="multipart/form-data" action="<?php echo base_url()."index.php/master/news/save";?>" class="form-horizontal" method="post">	
	<input type="hidden" name="news_id" id="news_id" value="<?php echo isset($val->news_id)?$val->news_id:'';?>" />
	<div class="row">
		<div class="col-md-8">
			<div class="row form-group">  
				<div class="col-md-5 control-label">Judul Berita</div>
				<div class="col-md-7">
					<input autofocus type="text" id="news_title" name="news_title" class="validate[required] form-control" value="<?php echo isset($val->news_title)?$val->news_title:'';?>" />
				</div>
			</div> 

			<div class="row form-group">
				<div class="col-md-5 control-label">Isi Berita</div>
				<div class="col-md-7">
					<!-- <input type="text" id="news_body" name="news_body" class="validate[required] form-control" value="<?php echo isset($val->news_body)?$val->news_body:'';?>" /> -->
					<textarea id="news_body" name="news_body" class="validate[required] form-control" value="<?php echo isset($val->news_body)?$val->news_body:'';?>"></textarea>
				</div> 
			</div> 

			<div class="row form-group">  
				<div class="col-md-5 control-label">Cover</div>
				<div class="col-md-7">
					<input type="file" id="news_cover" name="news_cover" class="validate[required]" />
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
			<button type="submit" name="simpan" class="btn btn-primary btn-cons"><i class="icon-ok"></i> Save</button>
		</div>
	</div>

</form>
<script type="text/javascript">
	var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';
	$(document).ready(function(){
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
				$("#user_fullname").val(selectedTingkat + "-CQ-" + selectedPengusul);			  
			}else{
				$("#user_fullname").val(selectedTingkat + "-PG-" + selectedPengusul);			  
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