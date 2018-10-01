<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Capture_photo extends AdminController {  
	function __construct()    
	{
		parent::__construct();    
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title( 'Capture Photo' );
		$this->DATA->table="app_kta";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());
		
		$this->breadcrumb[] = array(
				"title"		=> "Capture Photo",
				"url"		=> $this->own_link
			); 
			            
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
	}

	function index(){
		
		$this->js_file = array(
                'capture-photo.js?r='.rand(1,1000)
            );
            
		$this->breadcrumb[] = array(
				"title"		=> "Form"
			);
			
		$data = array();

		$this->_v($this->folder_view.$this->prefix_view,$data);
	}
	
	function get_city(){
		$id = $this->input->post('id');
		
		$data = array(
			"city" => array()
		);
		
		if( trim($id)!="" ){
			
			$this->DATA->table="app_kabupaten";
			$this->db->order_by("kab_nama","ASC");
			$city = $this->DATA->_getall(array('kab_propinsi_id' => $id));
			
			$data['city'] = $city;
		}
		
		die(json_encode($data));
	}
	
	function get_district(){
		$id = $this->input->post('id');
		
		$data = array(
			"district" => array()
		);
		
		if( trim($id)!="" ){
			
			$this->DATA->table="app_kecamatan";
			$this->db->order_by("kec_nama","ASC");
			$district = $this->DATA->_getall(array('kec_kab_id' => $id));
			
			$data['district'] = $district;
		}
		
		die(json_encode($data));
	}
	
	function get_area(){
		$id = $this->input->post('id');
		
		$data = array(
			"area" => array()
		);
		
		if( trim($id)!="" ){
			
			$this->DATA->table="app_kelurahan";
			$this->db->order_by("kel_nama","ASC");
			$area = $this->DATA->_getall(array('kel_kec_id' => $id));
			
			$data['area'] = $area;
		}
		
		die(json_encode($data));
	}

	function save(){
		$get_max = $this->db->query("
			select max(SUBSTRING(kta_nomor,-5)) as nomor
			from app_kta where kta_nomor !='' AND kta_kelurahan = '".$this->input->post('kta_kelurahan')."'
		")->row();

		$get_kd_prop = $this->db->query("
			select propinsi_kode
			from app_propinsi where propinsi_kode = '".$this->input->post('kta_propinsi')."'
		")->row();

		$get_kd_kab = $this->db->query("
			select kab_kode
			from app_kabupaten where kab_kode = '".$this->input->post('kta_kabupaten')."'
		")->row();

		$get_kd_kec = $this->db->query("
			select kec_kode
			from app_kecamatan where kec_kode = '".$this->input->post('kta_kecamatan')."'
		")->row();

		$get_kd_kel = $this->db->query("
			select kel_kode
			from app_kelurahan where kel_kode = '".$this->input->post('kta_kelurahan')."'
		")->row();
		
		$idx 				= isset($get_max->nomor)&&trim($get_max->nomor)!=0?(int)$get_max->nomor+1:1;
		$tanggal_kirim 		= date("Y-m-d h:i:s");
		$nomor_kta 			= str_repeat("0", 6-strlen($idx)).$idx;
		$nk					= substr($nomor_kta,2,4);
		$nomor_kartu 		= $get_kd_kec->kec_kode.$get_kd_kel->kel_kode.$nk;
		$kta_jenkel 		= !empty($_POST['kta_jenkel'])?$_POST['kta_jenkel']:"";
		$tgl_lahir 			= $this->input->post('kta_thn_lahir')."-".$this->input->post('kta_bln_lahir')."-".$this->input->post('kta_tgl_lahir');

//		$num = $this->DATA->_add(array('kta_no_id' => $this->input->post('kta_no_id')));
//		if($num == 0) {
			$status = array('Data anggota baru berhasil disimpan','success');		
			$ftext = $this->input->post('ftext');
			$ctext = $this->input->post('ctext');
			
			$fname = $this->input->post('kta_no_id')."_wajah";					
			$fname_with_ext = (!empty($ftext))? save_base64_image($ftext, $fname, './assets/collections/kta/photo/') : "";
					
			$cname = $this->input->post('kta_no_id')."_ktp";					
			$cname_with_ext = (!empty($ctext))? save_base64_image($ctext, $cname, './assets/collections/kta/photo/') : "";
			
			$data = array(
				'kta_nomor'			=> $nomor_kta,
				'kta_jenkel'		=> $kta_jenkel,
				'kta_tempat_lahir'	=> $this->input->post('kta_tempat_lahir'),
				'kta_tgl_lahir'		=> $tgl_lahir,
				'kta_nama_lengkap'	=> strtoupper($this->input->post('kta_nama_lengkap')),
				'kta_no_id'			=> $this->input->post('kta_no_id'),
				'kta_alamat'		=> $this->input->post('kta_alamat'),
				'kta_rt'			=> $this->input->post('kta_rt'),
				'kta_rw'			=> $this->input->post('kta_rw'),
				'kta_kodepos'		=> $this->input->post('kta_kodepos'),
				'kta_propinsi'		=> $this->input->post('kta_propinsi'),
				'kta_kabupaten'		=> $this->input->post('kta_kabupaten'),
				'kta_kecamatan'		=> $this->input->post('kta_kecamatan'),
				'kta_kelurahan'		=> $this->input->post('kta_kelurahan'),
				'kta_status_data'	=> 9,
				'kta_status'		=> '99',			
				'is_cetak'			=> '0',			
				'kta_nomor_kartu'	=> $nomor_kartu,
				'kta_foto_wajah'    => $fname_with_ext,
				'kta_foto_ktp'    	=> $cname_with_ext
			);
					
			$s = $this->DATA->_add($data);
			if(!$s) $status = array('Data anggota baru gagal disimpan','danger');
			
			redirect($this->own_link."?msg=".urldecode($status[0])."&type_msg=".$status[1]);
//		} else redirect($this->own_link."?msg=".urldecode("Data sudah ditemukan dalam database")."&type_msg=warning");		
	}

}