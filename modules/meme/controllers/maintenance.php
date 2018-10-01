<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Maintenance extends AdminController {  
	function __construct()    
	{
		parent::__construct(); 
		$this->_set_action();
		$this->_set_action(array("edit","delete"),"ITEM");
		$this->_set_title('Set Up Maintenance Mode');
		$this->DATA->table="app_maintenance";
		$this->folder_view = "meme/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->upload_path="./assets/collections/photo/"; 

		$this->breadcrumb[] = array(
				"title"		=> "Maintenance Mode",
				"url"		=> $this->own_link
			);

		if(!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()){
			$this->_reset();
		}
		
	
		$this->cat_search = array(
			''						=> 'All',
			'news_fullname'			=> 'Full Name',
			'news_email'			=> 'Email'
		); 
		$this->load->model("mdl_maintenance","M");
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js',
			'plugins/bootstrap/bootstrap-timepicker.min.js',
			'plugins/summernote/summernote.js'
		);
	}
		
	function _reset(){
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'name'		=> 'news',
			'date_start'=> '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'news_id',
			'order_dir' => 'DESC',
			'colum'		=> '',
			'keyword'	=> ''
		);
		$this->_releaseSession();
	}

	function index(){
		$par_filter = array(
				"offset"	=> $this->uri->segment($this->uri_segment),
				"limit"		=> $this->per_page,
				"param"		=> $this->cat_search
			);
		$this->data_table = $this->M->maintenance($par_filter);
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/index'
			));
		$this->_v($this->folder_view.$this->prefix_view,$data);
	}

	

	function add(){	
		$this->breadcrumb[] = array(
				"title"		=> "Add"
			);		
		$this->_v($this->folder_view.$this->prefix_view."_form",array(
			'group'		=> $this->db->get_where("app_acl_group",array(
								"ag_group_status"	=>	"1",
								"is_trash <>" 		=> "1"
							))->result()
		));
	}

	function edit(){

		$this->breadcrumb[] = array(
				"title"		=> "Edit"
			);
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));

		if(trim($id)!=''){
			$this->data_form = $this->DATA->data_id(array(
					'news_id'	=> $id
				));
			$role = array();
			$role_tmp = $this->db->get_where("app_news_group",array(
					"ug_news_id"	=> $id
				))->result();	

			foreach ((array)$role_tmp as $k => $v) {
					$role[] = $v->ug_group_id;
			}	
			$this->_v($this->folder_view.$this->prefix_view."_form",array(
				'group'		=> $this->db->get_where("app_acl_group",array(
					"ag_group_status"	=>	"1",
					"is_trash <>" => "1"	
				))->result(),
				'role'		=> $role
			));
		}else{
			redirect($this->own_link);
		}
	}
	
	function delete(){
		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id) != ''){
			$o = $this->DATA->_delete(
				array("news_id"	=> idClean($id))
			);
			
		}
		redirect($this->own_link."?msg=".urldecode('Delete data news succes')."&type_msg=success");
	}

	function save(){
		$fromdate 	= $this->input->post("date_from")." ".$this->input->post("time_from");
		$todate 	= $this->input->post("date_to")." ".$this->input->post("time_to");

		$data = array(
			'maintenance_status'			=> dbClean($_POST['status']),
			'maintenance_from'				=> $fromdate,
			'maintenance_to'				=> $todate
		);		

		$a = $this->_save_master( 
			$data,
			array(
				'id_maintenance' => dbClean($_POST['id_maintenance'])
			),
			dbClean($_POST['id_maintenance'])			
		);
		$this->db->insert("app_changelog",array(
						"changelog_date"			=> $todate,
						"changelog_version"			=> $this->input->post("version"),
						"changelog_text"			=> mysql_escape_string($this->input->post("update_list"))
		));

	
		redirect($this->own_link."?msg=".urldecode('Set Up Maintenance Mode Success.')."&type_msg=success");
	}

}