<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class News extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title('System Update Notification');
		$this->DATA->table="app_news";
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
			'news_fullname'			=> 'Full Name',
			'news_email'			=> 'Email'
		); 
		$this->load->model("mdl_news","M");
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
	}
	
	function cek_news(){
		echo _ajax_cek(array(
			"field" => "news_name",
			"table"	=> "iapi_news"
		));
	}
	
	function _reset(){
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'name'		=> 'news',
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'news_id',
			'order_dir' => 'DESC',
			'colum'		=> '',
			'keyword'	=> ''
		);
		$this->_releaseSession();
	}

	function index(){
		$hal = isset($this->jCfg['search']['name'])?$this->jCfg['search']['name']:"home";
		if($hal != 'news'){
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

		$this->per_page = 20;

		$par_filter = array(
			"offset"	=> $this->uri->segment($this->uri_segment),
			"limit"		=> $this->per_page,
			"param"		=> $this->cat_search
		);
		$this->data_table = $this->M->news($par_filter);
		$data = $this->_data(array(
			"base_url"	=> $this->own_link.'/index'
		));
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	

	function add(){	
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

	function edit(){

		$this->breadcrumb[] = array(
			"title"		=> "Edit"
		);
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));

		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
				'news_id'	=> $id
			));
			$role = array();
			$role_tmp = $this->db->get_where("app_news_group",array(
				"ug_news_id"	=> $id
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
				array("news_id"	=> idClean($id))
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data news succes')."&type_msg=success");
	}

	function save(){
		// $data = array(
		// 	'news_title'			=> dbClean($_POST['news_title']),
		// 	'news_body'				=> dbClean($_POST['news_body']),
		// );		
		// $a = $this->_save_master( 
		// 	$data,
		// 	array(
		// 		'news_id' => dbClean($_POST['news_id'])
		// 	),
		// 	dbClean($_POST['news_id'])			
		// );


		// redirect($this->own_link."?msg=".urldecode('Notification Updated')."&type_msg=success");
		// echo "Underconstruction";
	}

}