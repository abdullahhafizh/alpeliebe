<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Cropping_image extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Cropping Gambar');
		$this->DATA->table="app_kta";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Cropping Gambar",
				"url"		=> $this->own_link
			);

		$this->upload_path="./assets/collections/kta/";

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''							=> 'All',
			'kta_nomor'					=> 'Nomor Kartu',
			'kta_nama_lengkap'			=> 'Nama Lengkap',
			'kta_jenkel'				=> 'Gender',
			'kta_tempat_lahir'			=> 'Tempat Lahir',
			'kta_tgl_lahir'				=> 'Tanggal Lahir',
			'propinsi_nama'				=> 'Provinsi',
			'kab_nama'					=> 'Kabupaten',
			'kec_nama'					=> 'Kecamatan',
			'kel_nama'					=> 'Kelurahan',
			'kta_telp'					=> 'Telp',
			'kta_hp'					=> 'HP'
			
		); 
		$this->load->model("mdl_master","M");
		
		$this->css_file = array(
			'cropper/v0.7.9/css/cropper.min.css',
			'cropper/v0.7.9/css/main.css'
		);
		
		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js',
			'plugins/webcamjs/webcam.js',
			'plugins/fileinput/fileinput.min.js',
			'cropper/docs/v0.7.9/js/cropper.min.js'
		);
		
		$this->js_file = array(
			'cropper/docs/v0.7.9/js/main.js'
		);
	}

	
	function _reset(){
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'kta_id',
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
		$this->data_table = $this->M->kta($par_filter);
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));

		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	function edit(){

		$this->breadcrumb[] = array(
				"title"		=> "Edit"
			);
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));

		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
					'kta_id'	=> $id
				));			
			$this->_v($this->folder_view.$this->prefix_view."_form",array());
		}else{
			redirect($this->own_link);
		}
	}

	function save(){
		$foto = $this->input->post('data_url');
		
		$data = array(
			'kta_foto_wajah'	=> $foto[0],
			'kta_foto_ktp'		=> $foto[1]
		);				
		
		$a = $this->_save_master( 
			$data,
			array(
				'kta_id' => dbClean($_POST['kta_id'])
			),
			dbClean($_POST['kta_id'])			
		);
		
		redirect($this->own_link."?msg=".urldecode('Update image success')."&type_msg=success");			
	}

}