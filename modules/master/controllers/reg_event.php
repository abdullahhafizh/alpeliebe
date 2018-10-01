<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Reg_event extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM"); //"view"
		$this->_set_title('Pendaftaran Peserta Event/Kegiatan');
		$this->DATA->table="app_event";
		$this->folder_view = "master/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Reg Event",
				"url"		=> $this->own_link
			);

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
			redirect($this->own_link);
		}
		
	
		$this->cat_search = array(
			''						=> 'All',
			'event_name'			=> 'Nama Event',
			'event_start_date'		=> 'Tanggal Mulai',
			'event_end_date'		=> 'Tanggal Selesai',
			'propinsi_nama'			=> 'Provinsi',
			'kab_nama'				=> 'Kabupaten',
			'event_alamat'			=> 'Alamat'
			
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
			'order_by'  => 'event_id',
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
		$this->data_table = $this->M->event($par_filter);
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	function member(){
		$this->breadcrumb[] = array(
				"title"		=> "Edit"
			);
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
					'event_id'	=> $id
				));		
			
			$this->db->select('app_kta.*,app_event_subscriber.subs_date,app_propinsi.propinsi_nama,app_kabupaten.kab_nama');
			$this->db->join("app_kta","app_kta.kta_id = app_event_subscriber.subs_kta_id");
			$this->db->join('app_propinsi','app_propinsi.propinsi_id=app_kta.kta_propinsi');
			$this->db->join('app_kabupaten','app_kabupaten.kab_id=app_kta.kta_kabupaten');
			$this->db->order_by('app_event_subscriber.subs_date','DESC');
			$list = $this->db->get_where("app_event_subscriber",array(
				"subs_event_id"	=> $id,
			))->result();
					
			$this->_v($this->folder_view.$this->prefix_view."_member",array(
					"list"	=> $list
				));
		}else{
			redirect($this->own_link);
		}
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
					'event_id'	=> $id
				));		

			$this->db->order_by("uevent_id",'ASC');
			$undian = $this->db->get_where("app_undian_event",array(
					'uevent_event_id'	=> $id
				))->result();	
			$this->_v($this->folder_view.$this->prefix_view."_form",array(
					"undian"	=> $undian
				));
		}else{
			redirect($this->own_link);
		}
	}
	
	function delete(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id) != ''){
			$o = $this->DATA->_delete(
				array("event_id"	=> idClean($id)),
				TRUE
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data Subscriber succes')."&type_msg=success");
	}

	function save(){
	
		$m = $this->db->get_where("app_event_subscriber",array(
				"subs_event_id"	=> $this->input->post('event_id'),
				"subs_kta_id"	=> $this->input->post('kta_id')
			))->num_rows();

		if($m==0){
			$this->db->insert("app_event_subscriber",array(
				"subs_event_id"	=> $this->input->post('event_id'),
				"subs_kta_id"	=> $this->input->post('kta_id'),
				"subs_kta_no"	=> $this->input->post('kta_nomor'),
				"subs_date"		=> date("Y-m-d H:i:s"),
				"subs_status"	=> 1
			));
		}

		redirect($this->own_link."/edit?_id="._encrypt($this->input->post('event_id'))."&msg=".urldecode('Save / Update data Subscriber succes')."&type_msg=success");
	}

	//ajax..
	function get_kta(){
		$nomor = $this->input->post('nomor_kta');
		$data = $this->db->get_where("app_kta",array(
				"kta_nomor"	=> $nomor
			));
		$html = '';
		$res = array(
				"status" => 0,
				"html"   => ''
			);
		if( $data->num_rows > 0 ){
			$vm = $data->row();

			//cek expired...
            if($vm->kta_end_date < date("Y-m-d") ){
                $html = '<tr><td colspan="2" style="color:red;">Nomor Ini Sudah Expired Sejak '.myDate($vm->kta_end_date,"d M Y",false).', Silahkan diperpanjang dulu</td></tr>';
                $res = array(
                    "status" => 0,
                    "html"   => $html
                );
                die(json_encode($res));
            }

			$tipe_kta = cfg('tipe_kta');
			$jenkel = cfg('jenkel');

			$m = $this->db->get_where("app_event_subscriber",array(
				"subs_event_id"	=> $this->input->post('event_id'),
				"subs_kta_id"	=> $vm->kta_id
			))->num_rows();

			if( $m == 0 ){
				$mo = $this->M->kta(array(
						'id'	=> $vm->kta_id
					));			
				$v = $mo['data'][0];


				$html .= '<tr>
	                            <td width="200">Kategori KTA</td>
	                            <td>'.$tipe_kta[$v->kta_tipe].'<input type="hidden" name="kta_id" value="'.$v->kta_id.'" /></td>
	                          </tr>
	                           <tr>
	                            <td>Nama Lengkap</td>
	                            <td>'.$v->kta_nama_lengkap.'</td>
	                          </tr>
	                          <tr>
	                            <td>Jenis Kelamin</td>
	                            <td>'.$jenkel[$v->kta_jenkel].'</td>
	                          </tr>
	                          <tr>
	                            <td>Tanggal Lahir</td>
	                            <td>'.myDate($v->kta_tgl_lahir,"d M Y",false).'</td>
	                          </tr>
	                          <tr>
	                            <td>Email</td>
	                            <td>'.$v->kta_email.'</td>
	                          </tr>
	                          <tr>
	                            <td>Telp / Hp</td>
	                            <td>'.$v->kta_telp.' / '.$v->kta_hp.'</td>
	                          </tr>
	                          <tr>
	                            <td>Provinsi</td>
	                            <td>'.$v->propinsi_nama.'</td>
	                          </tr>
	                          <tr>
	                            <td>Kota</td>
	                            <td>'.$v->kab_nama.'</td>
	                          </tr>
	                          <tr>
	                            <td>Alamat</td>
	                            <td>'.$v->kta_alamat.'</td>
	                          </tr>';
	             $res = array(
					"status" => 1,
					"html"   => $html
				);
	        }else{
	        	$html = '<tr><td colspan="2">Nomor Ini Sudah Terdaftar di Event Ini</td></tr>';
				$res = array(
					"status" => 0,
					"html"   => $html
				);
	        }
		}else{
			$html = '<tr><td colspan="2">Data tidak ditemukan</td></tr>';
			$res = array(
				"status" => 0,
				"html"   => $html
			);
		}

		die(json_encode($res));
	}

}