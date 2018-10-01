<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Event extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('List Acara HNSI');
		$this->DATA->table="app_kecamatan";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Kecamatan",
				"url"		=> $this->own_link
			);

		$this->is_search_date = false;

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''						=> 'All',
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
			'plugins/bootstrap/bootstrap-select.js',
			'plugins/summernote/summernote.js'
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
		$data = array();
		$req_get 	= array(
						  "group" 		=> 'Group|A157742F-77DE-F5A4-4E44-EC109EA70F06', 
						  "sessionid" 	=> $_SESSION['sesiLogin'], 
			);
		$req = getEvent(json_encode($req_get));
//		debugCode($req_get);
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));
		$data['event'] = $req['data'];
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}
	function search(){

		$this->breadcrumb[] = array(
				"title"		=> "List"
			);

		if($this->input->post('btn_reset')){
			$this->_reset();
		}

		$par_filter = array(
				"offset"	=> $this->uri->segment($this->uri_segment),
				"propinsi"	=> $this->input->post('propinsi'),
				"kabupaten"	=> $this->input->post('kta_kabupaten'),
				"param"		=> $this->cat_search
			);
		$this->data_table = $this->M->kecamatan($par_filter);
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));
		$data['param'] = array(
			"propinsi" => trim($this->input->post('propinsi')),
			"kabupaten" => trim($this->input->post('kta_kabupaten'))
		);
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
					'kec_id'	=> $id
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
				array("kec_id"	=> idClean($id)),
				TRUE
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data kecamatan succes')."&type_msg=success");
	}

	function save(){
		$kode_kecamatan = $this->input->post('kab_propinsi_id').substr($this->input->post('kec_kab_id'),2,2).$this->input->post('kec_kode');
		$data = array(
			'kec_nama'				=> $this->input->post('kec_nama'),
			'kec_kode'				=> $kode_kecamatan,
			'kec_kab_id'			=> $this->input->post('kec_kab_id'),
			'kec_prop_id'			=> $this->input->post('kab_propinsi_id'),
			'kec_status'			=> $this->input->post('kab_status')
		);		

		$a = $this->_save_master( 
			$data,
			array(
				'kec_id' => dbClean($_POST['kec_id'])
			),
			dbClean($_POST['kec_id'])			
		);
	
		redirect($this->own_link."?msg=".urldecode('Data Kecamatan '.$this->input->post('kec_nama').' dengan Kecamatan Kode '.$kode_kecamatan.' Berhasil Di Update / Ditambah')."&type_msg=success");
	}

}