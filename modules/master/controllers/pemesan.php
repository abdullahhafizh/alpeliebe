<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Pemesan extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title('Master Data Pengusul');
		$this->DATA->table="app_pengguna";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->upload_path="./assets/collections/photo/"; 

		$this->breadcrumb[] = array(
				"title"		=> "Pemesan",
				"url"		=> $this->own_link
			);

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
		}
		
	
		$this->cat_search = array(
			''						=> 'All',
			'nama_pengguna'			=> 'Nama Pemesan',
			'propinsi_nama'			=> 'Propinsi Domisili'
		); 
		$this->load->model("mdl_master","M");
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
	}
	
	function cek_user(){
		echo _ajax_cek(array(
			"field" => "user_name",
			"table"	=> "iapi_user"
		));
	}
	
	function _reset(){
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'name'		=> 'pengguna',
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'penggunaID',
			'order_dir' => 'DESC',
			'colum'		=> '',
			'keyword'	=> ''
		);
		$this->_releaseSession();
	}

	function index(){
		$hal = isset($this->jCfg['search']['name'])?$this->jCfg['search']['name']:"home";
		if($hal != 'pengguna'){
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
		$this->data_table = $this->M->pengguna($par_filter);
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
					'penggunaID'	=> $id
				));
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
				array("penggunaID"	=> idClean($id))
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data user succes')."&type_msg=success");
	}

	function save(){
		$data = array(
			'tingkat_pengguna'			=> dbClean($_POST['tingkat']),
			'nama_pengguna'			=> dbClean($_POST['user_fullname']),
			'notelp_pengguna'		=> dbClean($_POST['user_phone']),
			'email_pengguna'		=> dbClean($_POST['user_email']),
			'propinsi_id'			=> dbClean($_POST['propinsi']),
			'is_trash'				=> 0,
			'status_pengguna'		=> isset($_POST['user_status'])?1:0
		);		
				
		$a = $this->_save_master( 
			$data,
			array(
				'penggunaID' => dbClean($_POST['penggunaID'])
			),
			dbClean($_POST['penggunaID'])			
		);

		$id = $a['id'];

		$this->_uploaded(
		array(
			'id'		=> $id ,
			'input'		=> 'user_photo',
			'param'		=> array(
							'field' => 'user_photo', 
							'par'	=> array('user_id' => $id)
						)
		));
	
		redirect($this->own_link."?msg=".urldecode('Data Pemesan Kartu Berhasil di Update')."&type_msg=success");
	}

}