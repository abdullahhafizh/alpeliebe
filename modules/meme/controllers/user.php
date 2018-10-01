<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class User extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title('Manage User Login');
		$this->DATA->table="app_user";
		$this->folder_view = "meme/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->upload_path="./assets/collections/photo/"; 

		$this->breadcrumb[] = array(
			"title"		=> "User",
			"url"		=> $this->own_link
		);

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
		}
		

		$this->cat_search = array(
			''						=> 'All',
			'user_fullname'			=> 'Full Name',
			'user_email'			=> 'Email'
		); 
		$this->load->model("mdl_user","M");
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/datatables/jquery.dataTables.min.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
	}

	function _reset(){
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'name'		=> 'user',
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'user_id',
			'order_dir' => 'DESC',
			'colum'		=> '',
			'keyword'	=> ''
		);
		$this->_releaseSession();
	}

	function index(){
		$hal = isset($this->jCfg['search']['name'])?$this->jCfg['search']['name']:"home";
		if($hal != 'user'){
			$this->_reset();
		}

		$this->breadcrumb[] = array(
			"title"		=> "List"
		);
		if($this->input->post('btn_search')){
			if($this->input->post('date_start') && trim($this->input->post('date_start'))!="")
				$this->jCfg['search']['date_start'] = $this->input->post('date_start');

			if($this->input->post('date_end') && trim($this->input->post('date_end'))!="")
				$this->jCfg['search']['date_end'] = $this->input->post('date_end');

			if($this->input->post('colum') && trim($this->input->post('colum'))!="")
				$this->jCfg['search']['colum'] = $this->input->post('colum');
			else
				$this->jCfg['search']['colum'] = "";	

			if($this->input->post('keyword') && trim($this->input->post('keyword'))!="")
				$this->jCfg['search']['keyword'] = $this->input->post('keyword');
			else
				$this->jCfg['search']['keyword'] = "";

			$this->_releaseSession();
		}

		if($this->input->post('btn_reset')){
			$this->_reset();
		}

//		$this->per_page = 20;

		$par_filter = array(
			"offset"	=> $this->uri->segment($this->uri_segment),
//				"limit"		=> $this->per_page,
			"param"		=> $this->cat_search
		);
		$this->data_table = $this->M->user($par_filter);
		$data = $this->_data(array(
			"base_url"	=> $this->own_link.'/index'
		));
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	function user_mobile($id){		
		$this->breadcrumb[] = array(
			"title"		=> "User Mobile",
			"url"		=> "user_mobile"
		);
		$this->_set_title('Manage Android User');
		if ($id <= 0) {
			$id = 1;
		}//
		$data['page'] = $id - 1;
		$page = $data['page'];
		$group = "Group|00";
		if (isset($_POST['group'])) {
			$group = $_POST['group'];
			$_SESSION['group_id'] = $group;
		}
		else
		{
			if (isset($_SESSION['group_id'])) {
				$group = $_SESSION['group_id'];
			}
		}		
		$keyword = null;
		if (isset($_POST['keyword'])) {
			$keyword = $_POST['keyword'];
			$_SESSION['keyword'] = $keyword;
		}
		else
		{
			if (isset($_SESSION['keyword'])) {
				$keyword = $_SESSION['keyword'];
			}
		}
		$data['groups'] = get_group();
		$data['json_decoded4'] = getall($group, null, $keyword, $page);
		$data['keyword'] = $keyword;
		$data['group_id'] = $group;		
		$this->_v($this->folder_view."user_mobile", $data);
	}

	function user_mobile_reset()
	{	
		unset($_SESSION['group_id']);
		unset($_SESSION['keyword']);
		redirect("/meme/user/user_mobile");
	}

	function reset_password()
	{	
		$this->breadcrumb[] = array(
			"title"		=> "User Mobile</li><li>Reset Password",
			"url"		=> "user_mobile"
		);		
		$id = _decrypt(dbClean(trim($this->input->get('_id'))));
		$data['member'] = get_bycardno($id);
		$this->_set_title('Ubah Password');		
		$this->_v($this->folder_view."reset_password", $data);
	}	

	function mobile_to_web()
	{	
		$this->_set_title('Add User From Mobile');
		$get_total_user = $this->db->query("
			select count(user_id) as total_user 
			from app_user where col1 = '".$this->jCfg['user']['id']."'
			")->row();

		$get_total_limit = $this->db->query("
			select user_limit
			from app_user where user_id = '".$this->jCfg['user']['id']."'
			")->row();
		if($this->jCfg['user']['userrole'] == 33 ){
			if($get_total_limit->user_limit <= $get_total_user->total_user){
				redirect($this->own_link."?msg=".urldecode('Daftar user sudah mencapai limit maksimal, hubungi Administrator untuk menambahkan limit user.')."&type_msg=danger");
			}else{
				$this->breadcrumb[] = array(
					"title"		=> "Add User From Mobile"
				);		
				$this->_v("meme/mobile_to_web",array(
					'group'		=> $this->db->get_where("app_acl_group",array(
						"ag_group_status"	=>	"1",
						"is_trash <>" 		=> "1"
					))->result()
				));			
			}
		}else{
			$this->breadcrumb[] = array(
				"title"		=> "Add User From Mobile"
			);
			$this->_v("meme/mobile_to_web",array(
				'group'		=> $this->db->get_where("app_acl_group",array(
					"ag_group_status"	=>	"1",
					"is_trash <>" 		=> "1"
				))->result()
			));						
		}
	}	

	function set_password()
	{
		$new = md5(dbClean($this->input->post('new_password')));
		$member_id = $this->input->post('member_id');		

		reset_password($member_id, $new);
	}

	function delete_user()
	{		
		$member_id = _decrypt(dbClean(trim($this->input->get('member'))));
		$group_id = _decrypt(dbClean(trim($this->input->get('group'))));
		delete_member($member_id, $group_id);
	}

	function update_cardprinted()
	{		
		$card_no = _decrypt(dbClean(trim($this->input->get('_id'))));
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "2206",
			CURLOPT_URL => "http://116.90.165.246:2206/kj_member/hnsi/get_bycardno",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"card_no\":\"".$card_no."\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
				"postman-token: ab7f72d6-c34d-13fb-ea67-9635642700b9",
				"sessionid: ".$_SESSION['sesiLogin']."",
				"versioncode: ".cfg('version_code').""
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$member = json_decode($response, true);
		}
		$member_id = $member['data']['0']['member_id'];		

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_PORT => "2206",
			CURLOPT_URL => "http://116.90.165.246:2206/kj_member/hnsi/update_cardprinted",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"member_id\":\"".$member_id."\",\"card_printed\":\"YES\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
				"postman-token: 453465ca-0226-2598-9550-78d6e1d1f3c5",
				"sessionid: 765F7D3E-02C6-8D21-3378-FAE49FF42923",
				"versioncode: 20"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
		redirect("/meme/user/user_mobile?msg=".urldecode('Update Status Printed success')."&type_msg=success");
	}
	function add(){
		$get_total_user = $this->db->query("
			select count(user_id) as total_user 
			from app_user where col1 = '".$this->jCfg['user']['id']."'
			")->row();

		$get_total_limit = $this->db->query("
			select user_limit
			from app_user where user_id = '".$this->jCfg['user']['id']."'
			")->row();
		if($this->jCfg['user']['userrole'] == 33 ){
			if($get_total_limit->user_limit <= $get_total_user->total_user){
				redirect($this->own_link."?msg=".urldecode('Daftar user sudah mencapai limit maksimal, hubungi Administrator untuk menambahkan limit user.')."&type_msg=danger");
			}else{
				$this->breadcrumb[] = array(
					"title"		=> "Add"
				);		
				$this->_v($this->folder_view.$this->prefix_view."_form",array(
					'group'		=> $this->db->get_where("app_acl_group",array(
						"ag_group_status"	=>	"1",
						"is_trash <>" 		=> "1"
					))->result()
				));			
			}
		}else{
			$this->breadcrumb[] = array(
				"title"		=> "Add"
			);		
			$this->_v($this->folder_view.$this->prefix_view."_form",array(
				'group'		=> $this->db->get_where("app_acl_group",array(
					"ag_group_status"	=>	"1",
					"is_trash <>" 		=> "1"
				))->result()
			));						
		}			
	}

	function edit(){

		$this->breadcrumb[] = array(
			"title"		=> "Edit"
		);
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));

		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
				'user_id'	=> $id
			));
			$role = array();
			$role_tmp = $this->db->get_where("app_user_group",array(
				"ug_user_id"	=> $id
			))->result();	

			foreach ((array)$role_tmp as $k => $v) {
				$role[] = $v->ug_group_id;
			}	
			$this->_v($this->folder_view.$this->prefix_view."_form",array(
				'group'		=> $this->db->get_where("app_acl_group",array(
					"ag_group_status"	=>	"1",
					"is_trash <>" => "1"	
				))->result(),
				'role'		=> $role
			));
		}else{
			redirect($this->own_link);
		}
	}

	function delete(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id) != ''){
			$o = $this->DATA->_delete(
				array("user_id"	=> idClean($id))
			);

		}
		redirect($this->own_link."?msg=".urldecode('Delete data user succes')."&type_msg=success");
	}

	function save(){
		$get_domisili = $this->db->query("
			select *
			from app_user where user_id = '".$this->input->post('data_manager')."'
			")->row();//as

		if($_POST['user_group'] == 34 || $_POST['user_group'] == 35){
			$propinsi = $get_domisili->user_province;
			$pengusul = $get_domisili->penggunaID;			
		}else{
			$propinsi = dbClean($_POST['kta_propinsi']);
			$pengusul = dbClean($_POST['kta_pemesan']);						
		}

		$data = array(
			'user_fullname'			=> dbClean($_POST['user_fullname']),
			'user_name'				=> dbClean($_POST['user_name']),
			'user_email'			=> dbClean($_POST['user_email']),
			'user_province'			=> $propinsi,
			'user_tingkat'			=> dbClean($_POST['tingkat']),
			'user_limit'			=> dbClean($_POST['user_limit']),
			'col1'					=> dbClean($_POST['data_manager']),
			'user_status'			=> isset($_POST['user_status'])?1:0
		);		

		if (isset($_POST['mobile'])) {
			$data['user_password'] = $_POST['user_password'];
		}		
		else
		{
			if( isset($_POST['user_password']) && trim($_POST['user_password']) != ''){
				$data['user_password'] = md5(dbClean($_POST['user_password']));
			}
		}		

		$a = $this->_save_master( 
			$data,
			array(
				'user_id' => dbClean($_POST['user_id'])
			),
			dbClean($_POST['user_id'])			
		);

		$id = $a['id'];

		if(isset($_POST['user_group']) && count($_POST['user_group']) > 0){
			$this->db->delete("app_user_group",array(
				"ug_user_id"	=> $id
			));
			foreach ((array)$_POST['user_group'] as $k => $v) {
				$this->db->insert("app_user_group",array(
					"ug_user_id"	=> $id,
					"ug_group_id"	=> $v,
					"ug_status"		=> 1
				));
			}
		}

		$this->_uploaded(
			array(
				'id'		=> $id ,
				'input'		=> 'user_photo',
				'param'		=> array(
					'field' => 'user_photo', 
					'par'	=> array('user_id' => $id)
				)
			));

		redirect($this->own_link."?msg=".urldecode('Save data user success')."&type_msg=success");
	}

}