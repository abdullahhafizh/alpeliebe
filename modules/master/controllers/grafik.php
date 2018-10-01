<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Grafik extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Report Anggota');
		$this->DATA->table="app_kta";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());
		$this->breadcrumb[] = array(
				"title"		=> "KTA",
				"url"		=> $this->own_link
			);
		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''					=> 'All',
			'kta_nama_lengkap'	=> 'Nama Lengkap',
			'kta_jenkel'		=> 'Jenis Kelamin',
			'kta_tgl_lahir'		=> 'Tanggal Lahir',
			'kta_agama'			=> 'Agama',
			'kta_email'			=> 'Email',
			'kta_propinsi'		=> 'Provinsi',
			'kta_kabupaten'		=> 'Kabupaten',
			'kta_telp'			=> 'Telp',
			'kta_hp'			=> 'HP'
			
		); 
		$this->load->model("mdl_master","M");

		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js',
			'plugins/webcamjs/webcam.js'
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
			'type'		=> 'summary',
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
				$this->sCfg['search']['date_start'] = $this->input->post('date_start');

			if($this->input->post('date_end') && trim($this->input->post('date_end'))!="")
				$this->sCfg['search']['date_end'] = $this->input->post('date_end');

			if($this->input->post('colum') && trim($this->input->post('colum'))!="")
				$this->sCfg['search']['colum'] = $this->input->post('colum');
			else
				$this->sCfg['search']['colum'] = "";	

			if($this->input->post('keyword') && trim($this->input->post('keyword'))!="")
				$this->sCfg['search']['keyword'] = $this->input->post('keyword');
			else
				$this->sCfg['search']['keyword'] = "";


			if($this->input->post('type_search') && trim($this->input->post('type_search'))!="")
				$this->sCfg['search']['type'] = $this->input->post('type_search');
			else
				$this->sCfg['search']['type'] = "summary";

			$this->_releaseSession();
		}

		if($this->input->post('btn_reset')){
			$this->_reset();
		}

		$this->per_page = 20;
		$par_filter = array(
				"wilayah"	=> true
			);
		$data['wilayah'] = $this->M->kta_summary($par_filter);

		$par_filter = array(
				"status"	=> true
			);
		$data['status'] = $this->M->kta_summary($par_filter);

		$par_filter = array(
				"jenkel"	=> true
			);
		$data['jenkel'] = $this->M->kta_summary($par_filter);


		$par_filter = array(
				"pekerjaan"	=> true
			);
		$data['pekerjaan'] = $this->M->kta_summary($par_filter);
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	function export(){

		$par_filter = array(
				"wilayah"	=> true
			);
		$data['wilayah'] = $this->M->kta_summary($par_filter);

		$par_filter = array(
				"tipe"	=> true
			);
		$data['tipe'] = $this->M->kta_summary($par_filter);

		$par_filter = array(
				"status"	=> true
			);
		$data['status'] = $this->M->kta_summary($par_filter);

		$par_filter = array(
				"jenkel"	=> true
			);
		$data['jenkel'] = $this->M->kta_summary($par_filter);

		$this->_v($this->folder_view.$this->prefix_view."_export",$data,false);

	}

}