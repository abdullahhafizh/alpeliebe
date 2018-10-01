<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Kartu_txt extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		error_reporting(E_ALL);
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Download .txt');
		$this->DATA->table="app_kta";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Download .txt",
				"url"		=> $this->own_link
			);

		$this->upload_path="./assets/collections/salesdraft/";

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''					=> 'All',
			'kta_nama_lengkap'	=> 'Nama Lengkap',
			'kta_jenkel'		=> 'Gender',
			'kta_tgl_lahir'		=> 'Tanggal Lahir',
			
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

		$this->per_page = 100;

		if($this->jCfg['page_tab']==3){

			$par_filter = array(
                "offset"    => $this->uri->segment($this->uri_segment),
                "limit"     => $this->per_page,
                "type_data" => 2,
                "param"     => $this->cat_search
				);
			$this->data_table = $this->M->kta($par_filter);

		}else{
			$par_filter = array(
					"offset"	=> $this->uri->segment($this->uri_segment),
					"limit"		=> $this->per_page,
					"type_data" => 2,
					"param"		=> $this->cat_search
				);
			$this->data_table = $this->M->kta($par_filter);
		}
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
			$mo = $this->M->kta(array(
					'id'	=> $id
				));			
			$this->data_form = $mo['data'][0];
			$this->_v($this->folder_view.$this->prefix_view."_form",array());
		}else{
			redirect($this->own_link);
		}
	}
	
	function cetak_bayar(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));

		if(trim($id)!=''){
			$mo = $this->M->kta(array(
					'id'	=> $id
				));			
			$this->data_form = $mo['data'][0];
			$this->_v($this->folder_view.$this->prefix_view."_cetak",array(),false);
		}else{
			redirect($this->own_link);
		}
	}

	function cetak_bayar_collective(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		$data = array();
		if(trim($id)!=''){
			$val = $this->db->get("app_bayar_kolektif",array(
					"kol_id"	=> $id
				))->row();
			$items = $this->db->query("
					SELECT app_kta.kta_nomor,app_kta.kta_nama_lengkap,app_kta.kta_jumlah_bayar 
					FROM app_kta, app_bayar_kolektif_item 
					where app_kta.kta_id = app_bayar_kolektif_item.ki_kartu_id
					AND 
						app_bayar_kolektif_item.ki_kol_id = '".$id."'
				")->result();
			$this->_v($this->folder_view.$this->prefix_view."_cetak_kolektif",array(
					"items" => $items,
					"m"		=> $val
				),false);
		}else{
			redirect($this->own_link);
		}
	}

	function cetak_kartu(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));

		if(trim($id)!=''){
			$mo = $this->M->kta(array(
					'id'	=> $id
				));			
			$this->data_form = $mo['data'][0];
			
			/*if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$targ_w = $targ_h = 150;
				$jpeg_quality = 90;
			
				$src = 'demo_files/pool.jpg';
				$img_r = imagecreatefromjpeg($src);
				$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			
				imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
				$targ_w,$targ_h,$_POST['w'],$_POST['h']);
			
				header('Content-type: image/jpeg');
				imagejpeg($dst_r,null,$jpeg_quality);
			
				exit;
			}*/

			$this->_v($this->folder_view.$this->prefix_view."_kartu",array(),false);
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

	function collective(){
		if(isset($_POST['item']) && count($_POST['item'])>0){
			$par_filter = array(
				"tab_lunas"	=> $this->jCfg['page_tab'],
				"in_id"		=> $this->input->post('item')
			);			
			$cetak = $this->M->kta($par_filter);
			$this->_v($this->folder_view.$this->prefix_view."_export",$cetak,false);
		}else{
			redirect($this->own_link."?msg=".urldecode('Pilih Data KTA yang akan dibayar')."&type_msg=error");
		}
	}

	function save_collective(){

		if(isset($_POST['item']) && count($_POST['item'])>0){

			foreach ((array)$_POST['item'] as $k => $v) {
				$this->DATA->table = "app_kta";
				$data = array(
					'is_cetak'			=> 1,					
				);	

				$m = $this->db->get_where("app_kta",array(
					"kta_id"	=> $v
				))->row();

				$get_max = $this->db->query("
					select max(SUBSTRING(kta_nomor,-6)) as nomor
					from app_kta where kta_nomor !='' AND 
					SUBSTRING(kta_nomor,-10,2) ='".date("y")."'
				")->row();

				$idx = isset($get_max->nomor)&&trim($get_max->nomor)!=0?(int)$get_max->nomor+1:1;
				$id_prop = (int)$m->kta_propinsi>9?$m->kta_propinsi:"0".$m->kta_propinsi;
				$nomor_kta = date("y").$id_prop.str_repeat("0", 6-strlen($idx)).$idx;
				$data['kta_nomor'] = $nomor_kta;

				$a = $this->_save_master( 
					$data,
					array(
						'kta_id' => $v
					),
					dbClean($v)			
				);

			$par_filter = array(
				"tab_lunas"	=> $this->jCfg['page_tab'],
				"in_id"		=> $this->input->post('item')
			);
			}
			$data = $this->M->kta($par_filter);
			$this->_v($this->folder_view.$this->prefix_view."_export",$data,false);
		}else{
			redirect($this->own_link."?msg=".urldecode('Pilih Data KTA yang akan dibayar')."&type_msg=error");
		}		
	
	}

	function save(){

		$data = array(
			'kta_jumlah_bayar'	=> $this->input->post('kta_jumlah_bayar'),
			'kta_lunas'			=> $this->input->post('kta_lunas'),
			'kta_no_kartu'		=> $this->input->post('kta_no_kartu'),
			'kta_approval_code'	=> $this->input->post('kta_approval_code'),
			'kta_jenis_bayar'	=> $this->input->post('kta_jenis_bayar'),
			'kta_note_bayar'	=> $this->input->post('kta_note_bayar'),
			'kta_tgl_bayar'		=> date("Y-m-d H:i:s"),
			'kta_tgl_bayar_2'	=> date("Y-m-d"),
			'kta_start_date'	=> date("Y-m-d"),
			'kta_end_date'		=> mDate(date("Y-m-d"),"+1 years","Y-m-d")
		);	

		if($data['kta_lunas'] ==  1){
			$data['kta_status'] =  1;
			$m = $this->db->get_where("app_kta",array(
					"kta_id"	=> $this->input->post('kta_id')
				))->row();

			$get_max = $this->db->query("
				select max(SUBSTRING(kta_nomor,-6)) as nomor
				from app_kta where kta_nomor !='' AND 
				SUBSTRING(kta_nomor,-10,2) ='".date("y")."'
			")->row();

			$idx = isset($get_max->nomor)&&trim($get_max->nomor)!=0?(int)$get_max->nomor+1:1;
			$id_prop = (int)$m->kta_propinsi>9?$m->kta_propinsi:"0".$m->kta_propinsi;
			$nomor_kta = date("y").$id_prop.str_repeat("0", 6-strlen($idx)).$idx;
			$data['kta_nomor'] = $nomor_kta;
		}
		
		$a = $this->_save_master( 
			$data,
			array(
				'kta_id' => dbClean($_POST['kta_id'])
			),
			dbClean($_POST['kta_id'])			
		);

		$this->upload_types = "file";
		$md = $this->_uploaded(
		array(
			'id'		=> $a['id'],
			'input'		=> 'kta_salesdraft',
			'folder'	=> 'files',
			'param'		=> array(
							'field' => 'kta_salesdraft', 
							'par'	=> array('kta_id' => $a['id'])
						)
		));
		//debugCode($md);
		redirect($this->own_link."?msg=".urldecode('Save / Update data KTA succes')."&type_msg=success");
	}
	function export(){
			$par_filter = array(
				"tab_lunas"	=> $this->jCfg['page_tab'],
				"in_id"		=> $this->input->post('item')
			);
			$data = $this->M->kta($par_filter);
			$this->_v($this->folder_view.$this->prefix_view."_export",$data);
	}

}