<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pendaftaran_kartu extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Pengaturan Pendaftaran KTA');
		$this->DATA->table="app_kta";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "KTA",
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
			'kta_tipe'					=> 'Tipe',
			'kta_nama_lengkap'			=> 'Nama Lengkap',
			'kta_jenkel'				=> 'Gender',
			'kta_tempat_lahir'			=> 'Tempat Lahir',
			'kta_tgl_lahir'				=> 'Tanggal Lahir',
			'propinsi_nama'				=> 'Provinsi',
			'kab_nama'					=> 'Kabupaten',
			'kec_nama'					=> 'Kecamatan',
			'kta_nama_koperasi'			=> 'Nama Koperasi',
			'kta_telp'					=> 'Telp',
			'kta_hp'					=> 'HP'
			
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

		$this->per_page = 10;

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
					'kta_id'	=> $id
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
				array("kta_id"	=> idClean($id)),
				TRUE
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data KTA succes')."&type_msg=success");
	}

	function save(){
		$get_max = $this->db->query("
			select max(SUBSTRING(kta_nomor,-5)) as nomor
			from app_kta where kta_nomor !=''
		")->row();
		
		$get_kd_prop = $this->db->query("
			select propinsi_kode
			from app_propinsi where propinsi_id = '".$this->input->post('kta_propinsi')."'
		")->row();

		$get_kd_kab = $this->db->query("
			select kab_kode
			from app_kabupaten where kab_id = '".$this->input->post('kta_kabupaten')."'
		")->row();

		$get_kd_kec = $this->db->query("
			select kec_kode
			from app_kecamatan where kec_id = '".$this->input->post('kta_kecamatan')."'
		")->row();

		$get_kd_kop = $this->db->query("
			select coop_code
			from app_koperasi where coop_id = '".$this->input->post('kta_koperasi')."'
		")->row();

		$idx = isset($get_max->nomor)&&trim($get_max->nomor)!=0?(int)$get_max->nomor+1:1;
		$nomor_kta = str_repeat("0", 5-strlen($idx)).$idx;
		if($this->input->post('kta_tipe') == 0){
			$kode_koperasi = "00000";
			$nomor_kartu = $get_kd_prop->propinsi_kode.$get_kd_kab->kab_kode.$get_kd_kec->kec_kode."00000".$nomor_kta;
		}else{
			$kode_koperasi = $this->input->post('kta_koperasi');			
			$nomor_kartu = $get_kd_prop->propinsi_kode.$get_kd_kab->kab_kode.$get_kd_kec->kec_kode.$get_kd_kop->coop_code.$nomor_kta;
		}
		$tgl_lahir = $this->input->post('kta_thn_lahir')."-".$this->input->post('kta_bln_lahir')."-".$this->input->post('kta_tgl_lahir');
		$data = array(
			'kta_nomor'			=> $nomor_kta,
			'kta_tipe'			=> $this->input->post('kta_tipe'),
			'kta_nama_lengkap'	=> $this->input->post('kta_nama_lengkap'),
			'kta_jenkel'		=> $this->input->post('kta_jenkel'),
			'kta_tgl_lahir'		=> $tgl_lahir,
			'kta_tempat_lahir'	=> $this->input->post('kta_tempat_lahir'),
			'kta_no_id'			=> $this->input->post('kta_no_id'),
			'kta_pekerjaan'		=> $this->input->post('kta_pekerjaan'),
			'kta_koperasi'		=> $kode_koperasi,
			'kta_propinsi'		=> $this->input->post('kta_propinsi'),
			'kta_kabupaten'		=> $this->input->post('kta_kabupaten'),
			'kta_kecamatan'		=> $this->input->post('kta_kecamatan'),
			'kta_telp'			=> $this->input->post('kta_telp'),
			'kta_hp'			=> $this->input->post('kta_hp'),
			'kta_type_ktp'		=> $this->input->post('kta_type_ktp'),
			'kta_alamat'		=> $this->input->post('kta_alamat'),
			'kta_email'			=> $this->input->post('kta_email'),
			'kta_agama'			=> $this->input->post('kta_agama'),
			'kta_status_asuransi'	=> '0',
			'kta_status'		=> '1',			
			'kta_nomor_kartu'	=> $nomor_kartu
		);	
		
		if( trim($data['kta_type_wajah']) == 'foto'){
			$data['kta_foto_wajah'] = $this->input->post('kta_foto_wajah');
			$data['kta_foto_wajah_ori'] = $this->input->post('kta_foto_wajah');
		}

		if( trim($data['kta_type_ktp']) == 'foto'){
			$data['kta_foto_ktp'] = $this->input->post('kta_foto_ktp');
		}


		$a = $this->_save_master( 
			$data,
			array(
				'kta_id' => dbClean($_POST['kta_id'])
			),
			dbClean($_POST['kta_id'])			
		);

		$id = $a['id'];

		if( trim($data['kta_type_wajah']) == 'upload'){
			$p = $this->_uploaded(
			array(
				'id'		=> $id ,
				'input'		=> 'upload_foto_wajah',
				'param'		=> array(
								'field' => 'kta_foto_wajah', 
								'par'	=> array('kta_id' => $id)
							)
			));

			if( isset($p['file_name']) && trim($p['file_name'])!="" ){
				$this->db->update("app_kta",array(
						'kta_foto_wajah_ori'	=> $p['file_name']
					),array(
						'kta_id' => $id
					));
			}
		}

		if( trim($data['kta_type_ktp']) == 'upload'){
			$m = $this->_uploaded(
			array(
				'id'		=> $id ,
				'input'		=> 'upload_foto_id',
				'param'		=> array(
								'field' => 'kta_foto_ktp', 
								'par'	=> array('kta_id' => $id)
							)
			));
		}

		redirect($this->own_link."/add?msg=".urldecode('Save / Update data KTA succes')."&type_msg=success");
	}

}