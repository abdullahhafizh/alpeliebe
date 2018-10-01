<div class="panel panel-default" style="margin-top:-10px;">
        <div class="table-responsive">
            <table class="table datatable">
               <thead>
                <tr>
                    <th width="30px">No</th>
                    <th width="50px">Tgl. Update</th>
                    <th width="180px">Cover</th>
                    <th width="300px">Judul Berita</th>
                    <th width="300px">Isi Berita</th>
                    <th width="80">Action</th>
                </tr>
                </thead>
               <tbody> 
                <?php 
//				debugCode($article);
                if(count($article) > 0){
                    foreach($article as $r){
                        ?>
                        <tr>
                            <td><?php echo ++$no;?></td>
                            <td><?php echo $r['last_update'];?></td>
                            <td><img src="<?php echo $r['image_cover'];?>" width="150px" height="100px"></td>
                            <td><?php echo $r['name'];?></td>
                            <td><?php echo substr($r['content_text'],0,100);?> ...</td>
                            <td align="right">
                                <?php // link_action($links_table_item,"?_id="._encrypt($r['article_id']));?>
                            </td>
                        </tr>
                <?php } 
                }
                ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<div class="pull-right">
    <?php // echo isset($paging)?$paging:'';?>
</div>

<script>
    var URL_AJAX = '<?php echo base_url();?>index.php/ajax/data';

    $(document).ready(function(){
	<?php if(isset($param) && !empty($param['propinsi'])){?>
		get_kabupaten('<?php echo $param['propinsi'];?>','<?php echo isset($param['kabupaten'])?$param['kabupaten']:'';?>');
	<?php } ?>

      $('#propinsi').change(function(){
          get_kabupaten($(this).val(),"");
      });

      $('#kta_kabupaten').change(function(){
          get_kecamatan($(this).val(),"");
      });
	  
    });

	  function get_kabupaten(prov,kab){
      $.post(URL_AJAX+"/kabupaten",{prov:prov,kab:kab},function(o){
        $('#kta_kabupaten').html(o);
      });
    }

    function get_kecamatan(prov,kab){
      $.post(URL_AJAX+"/kecamatan",{prov:prov,kab:kab},function(o){
        $('#kta_kecamatan').html(o);
      });
    }
</script>