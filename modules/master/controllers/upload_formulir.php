<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Upload_formulir extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->DATA->table="app_kta";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Upload Scan Formulir",
				"url"		=> $this->own_link
			);

		$this->upload_path="./assets/collections/kta/";

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''							=> 'All',
			'kta_no_id'					=> 'NIK / No. KTP'
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
		$this->_set_title('Upload Scan Formulir');
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
				"type_data"	=> 3, 
				"param"		=> $this->cat_search
			);
		$this->data_table = $this->M->upload_kta($par_filter);
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));
//		debugCode($data);
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	

	function addktp(){	
		$this->_set_title('Upload Scan Formulir (KTP)');
		$this->breadcrumb[] = array(
				"title"		=> "Tambah KTP"
			);		
		$this->_v($this->folder_view.$this->prefix_view."_form",array());
	}

	function addsuket(){	
		$this->_set_title('Upload Scan Formulir (Suket)');
		$this->breadcrumb[] = array(
				"title"		=> "Tambah Suket"
			);		
		$this->_v($this->folder_view.$this->prefix_view."_suket_form",array());
	}

	function edit(){

		$this->breadcrumb[] = array(
				"title"		=> "Edit"
			);
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		$tipe = $this->db->get_where("app_kta",array(
				"kta_id" => $id
		))->row();
		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
					'kta_id'	=> $id
				));
			if($tipe->kta_tipe_kta == "SUKET"){
				$this->_v($this->folder_view.$this->prefix_view."_suket_form",array());			
			}else{
				$this->_v($this->folder_view.$this->prefix_view."_form",array());						
			}
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
			select count(kta_no_id) as j
			from app_kta where kta_no_id = '".$this->input->post('kta_no_ktp')."'
		")->row();
		if(empty($_POST['kta_id'])){
			if($get_max->j > 0){
				redirect($this->own_link."/addktp?msg=".urldecode('NIK SUDAH TERDAFTAR')."&type_msg=danger");			
			}else{
			$today = date("Y-m-d H:i:s");
			if($this->jCfg['user']['userrole'] == 33){
				$managerid = $this->jCfg['user']['id'];
			}else{
				$managerid = $this->jCfg['user']['managerid'];				
			}
			$data = array(
				'kta_tipe_kta'				=> 'KTP',
				'kta_no_id'					=> $this->input->post('kta_no_ktp'),
				'kta_type_lampiran1'		=> $this->input->post('kta_type_lampiran1'),
				'kta_type_lampiran2'		=> $this->input->post('kta_type_lampiran2'),
				'kta_status_data'			=> '2',			
				'kta_status_assign'			=> 0,							
				'kta_pemesan'				=> $this->input->post('kta_pemesan'),			
				'col3'						=> $this->jCfg['user']['fullname'],
				'col4'						=> $this->jCfg['user']['id'],				
				'col10'						=> $managerid,				
				'time_scan'					=> $today				
			);				
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);				
				$id = $a['id'];				

				$this->db->insert("app_kta_track",array(
						"kta_id"			=> $id,
						"date_track"		=> date("Y-m-d H:i:s"),
						"track_status"		=> "KTA Diupload",
						"track_notes"		=> "KTA KTP",
						"track_user"		=> $this->jCfg['user']['id'],
						"track_username"	=> $this->jCfg['user']['name'],						
						"track_user_name"	=> $this->jCfg['user']['fullname'],						
				));

				$p = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_1',
					'param'		=> array(
									'nama' => "_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_L1", 
									'field' => 'kta_lampiran1', 
									'par'	=> array('kta_id' => $id)
								)
				));
				
				$m = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_2',
					'param'		=> array(
									'nama' => "_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_L2", 
									'field' => 'kta_lampiran2', 
									'par'	=> array('kta_id' => $id)
								)
				));
				redirect($this->own_link."/detail/?_id="._encrypt($id));
			}
		}else{
						$today = date("Y-m-d H:i:s");
			if($this->jCfg['user']['userrole'] == 33){
				$managerid = $this->jCfg['user']['id'];
			}else{
				$managerid = $this->jCfg['user']['managerid'];				
			}
			$data = array(
				'kta_tipe_kta'				=> 'KTP',
				'kta_no_id'					=> $this->input->post('kta_no_ktp'),
				'kta_type_lampiran1'		=> $this->input->post('kta_type_lampiran1'),
				'kta_type_lampiran2'		=> $this->input->post('kta_type_lampiran2'),
				'kta_status_data'			=> '2',			
				'kta_status_assign'			=> 0,							
				'kta_pemesan'				=> $this->input->post('kta_pemesan'),			
				'col3'						=> $this->jCfg['user']['fullname'],
				'col4'						=> $this->jCfg['user']['id'],				
				'col10'						=> $managerid,				
				'time_scan'					=> $today				
			);				
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);				
				$id = $a['id'];
				$this->db->insert("app_kta_track",array(
						"kta_id"			=> $id,
						"date_track"		=> date("Y-m-d H:i:s"),
						"track_status"		=> "KTA upload diedit",
						"track_notes"		=> "KTA KTP",
						"track_user"		=> $this->jCfg['user']['id'],
						"track_username"	=> $this->jCfg['user']['name'],						
						"track_user_name"	=> $this->jCfg['user']['fullname'],						
				));
				$p = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_1',
					'param'		=> array(
									'nama' => "_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_L1", 
									'field' => 'kta_lampiran1', 
									'par'	=> array('kta_id' => $id)
								)
				));
				
				$m = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_2',
					'param'		=> array(
									'nama' => "_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_L2", 
									'field' => 'kta_lampiran2', 
									'par'	=> array('kta_id' => $id)
								)
				));
				redirect($this->own_link."/detail/?_id="._encrypt($id));
			}
	}
	
	function save_suket(){
		$get_max = $this->db->query("
			select count(kta_no_id) as j
			from app_kta where kta_no_id = '".$this->input->post('kta_no_ktp')."'
		")->row();
		if(empty($_POST['kta_id'])){
		if($get_max->j ==  0){
			$today = date("Y-m-d H:i:s");
			if($this->jCfg['user']['userrole'] == 33){
				$managerid = $this->jCfg['user']['id'];
			}else{
				$managerid = $this->jCfg['user']['managerid'];				
			}
			$data = array(
				'kta_tipe_kta'				=> 'SUKET',
				'kta_no_id'					=> $this->input->post('kta_no_ktp'),
				'kta_type_lampiran1'		=> $this->input->post('kta_type_lampiran1'),
				'kta_type_lampiran2'		=> $this->input->post('kta_type_lampiran2'),
				'kta_status_data'			=> '2',			
				'kta_status_data'			=> '2',			
				'kta_status_assign'			=> 0,							
				'kta_pemesan'				=> $this->input->post('kta_pemesan'),			
				'col3'						=> $this->jCfg['user']['fullname'],
				'col4'						=> $this->jCfg['user']['id'],				
				'col10'						=> $managerid,				
				'time_scan'					=> $today				
			);				
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);				
				$id = $a['id'];
				$this->db->insert("app_kta_track",array(
						"kta_id"			=> $id,
						"date_track"		=> date("Y-m-d H:i:s"),
						"track_status"		=> "KTA Diupload",
						"track_notes"		=> "KTA SUKET",
						"track_user"		=> $this->jCfg['user']['id'],
						"track_username"	=> $this->jCfg['user']['name'],						
						"track_user_name"	=> $this->jCfg['user']['fullname'],						
				));
				$p = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_1',
					'param'		=> array(
									'nama' => "_".date("Y-m-d")."_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_L1", 
									'field' => 'kta_lampiran1', 
									'par'	=> array('kta_id' => $id)
								)
				));
				
				$m = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_2',
					'param'		=> array(
									'nama' => "_".date("Y-m-d")."_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_L2", 
									'field' => 'kta_lampiran2', 
									'par'	=> array('kta_id' => $id)
								)
				));
				
				$n = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_3',
					'param'		=> array(
									'nama' => "_".date("Y-m-d")."_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_suket", 
									'field' => 'kta_lampiran3', 
									'par'	=> array('kta_id' => $id)
								)
				));

/*				
				$this->data_form = $this->DATA->data_id(array(
						'kta_id'	=> $id
					));			
				$this->_v($this->folder_view.$this->prefix_view."_detail",array());
*/
				redirect($this->own_link."/suket_detail/?_id="._encrypt($id));
		}else{
			redirect($this->own_link."/addsuket"."?msg=".urldecode('NIK / NO SUKET SUDAH TERDAFTAR')."&type_msg=danger");			
		}
		}else{
			$today = date("Y-m-d H:i:s");
			if($this->jCfg['user']['userrole'] == 33){
				$managerid = $this->jCfg['user']['id'];
			}else{
				$managerid = $this->jCfg['user']['managerid'];				
			}
			$data = array(
				'kta_tipe_kta'				=> 'SUKET',
				'kta_no_id'					=> $this->input->post('kta_no_ktp'),
				'kta_type_lampiran1'		=> $this->input->post('kta_type_lampiran1'),
				'kta_type_lampiran2'		=> $this->input->post('kta_type_lampiran2'),
				'kta_status_data'			=> '2',			
				'kta_status_assign'			=> 0,							
				'kta_pemesan'				=> $this->input->post('kta_pemesan'),			
				'col3'						=> $this->jCfg['user']['fullname'],
				'col4'						=> $this->jCfg['user']['id'],				
				'col10'						=> $managerid,				
				'time_scan'					=> $today				
			);				
				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => dbClean($_POST['kta_id'])
					),
					dbClean($_POST['kta_id'])			
				);				
				$id = $a['id'];
				$this->db->insert("app_kta_track",array(
						"kta_id"			=> $id,
						"date_track"		=> date("Y-m-d H:i:s"),
						"track_status"		=> "KTA upload diedit",
						"track_notes"		=> "KTA SUKET",
						"track_user"		=> $this->jCfg['user']['id'],
						"track_username"	=> $this->jCfg['user']['name'],						
						"track_user_name"	=> $this->jCfg['user']['fullname'],						
				));
				$p = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_1',
					'param'		=> array(
									'nama' => "_".date("Y-m-d")."_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_L1", 
									'field' => 'kta_lampiran1', 
									'par'	=> array('kta_id' => $id)
								)
				));
				
				$m = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_2',
					'param'		=> array(
									'nama' => "_".date("Y-m-d")."_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_L2", 
									'field' => 'kta_lampiran2', 
									'par'	=> array('kta_id' => $id)
								)
				));
				$n = $this->_uploaded(
				array(
					'id'		=> $id ,
					'input'		=> 'upload_lampiran_3',
					'param'		=> array(
									'nama' => "_".date("Y-m-d")."_".$this->input->post('kta_pemesan')."_".$this->input->post('kta_no_ktp')."_suket", 
									'field' => 'kta_lampiran3', 
									'par'	=> array('kta_id' => $id)
								)
				));

				redirect($this->own_link."/suket_detail/?_id="._encrypt($id));
			}
	}

	function detail(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
					'kta_id'	=> $id
				));			
			$this->_v($this->folder_view.$this->prefix_view."_detail",array());
		}else{
			redirect($this->own_link);
		}
	}
	
	function suket_detail(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
					'kta_id'	=> $id	
				));			
			$this->_v($this->folder_view.$this->prefix_view."_suket_detail",array());
		}else{
			redirect($this->own_link);
		}
	}

	function save_detail(){
		redirect($this->own_link."/addktp"."?msg=".urldecode('data formulir dengan NIK '.$_POST['kta_ktp'].' berhasil di upload')."&type_msg=success");
	}
	function save_suket_detail(){
		redirect($this->own_link."/addsuket"."?msg=".urldecode('data formulir dengan No. SUKET '.$_POST['kta_ktp'].' berhasil di upload')."&type_msg=success");
	}
	
	function show_table(){
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
		  
		  $this->per_page=10;
		  $par_filter = array(
//				"offset"	=> $start,
//				"limit"		=> $length, 				
				"type_data"	=> 3, 
				"param"		=> $this->cat_search
			);
		$this->data_table = $this->M->upload_kta($par_filter);
		$data = $this->data_table;
        foreach($data['data'] as $r){
			$id = _encrypt($r->kta_id);
			$url = $this->own_link."/edit/?_id=".$id;
			if($r->kta_status_data == 0 ){
				$status =  '<span class="label label-warning">Entry</span>';
				$edit 	= '';
			}elseif($r->kta_status_data == 1 ){
				$status =  '<span class="label label-success">Approved</span>';								
				$edit 	= '';
			}elseif($r->kta_status_data == 2 ){
				$status =  '<span class="label label-info">Uploaded</span>';								
				$edit 	= "<a href='$url'><span class='label label-default label-form' data-toggle='tooltip' data-placement='top' title data-original-title='Edit'><li class='fa fa-edit'></li></span></a>";
			}else{
				$status =  '<span class="label label-danger" data-toggle="tooltip" data-placement="top" title data-original-title="'.$r->col6.'">Rejected</span>';				
				$edit 	= "<a href='$url'><span class='label label-default label-form' data-toggle='tooltip' data-placement='top' title data-original-title='Edit'><li class='fa fa-edit'></li></span></a>";
																		  
			}
			  $upload[] = array(
						++$no,
						$r->kta_tipe_kta,
						$r->nama_pengguna,
						$r->kta_no_id,
						$r->time_scan,
						$r->col3,
						$status,
						$r->col6,
						$edit
               );
//			debugCode($upload);
			}
			$output = array(
				 "draw" => $draw,
                 "recordsTotal" => count($data),
                 "recordsFiltered" => count($data),
                 "data" => $upload
            );
		  echo json_encode($output, JSON_UNESCAPED_SLASHES);
          exit();
     }
}