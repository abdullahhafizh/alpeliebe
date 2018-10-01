<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Pendaftaran_kartu extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Pendaftaran KTA-PG');
		$this->DATA->table="app_kta";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "KTA-PG",
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
			'kta_hp'					=> 'HP',
			'nama_pengguna'				=> 'Nama Pengusul'
			
		); 
		$this->load->model("mdl_master","M");
		
		$this->css_file = array(
			'cropper/v0.7.9/css/cropper.min.css',
			'cropper/v0.7.9/css/main.css'
//			'cropper/cropper.min.css'
		);
		
		//load js..
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js',
			'plugins/webcamjs/webcam.js',
			'plugins/fileinput/fileinput.min.js',
//			'plugins/blueimp/jquery.blueimp-gallery.min.js',
			'cropper/docs/v0.7.9/js/cropper.min.js'
//			'cropper/docs/v0.7.9/js/main2.js'
//			'plugins/dropzone/dropzone.min.js',
//			'plugins/filetree/jqueryFileTree.js',
//			'plugins/jstree/jstree.min.js',
//			'plugins/cropper/cropper.min.js'
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
			from app_kta where kta_nomor !='' AND kta_kelurahan = '".$this->input->post('kta_kelurahan')."' AND kta_kecamatan = '".$this->input->post('kta_kecamatan')."'
		")->row();

		$get_ktp = $this->db->query("
			select count(kta_no_id) as ktp
			from app_kta where kta_no_id = '".$this->input->post('kta_no_ktp')."'
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

		$tgl_lahir = $this->input->post('kta_thn_lahir')."-".$this->input->post('kta_bln_lahir')."-".$this->input->post('kta_tgl_lahir');


		$idx = isset($get_max->nomor)&&trim($get_max->nomor)!=0?(int)$get_max->nomor+1:1;
		$nomor_kta = str_repeat("0", 6-strlen($idx)).$idx;
		$tanggal_kirim = date("Y-m-d h:i:s");
		$nomor_kartu = $get_kd_kel->kel_kode.$nomor_kta;
		$foto = $this->input->post('data_url');
		
		if(empty($_POST['kta_id'])){
			$data = array(
				'kta_nomor'			=> $nomor_kta,
				'kta_nama_lengkap'	=> strtoupper($this->input->post('kta_nama_lengkap')),
				'kta_jenkel'		=> $this->input->post('kta_jenkel'),
				'kta_tempat_lahir'	=> $this->input->post('kta_tempat_lahir'),
				'kta_tgl_lahir'		=> $tgl_lahir,
//				'kta_umur'			=> $umur,
				'kta_agama'			=> $this->input->post('kta_agama'),
				'kta_email'			=> $this->input->post('kta_email'),
				'kta_telp'			=> $this->input->post('kta_telp'),
				'kta_hp'			=> $this->input->post('kta_hp'),
				'kta_alamat'		=> $this->input->post('kta_alamat'),
				'kta_propinsi'		=> $this->input->post('kta_propinsi'),
				'kta_kabupaten'		=> $this->input->post('kta_kabupaten'),
				'kta_kecamatan'		=> $this->input->post('kta_kecamatan'),
				'kta_kelurahan'		=> $this->input->post('kta_kelurahan'),
				'kta_status_nikah'	=> $this->input->post('kta_status_nikah'),
				'kta_namasuami'		=> $this->input->post('kta_nama_pasangan'),
				'kta_pekerjaan'		=> $this->input->post('kta_pekerjaan'),
				'kta_pendidikan'	=> $this->input->post('kta_pendidikan'),
				'kta_tingkatan'		=> $this->input->post('kta_tingkat'),
				'kta_jabatan'		=> $this->input->post('kta_jabatan'),
				'kta_facebook'		=> $this->input->post('kta_sosmed_fb'),
				'kta_instagram'		=> $this->input->post('kta_sosmed_ig'),
				'kta_twitter'		=> $this->input->post('kta_sosmed_twitter'),				
				'kta_pemesan'		=> $this->input->post('kta_pemesan'),
				'kta_tingkatan_provinsi'		=> $this->input->post('kta_tingkatan_provinsi'),
				'kta_tingkatan_kecamatan'		=> $this->input->post('kta_tingkatan_kecamatan'),
				'kta_tingkatan_kabkota'		=> $this->input->post('kta_tingkatan_kabkota'),
				'kta_tingkatan_desa'		=> $this->input->post('kta_tingkatan_desa'),				
				'kta_hastakarya'		=> $this->input->post('kta_hastakarya'),				
				'kta_nomor_kartu_old'	=> $this->input->post('kta_nomor_kartu_old'),
				'kta_no_id'		=> $this->input->post('kta_no_ktp'),
				'kta_type_lampiran1'		=> $this->input->post('kta_type_lampiran1'),
				'kta_type_lampiran2'		=> $this->input->post('kta_type_lampiran2'),
				'kta_status'		=> '1',			
				'kta_status_data'	=> '1',			
				'is_cetak'			=> '0',			
				'kta_nomor_kartu'	=> $nomor_kartu,
				'nama_user'		=> $this->jCfg['user']['fullname'],
				'col3'				=> $this->jCfg['user']['fullname'],
				'kta_foto_wajah'	=> $foto[0],
				'kta_foto_ktp'		=> $foto[1]
//				'kta_jenis_bayar'   => $this->input->post('kta_bayar')
			);				
		}else{
			$data = array(
				'kta_nama_lengkap'	=> strtoupper($this->input->post('kta_nama_lengkap')),
				'kta_jenkel'		=> $this->input->post('kta_jenkel'),
				'kta_tempat_lahir'	=> $this->input->post('kta_tempat_lahir'),
				'kta_tgl_lahir'		=> $tgl_lahir,
//				'kta_umur'			=> $umur,
				'kta_agama'			=> $this->input->post('kta_agama'),
				'kta_email'			=> $this->input->post('kta_email'),
				'kta_telp'			=> $this->input->post('kta_telp'),
				'kta_hp'			=> $this->input->post('kta_hp'),
				'kta_alamat'		=> $this->input->post('kta_alamat'),
				'kta_propinsi'		=> $this->input->post('kta_propinsi'),
				'kta_kabupaten'		=> $this->input->post('kta_kabupaten'),
				'kta_kecamatan'		=> $this->input->post('kta_kecamatan'),
				'kta_kelurahan'		=> $this->input->post('kta_kelurahan'),
				'kta_status_nikah'	=> $this->input->post('kta_status_nikah'),
				'kta_namasuami'		=> $this->input->post('kta_nama_pasangan'),
				'kta_pekerjaan'		=> $this->input->post('kta_pekerjaan'),
				'kta_nomor_kartu_old'	=> $this->input->post('kta_nomor_kartu_old'),
				'kta_pendidikan'		=> $this->input->post('kta_pendidikan'),
				'kta_tingkatan'		=> $this->input->post('kta_tingkat'),
				'kta_jabatan'		=> $this->input->post('kta_jabatan'),
				'kta_pemesan'		=> $this->input->post('kta_pemesan'),
				'kta_tingkatan_provinsi'		=> $this->input->post('kta_tingkatan_provinsi'),
				'kta_tingkatan_kecamatan'		=> $this->input->post('kta_tingkatan_kecamatan'),
				'kta_tingkatan_kabkota'		=> $this->input->post('kta_tingkatan_kabkota'),
				'kta_tingkatan_desa'		=> $this->input->post('kta_tingkatan_desa'),				
				'kta_hastakarya'		=> $this->input->post('kta_hastakarya'),				
				'kta_nomor_kartu_old'	=> $this->input->post('kta_nomor_kartu_old'),
				'kta_no_id'		=> $this->input->post('kta_no_ktp'),
				'kta_type_lampiran1'		=> $this->input->post('kta_type_lampiran1'),
				'kta_type_lampiran2'		=> $this->input->post('kta_type_lampiran2'),
//				'kta_jenis_bayar'   => $this->input->post('kta_bayar')
			);						
			
			if(!empty($foto[0]) && !empty($foto[1])){
				$data['kta_foto_wajah']	= $foto[0];
				$data['kta_foto_ktp']	= $foto[1];
			}
		}

		if(empty($_POST['kta_id'])){
			if($get_ktp->ktp == 0){
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);				
				$id = $a['id'];
				$p = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_1',
					'param'		=> array(
									'field' => 'kta_lampiran1', 
									'par'	=> array('kta_id' => $id)
								)
				));
				
				$m = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_2',
					'param'		=> array(
									'field' => 'kta_lampiran2', 
									'par'	=> array('kta_id' => $id)
								)
				));

				//redirect($this->own_link."/add?msg=".urldecode('Save / Update data KTA success')."&type_msg=success&pengusul=".$this->input->post('kta_pemesan')."");			
				$this->data_form = $this->DATA->data_id(array(
						'kta_id'	=> $id
					));			
				$this->_v($this->folder_view.$this->prefix_view."_detail",array());
			}else{
				redirect($this->own_link."/add?msg=".urldecode('No KTP / NIK sudah Terdaftar')."&type_msg=error");						
			}
		}else{
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);				
				$id = $a['id'];
				$p = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_1',
					'param'		=> array(
									'field' => 'kta_lampiran1', 
									'par'	=> array('kta_id' => $id)
								)
				));
				
				
				$m = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_2',
					'param'		=> array(
									'field' => 'kta_lampiran2', 
									'par'	=> array('kta_id' => $id)
								)
				));
					$this->data_form = $this->DATA->data_id(array(
							'kta_id'	=> $id
						));			
					$this->_v($this->folder_view.$this->prefix_view."_detail",array());
	
		}
		

	}
	
	function detail(){

		$data = array(
			'kta_status_data'	=> 1
		);	
		$a = $this->_save_master( 
			$data,
			array(
				'kta_id' => dbClean($_POST['kta_id'])
			),
			dbClean($_POST['kta_id'])			
		);

		redirect($this->own_link."/add"."?msg=".urldecode('Save / Update data KTA success')."&type_msg=success");
	}

}