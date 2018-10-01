<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Data_anggota extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Pengaturan Data Anggota');
		$this->DATA->table="jcow_accounts";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->upload_path="./assets/collections/photo/";

		$this->breadcrumb[] = array(
				"title"		=> "User",
				"url"		=> $this->own_link
			);

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''					=> 'All',
			'id'				=> 'ID',
			'username'			=> 'Username',
			'email'				=> 'Email',
			'fullname'			=> 'Nama Lengkap',
			'gender'			=> 'Jenkel',
			'birthyear'			=> 'Tanggal Lahir',
			'universitas'		=> 'Universitas',
			'badko_name'		=> 'Badko',
			'cabang_name'		=> 'Cabang',
			'komisariat_name'	=> 'Komisariat',
			'status'			=> 'Status'
			
		); 
		$this->load->model("mdl_master","M");

		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
	}

	
	function _reset(){
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'id',
			'order_dir' => 'DESC',
			'colum'		=> '',
			'keyword'	=> ''
		);
		$this->_releaseSession();
	}

	function index(){

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
		$this->data_table = $this->M->accounts($par_filter);
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));

		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	

	function add(){	
		$this->breadcrumb[] = array(
				"title"		=> "Add"
			);		
		$this->_v($this->folder_view.$this->prefix_view."_form",array());
	}

	function edit(){

		$this->breadcrumb[] = array(
				"title"		=> "Edit"
			);
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));

		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
					'id'	=> $id
				));			
			$this->_v($this->folder_view.$this->prefix_view."_form",array());
		}else{
			redirect($this->own_link);
		}
	}
	
	function delete(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id) != ''){
			$o = $this->DATA->_delete(
				array("id"	=> idClean($id)),
				TRUE
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data anggota succes')."&type_msg=success");
	}

	function save(){

		$birtdate = explode("-", $this->input->post('tgl_lahir'));
		$data = array(
			'fullname'			=> $this->input->post('fullname'),
			'email'				=> $this->input->post('email'),
			'gender'			=> $this->input->post('gender'),
			'about_me'			=> $this->input->post('about_me'),
			'universitas'		=> $this->input->post('universitas'),
			'alamat'			=> $this->input->post('alamat'),
			'hp'				=> $this->input->post('hp'),
			'status'			=> $this->input->post('status'),
			'pekerjaan'			=> $this->input->post('pekerjaan'),
			'perusahaan'		=> $this->input->post('perusahaan'),
			'jabatan'			=> $this->input->post('jabatan'),
			'alamat_kantor'		=> $this->input->post('alamat_kantor'),
			'jbtn'				=> $this->input->post('jbtn'),
			'bklk'				=> $this->input->post('bklk'),
			'badko'				=> $this->input->post('badko'),
			'cabang'			=> $this->input->post('cabang'),
			'komisariat'		=> $this->input->post('komisariat'),
			'lk1'				=> $this->input->post('lk1'),
			'lk2'				=> $this->input->post('lk2'),
			'lk3'				=> $this->input->post('lk3'),
			'birthyear'			=> $birtdate[0],
			'birthmonth'		=> $birtdate[1],
			'birthday'			=> $birtdate[2],
			'username'			=> $this->input->post('username'),
			'password'			=> $this->input->post('password')
		);		

		if(trim($data['password'])==""){
			unset($data['password']);
		}else{
			$data['password'] = md5($data['password']);
		}
		
		if( isset($_POST['user_password']) && trim($_POST['user_password']) != ''){
			$data['user_password'] = md5(dbClean($_POST['user_password']));
		}
		
		$a = $this->_save_master( 
			$data,
			array(
				'id' => dbClean($_POST['user_id'])
			),
			dbClean($_POST['user_id'])			
		);

		/*$id = $a['id'];

		$this->_uploaded(
		array(
			'id'		=> $id ,
			'input'		=> 'user_photo',
			'param'		=> array(
							'field' => 'user_photo', 
							'par'	=> array('user_id' => $id)
						)
		));

		*/
	
		redirect($this->own_link."?msg=".urldecode('Save / Update data anggota succes')."&type_msg=success");
	}

}