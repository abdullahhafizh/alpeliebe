<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Group extends AdminController {  
	function __construct()    
	{
		parent::__construct();    
		$this->_set_action();
		$this->_set_action(array("access","edit","delete"),"ITEM");
		$this->_set_title( 'Configuration Access Control List' );
		$this->DATA->table="app_acl_group";
		$this->folder_view = "meme/";
		$this->prefix_view = strtolower($this->_getClass());

		$this->breadcrumb[] = array(
				"title"		=> "Group",
				"url"		=> $this->own_link
			);
 
	}
 
	function index(){
		$this->breadcrumb[] = array(
				"title"		=> "List"
			);
		$this->db->order_by("ag_group_name","ASC");
		$data['data'] = $this->db->get_where("app_acl_group",array(
				'is_trash !=' => 1
			))->result();			
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
					'ag_id'	=> $id
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
				array("ag_id"	=> idClean($id))
			);
		}
		redirect($this->own_link."?msg=".urldecode('Delete data group succes')."&type_msg=success");
	}

	function save(){
		$data = array(
			'ag_group_name'		=> dbClean($_POST['group_name']),
			'ag_group_desc'		=> dbClean($_POST['group_desc']),
			'ag_group_status'	=> isset($_POST['ag_group_status'])?1:0
		);		
		$a = $this->_save_master( 
			$data,
			array(
				'ag_id' => dbClean($_POST['group_id'])
			),
			dbClean($_POST['group_id'])			
		);

		redirect($this->own_link."?msg=".urldecode('Save data group succes')."&type_msg=success");
	}
	
	function access(){
		//
		$this->breadcrumb[] = array(
				"title"		=> "Control List"
			);		

		$id=_decrypt(dbClean(trim($this->input->get('_id'))));
		if(trim($id) != ''){
			if(isset($_POST['simpan'])){	
				$this->db->delete("app_acl_group_accesses",array('aga_group_id'=>$id));	
				
				if(isset($_POST['acc_name']) && count($_POST['acc_name']) > 0){
					foreach($_POST['acc_name'] as $id_access=>$v){
						$this->DATA->table = "app_acl_group_accesses";
						if(count($v)>0){
							foreach($v as $id_action){
								$data_actions = array(
									'aga_access_id' => $id_access,
									'aga_group_id'	=> $id,
									'aga_action_id'	=> $id_action
								);
								$this->DATA->_add($data_actions);
							}
						}
						
					}
				}
				redirect($this->own_link."?msg=".urlencode('Update for Access Control List Success')."&type_msg=success");
					
			}else{
				$this->DATA->table="app_acl_group";
				$group=$this->DATA->data_id(array("ag_id"=>$id));
				$this->DATA->table="app_acl_actions";
				$actions = $this->DATA->_getall();
				$this->_set_title('Access Control List '.ucwords($group->ag_group_name));	
			
				$m_tbl=array();
				$this->DATA->table="app_acl_accesses";
				$access_mod = $this->db->query("select * from ".$this->DATA->table." order by acc_menu asc")->result();
				
				foreach($access_mod as $m){
					$action_module = array();
					foreach($actions as $o){
						$this->DATA->table="app_acl_group_accesses";
						$val = $this->DATA->data_id(array(
											"aga_access_id"	=> $m->acc_id,
											"aga_group_id"	=> $id,
											"aga_action_id"	=> $o->ac_id
									));
						$this->DATA->table="app_acl_access_actions";
						$obj = $this->DATA->data_id(array(
											"aca_access_id"	=> $m->acc_id,
											"aca_action_id"	=> $o->ac_id
									));
						
						$action_module[]=array(
							'id'	=> $o->ac_id,
							'name'	=> $o->ac_action,
							'show'	=> count($obj),
							'value'	=> count($val)
						);
					}
					$m_tbl[$m->acc_id] = array(
						'id_module'		=> $m->acc_id,
						'module_name'	=> $m->acc_menu,
						'action'		=> $action_module
					);
				}			
				
				$this->_v($this->folder_view.$this->prefix_view."_access",array(
								  "actions"	=> $actions,
							      "access"	=> $m_tbl 
							)								 	
					);
			}	
		}
		
	}

}
