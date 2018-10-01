<?php
class AdminController extends My_Controller{

	var $footer_page 	= array();
	var $header_page	= array();
	var $links			= array();
	var $links_table	= array();
	var $links_table_item = array();
	var $cat_search 	= array();
	var $own_link 		= "";
	var $title			= "";
	var $data_form;
	var $status_timesheet 	= array();
	var $status_image 		= array();
	var $type_timesheet		= array();
	var $breadcrumb			= array();
	var $arr_perpage = array();
	var $arr_status = array();
	var $print_type = "";

	var $is_no_title = false;
	var $is_dashboard = FALSE;
	var $arr_actions=array();
	function __construct(){

		parent::__construct();

		$this->jCfg['theme'] = 'admin/'.cfg('template_admin');
		$this->jCfg['access'] = $this->_set_sess_action();
		$this->_set_own_link();

		if( !isset($this->jCfg['is_login']) || $this->jCfg['is_login'] != 1){
			$this->setReferer($this->uri->uri_string);
			redirect(site_url("auth"));
		}

		if($this->_getClass()!= 'me' ){
			$this->_set_array_actions();
			if(in_array($this->_getMethod(),$this->arr_actions)){
				if(!_ac($this->_getMethod())){
					redirect(base_url()."?msg=Access denied &type=error");
					//die('Access Denied, please contact your web Administrator..');
				}
			}
		}

		$this->jCfg['menu'] = _get_menu($this->_set_sess_menu());

		if(isset($_GET['msg']) && trim($_GET['msg']) != ""){
			$this->message = dbClean($_GET['msg']);
		}


		$this->breadcrumb[] = array(
				"title"		=> "Home",
				"url"		=> site_url("meme/me")
			);

		$this->arr_perpage = array(20,50,100,500,1000,5000,10000);

		$this->load->helper('hmi');
	}

	function _set_array_actions(){
		$q = $this->db->get("app_acl_actions")->result();
		foreach($q as $r){
			$this->arr_actions[]=$r->ac_action;
		}
	}

	function _set_sess_action(){
		$return = array();
		if( isset($this->jCfg['user']['role']) && count($this->jCfg['user']['role']) > 0){
			$this->db->select("
					maa.ac_action,maa.ac_action_image,aac.acc_access_name,maa.ac_action_type,
					aac.acc_group_controller,aac.acc_controller_name,maa.ac_action_name
				");
			$this->db->join('app_acl_group_accesses agc', 'agc.aga_group_id = ag.ag_id', 'left');
			$this->db->join('app_acl_actions maa', 'agc.aga_action_id = maa.ac_id', 'left');
			$this->db->join('app_acl_accesses aac', 'agc.aga_access_id = aac.acc_id', 'left');

			$this->db->where("ag.ag_group_status","1");
			$this->db->where_in("ag.ag_id",$this->jCfg['user']['role']);
			$this->db->where("aac.acc_controller_name",strtolower($this->_getClass()));

			$sql = $this->db->get("app_acl_group ag")->result();

			$acc=array();
			if(count($sql) > 0){
				foreach($sql as $r){
					$acc[$r->ac_action] = $r;
				}
			}
			$return = $acc;
		}

		return $return;
	}

	function _set_sess_menu(){

		if( count($this->jCfg['user']['role']) > 0){
			$this->db->select("
					aac.*
				");
			$this->db->join('app_acl_group_accesses agc', 'agc.aga_group_id = ag.ag_id', 'left');
			$this->db->join('app_acl_actions maa', 'agc.aga_action_id = maa.ac_id', 'left');
			$this->db->join('app_acl_accesses aac', 'agc.aga_access_id = aac.acc_id', 'left');

			$this->db->where("ag.ag_group_status","1");
			$this->db->where_in("ag.ag_id",$this->jCfg['user']['role']);
			$this->db->where("maa.ac_action",'index');

			$this->db->group_by("aac.acc_id");
			$this->db->order_by("aac.acc_by_order","ASC");
			$this->db->order_by("aac.acc_access_name","ASC");

			$menu = $this->db->get("app_acl_group ag")->result_array();
			return $menu;
		}
	}

	function _set_action($v=array("bug","add","addktp","addsuket","index"),$type='MAIN'){
		if(count($v)>0){
			$acc = $this->jCfg['access'];
			foreach($v as $r){
				if(isset($acc[$r])){
					$arr_action = array(
						'title'	=> $r,
						'action'=> $r,
						'type'	=> $acc[$r]->ac_action_type,
						'link'	=> site_url($acc[$r]->acc_group_controller."/".$acc[$r]->acc_controller_name."/".$r),
						'image'	=> $acc[$r]->ac_action_image
					);
					if($type=='MAIN'){
						$this->links[] = $arr_action;
					}elseif($type=='TABLE'){
						$this->links_table[] = $arr_action;
					}elseif($type=='ITEM'){
						$this->links_table_item[] = $arr_action;
					}else{
						$this->links[] = $arr_action;
					}
				}
			}
		}
	}

	function _set_own_link(){
		$tlink=strtolower($this->_getClass());
		if(	isset($this->jCfg['access']['index']) && count($this->jCfg['access']['index']) > 0){
			$tlink = $this->jCfg['access']['index']->acc_group_controller."/".strtolower($this->_getClass())."/";
		}
		$this->own_link = site_url($tlink);
	}

	function _v($file,$data=array(),$header=TRUE){
		$this->header_page['val']		= $this->data_form;
		$this->header_page['message']	= $this->message;
		if($header==TRUE){
			$this->header_page['links'] 		= $this->links;
			$this->header_page['links_table']	= $this->links_table;
			$this->header_page['links_table_item']	= $this->links_table_item;
			$this->header_page['own_links']	= $this->own_link;
			$this->load->view($this->jCfg['theme'].'/'.$this->jCfg['theme_setting']['menu'].'/header',$this->header_page);
			$this->load->view($this->jCfg['theme'].'/'.$file,$data);
			$this->load->view($this->jCfg['theme'].'/'.$this->jCfg['theme_setting']['menu'].'/footer',$this->footer_page);
		}else{
			$data['val'] = $this->header_page['val'];
			$this->load->view($this->jCfg['theme'].'/'.$file,$data);
		}
	}

	function _save_master($data=array(),$par=array(),$vid=0){
		$id 	= 0;
		$act	= FALSE;
		$o = $this->DATA->_cek($par);
		if( $o == 0 ){
			$act = $this->DATA->_add($data);
			$id = $this->db->insert_id();
		}else{
			$act = $this->DATA->_update($par,$data);
			$id = $vid;
		}
		return array(
			'id'	=> $id,
			'msg'	=> ($act)?'Success...':'Fail...'
		);
	}

	function _set_title($t=""){
		return $this->header_page['title'] = $t;
	}

	function _set_sub_title($t=""){
		return $this->header_page['sub_title'] = $t;
	}

	function _set_cat_search($arr=array()){
		return $this->header_page['cat_search'] = $arr;
	}

	function sort(){
		$this->sCfg['search']['order_by'] = $this->input->get('sort_by');
		$this->sCfg['search']['order_dir'] = $this->input->get('sort_dir');
		$this->_releaseSession();
		$next = $this->input->get('next')&&trim($this->input->get('next'))!=""?$this->input->get('next'):site_url();
		redirect($next);
	}

	function per_page(){
		$this->sCfg['search']['per_page'] = $this->input->get('per_page');
		$this->_releaseSession();
		$next = $this->input->get('next')&&trim($this->input->get('next'))!=""?$this->input->get('next'):site_url();
		redirect($next);
	}

	function set_status(){
		$this->sCfg['search']['status'] = $this->input->get('status');
		$this->_releaseSession();
		$next = $this->input->get('next')&&trim($this->input->get('next'))!=""?$this->input->get('next'):site_url();
		redirect($next);
	}

function print_preview(){
/*
		$type = $this->input->get('type');

		$nomor = base64_decode(str_replace(' ','+',$this->input->get('n')));
		$foto = base64_decode(str_replace(' ','+',$this->input->get('f')));
		$nama = base64_decode(str_replace(' ','+',$this->input->get('na')));
		$knama = base64_decode(str_replace(' ','+',$this->input->get('k')));
		$pnama = base64_decode(str_replace(' ','+',$this->input->get('p')));
		$time = base64_decode(str_replace(' ','+',$this->input->get('t')));
		$id = base64_decode(str_replace(' ','+',$this->input->get('i')));
		$url = base64_decode(str_replace(' ','+',$this->input->get('u')));
		*/

		$namaLengkap = $this->input->get('namaLengkap');
		$noKartu = $this->input->get('noKartu');
		$tempatLahir = $this->input->get('tempatLahir');
		$tanggalLahir = $this->input->get('tanggalLahir');
		$alamat = $this->input->get('alamat');
		$namaDPD = $this->input->get('namaDPD');
		$namaDPC = $this->input->get('namaDPC');
		$profPic = $this->input->get('profPic');
		$golDarah = $this->input->get('golDarah');

		$data = array(
			'namaLengkap'		=> $namaLengkap,
			'noKartu'		=> $noKartu,
			'tempatLahir'		=> $tempatLahir,
			'tanggalLahir'		=> $tanggalLahir,
			'alamat'		=> $alamat,
			'namaDPD'		=> $namaDPD,
			'namaDPC'		=> $namaDPC,
			'profPic'		=> $profPic,
			'golDarah'	=> $golDarah
		);
		$this->_v("print_preview",$data,false);
	}
}
