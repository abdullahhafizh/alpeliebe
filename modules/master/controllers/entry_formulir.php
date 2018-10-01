<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Entry_formulir extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Entry Data Anggota BPP KKSS');
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
			'kta_hp'					=> 'HP'
			
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
			'plugins/datatables/jquery.dataTables.min.js',
//			'plugins/blueimp/jquery.blueimp-gallery.min.js',
			'cropper/docs/v0.7.9/js/cropper.min.js',
			'zoom/jquery.elevateZoom-3.0.8.min.js'
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

		$this->per_page = 1000;

		$par_filter = array(
				"offset"	=> $this->uri->segment($this->uri_segment),
				"limit"		=> $this->per_page, 
				"type_data"	=> 2, 
				"param"		=> $this->cat_search
			);
		$this->data_table = $this->M->upload_kta($par_filter);
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
			select max(SUBSTRING(kta_nomor,-6)) as nomor
			from app_kta where kta_nomor !='' AND kta_kabupaten = '".$this->input->post('kta_kabupaten')."'
		")->row();

		$get_npapg = $this->db->query("
			select kta_nomor_kartu, kta_foto_wajah
			from app_kta where kta_id = '".$this->input->post('kta_id')."'
		")->row();

		$get_ktp = $this->db->query("
			select count(kta_no_id) as ktp
			from app_kta where kta_no_id = '".$this->input->post('kta_no_ktp')."'
		")->row();
		
		$get_kd_prop = $this->db->query("
			select propinsi_kode, negara_kode
			from app_propinsi where propinsi_kode = '".$this->input->post('kta_propinsi')."'
		")->row();

		$get_kd_kab = $this->db->query("
			select kab_kode
			from app_kabupaten where kab_kode = '".$this->input->post('kta_kabupaten')."'
		")->row();

		$tgl_lahir = $this->input->post('kta_thn_lahir')."-".$this->input->post('kta_bln_lahir')."-".$this->input->post('kta_tgl_lahir');

			$a = "";
			if(!empty($_POST['hastakarya'])) {
				foreach($_POST['hastakarya'] as $check) {
						$koma = $check<count($_POST['hastakarya'])-1?",":"";
						$a = $a.$check.$koma;
				}
			}else{
				$a = "";
			}
			if(!empty($_POST['trikarya'])) {
				$trikarya = $_POST['trikarya'];
			}else{
				$trikarya = "";
			}
			if(!empty($_POST['sayap'])) {
				$sayap = $_POST['sayap'];
			}else{
				$sayap = "";
			}
			$kta_jenkel 		= !empty($_POST['kta_jenkel'])?$_POST['kta_jenkel']:"";
			$kta_agama 			= !empty($_POST['kta_agama'])?$_POST['kta_agama']:"";
			$kta_pendidikan 	= !empty($_POST['kta_pendidikan'])?$_POST['kta_pendidikan']:"";
			$kta_pekerjaan 		= !empty($_POST['kta_pekerjaan'])?$_POST['kta_pekerjaan']:"";
			$idx 				= isset($get_max->nomor)&&trim($get_max->nomor)!=0?(int)$get_max->nomor+1:1;
			$tanggal_kirim 		= date("Y-m-d h:i:s");
			$nomor_kta 			= str_repeat("0", 6-strlen($idx)).$idx;
			$nk					= substr($nomor_kta,0,6);
			$nomor_kartu 		= empty($_POST['kta_npapg'])?$get_kd_prop->negara_kode.$get_kd_kab->kab_kode.$nk:$_POST['kta_npapg'];
 			$today 				= date("Y-m-d H:i:s");
			$nu					= empty($_POST['kta_nomor'])?$nomor_kta:$_POST['kta_nomor'];

			$data = array(
				'kta_nomor'			=> $nu,
				'kta_jenkel'		=> $kta_jenkel,
				'kta_tempat_lahir'	=> $this->input->post('kta_tempat_lahir'),
				'kta_tgl_lahir'		=> $tgl_lahir,
				'kta_nama_lengkap'	=> strtoupper($this->input->post('kta_nama_lengkap')),
				'kta_no_id'			=> $this->input->post('kta_no_ktp'),
				'kta_alamat'		=> $this->input->post('kta_alamat'),
				'kta_rt'			=> $this->input->post('kta_rt'),
				'kta_rw'			=> $this->input->post('kta_rw'),
				'kta_kodepos'		=> $this->input->post('kta_kodepos'),
				'kta_propinsi'		=> $this->input->post('kta_propinsi'),
				'kta_kabupaten'		=> $this->input->post('kta_kabupaten'),
				'kta_kecamatan'		=> $this->input->post('kta_kecamatan'),
				'kta_kelurahan'		=> $this->input->post('kta_kelurahan'),
				'kta_jabatan'		=> $this->input->post('kta_jabatan'),
				'kta_divisi'		=> $this->input->post('kta_divisi'),
				'kta_status_data'	=> '1',
				'kta_status'		=> '1',			
				'is_cetak'			=> '0',			
				'kta_nomor_kartu'	=> $nomor_kartu
			);
						
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);				
				$id = $a['id'];				
				$this->data_form = $this->DATA->data_id(array(
						'kta_id'	=> $id
				));			
				$this->_v($this->folder_view.$this->prefix_view."_detail",array());
	}
	
	function detail(){
			$data = array(
				'kta_status_data'				=> '0',			
			);						
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);				

		redirect($this->own_link."?msg=".urldecode('Data KTA atas Nama '.$_POST['kta_nama'].' dengan nomor NIK '.$_POST['kta_npapg'].' Berhasil di Entry')."&type_msg=success");
	}
	
	function reject(){
			$today = date("Y-m-d H:i:s");
			$data = array(
				'kta_status_data'				=> '3',			
				'col6'							=> $this->input->post('ket_reject'),
				'col11'							=> $this->jCfg['user']['fullname'],				
				'time_reject_scan' 				=> $today
			);						
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);
		redirect($this->own_link."?msg=".urldecode('Data telah di-reject dan dikembalikan ke operator data scan')."&type_msg=success");
	}
	function crop(){
		$uId = uniqid();
		$wajah = $this->input->post('data_wajah');
		$ewajah = $this->input->post('exist_wajah');
		$ktp = $this->input->post('data_ktp');
		$ektp = $this->input->post('exist_ktp');
		
		if(isset($_POST['skip_crop'])){
			$this->data_form = $this->DATA->data_id(array(
				'kta_id'	=> dbClean($_POST['kta_id'])
			));			
			$this->_v($this->folder_view.$this->prefix_view."_form_entry",array());									
		}else{	
			if(empty($wajah) && empty($ktp)){
				redirect($this->own_link."?msg=".urldecode('Pastikan Foto & KTP sudah di crop')."&type_msg=danger");			
			}else{				
				$wnama = $uId.$this->input->post('kta_ktp')."_wajah";					
				if(!empty($wajah)) save_base64_image($wajah, $wnama, './assets/collections/kta/photo/');
				
				$knama = $uId.$this->input->post('kta_ktp')."_ktp";					
				if(!empty($ktp)) save_base64_image($ktp, $knama, './assets/collections/kta/photo/');
				$data = array(
							'kta_foto_wajah'	=> $wnama.".png",
							'kta_foto_ktp'		=> $knama.".png"
//							'kta_foto_wajah'	=> !empty($wajah)?$wnama.".png":(!empty($ewajah)?$ewajah:""),
//							'kta_foto_ktp'		=> !empty($ktp)?$knama.".png":(!empty($ektp)?$ektp:"")
				);										
				
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);
				$id = $a['id'];				
				$this->data_form = $this->DATA->data_id(array(
					'kta_id'	=> $id
				));			
				$this->_v($this->folder_view.$this->prefix_view."_form_entry",array());	
				
//				$nama_foto = $this->input->post('kta_ktp')."foto_wajah";
//				$foto = save_base64_image($foto[0], $nama_foto, './assets/collections/kta/photo/');
				/*for($i=0;$i<count($foto);$i++){
					$nama = $this->input->post('kta_ktp')."_".$i;					
					save_base64_image($foto[$i], $nama, './assets/collections/kta/photo/');
					if($i==0){
						$data = array(
		//					'kta_foto_wajah'	=> $foto[0],
		//					'kta_foto_ktp'		=> $foto[1],
							'kta_foto_wajah'	=> $nama."foto.png",
						);				
						
						$a = $this->_save_master( 
							$data,
							array(
								'kta_id' => dbClean($_POST['kta_id'])
							),
							dbClean($_POST['kta_id'])			
						);										
					}else{
						$data = array(
		//					'kta_foto_wajah'	=> $foto[0],
		//					'kta_foto_ktp'		=> $foto[1],
							'kta_foto_ktp'		=> $nama."ktp.png",
						);										
						$a = $this->_save_master( 
							$data,
							array(
								'kta_id' => dbClean($_POST['kta_id'])
							),
							dbClean($_POST['kta_id'])			
						);																
					}
				}*/					
			}
		}

	}
	function show_table(){
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
		  
		  $this->per_page=10;
		  $par_filter = array(
//				"offset"	=> $start,
//				"limit"		=> $length, 				
				"type_data"	=> 2, 
				"param"		=> $this->cat_search
			);
		$this->data_table = $this->M->upload_kta($par_filter);
		$data = $this->data_table;
//     	debugCode(count($data));
        foreach($data['data'] as $r){
			if($r->kta_status_data == 0 ){
				$status =  '<span class="label label-warning">Entry</span>';
			}elseif($r->kta_status_data == 1 ){
				$status =  '<span class="label label-success">Approved</span>';								
			}elseif($r->kta_status_data == 2 ){
				$status =  '<span class="label label-info">Registered</span>';								
			}else{
				$status =  '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="'.$r->col6.'">Rejected</span>';																		  
			}
			$id = _encrypt($r->kta_id);
			$url = $this->own_link."/edit/?_id=".$id;
			$edit = "<a href='$url'><span class='label label-default label-form' data-toggle='tooltip' data-placement='top' title data-original-title='Edit'><li class='fa fa-edit'></li></span></a>";
			  $upload[] = array(
						++$no,
						$r->time_add,
						$r->kta_nama_lengkap,
						$r->kta_email,
						$r->kta_hp,
						$status,
						"<a href='$url'><span class='label label-default label-form' data-toggle='tooltip' data-placement='top' title data-original-title='Edit'><li class='fa fa-edit'></li></span></a>"
               );
			}
			$output = array(
				 "draw" => $draw,
                 "recordsTotal" => count($data),
                 "recordsFiltered" => count($data),
                 "data" => $upload
            );
//		  debugCode(json_encode($upload, JSON_UNESCAPED_SLASHES));
		  echo json_encode($output, JSON_UNESCAPED_SLASHES);
          exit();
     }
}