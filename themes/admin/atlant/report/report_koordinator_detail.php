<form action="<?php echo $own_links;?>/search" method="post" >
	  <div class="well">
	  		<div class="row">	  			
	  			<div class="col-md-3">
                                <select class="form-control" id="propinsi" name="propinsi">
                                    <option value=""> - pilih koordinator data - </option>
                                    <?php foreach ((array)get_manager() as $m) {
									  $s = isset($param)&&$param['koordata']==$m->user_id?'selected="selected"':'';
										  echo "<option value='".$m->user_id."' $s >".$m->user_fullname."</option>";
										}
									?>
                                </select> 
		  		</div>
				<div class="col-md-2" style="margin-top:0px;">
					<button style="margin-right:5px;" name="btn_search" id="btn_search"  class="btn btn-primary col-md-5" type="submit">Lanjut</button>
		  			<input type="submit" value="Reset!" name="btn_reset" id="btn_reset" class="btn btn-warning col-md-5" />	
	  			</div>
	  		</div>	  	
	  </div>
</form>
