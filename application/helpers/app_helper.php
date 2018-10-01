<?php
function getCI(){
	$CI =& get_instance();
	return $CI; 
}

function getHeader(){ 
	$CI =getCI();
	$CI->load->view($CI->jCfg['theme'].'/'.$CI->jCfg['theme_setting']['menu'].'/header');
}

function getFooter(){
	$CI =getCI(); 
	$CI->load->view($CI->jCfg['theme'].'/'.$CI->jCfg['theme_setting']['menu'].'/footer');
} 

function getFormSearch(){
	$CI =getCI();
	//include('form-search.php');
	$CI->load->view($CI->jCfg['theme'].'/form-search');
} 

function getTinymce(){ 
	$CI =getCI();
	$CI->load->view($CI->jCfg['theme'].'/tinymce');
}

function getView($file="",$par=array()){
	$CI =getCI();
	$CI->load->view($CI->jCfg['theme']."/".$file,$par);
}

function themeUrl(){
	$CI =getCI();
	return base_url()."themes/".$CI->jCfg['theme']."/";
}

function pTxt($key='',$sep='-'){
	return str_replace($sep,' ', trim($key));
}

function get_group_role_in($in=array()){
	$CI = getCI();
	$CI->db->where_in("ag_id",$in);
	$m = $CI->db->get_where("app_acl_group",array(
		"is_trash !=" => 1,
		"ag_group_status" => 1
	))->result();
	return $m;
}

function myNum($num=0,$curr=""){
	$curr2 = strtolower($curr);
	if($curr2=="rp"){
		return number_format($num,0,",",".");
	}elseif($curr2=="$" || $curr2=="e"){
		return number_format($num,0,".",",")." ".$curr;
	}else{
		return number_format($num,0,",",".");
	}
}

function cfg($o='app_name'){ 
	$CI =getCI();
	$return = '';

	$logic = '';
	if(is_array($CI->config->item($o))){
		$logic = count($CI->config->item($o))>0?1:"";
	}else{
		$logic = $CI->config->item($o);
	}

	if(trim($logic)!=""){
		$return = $CI->config->item($o);
	}else{
		$v = $CI->db->get_where("app_config",array(
			'config_name' => $o
		))->row();
		if(count($v)>0)
			$return = $v->config_value;
	}

	return $return;
}

function hitung_umur($birthdate) { 
	list($year,$month,$day) = explode("-",$birthdate);
	$year_diff  = date("Y") - $year;
	$month_diff = date("m") - $month;
	$day_diff   = date("d") - $day;
	if ($month_diff < 0) $year_diff--;
	elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
	return $year_diff;
}

function myDate($dt,$f="d/m/Y H:i",$s=true){
	$day = array(
		1 => "Senin",
		2 => "Selasa",
		3 => "Rabu",
		4 => "Kamis",
		5 => "Jumat",
		6 => "Sabtu",
		7 => "Minggu"
	);
	if(trim($dt)!="0000-00-00" && trim($dt)!=""){
		$ts = strtotime($dt);
		$dtm = date($f,$ts);
		if( trim($dtm) == "01/01/1970" ){
			return "-";
		}else{
			return ($s)?$day[date("N",$ts)].", ".$dtm:$dtm;
		}
	}else{
		return "-";
	}
}

function get_date_id($date=""){
	
	$date = trim($date)==""?date("Y-m-d"):$date;

	$tgl = myDate($date,"d",false);
	$thn = myDate($date,"Y",false);

	$month = array(
		'01' 	=> "Januari",
		'02' 	=> "Februari",
		'03' 	=> "Maret",
		'04' 	=> "April",
		'05' 	=> "Mei",
		'06' 	=> "Juni",
		'07'	=> "Juli",
		'08' 	=> "Agustus",
		'09' 	=> "September",
		'10'  	=> "Oktober",
		'11'  	=> "November",
		'12' 	=> "Desember"
	);
	$bulan = $month[myDate($date,"m",false)];

	return $tgl." ".$bulan." ".$thn;
}

function debugCode($r=array(),$f=TRUE){
	echo "<pre>";
	print_r($r);
	echo "</pre>";
	
	if($f==TRUE)
		die;
}

function mDate($date="",$v="+1 day",$format='Y-m-d'){
	$date 	= (trim($date)=="")?date("Y-m-d"):$date;
	$nd 	=  strtotime(date("Y-m-d", strtotime($date)) . $v);
	return date($format,$nd);
}

function get_new_image($p=array()){
	$CI =getCI();
	$no_image = base_url()."assets/collections/no_image.jpg";
	$return = $no_image;
	
	$url_source_no_image = base_url()."assets/images/no_image.jpg";
	$p['url'] = trim($p['url'])==""?$url_source_no_image:$p['url'];
	
	if( trim($p['url']) != ""){
		$img_source = "./".str_replace(base_url(),"",$p['url']);
		$width = isset($p['width'])?$p['width']:0;
		$height = isset($p['height'])?$p['height']:0;
		
		if( file_exists($img_source) && !is_dir($img_source)){
			//get file source info.
			$finfo = pathinfo($img_source); 
			$n_width = $width==0?'ori':$width;
			
			$new_image_name = $finfo['filename']."_".$n_width.".".$finfo['extension'];
			if($height>0){
				$new_image_name = $finfo['filename']."_".$n_width."_".$height.".".$finfo['extension'];
			}
			
			$new_path 	= "./assets/images/".$new_image_name;

			if(!file_exists($new_path) && !is_dir($new_path) ){
				$CI->load->library('image_lib');
				$quality = isset($p['quality'])?$p['quality']:'100%';

				$v = array(
					"width"                 => $width,
					"height"                => $height,
					"quality"               => $quality,
					"source_image"  		=> $img_source,
					"new_image"             => $new_path
				);
				$img = getimagesize($v['source_image']);
				$realWidth      = $img[0];
				$realHeight 	= $img[1];

				if( $height > 0){

					//resize
					$oriW = $v['width'];
					$oriH = $v['height'];
					$x = $v['width']/$realWidth;
					$y = $v['height']/$realHeight;
					if($x < $y) {
						$v['width'] = round($realWidth*($v['height']/$realHeight));
					} else {
						$v['height'] = round($realHeight*($v['width']/$realWidth));
					}
					
					$CI->image_lib->initialize($v);
					if(!$CI->image_lib->resize()){
							//debugCode($this->image_lib->display_errors());
							//echo "eror resize ".$new_image_name;
						$return = base_url()."assets/images/no_image.jpg";
					}
					$CI->image_lib->clear();
					
					// CROP..
					$config = null;
					$config['image_library'] = 'GD2';
					$im = getimagesize($v['new_image']);
					$toCropLeft = ($im[0] - ($oriW *1))/2;
					$toCropTop = ($im[1] - ($oriH*1))/2;
					
					$config['source_image'] = $v['new_image'];
					$config['width'] = $oriW;
					$config['height'] = $oriH;
					$config['x_axis'] = $toCropLeft;
					$config['y_axis'] = $toCropTop;
					$config['maintain_ratio'] = false;
					$config['new_image'] = $v['new_image'];
					
					$CI->image_lib->initialize($config);

					if(!$CI->image_lib->crop()){
						die("Error Crop..");
					}
					$CI->image_lib->clear();
					
				}else{
					$CI->image_lib->initialize($v);
					$v['width']		= $v['width']==0?$realWidth:$v['width'];
					$v['height'] 	= $v['width']==0?round($realHeight*($v['width']/$realWidth)):$v['width'];
					//resize...
					if(!$CI->image_lib->resize()){
							//debugCode($this->image_lib->display_errors());
							//echo "eror resize ".$new_image_name;
						$return = base_url()."assets/images/no_image.jpg";
					}
					$CI->image_lib->clear();
				}	

				$return = base_url()."assets/images/".$new_image_name;	
			}else{
				$return = base_url()."assets/images/".$new_image_name;
				//$p['url'] = $url_source_no_image;
				//get_new_image($p);	
			}
		}
		
	}
	return $return;
}


function get_image($url="",$noimage=""){
	if(trim($noimage)==""){
		$no_image = base_url()."assets/images/no_image.jpg";
	}else{
		$no_image = themeUrl()."images/".$noimage;
	}
	$img = "";
	if(trim($url)!=""){
		$nurl = "./".str_replace(base_url(),"",$url);
		if(file_exists($nurl) && !is_dir($nurl)){
			$img = $url;
		}else
		$img = $no_image;
	}else
	$img = $no_image;
	
	return $img;
}


function _ac($c='index'){
	if(trim($c)!==''){
		$CI  = getCI();
		$acc = $CI->jCfg['access'];
		if(isset($acc[$c])){
			return TRUE;
		}else
		return FALSE;
	}else{
		return FALSE;
	}
}

function get_info_message(){

	if( isset($_GET['msg']) ){ 
		$type= isset($_GET['type_msg'])?$_GET['type_msg']:'info';
		$msg= isset($_GET['msg'])?$_GET['msg']:'info';
		?>
		<style type="text/css">
		#alert_top{
			position: absolute;
			right: 4px; width: 400px;
			margin-top: 30px;
			z-index: 9999;
			border:3px solid #fff;
			border-radius: 10px;
			-moz-border-radius:10px;

			-webkit-box-shadow: -2px -1px 10px 0px rgba(50, 50, 50, 0.75);
			-moz-box-shadow:    -2px -1px 10px 0px rgba(50, 50, 50, 0.75);
			box-shadow:         -2px -1px 10px 0px rgba(50, 50, 50, 0.75);
		}
	</style>
	<div class="alert alert-<?php echo $type;?>" id="alert_top">
		<button data-dismiss="alert" class="close"></button>
		<span class="semi-bold"><b>Pesan</b></span> <br />
		<?php echo urldecode($_GET['msg']);?>
	</div>

	<script type="text/javascript">
		function hidden_msg(){
			$('#alert_top').fadeOut();
		}
		setTimeout('hidden_msg()',8000);
	</script>
<?php } 
}

function _encrypt($key=""){
	$CI =getCI();
	$CI->load->library('encrypt');
	$nid = "meme#".$key."#".cfg('app_name').date("Ymd");
	return urlencode($CI->encrypt->encode($nid));
}

function _decrypt($key=""){
	$CI =getCI();
	$CI->load->library('encrypt');
	$nid = urldecode($CI->encrypt->decode($key));
	$nid_arr = explode("#",$nid);
	if(isset($nid_arr[1])){
		return $nid_arr[1];
	}else{
		redirect($CI->own_link."?msg=Error Parse&type_msg=error");
	}
}
function get_breadcrumb($par=array()){

	if( count($par) >= 2){
		echo "<ul class='breadcrumb'><li><a href=''>YOU ARE HERE</a></li>";
		if(count($par) >= 1){
			foreach ($par as $key => $value) {
				if( isset($value['url']) && trim($value['url'])!="" ){
					echo "<li>";
					if(strtolower($value['title'])=="home"){
						echo " <a href='".site_url()."'><i class='fa fa-home'></i></a> ";
					}
					else{
						echo "<a href='".$value['url']."'>".$value['title']."</a>";
					}
					echo "</li>";
				}
				else{
					echo "<li><a href='#' class='active'>".$value['title']."</a></li>";
				}
			}
		}
		echo '</ul>';
	}

}


function getLinks($links=array()){
	$CI =getCI();
	$uri =  $CI->uri->segment(3);
	if(count($links)>0){
		rsort($links);
		foreach($links as $v){
			if($v['action']!="bug"){
				if(trim($uri)==''||trim($uri)=='search'||trim($uri)=='access'){
					$fc = 'index';
				}else{		
					$fc = (trim($uri)=='edit'||trim($uri)=='add'||trim($uri)=='upload_excel'||trim($uri)=='print_mail'||trim($uri)=='print_nota')?'add':$uri;
				}
				$class_css = $v['action']=="index"?"list":$v['action'];
				$icon = $v['action']=="add"?'<i class="icon-plus" style="color:#222;"></i>':'<i class="icon-th-list" style="color:#222;"></i>';
				?>
				<li class="<?php echo ($fc==$v['action'])?'active':'';?>" ><a href="<?php echo $v['link'];?>" class="ttip_t" title="<?php echo $v['title'];?>"><?php echo $icon." ".$class_css;?></a></li>
				<?php
			}
		}
	}
}

function getLinksWebArch($links=array()){
	$CI =getCI();
	$uri =  $CI->uri->segment(3);
	if(count($links)>0){
		rsort($links);
		foreach($links as $v){
			if($v['action']!="bug"){
				if(trim($uri)==''||trim($uri)=='search'||trim($uri)=='access'){
					$fc = 'index';
				}else{		
					$fc = (trim($uri)=='edit'||trim($uri)=='add'||trim($uri)=='upload_excel'||trim($uri)=='print_mail'||trim($uri)=='print_nota')?'add':$uri;
				}
				if($v['action']=="index"){
					$class_css = "list";					
				}elseif($v['action']=="addsuket"){
					$class_css = "tambah suket";									
				}elseif($v['action']=="addktp"){
					$class_css = "tambah ktp";									
				}else{
					$class_css = $v['action'];					
				}
				$iconlinks = $v['action']=="add-suket"?'suket':$v['link'];
				$icon = $v['action']=="index"?'<i class="fa fa-th-list" style="color:#222;"></i>':'<i class="fa fa-plus-square" style="color:#222;"></i>';
				?>
				<li class="<?php echo ($fc==$v['action'])?'active':'';?> pull-right"><a href="<?php echo $v['link'];?>" class="tip" data-toggle="tooltip" style="color:#222;" data-original-title="<?php echo $v['title'];?>" title="<?php echo $v['title'];?>"><?php echo $icon." ".$class_css;?></a></li>
				<?php
			}
		}
	}
}

function cat_search($m=array()){
	$CI =getCI();
	if(count($m) > 0 ){
		foreach ($m as $key => $value) {
			$s = "";
			if($key==$CI->jCfg['search']['colum'])
				$s="selected='selected'";

			echo "<option value='".$key."' $s >".$value."</option>";
		}
	}
}

function cat_perpage($m=array()){
	$CI =getCI();
	echo '<select name="per_page" class="fr chosen" id="per_page" style="width:60px;">';
	if(count($m) > 0 ){
		foreach ($m as $key => $value) {
			$s = "";
			if($value==$CI->jCfg['search']['per_page'])
				$s="selected='selected'";

			echo "<option value='".$value."' $s >".$value."</option>";
		}
	}
	echo "</select>";
	?>
	<script type="text/javascript">

		$('#per_page').change(function(){
			val = $(this).val();
			document.location = "<?php echo $CI->own_link;?>/per_page?per_page="+val+"&next=<?php echo current_url();?>";
		});
	</script>
	<?php
}

function cat_status($m=array()){
	$CI =getCI();
	echo '<select name="data_status" class="fr" id="data_status" style="width:110px; margin-right:15px;">';
	if(count($m) > 0 ){
		echo "<option value='' >ALL</option>";
		foreach ($m as $key => $value) {
			$s = "";
			if($value==$CI->jCfg['search']['status'])
				$s="selected='selected'";

			echo "<option value='".$value."' $s >".$value."</option>";
		}
	}
	echo "</select>";
	?>
	<script type="text/javascript">

		$('#data_status').change(function(){
			val = $(this).val();
			document.location = "<?php echo $CI->own_link;?>/set_status?status="+val+"&next=<?php echo current_url();?>";
		});
	</script>
	<?php
}

function cek_is_mutasi($id=""){
	$CI = getCI();
	$m = $CI->db->get_where("pbsi_atlet_transfer",array(
		"atlet_transfer_atlet_id"	=> $id,
		"atlet_transfer_status"		=> 0
	))->num_rows();

	if( $m > 0 ){
		return false;
	}else{
		return true;
	}
}

function get_data_table(){ 
	?>
	<script src="<?php echo themeUrl();?>assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
	<script src="<?php echo themeUrl();?>assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>
	<script src="<?php echo themeUrl();?>assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
	<script src="<?php echo themeUrl();?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="<?php echo themeUrl();?>assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
	<script src="<?php echo themeUrl();?>assets/plugins/jquery-datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
	<script src="<?php echo themeUrl();?>assets/plugins/jquery-datatable/extra/js/TableTools.min.js" type="text/javascript" ></script>
	<script type="text/javascript" src="<?php echo themeUrl();?>assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
	<script type="text/javascript" src="<?php echo themeUrl();?>assets/plugins/datatables-responsive/js/lodash.min.js"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<script src="<?php echo themeUrl();?>assets/js/datatables.js" type="text/javascript"></script>
	<?php
}
function js_validate(){  
	?>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	<script src="<?php echo base_url();?>assets/js/languages/jquery.validationEngine-id.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.validationEngine.js" type="text/javascript"></script>
	<script>	
		$(document).ready(function() {
			$("#form-validated").validationEngine();

			$("#form-validated").bind("jqv.form.result", function(event , errorFound){
				if(errorFound){
				}else{
					$('#tab5hellowWorld').css('opacity','.5');
					$('#loading_submit').fadeIn();
				}
			})

			
			

		});
	</script>
	<?php
}

function _dt($dt="30/01/2014"){

	$tmp = explode(" ",$dt);
	$t = date("m", strtotime($tmp[1]));
	return $tmp[2]."-".$t."-".$tmp[0];
}
function js_hight_chart(){	
	?>
	<!-- <script src="<?php echo base_url();?>assets/js/cart/js/highcharts.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>assets/js/cart/js/modules/exporting.js" type="text/javascript"></script> -->
		<script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
		<script type="text/javascript" src="ttps://code.highcharts.com/stock/modules/exporting.js"></script>
		<?php
	}

	function js_picker(){	
		?>
		<link href="<?php echo themeUrl();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo themeUrl();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.input-append.date').datepicker({
					autoclose: true,
					todayHighlight: true,
					format:'dd M yyyy'
				});
			});
		</script>      
		<?php
	}

	function js_bracket(){	
		?>
		<link href="<?php echo base_url();?>assets/css/jquery.bracket.min.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url();?>assets/js/jquery.bracket.min.js" type="text/javascript"></script> 
		<?php
	}

	function js_gracket(){	
		?>
		<link href="<?php echo base_url();?>assets/css/gracket.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url();?>assets/js/jquery.gracket.min.js" type="text/javascript"></script> 
		<?php
	}

	function get_style(){
		?>
		<style>
		*{font-size:12px; font-family:tahoma; padding:0px; margin:0px;}
		.tabel{ width:100%;}.tabel tr td{padding:4px;}
		h3{font-weight:normal; font-size:18px; border-bottom:1px solid #999999; padding:4px;}
		body{margin:0px; padding:0px;}
	</style>
	<?php
}

function link_action($links=array(),$id="",$except=array()){
	if(count($links)>0){
		foreach($links as $m){
			$property = "";
			if($m['type']=='simple'){
				$property = " class='tip act_modal' rel='500|400'";
			}elseif($m['type']=='confirm'){
				$property = " class='tip act_confirm' rel='600|150' data-title='Konfirmasi Hapus Data' data-icon='fa-trash-o' data-desc='Pastikan data yang anda akan hapus ini benar, agar tidak terjadi kesalahan.' data-body='Apakah anda yakin data akan dihapus ??'";
			}else{
				$property = " class='tip' ";	
			}	
			if(count($except)>0&&in_array($m['action'], $except)){

			}else{
				?>
				<a href="<?php echo $m['link']."/".$id;?>" data-toggle="tooltip" <?php echo $property;?> data-original-title="<?php echo ucwords($m['title']);?>" title="<?php echo ucwords($m['title']);?> "><span class="<?php echo $m['image'];?>" style="font-size:18px;"></span></a>
				<?php  	
			} 
		}
	}
}

function get_category($section=""){
	$CI =getCI(); 
	return $CI->db->query("
		SELECT a.category_name,a.category_slug FROM app_category a, app_section b
		WHERE a.category_section = b.section_id
		AND b.section_slug = '".$section."' 
		")->result();
}

function get_old($ae="",$mu=""){
	$CI = getCI(); 
	$m  = $CI->db->query("
		SELECT nilai_".$mu." as nilai FROM iapi_nilai
		WHERE no_peserta = '".$ae."' 	
		AND nilai_".$mu." != 0 
		AND nilai_".$mu." != ''	
		ORDER BY periode_ujian DESC
		LIMIT 1
		")->row();

	$x = !isset($m->nilai)?0:$m->nilai;
	return $x;

}

function _ajax_cek($par=array()){
	$CI =getCI(); 
	
	if(isset($par['ext']) && trim($par['ext'])!=""){
		$validateValue	= $par['ext'].$_POST['validateValue'];
	}else{
		$validateValue	= $_POST['validateValue'];
	}
	
	if(isset($par['replace_dot'])){
		$validateValue	= str_replace(".","",$validateValue);
	}
	
	$validateId		= $_POST['validateId'];
	$validateError	= $_POST['validateError'];
	
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;
	$arrayToJs[1] = $validateError;
	
	$CI->DATA->table=$par['table'];
	$cek = $CI->DATA->_cek(array(
		$par['field'] => $validateValue
	));
	$tmp = "";
	if($cek > 0){	
		$arrayToJs[2] = "false";		
		$tmp = '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';			
	}else{
		$arrayToJs[2] = "true";
		$tmp = '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';			
	}
	return $tmp;
}


function _get_menu($menu=array()){
	$CI  = getCI();
	if(count($menu)<0) return array();
	$mnn="";
	foreach($menu as $mn){
		$mnx 	= preg_split("/>/",$mn['acc_menu']);
		$count	= count($mnx);
		$t		= "\$mnn";
		for($i=0;$i<$count;$i++){
			if(($count-1)==$i)
				$t .= "[]=array('menu'=>'".$mnx[$i]."','id'=>'".$mn['acc_id']."','class_group'=>'".$mn['acc_group']."','group'=>'".$mn['acc_group_controller']."','name'=>'".$mn['acc_controller_name']."','css_class'=>'".$mn['acc_css_class']."');";
			else
				$t .= "['".$mnx[$i]."']";
		}
		eval($t);
	}
	
	return $mnn;
	
}


function top_menu($m,$top=true){

	$CI  = getCI();
	$c 	= count($m);
	$uris = $CI->uri->segment(2);
	echo ($top)?'':'<ul class="animated zoomIn">';
	if($top){
		echo '<li><a href="'.site_url('meme/me').'"><span class="fa fa-home"></span> Dashboard </a></li>';
	}

	foreach((array)$m as $k=>$v)
	{	
		if(is_array($v) && !isset($v['menu']) && !isset($v['id']) && !isset($v['name']) ){
			
			$css_class = isset($v[0]['css_class']) && trim($v[0]['css_class'])!=""?$v[0]['css_class']:'fa fa-folder-open';
			echo '<li class="xn-openable">';
			echo '<a href="javascript:;"> <span class="'.$css_class.'"></span>'.$k.'</a>';
			top_menu($v,false);
			echo "</li>";
			
		}else {
			if( trim($v['name'])!=="me" && trim($v['name'])!=="" ){
				$css_class = isset($v[0]['css_class']) && trim($v[0]['css_class'])!=""?$v[0]['css_class']:'';//'fa fa-folder-open';
				echo '<li>';
				echo '<a href="'.site_url($v['group'].'/'.$v['name']).'" ><span class="'.$css_class.'"></span> '.$v['menu'].'</a>';
				echo '</li>';
			}
		}		

	}
	if($top){
		echo '<li><a href="javascript:;"><span class="fa fa-list"></span> Laporan </a>
		<ul><li><a href="'.site_url('report/report_kta/rar').'"><span class="fa fa-download"></span>Download Anggota Belum Tercetak </a></li></ul></li>';
	}
	if($top){
		echo '<li><a href="javascript:;"><span class="fa fa-users"></span> Group </a>
		<ul><li><a href="'.site_url('meme/me/group').'"><span class="fa fa-android"></span> Android Group Management </a></li></ul></li>';
	}
	echo ($top)?'':'</ul>';
}

function left_menu($m,$top=true){

	$CI  = getCI();
	$c 	= count($m);
	$uris = $CI->uri->segment(2);
	echo ($top)?'':'<ul class="animated zoomIn">';
	if($top){
		echo '<li><a href="'.site_url('meme/me').'"><span class="fa fa-home"></span> <span class="xn-text">Dashboard</span> </a></li>';
	}

	foreach((array)$m as $k=>$v)
	{	
		if(is_array($v) && !isset($v['menu']) && !isset($v['id']) && !isset($v['name']) ){
			
			$css_class = isset($v[0]['css_class']) && trim($v[0]['css_class'])!=""?$v[0]['css_class']:'fa fa-files-o';
			echo '<li class="xn-openable">';
			echo '<a href="javascript:;"> <span class="'.$css_class.'"></span><span class="xn-text">'.$k.'</span></a>';
			top_menu($v,false);
			echo "</li>";
			
		}else {
			if( trim($v['name'])!=="me" && trim($v['name'])!=="" ){
				$css_class = isset($v[0]['css_class']) && trim($v[0]['css_class'])!=""?$v[0]['css_class']:'';//'fa fa-folder-open';
				echo '<li>';
				echo '<a href="'.site_url($v['group'].'/'.$v['name']).'" ><span class="'.$css_class.'"></span> '.$v['menu'].'</a>';
				echo '</li>';
			}
		}		

	}
	echo ($top)?'':'</ul>';
}



function get_user_name($id="",$field="user_name"){
	$CI = getCI();
	$data = $CI->db->get_where("app_news",array(
		"user_id"	=> $id
	))->row();

	return isset($data->{$field})?$data->{$field}:'';
}


function get_chosen(){
	?>
	<script src="<?php echo themeUrl();?>assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".chosen").select2();
		});
	</script>
	<?php
}
function geboMenu($m,$top=true){
	$CI  = getCI();
	$c 	= count($m);
	$uris = $CI->uri->segment(2);
	echo ($top)?"<ul class='nav'>":"<ul class='dropdown-menu'>";
	//if( count($m) > 0 && trim($m)!=""){
	foreach($m as $k=>$v)
	{	
		if(is_array($v) && !isset($v['menu']) && !isset($v['id']) && !isset($v['name']) ){
			$carret = $top==true?'caret':'caret-right';
			$icon_white = $top==true?'icon-white':'';
			$css_class = isset($v[0]['css_class']) && trim($v[0]['css_class'])!=""?$v[0]['css_class']:'icon-list-alt';
			echo "<li class='dropdown'>";
			echo '<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="'.$css_class.' '.$icon_white.' "></i> '.$k.' <b class="'.$carret.'"></b></a>';
			geboMenu($v,false);
			echo "</li>";
		}else {
			echo "<li>";
			echo "<a href='".site_url($v['group']."/".$v['name'])."' >".$v['menu']."</a>";
			echo "</li>";
		}		
		
	}
	//}
	echo "</ul>";
}
function getCity($id=""){
	$CI  = getCI();
	$city = "";
	if(trim($id)!=""){
		$q = $CI->db->query("
			SELECT * FROM app_kabupaten WHERE kab_id='".$id."'
			LIMIT 0,1
			")->row();
		if(count($q) > 0){
			$city = $q->kab_nama;
		}
	}
	
	return $city; 
}

function option_province($prov=""){
	$CI  = getCI();
	
	$CI->db->order_by('propinsi_nama','ASC');
	$q = $CI->db->get("app_propinsi")->result();

	if( count($q) > 0 ){
		foreach ($q as $key => $value) {
			$selected = $value->propinsi_id==$prov?"selected='selected'":"";
			$callback .= "<option value='".$value->propinsi_id."' $selected >".$value->propinsi_nama."</option>";
		}
	}
	return $callback;		
}


function option_city($p=array()){
	if(isset($p['prov_selector']) && trim($p['prov_selector'])!=""){
		?>
		<script type="text/javascript">
			var DATA_URL = '<?php echo modUri();?>data/';
			$(document).ready(function(){
				$('#<?php echo $p['prov_selector'];?>').change(function(){
					_get_city($(this).val());
				});

				<?php $p['city'] = isset($p['city']) && trim($p['city'])!=""?$p['city']:'no city';?>
				_get_city($('#<?php echo $p['prov_selector'];?>').val(),'<?php echo $p['city'];?>');
			});
			function _get_city(prov,city){
				city = city==undefined?'':city;
				prov = prov==undefined?'':prov;
				$.post(DATA_URL+'get_city/'+prov,{city:city},function(o){
					$('#<?php echo $p['city_selector'];?>').html(o);
				});
			}

		</script>
		<?php
	}
}	

function getProvince($id=""){
	$CI  = getCI();
	$province = "";
	if(trim($id)!=""){
		$q = $CI->db->query("
			SELECT * FROM app_propinsi WHERE propinsi_id='".$id."'
			LIMIT 0,1
			")->row();
		if(count($q) > 0){
			$province = $q->propinsi_nama;
		}
	}
	
	return $province;
}

function get_header_table($obj=array()){
	$CI = getCI();
	if( count($obj) > 0 ){
		$direction = $CI->jCfg['search']['order_dir']=="ASC"?"DESC":"ASC";
		foreach ($obj as $key => $value) {
			if(trim($key)!=""){
				echo "<th><a href='".$CI->own_link."/sort?sort_by=".$key."&sort_dir=".$direction."&next=".current_url()."'>".$value."</a></th>";
			}
		}
	}
}

function gebo_choosen(){
	?>
	<script type="text/javascript" src="<?php echo themeUrl();?>lib/chosen/chosen.jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo themeUrl();?>lib/chosen/chosen.css"/>
	<script type="text/javascript">
		$(document).ready(function(){
			gebo_chosen.init();
		});
		gebo_chosen = {
			init: function(){
				$(".chosen_one").chosen({
					allow_single_deselect: true
				});
				$(".chosen_multi").chosen();
			}
		};
	</script>
	<?php
}

function get_role($user_id=""){
	$CI = getCI();

	$CI->db->select("app_acl_group.*");
	$CI->db->join("app_user_group","app_user_group.ug_group_id = app_acl_group.ag_id");
	$CI->db->where("app_acl_group.ag_group_status",1);
	$CI->db->where("app_acl_group.is_trash !=",1);
	$CI->db->where("app_user_group.ug_user_id",$user_id);
	$m = $CI->db->get("app_acl_group")->result();
	return $m;
}

function load_css(){
	$CI = getCI();
	$base_url_css = themeUrl()."css/";
	foreach ((array)$CI->css_file as $v) {
		echo '<link rel="stylesheet" type="text/css" href="'.$base_url_css.$v.'" />
		';
	}	
}

function load_js(){
	$CI = getCI();
	$base_url_js = themeUrl()."js/";
	foreach ((array)$CI->js_file as $v) {
		echo '<script type="text/javascript" src="'.$base_url_js.$v.'" ></script>
		';
	}
}

function load_js_plugins(){
	$CI = getCI();
	$base_url_js = themeUrl()."js/";
	foreach ((array)$CI->js_plugins as $v) {
		echo '<script type="text/javascript" src="'.$base_url_js.$v.'" ></script>
		';
	}
}

function load_js_script(){
	$CI = getCI();
	$base_url_js = themeUrl()."js/";
	if( count($CI->js_script) > 0){
		echo '<script type="text/javascript">';
		foreach ((array)$CI->js_script as $v) {	
			echo $v;
		}
		echo '</script>';
	}
}
function getBrowser(){ 
	$u_agent = $_SERVER['HTTP_USER_AGENT']; 
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version= "";

     //First get the platform?
	if (preg_match('/linux/i', $u_agent)) {
		$platform = 'linux';
	}
	elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		$platform = 'mac';
	}
	elseif (preg_match('/windows|win32/i', $u_agent)) {
		$platform = 'windows';
	}

     // Next get the name of the useragent yes seperately and for good reason
	if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
	{ 
		$bname = 'IE'; 
		$ub = "MSIE"; 
	} 
	elseif(preg_match('/Firefox/i',$u_agent)) 
	{ 
		$bname = 'Firefox'; 
		$ub = "Firefox"; 
	}
	elseif(preg_match('/OPR/i',$u_agent)) 
	{ 
		$bname = 'Opera'; 
		$ub = "OPR"; 
	} 
	elseif(preg_match('/Chrome/i',$u_agent)) 
	{ 
		$bname = 'Chrome'; 
		$ub = "Chrome"; 
	} 
	elseif(preg_match('/Safari/i',$u_agent)) 
	{ 
		$bname = 'Safari'; 
		$ub = "Safari"; 
	} 
	elseif(preg_match('/Netscape/i',$u_agent)) 
	{ 
		$bname = 'Netscape'; 
		$ub = "Netscape"; 
	} 

     // finally get the correct version number
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (!preg_match_all($pattern, $u_agent, $matches)) {
         // we have no matching number just continue
	}

     // see how many we have
	$i = count($matches['browser']);
	if ($i != 1) {
         //we will have two since we are not using 'other' argument yet
         //see if version is before or after the name
		if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
			$version= $matches['version'][0];
		}
		else {
			$version= isset($matches['version'][1])?$matches['version'][1]:'';
		}
	}
	else {
		$version= $matches['version'][0];
	}

     // check if we have a number
	if ($version==null || $version=="") {$version="?";}

	return array(
		'userAgent' => $u_agent,
		'name'      => $bname,
		'version'   => $version,
		'platform'  => $platform,
		'pattern'   => $pattern
	);
}
function get_up_maintenance(){
	$CI = getCI();
	$m = $CI->db->query("
		SELECT *
		FROM app_maintenance
		")->result();
	return $m;
}

function tester(){
	echo "string";
}
function cRequest($url="",$request="",$port="",$session="") {
	$ch = curl_init($url);
	$data = json_decode($request,TRUE);
	$id = $data['id'];
	$ps = $data['password'];
	$vc = $data['version_code'];
	curl_setopt_array($ch, array(
		CURLOPT_PORT => $port,
		CURLOPT_POST => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_HTTPHEADER => array(
			'Authorization: ',
			'Content-Type: application/json'
		),
		CURLOPT_POSTFIELDS =>  "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"id\":\"$id\",\"password\":\"$ps\",\"verification_code\":\"\",\"version_code\":$vc}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",								
		CURLOPT_HTTPHEADER => array(
			"Cache-Control: no-cache",
			"Postman-Token: f902dbd1-8c63-4928-ba81-77bc6741963d",
			"SessionId: REGISTER_LOGIN",
			"versioncode: ".cfg('version_code')."",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	)
);
	$response = curl_exec($ch);
	if($response === FALSE)die(curl_error($ch));
	$response_data = json_decode($response, TRUE);
	return $response_data;
}

function shorter($text, $chars_limit)
{
    // Check if length is larger than the character limit
	if (strlen($text) > $chars_limit)
	{
        // If so, cut the string at the character limit
		$new_text = substr($text, 0, $chars_limit);
        // Trim off white space
		$new_text = trim($new_text);
        // Add at end of text ...
		return $new_text . "...";
	}
    // If not just return the text as is
	else
	{
		return $text;
	}
}
