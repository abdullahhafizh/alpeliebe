<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Data_komisariat extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Pengaturan Data Komisariat Insancita');
		$this->DATA->table="jcow_komisariat";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Komisariat",
				"url"		=> $this->own_link
			);

		$this->is_search_date = false;

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''						=> 'All',
			'komisariat_name'		=> 'Nama Komisariat',
			'cabang_name'			=> 'Nama Cabang',
			'badko_name'			=> 'Nama Badko'
			
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
			'order_by'  => 'komisariat_id',
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
		$this->data_table = $this->M->komisariat($par_filter);
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
					'komisariat_id'	=> $id
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
				array("komisariat_id"	=> idClean($id)),
				TRUE
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data cabang succes')."&type_msg=success");
	}

	function save(){

		$data = array(
			'komisariat_name'			=> $this->input->post('komisariat_name'),
			'komisariat_cabang_id'		=> $this->input->post('komisariat_cabang_id'),
			'komisariat_badko_id'		=> $this->input->post('komisariat_badko_id'),
			'komisariat_status'			=> $this->input->post('komisariat_status')
		);		

		$a = $this->_save_master( 
			$data,
			array(
				'komisariat_id' => dbClean($_POST['komisariat_id'])
			),
			dbClean($_POST['komisariat_id'])			
		);

		//debugCode($a);
	
		redirect($this->own_link."?msg=".urldecode('Save / Update data cabang succes')."&type_msg=success");
	}

}