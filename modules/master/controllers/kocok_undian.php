<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Kocok_undian extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Pengaturan Kocok Undian');
		$this->DATA->table="app_kocok_undian";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Kocok Undian",
				"url"		=> $this->own_link
			);

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
		if( !isset($this->sCfg['kocok']) ){
			$this->sCfg['kocok'] = array(
				'event' 	=> '',
				'umur'		=> 0,
				'jenkel'	=> '',
				'tipe'		=> '',
				'jumlah'	=> 0,
				'prov'		=> 0,
				'kab'		=> 0,
				'ket'		=> '',
				'hadiah'	=> ''
			);
			$this->_releaseSession();
		}
	
		$this->cat_search = array(
			''						=> 'All',
			'kocok_nama'			=> 'Nama'
			
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
			'order_by'  => 'kocok_id',
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
		$this->data_table = $this->M->kocok_undian($par_filter);
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
					'kocok_id'	=> $id
				));		
			$this->_v($this->folder_view.$this->prefix_view."_form",array());
		}else{
			redirect($this->own_link);
		}
	}
	
	function kocok(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id) != ''){
			
			$this->data_form = $this->DATA->data_id(array(
					'kocok_id'	=> $id
				));

			$this->db->order_by("kd_id","DESC");
			$detail_kocok = $this->db->get_where("app_kocok_undian_detail",array(
					"kd_kocok_id"	=> $id
				))->result();	
 
			$data = array();
			if( isset($_POST['btn_search']) ){
				$par = array(
					'event' 	=> $this->input->post('event'),
					'umur'		=> $this->input->post('umur'),
					'jenkel'	=> $this->input->post('jenkel'),
					'tipe'		=> $this->input->post('tipe'),
					'prov'		=> $this->input->post('prov'),
					'kab'		=> $this->input->post('kab'),
					'jumlah'	=> $this->input->post('jumlah'),
					'ket'		=> $this->input->post('desc'),
					'hadiah'	=> $this->input->post('hadiah')
				);
				$this->sCfg['kocok'] = $par;
				$this->_releaseSession();

				$data = $this->M->kocok_search($par);
				$this->_v($this->folder_view.$this->prefix_view."_kocok",array(
					"data"	=> $data,
					"par"	=> $par,
					"detail"=> $detail_kocok
				));
			}elseif( isset($_POST['btn_simpan']) ){
				$data_detail = array(
						"kd_name" 	=> $this->input->post('desc'),
						"kd_hadiah"	=> $this->input->post('hadiah'),
						"kd_date"	=> date("Y-m-d H:i:s"),
						"kd_umur"	=> $this->input->post('umur'),
						"kd_tipe"	=> $this->input->post('tipe'),
						"kd_prov"	=> $this->input->post('prov'),
						"kd_kab"	=> $this->input->post('kab'),
						"kd_jenkel"	=> $this->input->post('jenkel'),
						"kd_jumlah"	=> $this->input->post('jumlah'),
						"kd_event"	=> $this->input->post('event'),
						"kd_user"	=> $this->jCfg['user']['id'],
						"kd_kocok_id" => $this->input->post('kocok_id')
					);
				$this->db->insert('app_kocok_undian_detail',$data_detail);
				$id_detail = $this->db->insert_id();
				if( isset($_POST['items']) && count($_POST['items']) > 0 ){
					foreach ((array)$_POST['items'] as $p => $q) {
						$this->db->insert("app_kocok_undian_pemenang",array(
								"kp_kocok_id"	=> $this->input->post('kocok_id'),
								"kp_kd_id"		=> $id_detail,
								"kp_kta_id"		=> $q,
								"kp_date"		=> date("Y-m-d H:i:s")
							));
					}
				}
				redirect($this->own_link."/kocok?_id="._encrypt($this->input->post('kocok_id'))."&msg=Success&type_msg=success");
			}else{
				$this->_v($this->folder_view.$this->prefix_view."_kocok",array(
					"data"	=> $data,
					"detail"=> $detail_kocok
				));
			}
		}else{
			redirect($this->own_link."?msg=".urldecode(' ID kosong')."&type_msg=error");
		}
	}

	function save(){

		$data = array(
			'kocok_nama'				=> $this->input->post('kocok_nama')
		);		

		$a = $this->_save_master( 
			$data,
			array(
				'kocok_id' => dbClean($_POST['kocok_id'])
			),
			dbClean($_POST['kocok_id'])			
		);
	
		redirect($this->own_link."?msg=".urldecode('Save / Update Kocok Undian succes')."&type_msg=success");
	}

}