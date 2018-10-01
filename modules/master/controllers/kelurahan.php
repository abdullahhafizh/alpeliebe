<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Kelurahan extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Data Kelurahan (Sesuai Data KPU)');
		$this->DATA->table="app_kelurahan";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Kelurahan",
				"url"		=> $this->own_link
			);

		$this->is_search_date = false;

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''						=> 'All',
			'kel_nama'				=> 'Nama Kelurahan',
			'kec_nama'				=> 'Nama Kecamatan',
			'kab_nama'				=> 'Nama Kabupaten',
			'propinsi_nama'			=> 'Nama Provinsi'
			
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
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'kec_id',
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
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	function search(){

		$this->breadcrumb[] = array(
				"title"		=> "List"
			);
			
		$data = array();	
		if(isset($_POST['btn_search'])){
			if($this->input->post('propinsi') && trim($this->input->post('propinsi'))!="")
				$this->jCfg['propinsi'] = $this->input->post('propinsi');

			if($this->input->post('kta_kabupaten') && trim($this->input->post('kta_kabupaten'))!="")
				$this->jCfg['kabupaten'] = $this->input->post('kta_kabupaten');

			if($this->input->post('kta_kecamatan') && trim($this->input->post('kta_kecamatan'))!="")
				$this->jCfg['kecamatan'] = $this->input->post('kta_kecamatan');
						
			// debugCode($data); 
			$par_filter = array(
					"offset"	=> $this->uri->segment($this->uri_segment),
					"propinsi"	=> $this->input->post('propinsi'),
					"kabupaten"	=> $this->input->post('kta_kabupaten'),
					"kecamatan"	=> $this->input->post('kta_kecamatan'),
					"param"		=> $this->cat_search
				);
			$this->data_table = $this->M->kelurahan($par_filter);
			$data = $this->_data(array(
					"base_url"	=> $this->own_link.'/index'
				));
						
			$data['param'] = array(
				"propinsi" => trim($this->input->post('propinsi')),
				"kabupaten" => trim($this->input->post('kta_kabupaten')),
				"kecamatan" => trim($this->input->post('kta_kecamatan'))
			);
			
			$this->_v($this->folder_view.$this->prefix_view,$data);
		}

		if($this->input->post('btn_reset')){
			$this->_reset();
		}

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
					'kel_id'	=> $id
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
				array("kel_id"	=> idClean($id)),
				TRUE
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data kelurahan succes')."&type_msg=success");
	}

	function save(){

		$data = array(
			'kel_kode'				=> $this->input->post('kel_kode'),
			'kel_nama'				=> $this->input->post('kel_nama'),
			'kel_kec_id'			=> $this->input->post('kta_kecamatan'),
			'kel_kab_id'			=> $this->input->post('kta_kabupaten'),
			'kel_prop_id'			=> $this->input->post('kta_propinsi'),
			'kel_status'			=> $this->input->post('kel_status')
		);		

		$a = $this->_save_master( 
			$data,
			array(
				'kel_id' => dbClean($_POST['kel_id'])
			),
			dbClean($_POST['kel_id'])			
		);
	
		redirect($this->own_link."?msg=".urldecode('Data Kelurahan '.$this->input->post('kel_nama').' dengan Kelurahan Kode '.$this->input->post('kel_kode').' Berhasil Di Update / Ditambah')."&type_msg=success");
	}

}