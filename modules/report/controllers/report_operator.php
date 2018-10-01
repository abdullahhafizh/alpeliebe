<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Report_operator extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		error_reporting(E_ALL);
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Report Operator Data Scan & Entry');
		$this->DATA->table="app_kta";
		$this->folder_view = "report/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Report Operator Data Scan & Entry",
				"url"		=> $this->own_link
			);

		$this->upload_path="./assets/collections/salesdraft/";

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''					=> 'All',
			'kta_tipe'			=> 'Tipe',
			'kta_nama_lengkap'	=> 'Nama Lengkap',
			'kta_jenkel'		=> 'Gender',
			'kta_tgl_lahir'		=> 'Tanggal Lahir',
			'kta_email'			=> 'Email',
			'kta_propinsi'		=> 'Provinsi',
			'coop_name'			=> 'Koperasi',			
		); 

		$this->load->model("mdl_report","M");

		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js',
			'plugins/datatables/jquery.dataTables.min.js',
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
			'keyword'	=> ''
		);
		$this->sCfg['page_tab'] = '1';
		$this->_releaseSession();
	}

	function set_tab(){
		$tab = $this->input->get('tab');
		$this->sCfg['page_tab'] = $tab;
		$this->_releaseSession();

		$next = $this->own_link;
		if(isset($_GET['next'])){
			$next = $_GET['next'];
		}

		redirect($next);
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
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));

			$data['param'] = array(
				"koordata" => trim($this->input->post('koordinator')),
				"operator" => trim($this->input->post('operator')),
				"date_from" => trim($this->input->post('date_from')),
				"date_to" => trim($this->input->post('date_to'))
			);

		$this->_v($this->folder_view.$this->prefix_view,$data);
	}
}