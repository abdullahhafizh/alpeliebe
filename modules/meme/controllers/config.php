<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Config extends AdminController {  
	
	function __construct()   
	{
		parent::__construct();   
		$this->_set_action(); 
		$this->_set_title('Setting Configuration');
		$this->DATA->table="app_config";

		$this->folder_view = "meme/";
		$this->prefix_view = strtolower($this->_getClass());
		$this->breadcrumb[] = array(
				"title"		=> "Configuration",
				"url"		=> $this->own_link
			);

	}

	function index(){
		$this->breadcrumb[] = array(
				"title"		=> "Form",
			);

		$m =  $this->DATA->_getall();
		$this->_v($this->folder_view.$this->prefix_view,array(
			'data'	=> $m
		));
	}
	
	function save(){
		if(isset($_POST['submit'])){
			foreach($_POST as $k=>$v){
				if($k!='submit'){					
					$a = $this->DATA->_update(array('config_name'	=> dbClean($k)),
						array('config_value'	=> dbClean($_POST[$k]))
					);
				}
			}
			
		}
		redirect($this->own_link."?msg=".urlencode("Success")."&type=success");
	}

}
