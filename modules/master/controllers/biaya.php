<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Biaya extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Biaya Kirim');
		$this->DATA->table="app_biaya_kirim";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Biaya Kirim",
				"url"		=> $this->own_link
			);

		$this->is_search_date = false;

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
		}
		
	
		$this->cat_search = array(
			''				=> 'All',
			'propinsi_nama'	=> 'Trayek',
			'bk_biaya'		=> 'Biaya Kirim',
			'bk_kurir'		=> 'Kurir',
			
		); 
		$this->load->model("mdl_master","M");

		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/datatables/jquery.dataTables.min.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
	}

	
	function _reset(){
		$this->jCfg['search'] = $this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'bk_id',
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
				$this->jCfg['search']['colum'] = $this->sCfg['search']['colum'] = $this->input->post('colum');
			else
				$this->jCfg['search']['colum'] = $this->sCfg['search']['colum'] = "";	

			if($this->input->post('keyword') && trim($this->input->post('keyword'))!="")
				$this->jCfg['search']['keyword'] = $this->sCfg['search']['keyword'] = $this->input->post('keyword');
			else
				$this->jCfg['search']['keyword'] = $this->sCfg['search']['keyword'] = "";

			$this->_releaseSession();
		}

		if($this->input->post('btn_reset')){
			$this->_reset();
		}

		$this->per_page = 100;

		$par_filter = array(
				"offset"	=> $this->uri->segment($this->uri_segment),
				"limit"		=> $this->per_page,
				"param"		=> $this->cat_search
			);
		$this->data_table = $this->M->biaya($par_filter);
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
					'bk_id'	=> $id
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
				array("kab_id"	=> idClean($id)),
				TRUE
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data kecamatan succes')."&type_msg=success");
	}

	function save(){

		$data = array(
			'bk_tujuan'	=> $this->input->post('bk_tujuan'),
			'bk_biaya'		=> $this->input->post('bk_biaya'),
			'bk_kurir'		=> $this->input->post('bk_kurir'),
			'bk_tanggal'	=> date('Y-m-d H:i:s'),
			'bk_user'		=> $this->jCfg['user']['id']
		);		

		$a = $this->_save_master( 
			$data,
			array(
				'bk_id' => dbClean($_POST['bk_id'])
			),
			dbClean($_POST['bk_id'])			
		);
	
		redirect($this->own_link."?msg=".urldecode('Save / Update data kecamatn succes')."&type_msg=success");
	}

}