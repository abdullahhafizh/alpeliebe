<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Me extends AdminController {

	var $front_menu = '';	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		//$this->output->enable_profiler(TRUE);
		$this->DATA->table="app_kta";
		$this->css_file = array(
			'cropper/v0.7.9/css/cropper.min.css',
			'cropper/v0.7.9/css/main.css'
//			'cropper/cropper.min.css'
		);

		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js',
			'plugins/webcamjs/webcam.js',
			'plugins/fileinput/fileinput.min.js',
//			'plugins/blueimp/jquery.blueimp-gallery.min.js',
			'cropper/docs/v0.7.9/js/cropper.min.js'
//			'cropper/docs/v0.7.9/js/main2.js'
//			'plugins/dropzone/dropzone.min.js',
//			'plugins/filetree/jqueryFileTree.js',
//			'plugins/jstree/jstree.min.js',
//			'plugins/cropper/cropper.min.js'
		);

		$this->js_file = array(
			'cropper/docs/v0.7.9/js/main.js'
		);		
	}

	function set_theme(){
		$this->sCfg['theme_setting']['header'] = true;
		$this->_releaseSession();
	}

	function set_exp(){
		/*$m = $this->db->get_where("app_kta",array(
					"kta_id !="	=> ''
				))->result();
		$jumlah = 0;
		foreach ((array)$m as $key => $value) {
			$exp = mDate($value->kta_tgl_bayar_2,"+1 years","Y-m-d");
			$this->db->update("app_kta",array(
					"kta_start_date" => $value->kta_tgl_bayar_2,
					"kta_end_date"   => $exp
				),array(
					"kta_id" => $value->kta_id
				));
			$jumlah++;

		}

		die('Sukses, ada '.$jumlah.' yang sudah di update');*/

	}
	
	function index(){
		$tot_member = tot_member();
		$tot_card_printed = tot_card_printed();
		$tot_card_not_printed = tot_card_not_printed();
		$tot_print_per_province = tot_print_per_province();		
		$this->is_dashboard = true;
		// $this->css_file[] = 'daterangepicker/daterangepicker-bs3.css';
		// $this->js_plugins = array('plugins/moment.min.js','plugins/daterangepicker/daterangepicker.js','plugins/knob/jquery.knob.min.js');
		// $this->js_file[] = 'page/init.daterangepicker.js';
		// $this->breadcrumb[] = array(
		// 	"title"		=> "Home",
		// 	"url"		=> $this->own_link
		// );
		$this->breadcrumb[] = array(
			"title"		=> "Dashboard"
		);
		// $data = array();
		$data['tot_member'] = $tot_member['data']['0']['data_count'];
		$data['tot_card_printed'] = $tot_card_printed['data']['0']['data_count'];
		$data['tot_card_not_printed'] = $tot_card_not_printed['data']['0']['data_count'];
		$data['tot_print_per_province'] = $tot_print_per_province;
		$data['req2'] = tot_per_3month();
		if (!isset($_SESSION['tingkat_kta'])) {
			$_SESSION['tingkat_kta'] = "sma";
		}
		if ($_SESSION['tingkat_kta'] == null || $_SESSION['tingkat_kta'] == 1) {
			$_SESSION['tingkat_kta'] = "sma";
		}

		//for($i=0;$i<=100000000;$i++){
			//echo $i;
		//}
		// $hckey = $this->db->get_where("app_propinsi",array(
		// 	"propinsi_id" => $this->jCfg['user']['propinsi']
		// ))->row();
		if($this->jCfg['user']['userrole'] == 30){
			$get_propinsi = $this->db->query("
				select app_pengguna.nama_pengguna,app_pengguna.propinsi_id, app_propinsi.propinsi_nama,app_propinsi.hc_key FROM app_pengguna
				LEFT JOIN app_propinsi
				ON app_pengguna.propinsi_id = app_propinsi.propinsi_id
				WHERE app_pengguna.penggunaID = '".$this->jCfg['user']['penggunaid']."'
				")->row();
			$this->_v("dashboard-pemesan",array(
				"prop_nama" => $get_propinsi->propinsi_nama,
				"hc_key" => $get_propinsi->hc_key,
				"id_prop" => $get_propinsi->propinsi_id
			));
			redirect(site_url('meme/me/dashboard-pemesan'));
		}elseif($this->jCfg['user']['userrole'] == 31){
			$this->_v("dashboard-finance",$data);
		}elseif($this->jCfg['user']['userrole'] == 34){
			$this->_v("dashboard-operator-entry",$data);
		}elseif($this->jCfg['user']['userrole'] == 35){
			$this->_v("dashboard-operator-scan",$data);
		}elseif($this->jCfg['user']['userrole'] == 33){
			$this->_v("dashboard-koordinator",$data);
		}elseif($this->jCfg['user']['userrole'] == 36){
			$this->_v("dashboard-domisili",$data);
		}else{
			$this->_v("index",$data);
		}		
	}

	function locked(){
		$data = array();
		$this->is_dashboard = TRUE;
		$this->_v("lockscreen",$data,false);
	}

	function daftar(){
		$data = array();
		$this->is_dashboard = TRUE;
		$this->_set_title( 'PENDAFTARAN KARTU ANGGOTA' );
		$this->_v("daftar",$data);
	}

	function kasir(){
		$data = array();

		$this->_set_title( 'KASIR PENDAFTARAN EVENT' );
		$this->_v("kasir",$data);
	}

	function user_guide(){

		$this->_set_title( 'User Guide' );
		$this->_v("user_guide",array());

	}

	function background(){
		$this->is_dashboard = TRUE;
		$this->_set_title( 'Change Background & Color' );

		if( isset($_POST['simpan']) ){
			$color = '';
			$bg = isset($_POST['opt_bg'])?$_POST['opt_bg']:'bg12.png';

			$this->db->update("app_news",array(
				'user_background' 	=> $bg,
				'user_themes'		=> $color
			),array(
				'user_id'		=> $this->jCfg['user']['id']
			));

			//set sesstion...
			$this->sCfg['user']['bg']		= $bg;
			$this->sCfg['user']['color']	= $color;
			$this->_releaseSession();

			redirect($this->own_link."/background?msg=".urldecode('Update background & color succes')."&type_msg=success");

		}

		$this->_v("background",array());
	}
	function profile(){
		$this->is_dashboard = TRUE;
		$this->_set_title('Profile of ( You ) '.$this->jCfg['user']['fullname']);
		$this->breadcrumb[] = array(
			"title"		=> "Profile"
		);
		$this->_v("view-profile",array(
			"data"	=> $this->db->get_where("app_news",array(
				"user_id"	=> $this->jCfg['user']['id']
			))->row()
		));

	}

	function detail_kta($string){
	// debugCode(tot_per_angkatan());
	// $id=dbClean(trim($this->input->get('_id')));

	// $get_propinsi = $this->db->query("
	// 	select *
	// 	from app_propinsi where hc_key = 'id-ku'
	// 	")->row();

		$this->is_dashboard = TRUE;
	// $this->_set_title('Detail Report KTA-PG');
		$this->breadcrumb[] = array(
			"title"		=> "Detail Data KTA"
		);
		if ($string == "sma") {
			$data['req'] = tot_per_sma();
			$data['print'] = tot_print_per_sma();
		}
		elseif ($string == "smp") {
			$data['req'] = tot_per_smp();
			$data['print'] = tot_print_per_smp();
		}
		elseif ($string == "sd") {
			$data['req'] = tot_per_sd();
			$data['print'] = tot_print_per_sd();
		}
		elseif ($string == "tk") {
			$data['req'] = tot_per_tk();
			$data['print'] = tot_print_per_tk();
		}
		elseif ($string == "staff") {
			$data['req'] = tot_per_staff();
			$data['print'] = tot_print_per_staff();
		}
		else {
			redirect(site_url('meme/me/detail_kta/'.$_SESSION['tingkat_kta'].''));
		}
		$_SESSION['tingkat_kta'] = $string;
		$this->_v("detail-kta", $data);
	// $this->_v("detail-kta",array(
	// 	"prop_nama" => $get_propinsi->propinsi_nama,
	// 	"hc_key" => $get_propinsi->hc_key,
	// 	"id_prop" => $get_propinsi->propinsi_id
	// ));

	}

	function domisili(){

		$id=dbClean(trim($this->input->get('_id')));

		$get_propinsi = $this->db->query("
			select *
			from app_propinsi where hc_key = '".$id."'
			")->row();

		$this->is_dashboard = TRUE;
		$this->_set_title('Maps Distribution Detail : '.$get_propinsi->propinsi_nama);
		$this->breadcrumb[] = array(
			"title"		=> "Maps Detail"
		);

		$this->_v("domisili",array(
			"prop_nama" => $get_propinsi->propinsi_nama,
			"hc_key" => $get_propinsi->hc_key,
			"id_prop" => $get_propinsi->propinsi_id
		));

	}

	function edit_profile(){

		$this->is_dashboard = TRUE;
		$this->_set_title('Update Profile For ( You ) '.$this->jCfg['user']['fullname']);
		$this->breadcrumb[] = array(
			"title"		=> "Profile",
			"url"		=> $this->own_link
		);

		$this->breadcrumb[] = array(
			"title"		=> "Update Profile"
		);

		if( isset($_POST['update']) ){
			$this->DATA->table = "app_news";
			$data = array(
				'user_fullname'		=> dbClean($_POST['user_fullname']),
				'user_email'		=> dbClean($_POST['user_email'])

			);
			if( isset($_POST['user_password']) && trim($_POST['user_password']) != ''){
				$data['user_password'] = md5(dbClean($_POST['user_password']));
			}

			$a = $this->_save_master(
				$data,
				array(
					'user_id' => $this->jCfg['user']['id']
				),
				$this->jCfg['user']['id']
			);

			$this->upload_path="./assets/collections/photo/";
			$id = $this->jCfg['user']['id'];
			$this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'user_photo',
					'param'		=> array(
						'field' => 'user_photo',
						'par'	=> array('user_id' => $id)
					)
				));
			redirect($this->own_link."/profile?msg=".urldecode('Update data user succes')."&type_msg=success");
		}

		$this->_v("edit-profile",array(
			"data"	=> $this->db->get_where("app_news",array(
				"user_id"	=> $this->jCfg['user']['id']
			))->row()
		));

	}

	function change_password(){
		$this->breadcrumb[] = array(
			"title"		=> "Change Password",
			"url"		=> $this->own_link
		);

		$pesan="";
		if(isset($_POST['btn_simpan'])){
			$pass_lama = md5(dbClean($_POST['old_pass']));
			$this->DATA->table="app_user";
			$m1 = $this->DATA->_getall(array(
				"user_name"		=> $this->jCfg['user']['name'],
				"user_password"	=> $pass_lama
			));

			if(count($m1)>0){
				$pass_baru = md5(dbClean($_POST['new_pass']));
				$mx = $this->DATA->_update(
					array(
						"user_name"		=> $this->jCfg['user']['name']
					),array(
						"user_password" => $pass_baru
					)

				);
				$pesan = ($mx)?"Success update your password":"Success update your password";
				$mtype = ($mx)?"success":"error";
			}else{
				$pesan ="Your old password is not correctly!";
				$mtype = "danger";
			}

			redirect($this->own_link."/change_password?msg=".urldecode($pesan)."&type_msg=".$mtype);
		}


		$this->_set_title('Change Password For ( You ) '.$this->jCfg['user']['fullname']);
		$this->_v("change-password",array(
			"pesan"	=> $pesan
		));
	}
	function app_version(){
		$this->breadcrumb[] = array(
			"title"		=> "KTA-PG Applicaton Version",
			"url"		=> $this->own_link
		);
		$this->_v("app-version",array(
			"pesan"	=> ''
		));
	}

	function bug(){
		if(isset($_POST['btn_simpan'])){
			$pesan = dbClean($_POST['pesan']);
			$url   = isset($_GET['url'])?$_GET['url']:'';
			$by    = $this->jCfg['user']['name'];
			$tgl   = date("Y-m-d H:i:s");
			$msg   = "Telah Terjadi Error Pada ".$tgl." Dilaporkan Oleh : ".$by."\n";
			$msg  .= "Error Pada ".$url." \n Pesan : ".$pesan."\n";

			$this->sendEmail(array(
				'from'		=> 'web@'.$this->domain,
				'to'		=> array(getCfgApp('bug_email')),
				'subject'	=> 'Bolanews Bug',
				'priority'	=> 1,
				'message'	=> $msg
			));

			echo "<script>parent.location.reload(true);</script>";
		}

		$this->_v("report_bug",array(
			"url"	=> isset($_GET['url'])?$_GET['url']:''
		),FALSE);
	}
	function edit_reject(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
				'kta_id'	=> $id
			));
			$folder = "master";
			$prefix = "upload_formulir";
			$this->_v($folder."/".$prefix."_form",array());
		}
	}
	function data_entry(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
				'kta_id'	=> $id
			));
			$folder = "master";
			$prefix = "entry_formulir";
//		redirect($this->_v($folder."/".$prefix."_form",array()));
			$this->_v($folder."/".$prefix."_form",array());
		}
	}

	function group()
	{
		$this->breadcrumb[] = array(
			"title"		=> "Group Mobile",
		);
		$this->_set_title('Manage Android Group');
		$group = "Group|00";
		if (isset($_POST['group'])) {
			$group = $_POST['group'];
			$_SESSION['group_group'] = $group;
		}
		else
		{
			if (isset($_SESSION['group_group'])) {
				$group = $_SESSION['group_group'];
			}
		}		
		$data['groups'] = get_group();
		$data['json_decoded4'] = get_group($group);	
	// debugCode($data['json_decoded4']);
		$this->_v("group", $data);
	}

	function getCurlValue($filename, $contentType, $postname)
	{
    // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
    // See: https://wiki.php.net/rfc/curl-file-upload
		if (function_exists('curl_file_create')) {
			return curl_file_create($filename, $contentType, $postname);
		}

    // Use the old style if using an older version of PHP
		$value = "@{$filename};filename=" . $postname;
		if ($contentType) {
			$value .= ';type=' . $contentType;
		}

		return $value;
	}

	function update_group()
	{					
		$filename = $_FILES['icon']['name'];
		$filedata = $_FILES['icon']['tmp_name'];
		$filetype = $_FILES['icon']['type'];
		$curl = $this->getCurlValue($filename, $filetype, $filedata);
		update_group($_POST['group'], $curl, $filename, $type);
	}

	function group_reset()
	{	
		unset($_SESSION['group_group']);
		redirect("/meme/me/group");
	}

}
